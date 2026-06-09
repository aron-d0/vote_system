@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Cast Your Vote</h1>

@if($elections->isEmpty())
    <div class="rounded-lg bg-white shadow-sm p-6">
        <p class="text-gray-700">There are no active elections available right now.</p>
    </div>
@else
    <form id="ballot-form" action="{{ route('votes.store') }}" method="POST" class="space-y-6">
        @csrf

        @if(! isset($selectedElection))
            <div>
                <label for="election_id" class="block font-medium">Election</label>
                <select name="election_id" id="election_id" class="border p-2 w-full rounded" required>
                    <option value="">Select an election</option>
                    @foreach($elections as $election)
                        @php $alreadyVoted = in_array($election->id, $votedElectionIds ?? [], true); @endphp
                        <option value="{{ $election->id }}" {{ old('election_id') == $election->id ? 'selected' : '' }} {{ $alreadyVoted ? 'disabled' : '' }}>
                            {{ $election->title }}{{ $alreadyVoted ? ' (already voted)' : '' }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-2">You may only vote once per election. Already-voted elections are disabled.</p>
                @error('election_id')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>
        @else
            <input type="hidden" name="election_id" value="{{ $selectedElection->id }}">
            <div class="rounded-lg border bg-white p-4 shadow-sm">
                <h2 class="text-xl font-semibold">{{ $selectedElection->title }}</h2>
                <p class="text-sm text-gray-500">Voting for {{ $selectedElection->title }}.</p>
            </div>
        @endif

        @foreach(($selectedElection ? collect([$selectedElection]) : $elections) as $election)
            <div class="election-section border rounded-lg p-4 bg-white shadow-sm" data-election-id="{{ $election->id }}" {{ isset($selectedElection) ? '' : 'hidden' }}>
                <h2 class="text-lg font-semibold mb-3">{{ $election->title }}</h2>
                <p class="text-sm text-gray-500 mb-4">Choose one candidate for each position below.</p>

                <div class="grid gap-6">
                    <div class="rounded-lg border p-4 bg-gray-50">
                        <h3 class="font-semibold mb-3">President</h3>
                        <div class="grid gap-3 md:grid-cols-2">
                            @forelse($election->candidates->where('position', App\Models\Candidate::POSITION_PRESIDENT) as $candidate)
                                <label class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-4 cursor-pointer hover:border-indigo-500">
                                    <input type="radio" name="president_candidate" value="{{ $candidate->id }}" class="form-radio h-5 w-5 text-indigo-600" required {{ old('president_candidate') == $candidate->id ? 'checked' : '' }}>
                                    <div class="space-y-1">
                                        <div class="text-lg font-semibold">{{ $candidate->name }}</div>
                                        <div class="text-sm text-gray-500">President candidate</div>
                                    </div>
                                </label>
                            @empty
                                <p class="text-gray-500">No president candidates available.</p>
                            @endforelse
                        </div>
                        @error('president_candidate')<p class="text-red-600 text-sm mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div class="rounded-lg border p-4 bg-gray-50">
                        <h3 class="font-semibold mb-3">Vice President</h3>
                        <div class="grid gap-3 md:grid-cols-2">
                            @forelse($election->candidates->where('position', App\Models\Candidate::POSITION_VICE) as $candidate)
                                <label class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-4 cursor-pointer hover:border-indigo-500">
                                    <input type="radio" name="vice_president_candidate" value="{{ $candidate->id }}" class="form-radio h-5 w-5 text-indigo-600" required {{ old('vice_president_candidate') == $candidate->id ? 'checked' : '' }}>
                                    <div class="space-y-1">
                                        <div class="text-lg font-semibold">{{ $candidate->name }}</div>
                                        <div class="text-sm text-gray-500">Vice President candidate</div>
                                    </div>
                                </label>
                            @empty
                                <p class="text-gray-500">No vice president candidates available.</p>
                            @endforelse
                        </div>
                        @error('vice_president_candidate')<p class="text-red-600 text-sm mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div class="rounded-lg border p-4 bg-gray-50">
                        <h3 class="font-semibold mb-3">Senators (Select up to 3 from 12 candidates)</h3>
                        <div class="grid gap-3 md:grid-cols-2">
                            @forelse($election->candidates->where('position', App\Models\Candidate::POSITION_SENATOR)->take(12) as $candidate)
                                <label class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-4 cursor-pointer hover:border-indigo-500">
                                    <input type="checkbox" name="senator_candidates[]" value="{{ $candidate->id }}" class="form-checkbox h-5 w-5 text-indigo-600 senator-checkbox" {{ is_array(old('senator_candidates')) && in_array($candidate->id, old('senator_candidates', [])) ? 'checked' : '' }}>
                                    <div class="space-y-1">
                                        <div class="text-lg font-semibold">{{ $candidate->name }}</div>
                                        <div class="text-sm text-gray-500">Senator candidate</div>
                                    </div>
                                </label>
                            @empty
                                <p class="text-gray-500">No senator candidates available.</p>
                            @endforelse
                        </div>
                        @error('senator_candidates')<p class="text-red-600 text-sm mt-2">{{ $message }}</p>@enderror
                        @error('senator_candidates.*')<p class="text-red-600 text-sm mt-2">{{ $message }}</p>@enderror
                        <p class="senator-count text-sm text-gray-600 mt-2">Selected 0 of 3</p>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="flex items-center gap-3 mt-4">
            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="want_print" value="1" class="form-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded">
                Print a paper receipt after submitting your ballot
            </label>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Submit Ballot</button>
    </form>

    <script>
        const electionSelect = document.getElementById('election_id');
        const sections = document.querySelectorAll('.election-section');

        function updateElectionSections() {
            if (! electionSelect) {
                return;
            }

            const selectedId = electionSelect.value;

            sections.forEach(section => {
                const isVisible = section.dataset.electionId === selectedId;
                section.hidden = !isVisible;
                section.querySelectorAll('select, input').forEach(element => {
                    element.disabled = !isVisible;
                });
            });
        }

        if (electionSelect) {
            if (electionSelect.value === '' && electionSelect.options.length > 1) {
                for (let i = 0; i < electionSelect.options.length; i++) {
                    if (electionSelect.options[i].value) {
                        electionSelect.selectedIndex = i;
                        break;
                    }
                }
            }

            electionSelect.addEventListener('change', updateElectionSections);
            updateElectionSections();
        }

        function updateSenatorCounter(section) {
            const checkboxes = section.querySelectorAll('.senator-checkbox');
            const countEl = section.querySelector('.senator-count');
            if (! countEl) return;
            let selected = 0;
            checkboxes.forEach(cb => { if (cb.checked) selected++; });
            countEl.textContent = `Selected ${selected} of 3`;
            checkboxes.forEach(cb => {
                cb.disabled = selected >= 3 && !cb.checked;
            });
        }

        sections.forEach(section => {
            section.addEventListener('change', function (e) {
                if (e.target.classList.contains('senator-checkbox')) {
                    updateSenatorCounter(section);
                }
            });
            updateSenatorCounter(section);
        });
    </script>
@endif
@endsection
