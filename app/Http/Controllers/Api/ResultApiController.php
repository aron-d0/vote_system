<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;

class ResultApiController extends Controller
{
    public function show(Election $election)
    {
        $this->authorize('view', $election);

        $results = [];
        $positions = [
            Candidate::POSITION_PRESIDENT,
            Candidate::POSITION_VICE,
            Candidate::POSITION_SENATOR,
        ];

        foreach ($positions as $position) {
            $candidates = $election->candidates()
                ->where('position', $position)
                ->withCount(['votes' => function ($query) use ($election, $position) {
                    $query->where('election_id', $election->id)->where('position', $position);
                }])
                ->orderByDesc('votes_count')
                ->get(['id', 'name', 'position']);

            $results[$position] = $candidates;
        }

        return response()->json([
            'election' => $election->only('id', 'title', 'description'),
            'results' => $results,
            'total_votes' => Vote::where('election_id', $election->id)->distinct('user_id')->count('user_id'),
        ]);
    }

    public function summary(Election $election)
    {
        $this->authorize('view', $election);

        $totalVotes = Vote::where('election_id', $election->id)->distinct('user_id')->count('user_id');
        $totalCandidates = $election->candidates()->count();

        $results = [];
        $positions = [Candidate::POSITION_PRESIDENT, Candidate::POSITION_VICE, Candidate::POSITION_SENATOR];

        foreach ($positions as $position) {
            $topCandidate = $election->candidates()
                ->where('position', $position)
                ->withCount(['votes' => function ($query) use ($election, $position) {
                    $query->where('election_id', $election->id)->where('position', $position);
                }])
                ->orderByDesc('votes_count')
                ->first(['id', 'name', 'position', 'votes_count']);

            if ($topCandidate) {
                $results[$position] = $topCandidate;
            }
        }

        return response()->json([
            'election' => $election->only('id', 'title'),
            'summary' => [
                'total_votes' => $totalVotes,
                'total_candidates' => $totalCandidates,
                'leaders' => $results,
            ],
        ]);
    }

    public function publicResults(Election $election)
    {
        // Public results - no authorization needed
        $totalVotes = Vote::where('election_id', $election->id)->distinct('user_id')->count('user_id');

        $results = [];
        $positions = [Candidate::POSITION_PRESIDENT, Candidate::POSITION_VICE, Candidate::POSITION_SENATOR];

        foreach ($positions as $position) {
            $candidates = $election->candidates()
                ->where('position', $position)
                ->withCount(['votes' => function ($query) use ($election, $position) {
                    $query->where('election_id', $election->id)->where('position', $position);
                }])
                ->orderByDesc('votes_count')
                ->get(['id', 'name', 'position']);

            $results[$position] = $candidates;
        }

        return response()->json([
            'election' => $election->only('id', 'title', 'description'),
            'results' => $results,
            'total_votes' => $totalVotes,
            'timestamp' => now(),
        ]);
    }
}
