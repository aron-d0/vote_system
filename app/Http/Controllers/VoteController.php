<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index()
    {
        $votes = auth()->user()->votes()->with(['candidate', 'election'])->get();
        return view('votes.index', compact('votes'));
    }

    public function create(Election $selectedElection = null)
    {
        $elections = Election::active()->with('candidates')->get();

        // Check if user has already voted for any active election
        foreach ($elections as $election) {
            $userHasVoted = Vote::where('user_id', auth()->id())
                ->where('election_id', $election->id)
                ->exists();

            if ($userHasVoted) {
                return redirect()->route('dashboard')
                    ->with('info', "You have already voted in the {$election->title} election. You can only vote once per election.");
            }
        }

        // If a specific election is selected, check if user has already voted for it
        if ($selectedElection) {
            $userHasVoted = Vote::where('user_id', auth()->id())
                ->where('election_id', $selectedElection->id)
                ->exists();

            if ($userHasVoted) {
                return redirect()->route('dashboard')
                    ->with('info', "You have already voted in the {$selectedElection->title} election. You can only vote once per election.");
            }
        }

        return view('votes.create', compact('elections', 'selectedElection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'election_id' => 'required|exists:elections,id',
            'president_candidate' => 'required|exists:candidates,id',
            'vice_president_candidate' => 'required|exists:candidates,id',
            'senator_candidates' => 'sometimes|array|max:3',
            'senator_candidates.*' => 'distinct|exists:candidates,id',
            'want_print' => 'nullable|boolean',
        ]);

        $election = Election::with('candidates')->findOrFail($request->election_id);

        if (! $election->isActive()) {
            return back()->withErrors(['election_id' => 'This election is not currently active.'])->withInput();
        }

        $hasPresident = Vote::where('user_id', auth()->id())
            ->where('election_id', $election->id)
            ->where('position', Candidate::POSITION_PRESIDENT)
            ->exists();

        $hasVice = Vote::where('user_id', auth()->id())
            ->where('election_id', $election->id)
            ->where('position', Candidate::POSITION_VICE)
            ->exists();

        $hasSenators = Vote::where('user_id', auth()->id())
            ->where('election_id', $election->id)
            ->where('position', Candidate::POSITION_SENATOR)
            ->exists();

        if ($hasPresident || $hasVice || $hasSenators) {
            return back()->withErrors(['election_id' => 'You have already submitted votes for this election.'])->withInput();
        }

        $presidentCandidate = Candidate::where('id', $request->president_candidate)
            ->where('election_id', $election->id)
            ->where('position', Candidate::POSITION_PRESIDENT)
            ->first();

        $viceCandidate = Candidate::where('id', $request->vice_president_candidate)
            ->where('election_id', $election->id)
            ->where('position', Candidate::POSITION_VICE)
            ->first();

        if (! $presidentCandidate || ! $viceCandidate) {
            return back()->withErrors(['election_id' => 'Selected candidates must belong to the chosen election and position.'])->withInput();
        }

        $senatorCandidates = $request->input('senator_candidates', []);
        $senatorCandidates = array_filter($senatorCandidates);

        if ($election->candidates->where('position', Candidate::POSITION_SENATOR)->isNotEmpty() && count($senatorCandidates) === 0) {
            return back()->withErrors(['senator_candidates' => 'Please select one or more senator candidates.'])->withInput();
        }

        if (count($senatorCandidates) > 3) {
            return back()->withErrors(['senator_candidates' => 'You may select up to 3 senator candidates.'])->withInput();
        }

        $senatorCandidates = Candidate::whereIn('id', $senatorCandidates)
            ->where('election_id', $election->id)
            ->where('position', Candidate::POSITION_SENATOR)
            ->pluck('id')
            ->toArray();

        if (count($senatorCandidates) !== count($request->input('senator_candidates', []))) {
            return back()->withErrors(['senator_candidates' => 'Senator selections must belong to the chosen election.'])->withInput();
        }

        $votes = [
            [
                'user_id' => auth()->id(),
                'candidate_id' => $presidentCandidate->id,
                'election_id' => $election->id,
                'position' => Candidate::POSITION_PRESIDENT,
            ],
            [
                'user_id' => auth()->id(),
                'candidate_id' => $viceCandidate->id,
                'election_id' => $election->id,
                'position' => Candidate::POSITION_VICE,
            ],
        ];

        foreach ($senatorCandidates as $senatorId) {
            $votes[] = [
                'user_id' => auth()->id(),
                'candidate_id' => $senatorId,
                'election_id' => $election->id,
                'position' => Candidate::POSITION_SENATOR,
            ];
        }

        Vote::insert($votes);

        session()->flash('vote_receipt', [
            'election' => $election->title,
            'president' => $presidentCandidate->name,
            'vice_president' => $viceCandidate->name,
            'senators' => Candidate::whereIn('id', $senatorCandidates)->pluck('name')->toArray(),
        ]);

        // If the user requested a printed copy, redirect to the receipt page.
        // Otherwise return to dashboard.
        $wantPrint = filter_var($request->input('want_print'), FILTER_VALIDATE_BOOLEAN);

        if ($wantPrint) {
            return redirect()->route('votes.receipt');
        }

        return redirect()->route('dashboard');
    }

    public function receipt()
    {
        $receipt = session('vote_receipt');

        if (! $receipt) {
            return redirect()->route('votes.index');
        }

        return view('votes.receipt', compact('receipt'));
    }
}
