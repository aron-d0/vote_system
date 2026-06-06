@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-900 min-h-screen">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-800 text-gray-200 shadow-md sm:rounded-lg p-8">
            
            <!-- Header -->
            <h1 class="text-3xl font-bold mb-6 text-white">Create Election</h1>

            <!-- Form -->
            <form action="{{ route('elections.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" 
                           class="w-full rounded-md border-gray-600 bg-gray-700 text-gray-200 
                                  focus:ring-blue-500 focus:border-blue-500 p-3" required>
                    @error('title')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full rounded-md border-gray-600 bg-gray-700 text-gray-200 
                                     focus:ring-blue-500 focus:border-blue-500 p-3">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Start Date & Time</label>
                        <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" 
                               class="w-full rounded-md border-gray-600 bg-gray-700 text-gray-200 
                                      focus:ring-blue-500 focus:border-blue-500 p-3" required>
                        @error('start_at')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">End Date & Time</label>
                        <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" 
                               class="w-full rounded-md border-gray-600 bg-gray-700 text-gray-200 
                                      focus:ring-blue-500 focus:border-blue-500 p-3" required>
                        @error('end_at')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-md shadow-md transition">
                        Save Election
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
