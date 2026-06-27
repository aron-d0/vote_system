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

test('admin users are redirected away from voter ballot screens', function () {
    [$election] = createElectionWithCandidates();
    $admin = User::factory()->create([
        'is_admin' => true,
    ]);

    $this->actingAs($admin)
        ->get(route('votes.election.create', $election))
        ->assertRedirect(route('admin.dashboard', absolute: false))
        ->assertSessionHas('info');
});

test('voter ballot history groups submitted votes by election', function () {
    [$election, $president, $vicePresident, $senators] = createElectionWithCandidates();
    $user = User::factory()->create();

    foreach (array_merge([$president, $vicePresident], $senators->all()) as $candidate) {
        Vote::create([
            'user_id' => $user->id,
            'candidate_id' => $candidate->id,
            'election_id' => $election->id,
            'position' => $candidate->position,
        ]);
    }

    $this->actingAs($user)
        ->get(route('votes.index'))
        ->assertOk()
        ->assertSee('Student Council 2026')
        ->assertSee('President Candidate')
        ->assertSee('5 recorded votes');
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

test('an admin API token can patch an election without resending every field', function () {
    $election = Election::create([
        'title' => 'Original API Election',
        'description' => 'Before patch.',
        'start_at' => now()->addDay(),
        'end_at' => now()->addDays(2),
    ]);

    $admin = User::factory()->create([
        'is_admin' => true,
        'api_token' => 'patch-admin-token',
    ]);

    $this
        ->withHeader('Authorization', 'Bearer '.$admin->api_token)
        ->patchJson("/api/elections/{$election->id}", [
            'title' => 'Patched API Election',
        ])
        ->assertOk()
        ->assertJsonPath('title', 'Patched API Election');

    expect($election->fresh()->description)->toBe('Before patch.');
});

test('a voter can submit a ballot through the api with a bearer token', function () {
    [$election, $president, $vicePresident, $senators] = createElectionWithCandidates();
    $user = User::factory()->create([
        'api_token' => 'voter-api-token',
    ]);

    $response = $this
        ->withHeader('Authorization', 'Bearer '.$user->api_token)
        ->postJson('/api/votes', [
            'election_id' => $election->id,
            'president_candidate' => $president->id,
            'vice_president_candidate' => $vicePresident->id,
            'senator_candidates' => $senators->take(3)->pluck('id')->all(),
        ]);

    $response->assertCreated()
        ->assertJsonPath('message', 'Vote submitted successfully')
        ->assertJsonCount(5, 'votes')
        ->assertJsonPath('votes.0.election.title', 'Student Council 2026');
});
