@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="mb-6">
                <p class="text-sm font-medium text-indigo-600">Admin</p>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Candidate</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update candidate details and ballot placement.</p>
            </div>

            <form action="{{ route('candidates.update', $candidate) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $candidate->name) }}" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" required>
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="election_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Election</label>
                    <select id="election_id" name="election_id" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" required>
                        <option value="">Select an election</option>
                        @foreach($elections as $election)
                            <option value="{{ $election->id }}" {{ old('election_id', $candidate->election_id) == $election->id ? 'selected' : '' }}>{{ $election->title }}</option>
                        @endforeach
                    </select>
                    @error('election_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                    <select id="position" name="position" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" required>
                        <option value="">Select a position</option>
                        @foreach($positions as $position)
                            <option value="{{ $position }}" {{ old('position', $candidate->position) == $position ? 'selected' : '' }}>{{ $position }}</option>
                        @endforeach
                    </select>
                    @error('position')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('candidates.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Cancel</a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Update Candidate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
