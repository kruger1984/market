<?php

declare(strict_types=1);

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('admin.dashboard.index'));
    $response->assertRedirect(route('login'));
});

test('authenticated users as admin can visit the dashboard', function () {
    $user = User::factory()->asAdmin()->create();
    $this->actingAs($user);

    $response = $this->get(route('admin.dashboard.index'));
    $response->assertOk();
});
