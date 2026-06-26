<?php

use App\Models\User;

test('api register creates a voter account without returning a token', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Postman Demo Voter',
        'email' => 'postman-voter@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertCreated()
        ->assertJsonPath('message', 'Account created successfully. Please log in to get an API token.')
        ->assertJsonPath('user.email', 'postman-voter@example.com')
        ->assertJsonMissingPath('token');

    $this->assertDatabaseHas('users', [
        'email' => 'postman-voter@example.com',
        'is_admin' => false,
    ]);
});

test('api login returns a bearer token for valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'voter@example.com',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertOk()
        ->assertJsonPath('token_type', 'Bearer')
        ->assertJsonPath('user.email', 'voter@example.com')
        ->assertJsonStructure(['token', 'token_type', 'user']);

    expect($user->fresh()->api_token)->not->toBeNull();
});

test('api login rejects invalid credentials', function () {
    $user = User::factory()->create([
        'email' => 'voter@example.com',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertUnauthorized()
        ->assertJsonPath('message', 'Invalid credentials');
});

test('protected api routes require a bearer token', function () {
    $this->getJson('/api/user')
        ->assertUnauthorized();
});

test('api logout revokes the bearer token', function () {
    $user = User::factory()->create([
        'api_token' => 'test-token',
    ]);

    $this->withHeader('Authorization', 'Bearer test-token')
        ->postJson('/api/logout')
        ->assertOk()
        ->assertJsonPath('message', 'Logged out successfully');

    expect($user->fresh()->api_token)->toBeNull();
});
