<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::with('election')
            ->orderBy('election_id')
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view('candidates.index', compact('candidates'));
    }

    public function create()
    {
        $elections = Election::all();
        $positions = Candidate::positions();
        return view('candidates.create', compact('elections', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'election_id' => 'required|exists:elections,id',
            'position' => 'required|in:' . implode(',', Candidate::positions()),
        ], [
            'position.in' => 'Choose a valid ballot position.',
        ]);

        Candidate::create($request->only(['name', 'election_id', 'position']));

        return redirect()->route('candidates.index')->with('success', 'Candidate added successfully.');
    }

    public function show(Candidate $candidate)
    {
        return view('candidates.show', compact('candidate'));
    }

    public function edit(Candidate $candidate)
    {
        $elections = Election::all();
        $positions = Candidate::positions();
        return view('candidates.edit', compact('candidate', 'elections', 'positions'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'election_id' => 'required|exists:elections,id',
            'position' => 'required|in:' . implode(',', Candidate::positions()),
        ], [
            'position.in' => 'Choose a valid ballot position.',
        ]);

        $candidate->update($request->only(['name', 'election_id', 'position']));

        return redirect()->route('candidates.index')->with('success', 'Candidate updated successfully.');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->route('candidates.index')->with('success', 'Candidate deleted successfully.');
    }
}
