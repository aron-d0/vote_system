@extends('layouts.app')

@section('content')
<div class="py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Candidates</h1>

    <!-- Add Candidate -->
    <a href="{{ route('candidates.create') }}" 
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition">
        + Add Candidate
    </a>

    <!-- Candidates List -->
    <div class="mt-6 grid gap-6 md:grid-cols-2">
        @foreach($candidates as $candidate)
            <div class="border rounded-lg bg-white dark:bg-gray-800 shadow hover:shadow-lg transition p-6">
                <!-- Candidate Info -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $candidate->name }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ $candidate->position }} — {{ $candidate->election->title }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 flex flex-wrap gap-2">
                    <!-- Edit -->
                    <a href="{{ route('candidates.edit', $candidate->id) }}" 
                       class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow 
                              hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                        Edit
                    </a>

                    <!-- Delete -->
                    <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow 
                                       hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
