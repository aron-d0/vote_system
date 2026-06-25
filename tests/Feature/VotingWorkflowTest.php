<?php

use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;

function createElectionWithCandidates(): array
{
    $election = Election::create([
        'title' => 'Student Council 2026',
        'description' => 'A test election.',
        'start_at' => now()->subHour(),
        'end_at' => now()->addHour(),
    ]);

    $president = Candidate::create([
        'name' => 'President Candidate',
        'election_id' => $election->id,
        'position' => Candidate::POSITION_PRESIDENT,
    ]);

    $vicePresident = Candidate::create([
        'name' => 'Vice President Candidate',
        'election_id' => $election->id,
        'position' => Candidate::POSITION_VICE,
    ]);

    $senators = collect(range(1, 3))->map(fn (int $number) => Candidate::create([
        'name' => "Senator Candidate {$number}",
        'election_id' => $election->id,
        'position' => Candidate::POSITION_SENATOR,
    ]));

    return [$election, $president, $vicePresident, $senators];
}

test('a voter can submit one complete ballot for an active election', function () {
    [$election, $president, $vicePresident, $senators] = createElectionWithCandidates();
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/votes', [
        'election_id' => $election->id,
        'president_candidate' => $president->id,
        'vice_president_candidate' => $vicePresident->id,
        'senator_candidates' => $senators->pluck('id')->all(),
    ]);

    $response->assertRedirect(route('dashboard', absolute: false));

    expect(Vote::where('user_id', $user->id)->where('election_id', $election->id)->count())->toBe(5);
});

test('a voter cannot submit a second ballot for the same election', function () {
    [$election, $president, $vicePresident, $senators] = createElectionWithCandidates();
    $user = User::factory()->create();

    Vote::create([
        'user_id' => $user->id,
        'candidate_id' => $president->id,
        'election_id' => $election->id,
        'position' => Candidate::POSITION_PRESIDENT,
    ]);

    $response = $this->actingAs($user)->post('/votes', [
        'election_id' => $election->id,
        'president_candidate' => $president->id,
        'vice_president_candidate' => $vicePresident->id,
        'senator_candidates' => $senators->pluck('id')->all(),
    ]);

    $response->assertSessionHasErrors('election_id');

    expect(Vote::where('user_id', $user->id)->where('election_id', $election->id)->count())->toBe(1);
});

test('an admin API token can create an election through admin middleware', function () {
    $admin = User::factory()->create([
        'is_admin' => true,
        'api_token' => 'test-admin-token',
    ]);

    $response = $this
        ->withHeader('Authorization', 'Bearer '.$admin->api_token)
        ->postJson('/api/elections', [
            'title' => 'API Election',
            'description' => 'Created through the API.',
            'start_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'end_at' => now()->addDays(2)->format('Y-m-d H:i:s'),
        ]);

    $response->assertCreated()
        ->assertJsonPath('title', 'API Election');

    $this->assertDatabaseHas('elections', [
        'title' => 'API Election',
        'description' => 'Created through the API.',
    ]);
});
