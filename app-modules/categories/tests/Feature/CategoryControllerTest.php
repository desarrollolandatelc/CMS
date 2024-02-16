<?php

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Brands\Models\Brand;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Modules\Categories\Models\Category;

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

test('an_administrator_can_see_the_index_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('categories.index'));

    $response->assertStatus(200);
});

test('non_administrator_can_see_the_index_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('categories.index'));

    $response->assertStatus(403);
});

test('an_administrator_can_see_the_create_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('categories.create'));

    $response->assertStatus(200);
});

test('non_administrator_can_see_the_create_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('categories.create'));

    $response->assertStatus(403);
});


test('an_administrator_can_store_a_category', function () {
    $data = [
        'name' => 'Category Name',
        'alias' => Str::slug('Category Name'),
        'status' => 1,
        'parent_id' => null,
    ];
    $response = $this->actingAs($this->admin)->post(route('categories.store'), $data);

    $response->assertRedirect(route('categories.create'));
    $this->assertDatabaseHas('categories', [
        'name' => 'Category Name',
        'alias' => Str::slug('Category Name'),
    ]);
});

test('non_administrator_can_store_a_category', function () {
    $defaultUser = User::factory()->create();
    $data = [
        'name' => 'Category Name',
        'alias' => Str::slug('Category Name'),
        'status' => 1,
        'parent_id' => null,
    ];
    $response = $this->actingAs($defaultUser)->post(route('categories.store'), $data);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('categories', $data);
});

test('an_administrator_can_store_a_category_without_required_fields', function () {
    $data = [
        'name' => '',
        'alias' => '',
        'status' => '',
        'parent_id' => null,
    ];
    $response = $this->actingAs($this->admin)->post(route('categories.store'), $data);

    $response->assertSessionHasErrors(['name', 'alias', 'status']);
});


test('an_administrator_can_store_a_category_inexisten_parent', function () {
    $data = [
        'name' => 'Category Name',
        'alias' =>  Str::slug('Category Name'),
        'status' => 1,
        'parent_id' => 1,
    ];
    $response = $this->actingAs($this->admin)->post(route('categories.store'), $data);

    $response->assertSessionHasErrors(['parent_id']);
    $this->assertDatabaseMissing('categories', $data);
});

test('an_administrator_can_store_a_category_exist_parent', function () {
    $category = Category::create([
        'name' => 'Category Name',
        'alias' =>  Str::slug('Category Name'),
        'status' => 1,
        'parent_id' => 1,
    ]);

    $data = [
        'name' => 'Category Name',
        'alias' =>  Str::slug('Category Name'),
        'status' => 1,
        'parent_id' => $category->id,
    ];
    $response = $this->actingAs($this->admin)->post(route('categories.store'), $data);
    $response->assertRedirect(route('categories.create'));
    $this->assertDatabaseHas('categories', $data);
});


test('an_administrator_can_update_a_category', function () {
    $category = Category::create([
        'name' => 'Category Name',
        'alias' =>  Str::slug('Category Name'),
        'status' => 1,
        'parent_id' => null,
    ]);
    $data = [
        'name' => 'Category Name2',
        'alias' =>  Str::slug('Category Name2'),
        'status' => 1,
        'parent_id' => null,
    ];
    $response = $this->actingAs($this->admin)->put(route('categories.update', $category->id), $data);

    $response->assertRedirect(route('categories.edit', $category->id));
    $this->assertDatabaseHas('categories', $data);
});


test('non_administrator_can_update_a_category', function () {
    $defaultUser = User::factory()->create();
    $category = Category::create([
        'name' => 'Category Name',
        'alias' =>  Str::slug('Category Name'),
        'status' => 1,
        'parent_id' => null,
    ]);
    $data = [
        'name' => 'Category Name2',
        'alias' =>  Str::slug('Category Name2'),
        'status' => 1,
        'parent_id' => null,
    ];
    $response = $this->actingAs($defaultUser)->put(route('categories.update', $category->id), $data);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('categories', $data);
});

test('an_administrator_can_update_a_category_without_changes', function () {
    $category = Category::create([
        'name' => 'Category Name',
        'alias' =>  Str::slug('Category Name'),
        'status' => 1,
        'parent_id' => null,
    ]);
    $data = [
        'name' => 'Category Name',
        'alias' =>  Str::slug('Category Name'),
        'status' => 1,
        'parent_id' => null,
    ];
    $response = $this->actingAs($this->admin)->put(route('categories.update', $category->id), $data);

    $response->assertRedirect(route('categories.edit', $category->id));
    $this->assertDatabaseHas('categories', $data);
});

test('an_administrator_can_update_a_category_changing_parent_id', function () {
    $category = Category::create([
        'name' => 'Category Name',
        'alias' =>  Str::slug('Category Name'),
        'status' => 1,
        'parent_id' => null,
    ]);
    $category2 = Category::create([
        'name' => 'Category Name2',
        'alias' =>  Str::slug('Category Name2'),
        'status' => 1,
        'parent_id' => $category->id,
    ]);

    $category3 = Category::create([
        'name' => 'Category Name3',
        'alias' =>  Str::slug('Category Name3'),
        'status' => 1,
        'parent_id' => $category->id,
    ]);
    $data = [
        'name' => 'Category Name2',
        'alias' =>  Str::slug('Category Name2'),
        'status' => 1,
        'parent_id' => $category3->id,
    ];
    $response = $this->actingAs($this->admin)->put(route('categories.update', $category2->id), $data);

    $response->assertRedirect(route('categories.edit', $category2->id));
    $this->assertDatabaseHas('categories', $data);
});

test('administrator_can_delete_multiple_categories', function () {
    // Creamos un nuevo proveedor
    $category = Category::create([
        'name' => 'Category Name',
        'alias' =>  Str::slug('Category Name'),
        'status' => 1,
        'parent_id' => null,
    ]);
    $category2 = Category::create([
        'name' => 'Category Name2',
        'alias' =>  Str::slug('Category Name2'),
        'status' => 1,
        'parent_id' => $category->id,
    ]);

    $response = $this->actingAs($this->admin)->delete(route('categories.bulk-destroy'), [
        'ids' => [$category->id, $category2->id]
    ]);

    $response->assertStatus(302);
    $this->assertDatabaseMissing('clients', $category->toArray());
    $this->assertDatabaseMissing('clients', $category2->toArray());
});
