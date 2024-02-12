<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

test('test_only_admin_can_register_users', function () {
    $adminUser = User::factory()->create();

    $role = Role::create([
        'name' => 'administrator'
    ]);

    $adminUser->assignRole($role);

    $userData = [
        'name' => 'John Doe',
        'email' => 'jane@example.com',
        'role' => 'administrator',
    ];

    $response = $this->actingAs($adminUser)->post(route('register'), $userData);

    $response->assertStatus(302); // Assuming a redirect happens after successful registration
    $this->assertDatabaseHas('users', ['name' => 'John Doe', 'email' => 'jane@example.com']);
    $this->assertDatabaseHas('model_has_roles', ['model_id' => 2, 'role_id' => 1]);
});

test('test_registration_fails_without_required_fields', function () {
    $adminUser = User::factory()->create();

    $role = Role::create([
        'name' => 'administrator'
    ]);

    $adminUser->assignRole($role);

    $userData = [
        'name' => '', // Leave required fields empty
        'email' => '',
        'role' => '',
    ];

    $response = $this->actingAs($adminUser)->post(route('register'), $userData);
    $response->assertSessionHasErrors(['name', 'email', 'role']);
});

// Comprobar que un usuario sin role administrator no pueda registrar usuarios
test('test_registration_fails_without_administrator_role', function () {
    $adminUser = User::factory()->create();
    $role = Role::create([
        'name' => 'administrator'
    ]);

    $userData = [
        'name' => 'John Doe',
        'email' => 'jane@example.com',
        'role' => 'administrator',
    ];
    $response = $this->actingAs($adminUser)->post(route('register'), $userData);
    $response->assertStatus(403);
    $this->assertDatabaseMissing('users', ['name' => 'John Doe', 'email' => 'jane@example.com']);
});

/* test('test_email_is_sent_after_registration', function () {
    Mail::fake();
    $adminUser = User::factory()->create(['role' => 'admin']);
    $userData = [
        'name' => 'Jane Doe',
        'username' => 'janedoe',
        'role' => 'user',
        'email' => 'jane@example.com',
    ];

    $this->actingAs($adminUser)->post('/register', $userData);

    Mail::assertSent(function ($mail) use ($userData) {
        return $mail->to[0]['address'] === $userData['email'];
    });
}); */
