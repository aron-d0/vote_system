<?php

namespace App\Http\Controllers\Api;

use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CandidateApiController extends Controller
{
    public function index()
    {
        $candidates = Candidate::with('election')->paginate(15);
        return response()->json($candidates);
    }

    public function show(Candidate $candidate)
    {
        return response()->json($candidate->load('election', 'votes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'election_id' => 'required|exists:elections,id',
            'position' => 'required|in:' . implode(',', Candidate::positions()),
        ]);

        $candidate = Candidate::create($request->only(['name', 'election_id', 'position']));

        return response()->json($candidate, 201);
    }

    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'election_id' => 'required|exists:elections,id',
            'position' => 'required|in:' . implode(',', Candidate::positions()),
        ]);

        $candidate->update($request->only(['name', 'election_id', 'position']));

        return response()->json($candidate);
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();

        return response()->json(['message' => 'Candidate deleted successfully']);
    }

    public function byElection(Election $election)
    {
        $candidates = $election->candidates()
            ->select('id', 'name', 'position', 'election_id')
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return response()->json([
            'election' => $election->only('id', 'title', 'description'),
            'candidates' => $candidates->groupBy('position'),
        ]);
    }
}
