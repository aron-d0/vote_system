<x-app-layout>
    <h1 class="text-3xl font-bold mb-6 text-indigo-600">My Votes</h1>

    <ul class="grid md:grid-cols-2 gap-6">
        @forelse($votes as $vote)
            <li class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
                <div class="font-semibold text-gray-800 text-lg">
                    {{ $vote->candidate->name }}
                </div>
                <div class="text-sm text-gray-600 mt-1">
                    {{ $vote->position }} · {{ $vote->election->title }}
                </div>
            </li>
        @empty
            <li class="bg-gray-50 rounded-lg p-4 text-center text-gray-500 shadow-sm">
                No votes yet.
            </li>
        @endforelse
    </ul>
</x-app-layout>
