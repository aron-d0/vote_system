@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Candidate</h1>

<form action="{{ route('candidates.update', $candidate->id) }}" method="POST" class="space-y-4">
    @csrf @method('PUT')

    <div>
        <label class="block font-medium">Name</label>
        <input type="text" name="name" value="{{ old('name', $candidate->name) }}" class="border p-2 w-full rounded" required>
    </div>

    <div>
        <label class="block font-medium">Election</label>
        <select name="election_id" class="border p-2 w-full rounded" required>
            <option value="">Select an election</option>
            @foreach($elections as $election)
                <option value="{{ $election->id }}" {{ old('election_id', $candidate->election_id) == $election->id ? 'selected' : '' }}>{{ $election->title }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-medium">Position</label>
        <select name="position" class="border p-2 w-full rounded" required>
            <option value="">Select a position</option>
            @foreach($positions as $position)
                <option value="{{ $position }}" {{ old('position', $candidate->position) == $position ? 'selected' : '' }}>{{ $position }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
</form>
@endsection
