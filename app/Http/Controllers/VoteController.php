<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function index()
    {
        $votes = auth()->user()->votes()
            ->with(['candidate', 'election'])
            ->latest()
            ->get()
            ->groupBy('election_id');

        return view('votes.index', compact('votes'));
    }

    public function create(?Election $election = null)
    {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard')
                ->with('info', 'Admin accounts manage elections and cannot submit ballots.');
        }

        $selectedElection = $election;
        $elections = Election::active()
            ->with(['candidates' => fn ($query) => $query->orderBy('position')->orderBy('name')])
            ->orderBy('end_at')
            ->get();

        if ($selectedElection && ! $selectedElection->isActive()) {
            return redirect()->route('dashboard')
                ->with('info', "The {$selectedElection->title} election is not currently open for voting.");
        }

        $votedElectionIds = Vote::where('user_id', auth()->id())
            ->whereIn('election_id', $elections->pluck('id'))
            ->pluck('election_id')
            ->unique()
            ->toArray();

        if ($selectedElection && in_array($selectedElection->id, $votedElectionIds, true)) {
            return redirect()->route('dashboard')
                ->with('info', "You have already voted in the {$selectedElection->title} election. You can only vote once per election.");
        }

        if ($elections->isNotEmpty() && count($votedElectionIds) >= $elections->count()) {
            return redirect()->route('dashboard')
                ->with('info', 'You have already voted in all active elections.');
        }

        return view('votes.create', compact('elections', 'selectedElection', 'votedElectionIds'));
    }

    public function store(Request $request)
    {
        if ($request->user()->is_admin) {
            return redirect()->route('admin.dashboard')
                ->with('info', 'Admin accounts manage elections and cannot submit ballots.');
        }

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

        $hasVotes = Vote::where('user_id', auth()->id())
            ->where('election_id', $election->id)
            ->exists();

        if ($hasVotes) {
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

        $requestedSenatorCandidates = array_values(array_filter($request->input('senator_candidates', [])));
        $senatorCandidates = $requestedSenatorCandidates;

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

        if (count($senatorCandidates) !== count($requestedSenatorCandidates)) {
            return back()->withErrors(['senator_candidates' => 'Senator selections must belong to the chosen election.'])->withInput();
        }

        $timestamp = now();
        $votes = [
            [
                'user_id' => auth()->id(),
                'candidate_id' => $presidentCandidate->id,
                'election_id' => $election->id,
                'position' => Candidate::POSITION_PRESIDENT,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'user_id' => auth()->id(),
                'candidate_id' => $viceCandidate->id,
                'election_id' => $election->id,
                'position' => Candidate::POSITION_VICE,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ];

        foreach ($senatorCandidates as $senatorId) {
            $votes[] = [
                'user_id' => auth()->id(),
                'candidate_id' => $senatorId,
                'election_id' => $election->id,
                'position' => Candidate::POSITION_SENATOR,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        DB::transaction(fn () => Vote::insert($votes));

        session()->flash('vote_receipt', [
            'election' => $election->title,
            'president' => $presidentCandidate->name,
            'vice_president' => $viceCandidate->name,
            'senators' => Candidate::whereIn('id', $senatorCandidates)->pluck('name')->toArray(),
        ]);

        $wantPrint = filter_var($request->input('want_print'), FILTER_VALIDATE_BOOLEAN);

        if ($wantPrint) {
            return redirect()->route('votes.receipt');
        }

        return redirect()->route('dashboard')->with('success', 'Your ballot has been submitted successfully.');
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
