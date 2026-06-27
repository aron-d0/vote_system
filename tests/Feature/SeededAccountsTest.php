<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;

test('seeded demo accounts can authenticate with documented passwords', function () {
    $this->seed(DatabaseSeeder::class);

    expect(Auth::attempt([
        'email' => 'admin@example.com',
        'password' => 'password123',
    ]))->toBeTrue();

    Auth::logout();

    expect(Auth::attempt([
        'email' => 'test@example.com',
        'password' => 'password',
    ]))->toBeTrue();

    Auth::logout();

    expect(Auth::attempt([
        'email' => 'aron@example.com',
        'password' => '12345678',
    ]))->toBeTrue();

    Auth::logout();

    expect(Auth::attempt([
        'email' => 'mariphilmarigmen11@gmail.com',
        'password' => '12345678',
    ]))->toBeTrue();
});

test('web login normalizes email casing and spaces', function () {
    User::factory()->create([
        'email' => 'aron@example.com',
        'password' => '12345678',
    ]);

    $this->post('/login', [
        'email' => '  ARON@EXAMPLE.COM  ',
        'password' => '12345678',
    ])->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});
