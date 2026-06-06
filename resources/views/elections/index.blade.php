@extends('layouts.app')

@section('content')
<div class="py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Elections</h1>

    <!-- Add Election -->
    <a href="{{ route('elections.create') }}" 
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition">
        + Add Election
    </a>

    <!-- Elections Grid -->
    <div class="mt-6 grid gap-6 md:grid-cols-2">
        @foreach($elections as $election)
            <div class="border rounded-lg bg-white dark:bg-gray-800 shadow hover:shadow-lg transition p-6">
                <!-- Header -->
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $election->title }}
                        </h2>
                        <p class="text-sm text-gray-500">
                            {{ optional($election->start_at)->format('M d, Y H:i') }} 
                            &ndash; 
                            {{ optional($election->end_at)->format('M d, Y H:i') }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-2">
                        <!-- Edit -->
                        <a href="{{ route('elections.edit', $election->id) }}" 
                           class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow 
                                  hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                            Edit
                        </a>

                        <!-- Results -->
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('elections.results', $election->id) }}" 
                               class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-md shadow 
                                      hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1">
                                Results
                            </a>
                        @endif

                        <!-- Vote / Closed -->
                        @if($election->isActive())
                            <a href="{{ route('votes.election.create', $election->id) }}" 
                               class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow 
                                      hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                                Vote
                            </a>
                        @else
                            <span class="px-4 py-2 text-sm font-semibold text-gray-400 bg-gray-100 rounded-md">
                                Closed
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                @if($election->description)
                    <p class="mt-3 text-gray-700 dark:text-gray-300">{{ $election->description }}</p>
                @endif

                <!-- Delete -->
                <form action="{{ route('elections.destroy', $election->id) }}" method="POST" class="mt-4">
                    @csrf @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow 
                                   hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                        Delete
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
