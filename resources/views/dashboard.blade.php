<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <p class="text-sm font-medium text-indigo-200">Voter workspace</p>
            <h2 class="text-xl font-semibold text-white leading-tight">Dashboard</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <section class="grid gap-4 md:grid-cols-3">
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Active elections</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $activeElections->count() }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Completed ballots</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $votedElectionIds->count() }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Recorded selections</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $submittedVotes->count() }}</p>
                </div>
            </section>

            <section class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Open Elections</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Choose an available election and submit one complete ballot.</p>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($activeElections as $election)
                        @php $alreadyVoted = $votedElectionIds->contains($election->id); @endphp
                        <div class="flex flex-col gap-4 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h4 class="text-base font-semibold text-gray-900 dark:text-white">{{ $election->title }}</h4>
                                    @if($alreadyVoted)
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">Submitted</span>
                                    @else
                                        <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-800">Open</span>
                                    @endif
                                </div>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $election->description ?: 'No description provided.' }}</p>
                                <p class="mt-2 text-xs text-gray-500">
                                    Ends {{ optional($election->end_at)->format('M d, Y h:i A') }} · {{ $election->candidates_count }} candidates
                                </p>
                            </div>

                            @if($alreadyVoted)
                                <a href="{{ route('votes.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                                    View Ballot
                                </a>
                            @else
                                <a href="{{ route('votes.election.create', $election) }}" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                                    Vote Now
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-white">No active elections right now</h4>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Please check back once an administrator opens an election.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
