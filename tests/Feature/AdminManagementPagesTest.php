<?php

use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;

test('admin dashboard and management pages render', function () {
    $admin = User::factory()->create([
        'is_admin' => true,
    ]);

    $election = Election::create([
        'title' => 'Render Check Election',
        'description' => 'A seeded election for admin page rendering.',
        'start_at' => now()->subDay(),
        'end_at' => now()->addDay(),
    ]);

    Candidate::create([
        'name' => 'Render Check Candidate',
        'election_id' => $election->id,
        'position' => Candidate::POSITION_PRESIDENT,
    ]);

    $this->actingAs($admin)->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Election Control Center');

    $this->actingAs($admin)->get(route('elections.index'))
        ->assertOk()
        ->assertSee('Render Check Election');

    $this->actingAs($admin)->get(route('candidates.index'))
        ->assertOk()
        ->assertSee('Render Check Candidate');
});
