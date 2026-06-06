@extends('layouts.app')

@section('content')
<div class="py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Edit Election</h1>

    <form action="{{ route('elections.update', $election->id) }}" method="POST" 
          class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf @method('PUT')

        <!-- Title -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
            <input type="text" name="title" 
                   value="{{ old('title', $election->title) }}" 
                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                          focus:ring-blue-500 focus:border-blue-500 p-2" required>
            @error('title')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                             focus:ring-blue-500 focus:border-blue-500 p-2">{{ old('description', $election->description) }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Dates -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date & Time</label>
                <input type="datetime-local" name="start_at" 
                       value="{{ old('start_at', optional($election->start_at)->format('Y-m-d\TH:i')) }}" 
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                              focus:ring-blue-500 focus:border-blue-500 p-2" required>
                @error('start_at')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date & Time</label>
                <input type="datetime-local" name="end_at" 
                       value="{{ old('end_at', optional($election->end_at)->format('Y-m-d\TH:i')) }}" 
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                              focus:ring-blue-500 focus:border-blue-500 p-2" required>
                @error('end_at')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-md shadow-md transition">
                Update Election
            </button>
        </div>
    </form>
</div>
@endsection
