<?php
$user = App\Models\User::factory()->create();
echo 'user id: ' . $user->id . PHP_EOL;
echo 'email: ' . $user->email . PHP_EOL;
echo 'password hash: ' . $user->password . PHP_EOL;
echo 'hash check: ' . (Illuminate\Support\Facades\Hash::check('password', $user->password) ? 'ok' : 'bad') . PHP_EOL;
echo 'attempt: ' . (Illuminate\Support\Facades\Auth::attempt(['email' => $user->email, 'password' => 'password']) ? 'ok' : 'bad') . PHP_EOL;
