<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CandidateApiController;
use App\Http\Controllers\Api\ElectionApiController;
use App\Http\Controllers\Api\ResultApiController;
use App\Http\Controllers\Api\VoteApiController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public endpoints - candidates, elections, and results
Route::get('/candidates', [CandidateApiController::class, 'index']);
Route::get('/candidates/{candidate}', [CandidateApiController::class, 'show']);
Route::get('/elections', [ElectionApiController::class, 'index']);
Route::get('/elections/{election}', [ElectionApiController::class, 'show']);
Route::get('/elections/{election}/candidates', [CandidateApiController::class, 'byElection']);
Route::get('/elections/{election}/results/public', [ResultApiController::class, 'publicResults']);
Route::post('/login', [AuthController::class, 'login']);

// Authenticated endpoints
Route::middleware('auth:api')->group(function () {
    // Get current user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Votes API
    Route::post('/votes', [VoteApiController::class, 'store']);
    Route::get('/votes', [VoteApiController::class, 'userVotes']);

    // Results API (admin only)
    Route::get('/elections/{election}/results', [ResultApiController::class, 'show'])->middleware('is_admin');
    Route::get('/elections/{election}/results/summary', [ResultApiController::class, 'summary'])->middleware('is_admin');

    Route::middleware([IsAdmin::class])->group(function () {
        Route::post('/elections', [ElectionApiController::class, 'store']);
        Route::match(['put', 'patch'], '/elections/{election}', [ElectionApiController::class, 'update']);
        Route::delete('/elections/{election}', [ElectionApiController::class, 'destroy']);

        Route::post('/candidates', [CandidateApiController::class, 'store']);
        Route::match(['put', 'patch'], '/candidates/{candidate}', [CandidateApiController::class, 'update']);
        Route::delete('/candidates/{candidate}', [CandidateApiController::class, 'destroy']);
    });
});
