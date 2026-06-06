@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-800 text-gray-200 shadow-md sm:rounded-lg p-8">
            
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
                <a href="{{ route('elections.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md shadow-md transition font-semibold">
                    + New Election
                </a>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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

                <!-- Analytics Card -->
                <div class="bg-gray-700 border border-gray-600 p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="font-semibold text-lg text-white">Analytics</h2>
                            <p class="text-sm text-gray-300">View live results and charts.</p>
                        </div>
                        <a href="{{ route('elections.index') }}" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md transition font-medium">
                            Open
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 bg-gray-700 border border-gray-600 p-6 rounded-lg shadow">
                <h3 class="text-white font-semibold mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-4">
                    <!-- Voter QR Button -->
                    <a href="{{ route('voter.verification') }}" 
                       class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 
                              px-5 py-2 rounded-md text-white shadow-md transition font-semibold">
                        📱 Voter QR
                    </a>

                    <!-- Quick Seed Button -->
                    <form action="{{ route('elections.store') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 
                                       px-5 py-2 rounded-md text-white shadow-md transition font-semibold">
                            ⚡ Quick Seed
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
