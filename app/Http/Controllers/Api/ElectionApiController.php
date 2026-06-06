<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Election;
use Illuminate\Http\Request;

class ElectionApiController extends Controller
{
    public function index()
    {
        $elections = Election::orderBy('start_at', 'desc')->paginate(15);
        return response()->json($elections);
    }

    public function show(Election $election)
    {
        return response()->json($election);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_at' => 'required_without:start_date|date',
            'end_at' => 'required_without:end_date|date|after_or_equal:start_at',
            'start_date' => 'required_without:start_at|date',
            'end_date' => 'required_without:end_at|date|after_or_equal:start_date',
        ]);

        if (! isset($data['start_at']) && isset($data['start_date'])) {
            $data['start_at'] = $data['start_date'];
        }

        if (! isset($data['end_at']) && isset($data['end_date'])) {
            $data['end_at'] = $data['end_date'];
        }

        $election = Election::create(array_intersect_key($data, array_flip(['title', 'description', 'start_at', 'end_at'])));

        return response()->json($election, 201);
    }

    public function update(Request $request, Election $election)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_at' => 'required_without:start_date|date',
            'end_at' => 'required_without:end_date|date|after_or_equal:start_at',
            'start_date' => 'required_without:start_at|date',
            'end_date' => 'required_without:end_at|date|after_or_equal:start_date',
        ]);

        if (! isset($data['start_at']) && isset($data['start_date'])) {
            $data['start_at'] = $data['start_date'];
        }

        if (! isset($data['end_at']) && isset($data['end_date'])) {
            $data['end_at'] = $data['end_date'];
        }

        $election->update(array_intersect_key($data, array_flip(['title', 'description', 'start_at', 'end_at'])));

        return response()->json($election);
    }

    public function destroy(Election $election)
    {
        $election->delete();

        return response()->json(['message' => 'Election deleted successfully']);
    }
}
