@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="flex flex-col gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold">Voting Receipt</h1>
            <p class="text-sm text-gray-500">Your vote has been successfully recorded. Review your selections below.</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded font-semibold cursor-pointer">🖨️ Print Receipt</button>
            <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded font-semibold">Back to Dashboard</a>
        </div>
    </div>

    <div class="rounded-lg border bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold mb-3">Election</h2>
        <p class="text-lg">{{ $receipt['election'] }}</p>

        <div class="mt-6 grid gap-4 md:grid-cols-3">
            <div class="rounded-lg border p-4 bg-gray-50">
                <h3 class="font-semibold text-lg mb-2">President</h3>
                <p>{{ $receipt['president'] }}</p>
            </div>
            <div class="rounded-lg border p-4 bg-gray-50">
                <h3 class="font-semibold text-lg mb-2">Vice President</h3>
                <p>{{ $receipt['vice_president'] }}</p>
            </div>
            <div class="rounded-lg border p-4 bg-gray-50 md:col-span-3">
                <h3 class="font-semibold text-lg mb-2">Senators</h3>
                @if(count($receipt['senators']))
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($receipt['senators'] as $senator)
                            <li>{{ $senator }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No senators selected.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
