<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    public function index()
    {
        $elections = Election::all();
        return view('elections.index', compact('elections'));
    }

    public function create()
    {
        return view('elections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ]);

        Election::create($request->only(['title', 'description', 'start_at', 'end_at']));

        return redirect()->route('elections.index')->with('success', 'Election created successfully.');
    }

    public function edit(Election $election)
    {
        return view('elections.edit', compact('election'));
    }

    public function update(Request $request, Election $election)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ]);

        $election->update($request->only(['title', 'description', 'start_at', 'end_at']));

        return redirect()->route('elections.index')->with('success', 'Election updated successfully.');
    }

    public function destroy(Election $election)
    {
        $election->delete();
        return redirect()->route('elections.index')->with('success', 'Election deleted successfully.');
    }

    public function results(Election $election)
    {
        $candidates = $election->candidates()->withCount('votes')->get();

        $groupedCandidates = $candidates->groupBy('position');
        $winnerCounts = [
            Candidate::POSITION_PRESIDENT => 1,
            Candidate::POSITION_VICE => 1,
            Candidate::POSITION_SENATOR => 3,
        ];

        $winners = collect();
        foreach ($winnerCounts as $position => $limit) {
            $positionCandidates = $groupedCandidates->get($position, collect());
            $winners[$position] = $positionCandidates
                ->sortByDesc('votes_count')
                ->take($limit);
        }

        return view('elections.results', compact('election', 'groupedCandidates', 'winners'));
    }
}
