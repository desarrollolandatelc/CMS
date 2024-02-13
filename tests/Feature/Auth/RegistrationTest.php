<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

test('registration_screen_can_be_rendered', function () {
    $admin = User::factory()->create();
    $role = Role::create(['name' => 'administrador']);
    $admin->assignRole($role);
    //Creamos un usuario y lo autenticamos
    $this->actingAs($admin);
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

test('new_users_can_register', function () {
    $admin = User::factory()->create();
    $role = Role::create(['name' => 'administrador']);
    $admin->assignRole($role);

    //Creamos un usuario y lo autenticamos
    $this->actingAs($admin);

    $response = $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'role' => 'administrador',
        'status' => 1
    ]);

    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'status' => 1
    ]);
});
