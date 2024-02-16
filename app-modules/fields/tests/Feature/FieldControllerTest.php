<?php

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Fields\Models\Field;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    // Creamos un usuario
    $this->admin = User::factory()->create();

    // Creamos un role
    $role = Role::create([
        'name' => 'administrador',
    ]);

    // Asignamos el role al usuario
    $this->admin->assignRole($role);
});

test('an_administrator_can_see_the_fields_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('fields.index'));

    $response->assertStatus(200);
});


test('non_administrator_can_see_the_fields_index_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('fields.index'));
    $response->assertStatus(403);
});


test('an_administrator_can_see_the_fields_create_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('fields.create'));

    $response->assertStatus(200);
});

test('non_administrator_can_see_the_fields_create_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('fields.create'));

    $response->assertStatus(403);
});

test('an_administrator_can_store_a_fields', function () {

    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->post(route('fields.store'), $data)->assertRedirect(route('fields.create'));

    $this->assertDatabaseHas('fields', $data);
});

test('non_administrator_can_store_a_field', function () {

    $defaultUser = User::factory()->create();
    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($defaultUser)->post(route('fields.store'), $data);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('fields', $data);
});

test('an_administrator_can_store_a_field_without_required_fields', function () {

    $data = [
        'name' => '',
        'alias' => '',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->post(route('fields.store'), $data)->assertRedirect(route('fields.create'));

    $response->assertSessionHasErrors(['name', 'alias']);
});


test('an_administrator_can_store_a_field_with_repeated_name', function () {
    Field::create([
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ]);

    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->post(route('fields.store'), $data)->assertRedirect(route('fields.create'));

    $response->assertSessionHasErrors(['name']);
});

test('an_administrator_can_update_a_field', function () {
    $field = Field::create([
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ]);

    $data = [
        'name' => 'test1',
        'alias' => 'test1',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->put(route('fields.update', $field->id), $data)
        ->assertRedirect(route('fields.edit', $field->id));

    $this->assertDatabaseHas('fields', $data);
});

test('an_administrator_can_update_a_field_without_changes', function () {
    $field = Field::create([
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ]);

    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->put(route('fields.update', $field->id), $data)
        ->assertRedirect(route('fields.edit', $field->id));

    $response->assertSessionHasNoErrors();
});

test('administrator_can_delete_multiple_fields', function () {
    // Creamos un nuevo proveedor
    $field = Field::create([
        'name' => 'Field1',
        'alias' => Str::slug('Field1'),
        'status' => 1
    ]);
    // Creamos un nuevo proveedor
    $field2 = Field::create([
        'name' => 'Field2',
        'alias' => Str::slug('Field2'),
        'status' => 1
    ]);

    $response = $this->actingAs($this->admin)->delete(route('fields.bulk-destroy'), [
        'ids' => [$field->id, $field2->id]
    ]);

    $response->assertStatus(302);
    $this->assertDatabaseMissing('fields', $field->toArray());
    $this->assertDatabaseMissing('fields', $field2->toArray());
});
