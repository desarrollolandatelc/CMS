<?php

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Currencies\Models\Currency;
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

test('an_administrator_can_see_the_currencies_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('currencies.index'));

    $response->assertStatus(200);
});

test('non_administrator_can_see_the_currencies_index_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('currencies.index'));
    $response->assertStatus(403);
});


test('an_administrator_can_see_the_currencies_create_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('currencies.create'));

    $response->assertStatus(200);
});

test('non_administrator_can_see_the_currencies_create_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('currencies.create'));

    $response->assertStatus(403);
});


test('an_administrator_can_store_a_currencies', function () {

    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->post(route('currencies.store'), $data)->assertRedirect(route('currencies.create'));

    $this->assertDatabaseHas('currencies', $data);
});


test('non_administrator_can_store_a_currency', function () {

    $defaultUser = User::factory()->create();
    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($defaultUser)->post(route('currencies.store'), $data);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('currencies', $data);
});



test('an_administrator_can_store_a_currency_without_required_fields', function () {

    $data = [
        'name' => '',
        'alias' => '',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->post(route('currencies.store'), $data)->assertRedirect(route('currencies.create'));

    $response->assertSessionHasErrors(['name', 'alias']);
});

test('an_administrator_can_store_a_currency_with_repeated_name', function () {
    Currency::create([
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ]);

    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->post(route('currencies.store'), $data)->assertRedirect(route('currencies.create'));

    $response->assertSessionHasErrors(['name']);
});

test('an_administrator_can_update_a_currency', function () {
    $currency = Currency::create([
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ]);

    $data = [
        'name' => 'test1',
        'alias' => 'test1',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->put(route('currencies.update', $currency->id), $data)
        ->assertRedirect(route('currencies.edit', $currency->id));

    $this->assertDatabaseHas('currencies', $data);
});

test('an_administrator_can_update_a_currency_without_changes', function () {
    $currency = Currency::create([
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ]);

    $data = [
        'name' => 'test',
        'alias' => 'test',
        'status' => 1
    ];
    $response = $this->actingAs($this->admin)->put(route('currencies.update', $currency->id), $data)
        ->assertRedirect(route('currencies.edit', $currency->id));

    $response->assertSessionHasNoErrors();
});

test('administrator_can_delete_multiple_currencies', function () {
    // Creamos un nuevo proveedor
    $currency = Currency::create([
        'name' => 'currency1',
        'alias' => Str::slug('currency1'),
        'status' => 1
    ]);
    // Creamos un nuevo proveedor
    $currency2 = currency::create([
        'name' => 'currency2',
        'alias' => Str::slug('currency2'),
        'status' => 1
    ]);

    $response = $this->actingAs($this->admin)->delete(route('currencies.bulk-destroy'), [
        'ids' => [$currency->id, $currency2->id]
    ]);

    $response->assertStatus(302);
    $this->assertDatabaseMissing('currencies', $currency->toArray());
    $this->assertDatabaseMissing('currencies', $currency2->toArray());
});
