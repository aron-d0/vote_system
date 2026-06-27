@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">Voting history</p>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Ballots</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Review the ballots submitted from your account.</p>
            </div>
            <a href="{{ route('votes.create') }}" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                Vote in an Active Election
            </a>
        </div>

        @forelse($votes as $electionVotes)
            @php
                $firstVote = $electionVotes->first();
                $election = $firstVote?->election;
            @endphp

            <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $election?->title ?? 'Election' }}</h2>
                            <p class="text-sm text-gray-500">Submitted {{ optional($firstVote?->created_at)->format('M d, Y h:i A') }}</p>
                        </div>
                        <span class="inline-flex w-fit rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                            {{ $electionVotes->count() }} recorded vote{{ $electionVotes->count() === 1 ? '' : 's' }}
                        </span>
                    </div>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($electionVotes->sortBy('position') as $vote)
                        <div class="grid gap-2 px-6 py-4 sm:grid-cols-[180px_1fr]">
                            <div class="text-sm font-medium text-gray-500">{{ $vote->position }}</div>
                            <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $vote->candidate?->name ?? 'Candidate removed' }}</div>
                        </div>
                    @endforeach
                </div>
            </section>
        @empty
            <div class="rounded-lg border border-dashed border-gray-300 bg-white px-6 py-12 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">No submitted ballots yet</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Active elections will appear on your dashboard when voting is open.</p>
                <a href="{{ route('dashboard') }}" class="mt-5 inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Go to Dashboard
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
