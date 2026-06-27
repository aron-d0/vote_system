@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div>
            <p class="text-sm font-medium text-indigo-600">Ballot</p>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Cast Your Vote</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Submit one complete ballot per election. Your selections cannot be changed afterward.</p>
        </div>

        @if($elections->isEmpty())
            <div class="rounded-lg border border-dashed border-gray-300 bg-white px-6 py-12 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">No active elections available</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Voting will appear here once an election is open.</p>
            </div>
        @else
            <form id="ballot-form" action="{{ route('votes.store') }}" method="POST" class="space-y-6">
                @csrf

                @if(! isset($selectedElection))
                    <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <label for="election_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Election</label>
                        <select name="election_id" id="election_id" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" required>
                            <option value="">Select an election</option>
                            @foreach($elections as $election)
                                @php $alreadyVoted = in_array($election->id, $votedElectionIds ?? [], true); @endphp
                                <option value="{{ $election->id }}" {{ old('election_id') == $election->id ? 'selected' : '' }} {{ $alreadyVoted ? 'disabled' : '' }}>
                                    {{ $election->title }}{{ $alreadyVoted ? ' (already voted)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-sm text-gray-500">Already-voted elections are disabled.</p>
                        @error('election_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </section>
                @else
                    <input type="hidden" name="election_id" value="{{ $selectedElection->id }}">
                    <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $selectedElection->title }}</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $selectedElection->description ?: 'No description provided.' }}</p>
                    </section>
                @endif

                @foreach(($selectedElection ? collect([$selectedElection]) : $elections) as $election)
                    <section class="election-section space-y-5 rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800" data-election-id="{{ $election->id }}" {{ isset($selectedElection) ? '' : 'hidden' }}>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $election->title }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Choose one President, one Vice President, and up to three Senators.</p>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <h3 class="mb-3 text-base font-semibold text-gray-900 dark:text-white">President</h3>
                                <div class="grid gap-3 md:grid-cols-2">
                                    @forelse($election->candidates->where('position', App\Models\Candidate::POSITION_PRESIDENT) as $candidate)
                                        <label class="candidate-choice">
                                            <input type="radio" name="president_candidate" value="{{ $candidate->id }}" class="h-5 w-5 text-indigo-600" required {{ old('president_candidate') == $candidate->id ? 'checked' : '' }}>
                                            <span>
                                                <span class="block font-semibold text-gray-900 dark:text-white">{{ $candidate->name }}</span>
                                                <span class="block text-sm text-gray-500">President candidate</span>
                                            </span>
                                        </label>
                                    @empty
                                        <p class="rounded-md bg-yellow-50 px-4 py-3 text-sm text-yellow-800">No president candidates available.</p>
                                    @endforelse
                                </div>
                                @error('president_candidate')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <h3 class="mb-3 text-base font-semibold text-gray-900 dark:text-white">Vice President</h3>
                                <div class="grid gap-3 md:grid-cols-2">
                                    @forelse($election->candidates->where('position', App\Models\Candidate::POSITION_VICE) as $candidate)
                                        <label class="candidate-choice">
                                            <input type="radio" name="vice_president_candidate" value="{{ $candidate->id }}" class="h-5 w-5 text-indigo-600" required {{ old('vice_president_candidate') == $candidate->id ? 'checked' : '' }}>
                                            <span>
                                                <span class="block font-semibold text-gray-900 dark:text-white">{{ $candidate->name }}</span>
                                                <span class="block text-sm text-gray-500">Vice President candidate</span>
                                            </span>
                                        </label>
                                    @empty
                                        <p class="rounded-md bg-yellow-50 px-4 py-3 text-sm text-yellow-800">No vice president candidates available.</p>
                                    @endforelse
                                </div>
                                @error('vice_president_candidate')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Senators</h3>
                                    <p class="senator-count text-sm font-medium text-gray-600 dark:text-gray-400">Selected 0 of 3</p>
                                </div>
                                <div class="grid gap-3 md:grid-cols-2">
                                    @forelse($election->candidates->where('position', App\Models\Candidate::POSITION_SENATOR)->take(12) as $candidate)
                                        <label class="candidate-choice">
                                            <input type="checkbox" name="senator_candidates[]" value="{{ $candidate->id }}" class="senator-checkbox h-5 w-5 rounded text-indigo-600" {{ is_array(old('senator_candidates')) && in_array($candidate->id, old('senator_candidates', [])) ? 'checked' : '' }}>
                                            <span>
                                                <span class="block font-semibold text-gray-900 dark:text-white">{{ $candidate->name }}</span>
                                                <span class="block text-sm text-gray-500">Senator candidate</span>
                                            </span>
                                        </label>
                                    @empty
                                        <p class="rounded-md bg-yellow-50 px-4 py-3 text-sm text-yellow-800">No senator candidates available.</p>
                                    @endforelse
                                </div>
                                @error('senator_candidates')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                @error('senator_candidates.*')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </section>
                @endforeach

                <div class="flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:flex-row sm:items-center sm:justify-between">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="want_print" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600">
                        Show receipt after submitting
                    </label>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-green-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                        Submit Ballot
                    </button>
                </div>
            </form>

            <script>
                const electionSelect = document.getElementById('election_id');
                const sections = document.querySelectorAll('.election-section');

                function updateElectionSections() {
                    if (!electionSelect) return;

                    const selectedId = electionSelect.value;

                    sections.forEach(section => {
                        const isVisible = section.dataset.electionId === selectedId;
                        section.hidden = !isVisible;
                        section.querySelectorAll('input, select, textarea, button').forEach(element => {
                            element.disabled = !isVisible;
                        });
                    });
                }

                if (electionSelect) {
                    electionSelect.addEventListener('change', updateElectionSections);
                    updateElectionSections();
                }

                function updateSenatorCounter(section) {
                    const checkboxes = section.querySelectorAll('.senator-checkbox');
                    const countEl = section.querySelector('.senator-count');
                    const selected = Array.from(checkboxes).filter(cb => cb.checked).length;

                    if (countEl) {
                        countEl.textContent = `Selected ${selected} of 3`;
                    }

                    if (section.hidden) {
                        return;
                    }

                    checkboxes.forEach(cb => {
                        cb.disabled = selected >= 3 && !cb.checked;
                    });
                }

                sections.forEach(section => {
                    section.addEventListener('change', event => {
                        if (event.target.classList.contains('senator-checkbox')) {
                            updateSenatorCounter(section);
                        }
                    });
                    updateSenatorCounter(section);
                });
            </script>
        @endif
    </div>
</div>
@endsection
