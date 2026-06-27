<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->is_admin) {
        return redirect()->route('admin.dashboard');
    }

    $activeElections = Election::active()->withCount('candidates')->orderBy('end_at')->get();
    $votedElectionIds = Vote::where('user_id', $user->id)->pluck('election_id')->unique();
    $submittedVotes = Vote::where('user_id', $user->id)->with(['candidate', 'election'])->latest()->get();

    return view('dashboard', compact('activeElections', 'votedElectionIds', 'submittedVotes'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('elections', ElectionController::class)->except(['show']);
    Route::resource('candidates', CandidateController::class)->except(['show']);
    Route::get('elections/{election}/results', [ElectionController::class, 'results'])->name('elections.results');
    Route::get('elections/{election}/analytics', [AnalyticsController::class, 'dashboard'])->name('elections.analytics');
    Route::get('api/elections/{election}/live-results', [AnalyticsController::class, 'liveResults'])->name('elections.liveResults');
    Route::get('admin', function () {
        return view('admin.dashboard', [
            'totalElections' => Election::count(),
            'activeElections' => Election::active()->count(),
            'totalCandidates' => Candidate::count(),
            'totalBallots' => Vote::query()
                ->select('user_id', 'election_id')
                ->distinct()
                ->get()
                ->count(),
            'recentElections' => Election::withCount('candidates')->latest()->take(5)->get(),
        ]);
    })->name('admin.dashboard');
});

// Voter routes
Route::middleware(['auth'])->group(function () {
    Route::get('votes', [VoteController::class, 'index'])->name('votes.index');
    Route::get('votes/create', [VoteController::class, 'create'])->name('votes.create');
    Route::get('elections/{election}/vote', [VoteController::class, 'create'])->name('votes.election.create');
    Route::post('votes', [VoteController::class, 'store'])->name('votes.store');
    Route::get('votes/receipt', [VoteController::class, 'receipt'])->name('votes.receipt');
    Route::get('voter/verification', function () {
        return view('votes.voter-verification');
    })->name('voter.verification');
});

require __DIR__.'/auth.php';
