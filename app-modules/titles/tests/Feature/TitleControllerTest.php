<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Titles\Models\Title;
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

test('an_administrator_can_see_the_titles_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('titles.index'));

    $response->assertStatus(200);
});

test('non_administrator_can_see_the_titles_index_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('titles.index'));
    $response->assertStatus(403);
});


test('an_administrator_can_see_the_titles_create_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('titles.create'));

    $response->assertStatus(200);
});

test('non_administrator_can_see_the_titles_create_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('titles.create'));

    $response->assertStatus(403);
});

test('an_administrator_can_store_a_titles', function () {

    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->post(route('titles.store'), $data)->assertRedirect(route('titles.create'));

    $this->assertDatabaseHas('titles', $data);
});

test('non_administrator_can_store_a_title', function () {

    $defaultUser = User::factory()->create();
    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($defaultUser)->post(route('titles.store'), $data);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('titles', $data);
});

test('an_administrator_can_store_a_title_without_required_fields', function () {

    $data = [
        'name' => '',
        'alias' => '',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->post(route('titles.store'), $data)->assertRedirect(route('titles.create'));

    $response->assertSessionHasErrors(['name', 'alias']);
});

test('an_administrator_can_store_a_title_with_repeated_name', function () {
    Title::create([
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ]);

    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->post(route('titles.store'), $data)->assertRedirect(route('titles.create'));

    $response->assertSessionHasErrors(['name']);
});

test('an_administrator_can_update_a_title', function () {
    $title = Title::create([
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ]);

    $data = [
        'name' => 'test1',
        'alias' => 'test1',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->put(route('titles.update', $title->id), $data)
        ->assertRedirect(route('titles.edit', $title->id));

    $this->assertDatabaseHas('titles', $data);
});

test('an_administrator_can_update_a_title_without_changes', function () {
    $title = Title::create([
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ]);

    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->put(route('titles.update', $title->id), $data)
        ->assertRedirect(route('titles.edit', $title->id));

    $response->assertSessionHasNoErrors();
});

test('administrator_can_delete_multiple_titles', function () {
    // Creamos un nuevo proveedor
    $title = Title::create([
        'name' => 'title1',
        'alias' => Str::slug('title1'),
        'status' => 1
    ]);
    // Creamos un nuevo proveedor
    $title2 = Title::create([
        'name' => 'Field2',
        'alias' => Str::slug('Field2'),
        'status' => 1
    ]);

    $response = $this->actingAs($this->admin)->delete(route('titles.bulk-destroy'), [
        'ids' => [$title->id, $title2->id]
    ]);

    $response->assertStatus(302);
    $this->assertDatabaseMissing('titles', $title->toArray());
    $this->assertDatabaseMissing('titles', $title2->toArray());
});
