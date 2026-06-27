@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">Administrator</p>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Election Control Center</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage elections, candidates, and result monitoring from one place.</p>
            </div>
            <a href="{{ route('elections.create') }}" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                Create Election
            </a>
        </div>

        <section class="grid gap-4 md:grid-cols-4">
            <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total elections</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalElections }}</p>
            </div>
            <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <p class="text-sm text-gray-500 dark:text-gray-400">Active elections</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $activeElections }}</p>
            </div>
            <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <p class="text-sm text-gray-500 dark:text-gray-400">Candidates</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalCandidates }}</p>
            </div>
            <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <p class="text-sm text-gray-500 dark:text-gray-400">Ballots submitted</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalBallots }}</p>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1fr_360px]">
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Elections</h2>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($recentElections as $election)
                        <div class="flex flex-col gap-3 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $election->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $election->candidates_count }} candidates · {{ optional($election->start_at)->format('M d, Y') }} to {{ optional($election->end_at)->format('M d, Y') }}</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('elections.edit', $election) }}" class="rounded-md border border-gray-300 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Edit</a>
                                <a href="{{ route('elections.results', $election) }}" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white hover:bg-green-700">Results</a>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center text-sm text-gray-500">No elections have been created yet.</div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h2>
                <div class="mt-5 grid gap-3">
                    <a href="{{ route('elections.index') }}" class="rounded-md border border-gray-300 px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Manage Elections</a>
                    <a href="{{ route('candidates.index') }}" class="rounded-md border border-gray-300 px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Manage Candidates</a>
                    <a href="{{ route('voter.verification') }}" class="rounded-md border border-gray-300 px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Voter Verification</a>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
