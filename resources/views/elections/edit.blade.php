@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="mb-6">
                <p class="text-sm font-medium text-indigo-600">Admin</p>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Election</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Adjust the election details and voting window.</p>
            </div>

            <form action="{{ route('elections.update', $election) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input id="title" type="text" name="title" value="{{ old('title', $election->title) }}" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" required>
                    @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea id="description" name="description" rows="3" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">{{ old('description', $election->description) }}</textarea>
                    @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="start_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date & Time</label>
                        <input id="start_at" type="datetime-local" name="start_at" value="{{ old('start_at', optional($election->start_at)->format('Y-m-d\TH:i')) }}" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" required>
                        @error('start_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="end_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date & Time</label>
                        <input id="end_at" type="datetime-local" name="end_at" value="{{ old('end_at', optional($election->end_at)->format('Y-m-d\TH:i')) }}" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" required>
                        @error('end_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('elections.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Cancel</a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Update Election</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
