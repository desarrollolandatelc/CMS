<?php

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Brands\Models\Brand;
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

test('an_administrator_can_see_the_brands_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('brands.index'));

    $response->assertStatus(200);
});

test('non_administrator_can_see_the_brands_index_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('brands.index'));
    $response->assertStatus(403);
});


test('an_administrator_can_see_the_brands_create_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('brands.create'));

    $response->assertStatus(200);
});

test('non_administrator_can_see_the_brands_create_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('brands.create'));

    $response->assertStatus(403);
});


test('an_administrator_can_store_a_brand', function () {

    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->post(route('brands.store'), $data)->assertRedirect(route('brands.create'));

    $this->assertDatabaseHas('brands', $data);
});


test('non_administrator_can_store_a_brand', function () {

    $defaultUser = User::factory()->create();
    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($defaultUser)->post(route('brands.store'), $data);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('brands', $data);
});

test('an_administrator_can_store_a_brand_without_required_fields', function () {

    $data = [
        'name' => '',
        'alias' => '',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->post(route('brands.store'), $data)->assertRedirect(route('brands.create'));

    $response->assertSessionHasErrors(['name', 'alias']);
});

test('an_administrator_can_store_a_brand_with_repeated_name', function () {
    Brand::create([
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ]);

    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->post(route('brands.store'), $data)->assertRedirect(route('brands.create'));

    $response->assertSessionHasErrors(['name']);
});

test('an_administrator_can_update_a_brand', function () {
    $brand = Brand::create([
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ]);

    $data = [
        'name' => 'test1',
        'alias' => 'test1',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->put(route('brands.update', $brand->id), $data)
        ->assertRedirect(route('brands.edit', $brand->id));

    $this->assertDatabaseHas('brands', $data);
});

test('an_administrator_can_update_a_brand_without_changes', function () {
    $brand = Brand::create([
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ]);

    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->put(route('brands.update', $brand->id), $data)
        ->assertRedirect(route('brands.edit', $brand->id));

    $response->assertSessionHasNoErrors();
});

test('administrator_can_delete_multiple_brands', function () {
    // Creamos un nuevo proveedor
    $brand = Brand::create([
        'name' => 'Brand1',
        'alias' => Str::slug('Brand1'),
        'status' => 1
    ]);
    // Creamos un nuevo proveedor
    $brand2 = Brand::create([
        'name' => 'Brand2',
        'alias' => Str::slug('Brand2'),
        'status' => 1
    ]);

    $response = $this->actingAs($this->admin)->delete(route('brands.bulk-destroy'), [
        'ids' => [$brand->id, $brand2->id]
    ]);

    $response->assertStatus(302);
    $this->assertDatabaseMissing('clients', $brand->toArray());
    $this->assertDatabaseMissing('clients', $brand2->toArray());
});
