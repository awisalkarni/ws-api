<?php

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create([
        'email' => 'admin@ws-api.test',
        'password' => bcrypt('password'),
    ]);
});

it('shows login page', function () {
    $this->get('/admin/login')
        ->assertSuccessful()
        ->assertSee('Waktu Solat Admin');
});

it('redirects authenticated admin from login page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/login')
        ->assertRedirect('/');
});

it('authenticates with valid credentials', function () {
    $this->post('/admin/login', [
        'email' => 'admin@ws-api.test',
        'password' => 'password',
    ])
        ->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticated();
});

it('rejects invalid credentials', function () {
    $this->post('/admin/login', [
        'email' => 'admin@ws-api.test',
        'password' => 'wrong-password',
    ])
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('redirects unauthenticated user to login', function () {
    $this->get('/admin/dashboard')
        ->assertRedirect('/admin/login');
});

it('can access dashboard when authenticated', function () {
    $this->actingAs($this->admin)
        ->get('/admin/dashboard')
        ->assertSuccessful();
});

it('can logout', function () {
    $this->actingAs($this->admin)
        ->post('/admin/logout')
        ->assertRedirect(route('admin.login'));

    $this->assertGuest();
});
