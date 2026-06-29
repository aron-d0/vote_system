@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">Ballot submitted</p>
                <h1 class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">Voting Receipt</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Your selections were recorded successfully.</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                <button onclick="window.print()" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                    Print Receipt
                </button>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
                    Back to Dashboard
                </a>
            </div>
        </div>

        <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-5 dark:border-gray-700 dark:bg-gray-900">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Election</p>
                <h2 class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $receipt['election'] }}</h2>
            </div>

            <div class="grid gap-0 divide-y divide-gray-100 dark:divide-gray-700 md:grid-cols-2 md:divide-x md:divide-y-0">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">President</p>
                    <p class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $receipt['president'] }}</p>
                </div>
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Vice President</p>
                    <p class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $receipt['vice_president'] }}</p>
                </div>
            </div>

            <div class="border-t border-gray-200 p-6 dark:border-gray-700">
                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Senators</p>
                        <h3 class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                            {{ count($receipt['senators']) }} selected
                        </h3>
                    </div>
                </div>

                @if(count($receipt['senators']))
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        @foreach($receipt['senators'] as $senator)
                            <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-semibold text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                {{ $senator }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="mt-4 rounded-md border border-dashed border-gray-300 px-4 py-3 text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">No senators selected.</p>
                @endif
            </div>
        </section>
    </div>
</div>
@endsection
