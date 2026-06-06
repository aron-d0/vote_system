@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('elections.index') }}" 
               class="text-indigo-400 hover:text-indigo-300 transition">← Back to Elections</a>
            <h1 class="text-3xl font-bold text-white mt-2">{{ $election->title }} - Analytics</h1>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
                <h3 class="text-sm font-semibold text-gray-400 uppercase">Total Voters</h3>
                <p class="text-4xl font-bold text-white mt-2">{{ $totalVoters }}</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
                <h3 class="text-sm font-semibold text-gray-400 uppercase">Total Candidates</h3>
                <p class="text-4xl font-bold text-white mt-2">{{ $totalCandidates }}</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
                <h3 class="text-sm font-semibold text-gray-400 uppercase">Election Status</h3>
                <p class="text-2xl font-bold mt-2">
                    <span class="@if($election->isActive()) text-green-400 @else text-red-400 @endif">
                        @if($election->isActive()) Active @else Inactive @endif
                    </span>
                </p>
            </div>
        </div>

        <!-- Charts by Position -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- President Chart -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
                <h2 class="text-xl font-semibold text-white mb-4">President Votes</h2>
                <canvas id="presidentChart"></canvas>
                <div class="mt-4 space-y-1 text-sm text-gray-300">
                    @foreach($positionResults['President'] as $candidate)
                        <div class="flex justify-between">
                            <span>{{ $candidate->name }}</span>
                            <span class="font-semibold text-green-400">{{ $candidate->votes_count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Vice President Chart -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
                <h2 class="text-xl font-semibold text-white mb-4">Vice President Votes</h2>
                <canvas id="viceChart"></canvas>
                <div class="mt-4 space-y-1 text-sm text-gray-300">
                    @foreach($positionResults['Vice President'] as $candidate)
                        <div class="flex justify-between">
                            <span>{{ $candidate->name }}</span>
                            <span class="font-semibold text-green-400">{{ $candidate->votes_count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Senator Chart -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
                <h2 class="text-xl font-semibold text-white mb-4">Top 5 Senators</h2>
                <canvas id="senatorChart"></canvas>
                <div class="mt-4 space-y-1 text-sm text-gray-300">
                    @foreach($positionResults['Senator']->take(5) as $candidate)
                        <div class="flex justify-between">
                            <span>{{ $candidate->name }}</span>
                            <span class="font-semibold text-green-400">{{ $candidate->votes_count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Auto-refresh Info -->
        <div class="mt-10 bg-blue-900 border border-blue-600 p-4 rounded-lg text-blue-200">
            <p>💡 Charts update every 10 seconds for real-time monitoring.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartConfig = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: { color: '#d1d5db' }
            }
        },
        scales: {
            y: {
                ticks: { color: '#d1d5db' },
                grid: { color: 'rgba(209, 213, 219, 0.1)' }
            },
            x: {
                ticks: { color: '#d1d5db' },
                grid: { color: 'rgba(209, 213, 219, 0.1)' }
            }
        }
    };

    // President Chart
    new Chart(document.getElementById('presidentChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['President']['labels']) !!},
            datasets: [{
                label: 'Votes',
                data: {!! json_encode($chartData['President']['votes']) !!},
                backgroundColor: ['rgba(59, 130, 246, 0.8)', 'rgba(139, 92, 246, 0.8)', 'rgba(236, 72, 153, 0.8)']
            }]
        },
        options: chartConfig
    });

    // Vice President Chart
    new Chart(document.getElementById('viceChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['Vice President']['labels']) !!},
            datasets: [{
                label: 'Votes',
                data: {!! json_encode($chartData['Vice President']['votes']) !!},
                backgroundColor: ['rgba(59, 130, 246, 0.8)', 'rgba(139, 92, 246, 0.8)', 'rgba(236, 72, 153, 0.8)']
            }]
        },
        options: chartConfig
    });

    // Senator Chart (Horizontal)
    new Chart(document.getElementById('senatorChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['Senator']['labels']) !!},
            datasets: [{
                label: 'Votes',
                data: {!! json_encode($chartData['Senator']['votes']) !!},
                backgroundColor: 'rgba(34, 197, 94, 0.8)'
            }]
        },
        options: { ...chartConfig, indexAxis: 'y' }
    });

    // Auto-refresh every 10 seconds
    setInterval(() => location.reload(), 10000);
</script>
@endsection
