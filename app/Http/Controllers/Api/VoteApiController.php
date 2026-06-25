<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'election_id' => 'required|exists:elections,id',
            'president_candidate' => 'required|exists:candidates,id',
            'vice_president_candidate' => 'required|exists:candidates,id',
            'senator_candidates' => 'sometimes|array|max:3',
            'senator_candidates.*' => 'distinct|exists:candidates,id',
        ]);

        $user = $request->user();
        $election = Election::with('candidates')->findOrFail($request->election_id);

        if (! $election->isActive()) {
            return response()->json(['error' => 'Election is not active'], 422);
        }

        // Check if user already voted
        $userHasVoted = Vote::where('user_id', $user->id)
            ->where('election_id', $election->id)
            ->exists();

        if ($userHasVoted) {
            return response()->json(['error' => 'You have already voted in this election'], 422);
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
            return response()->json(['error' => 'Invalid candidate selection'], 422);
        }

        $senatorCandidateIds = array_filter($request->input('senator_candidates', []));

        if ($election->candidates->where('position', Candidate::POSITION_SENATOR)->isNotEmpty() && count($senatorCandidateIds) === 0) {
            return response()->json(['error' => 'Please select one or more senator candidates'], 422);
        }

        $senatorCandidates = Candidate::whereIn('id', $senatorCandidateIds)
            ->where('election_id', $election->id)
            ->where('position', Candidate::POSITION_SENATOR)
            ->pluck('id')
            ->toArray();

        if (count($senatorCandidates) !== count($senatorCandidateIds)) {
            return response()->json(['error' => 'Senator selections must belong to the chosen election'], 422);
        }

        $timestamp = now();
        $votes = [
            ['user_id' => $user->id, 'candidate_id' => $presidentCandidate->id, 'election_id' => $election->id, 'position' => Candidate::POSITION_PRESIDENT, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['user_id' => $user->id, 'candidate_id' => $viceCandidate->id, 'election_id' => $election->id, 'position' => Candidate::POSITION_VICE, 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        foreach ($senatorCandidates as $senatorId) {
            $votes[] = ['user_id' => $user->id, 'candidate_id' => $senatorId, 'election_id' => $election->id, 'position' => Candidate::POSITION_SENATOR, 'created_at' => $timestamp, 'updated_at' => $timestamp];
        }

        DB::transaction(fn () => Vote::insert($votes));

        return response()->json(['message' => 'Vote submitted successfully', 'votes' => $votes], 201);
    }

    public function userVotes()
    {
        $votes = auth()->user()->votes()
            ->with(['candidate', 'election'])
            ->get();

        return response()->json($votes);
    }
}
