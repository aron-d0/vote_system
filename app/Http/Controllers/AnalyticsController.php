<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use App\Models\Candidate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    use AuthorizesRequests;

    public function dashboard(Election $election)
    {
        $this->authorize('isAdmin');

        $totalVoters = Vote::where('election_id', $election->id)
            ->distinct('user_id')
            ->count('user_id');

        $totalCandidates = $election->candidates()->count();

        $positionResults = [];
        $positions = [
            Candidate::POSITION_PRESIDENT,
            Candidate::POSITION_VICE,
            Candidate::POSITION_SENATOR,
        ];

        foreach ($positions as $position) {
            $candidates = $election->candidates()
                ->where('position', $position)
                ->withCount(['votes' => function ($query) use ($election, $position) {
                    $query->where('election_id', $election->id)
                        ->where('position', $position);
                }])
                ->orderByDesc('votes_count')
                ->get(['id', 'name', 'votes_count']);

            $positionResults[$position] = $candidates;
        }

        // Chart data preparation
        $chartData = [];
        foreach ($positions as $position) {
            $labels = $positionResults[$position]->pluck('name')->toArray();
            $votes = $positionResults[$position]->pluck('votes_count')->toArray();

            $chartData[$position] = [
                'labels' => $labels,
                'votes' => $votes,
            ];
        }

        return view('analytics.dashboard', [
            'election' => $election,
            'totalVoters' => $totalVoters,
            'totalCandidates' => $totalCandidates,
            'positionResults' => $positionResults,
            'chartData' => $chartData,
        ]);
    }

    public function liveResults(Election $election)
    {
        $this->authorize('isAdmin');

        $totalVoters = Vote::where('election_id', $election->id)
            ->distinct('user_id')
            ->count('user_id');

        $positions = [
            Candidate::POSITION_PRESIDENT,
            Candidate::POSITION_VICE,
            Candidate::POSITION_SENATOR,
        ];

        $results = [];
        foreach ($positions as $position) {
            $candidates = $election->candidates()
                ->where('position', $position)
                ->withCount(['votes' => function ($query) use ($election, $position) {
                    $query->where('election_id', $election->id)
                        ->where('position', $position);
                }])
                ->orderByDesc('votes_count')
                ->get(['id', 'name', 'votes_count']);

            $results[$position] = $candidates;
        }

        return response()->json([
            'total_voters' => $totalVoters,
            'results' => $results,
            'timestamp' => now(),
        ]);
    }
}
