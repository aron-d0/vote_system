<?php

test('login form action stays secure behind a forwarded https proxy', function () {
    $response = $this->withServerVariables([
        'HTTP_HOST' => 'votesystem-production-7bcf.up.railway.app',
        'HTTPS' => 'off',
    ])->withHeaders([
        'X-Forwarded-Proto' => 'https',
        'X-Forwarded-Host' => 'votesystem-production-7bcf.up.railway.app',
        'X-Forwarded-Port' => '443',
    ])->get('/login');

    $response->assertOk()
        ->assertSee('action="https://votesystem-production-7bcf.up.railway.app/login"', false);
});
