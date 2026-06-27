<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;

test('seeded admin account can authenticate with documented password', function () {
    $this->seed(DatabaseSeeder::class);

    expect(Auth::attempt([
        'email' => 'admin@example.com',
        'password' => 'password123',
    ]))->toBeTrue();

    expect(User::where('email', 'test@example.com')->exists())->toBeFalse();
    expect(User::where('email', 'mariphilmarigmen11@gmail.com')->exists())->toBeFalse();
    expect(User::where('email', 'aron@example.com')->exists())->toBeFalse();
});

test('seeding does not reset an existing admin password', function () {
    $admin = User::factory()->create([
        'name' => 'Existing Admin',
        'email' => 'admin@example.com',
        'password' => 'custom-secret',
        'is_admin' => false,
    ]);

    $this->seed(DatabaseSeeder::class);

    $admin->refresh();

    expect($admin->name)->toBe('Existing Admin');
    expect((bool) $admin->is_admin)->toBeTrue();
    expect(Auth::attempt([
        'email' => 'admin@example.com',
        'password' => 'custom-secret',
    ]))->toBeTrue();
});

test('web login normalizes email casing and spaces', function () {
    User::factory()->create([
        'email' => 'mariphilmarigmen11@gmail.com',
        'password' => '12345678',
    ]);

    $this->post('/login', [
        'email' => '  MARIPHILMARIGMEN11@GMAIL.COM  ',
        'password' => '12345678',
    ])->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});
