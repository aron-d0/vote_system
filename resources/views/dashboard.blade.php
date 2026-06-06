<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Dashboard Card -->
            <div class="bg-gray-800 shadow-lg sm:rounded-lg p-6 text-gray-200">
                
                @if(auth()->user()->is_admin)
                    <h3 class="text-lg font-bold mb-6 text-white">Admin Panel</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        
                        <!-- Elections Card -->
                        <div class="bg-gray-700 border border-gray-600 p-6 rounded-lg shadow hover:shadow-lg transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="font-semibold text-lg text-white">Manage Elections</h2>
                                    <p class="text-sm text-gray-300">Create, edit, and delete elections.</p>
                                </div>
                                <a href="{{ route('elections.index') }}" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md transition font-medium">
                                    Open
                                </a>
                            </div>
                        </div>

                        <!-- Candidates Card -->
                        <div class="bg-gray-700 border border-gray-600 p-6 rounded-lg shadow hover:shadow-lg transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="font-semibold text-lg text-white">Manage Candidates</h2>
                                    <p class="text-sm text-gray-300">Add, edit, or remove candidates.</p>
                                </div>
                                <a href="{{ route('candidates.index') }}" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md transition font-medium">
                                    Open
                                </a>
                            </div>
                        </div>

                        <!-- Votes Card -->
                        <div class="bg-gray-700 border border-gray-600 p-6 rounded-lg shadow hover:shadow-lg transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="font-semibold text-lg text-white">View Votes</h2>
                                    <p class="text-sm text-gray-300">Check ballots and voting history.</p>
                                </div>
                                <a href="{{ route('votes.index') }}" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md transition font-medium">
                                    Open
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Voting Area for non-admins -->
                    <h3 class="text-lg font-bold mb-6 text-white">Voting Area</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-gray-700 border border-gray-600 p-6 rounded-lg shadow hover:shadow-lg transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="font-semibold text-lg text-white">Start Voting</h2>
                                    <p class="text-sm text-gray-300">Cast your vote in active elections.</p>
                                </div>
                                <a href="{{ route('votes.create') }}" 
                                   class="inline-block bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md shadow-md transition font-medium">
                                    Vote Now
                                </a>
                            </div>
                        </div>
                        <div class="bg-gray-700 border border-gray-600 p-6 rounded-lg shadow hover:shadow-lg transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="font-semibold text-lg text-white">My Ballots</h2>
                                    <p class="text-sm text-gray-300">View your submitted votes.</p>
                                </div>
                                <a href="{{ route('votes.index') }}" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md transition font-medium">
                                    Open
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
