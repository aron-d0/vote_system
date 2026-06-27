@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">Admin</p>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Elections</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Create election windows, monitor readiness, and review results.</p>
            </div>
            <a href="{{ route('elections.create') }}" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                Add Election
            </a>
        </div>

        <div class="grid gap-5">
            @forelse($elections as $election)
                @php
                    $isActive = $election->isActive();
                    $hasEnded = $election->end_at && $election->end_at->lt(now());
                @endphp

                <article class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $election->title }}</h2>
                                @if($isActive)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">Open</span>
                                @elseif($hasEnded)
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">Closed</span>
                                @else
                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">Scheduled</span>
                                @endif
                            </div>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $election->description ?: 'No description provided.' }}</p>
                            <div class="mt-3 flex flex-wrap gap-3 text-xs text-gray-500">
                                <span>{{ optional($election->start_at)->format('M d, Y h:i A') }} - {{ optional($election->end_at)->format('M d, Y h:i A') }}</span>
                                <span>{{ $election->candidates_count }} candidates</span>
                                <span>{{ $election->votes_count }} vote records</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('elections.results', $election) }}" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white hover:bg-green-700">Results</a>
                            <a href="{{ route('elections.analytics', $election) }}" class="rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white hover:bg-sky-700">Analytics</a>
                            <a href="{{ route('elections.edit', $election) }}" class="rounded-md border border-gray-300 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Edit</a>
                            <form action="{{ route('elections.destroy', $election) }}" method="POST" onsubmit="return confirm('Delete this election and all related candidates/votes?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">Delete</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-lg border border-dashed border-gray-300 bg-white px-6 py-12 text-center dark:border-gray-700 dark:bg-gray-800">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">No elections yet</h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Create the first election before adding candidates.</p>
                    <a href="{{ route('elections.create') }}" class="mt-5 inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Create Election</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
