<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\PersonTypes\Models\PersonType;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\Providers\Models\Provider;

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

    // Creamos un tipo de persona
    $this->personType = PersonType::create([
        'name' => 'Natural',
        'alias' => Str::slug('Jurídica'),
        'status' => 1
    ]);

    // Creamos un tipo de documento
    $documentType = [
        'name' => 'Cédula de ciudadaniá',
        'alias' => Str::slug('Cédula de ciudadaniá'),
        'status' => 1
    ];
    // Asignamos el tipo de persona al tipo de documento
    $this->documentType = $this->personType->documentTypes()->create($documentType);

    // Logueamos al usuario
    $this->actingAs($this->admin);
});

test('an_administrator_can_create_providers_without_address_or_phone', function () {

    // Define the data for the new client
    $clientData = [
        'name' => 'New Client',
        'alias' => Str::slug('New Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ];

    // Perform the post request to the client registration route
    $response = $this->actingAs($this->admin)->post(route('providers.store'), $clientData);
    // Assert the client was created successfully
    $response->assertStatus(302); // Assuming redirect after successful creation
    $response->assertSessionHas('success', 'Provider created successfully.');

    // Assert the client exists in the database
    $this->assertDatabaseHas('providers', $clientData);
});

test('an_administrator_can_create_providers_with_address_and_phone', function () {

    // Define the data for the new client
    $clientData = [
        'name' => 'New Client',
        'alias' => Str::slug('New Client'),
        'email' => 'client@example.com',
        'phone' => '1234567890',
        'address' => '123 Main St',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ];

    // Perform the post request to the client registration route
    $response = $this->post(route('providers.store'), $clientData);
    // Assert the client was created successfully
    $response->assertStatus(302); // Assuming redirect after successful creation
    $response->assertSessionHas('success', 'Provider created successfully.');

    // Assert the client exists in the database
    $this->assertDatabaseHas('providers', $clientData);
});

test('an_non_administrator_cannot_create_providers', function () {

    $defaultUser = User::factory()->create();

    $this->actingAs($defaultUser);
    // Define the data for the new client
    $clientData = [
        'name' => 'New Client',
        'alias' => Str::slug('New Client'),
        'email' => 'client@example.com',
        'phone' => '1234567890',
        'address' => '123 Main St',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ];
    // Perform the post request to the client registration route
    $response = $this->post(route('providers.store'), $clientData);
    // Assert the client was created successfully
    $response->assertStatus(403);

    // Assert the client exists in the database
    $this->assertDatabaseMissing('providers', $clientData);
});

test('an_administrator_can_update_providers', function () {
    // Creamos un nuevo proveedor
    $provider = Provider::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'phone' => '1234567890',
        'address' => '123 Main St',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);

    // Define the new data for the client
    $newClientData = [
        'name' => 'New Client',
        'alias' => Str::slug('New Client'),
        'email' => 'client@example.com',
        'phone' => '1234567890',
        'address' => '123 Main St',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ];
    // Update the client
    $response = $this->put(route('providers.update', $provider->id), $newClientData);

    // Assert the client was updated successfully
    $response->assertStatus(302); // Assuming redirect after successful update
    // Comprobamos que me redirija a la ruta de edición
    $response->assertRedirect(route('providers.edit', $provider->id));
    $response->assertSessionHas('success', 'Provider updated successfully.');

    // Assert the client exists in the database
    $this->assertDatabaseHas('providers', $newClientData);
});

test('non_administrator_can_update_providers', function () {

    $defaultUser = User::factory()->create();
    $this->actingAs($defaultUser);
    // Creamos un nuevo proveedor
    $provider = Provider::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'phone' => '1234567890',
        'address' => '123 Main St',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);

    // Define the new data for the client
    $newClientData = [
        'name' => 'New Client',
        'alias' => Str::slug('New Client'),
        'email' => 'client@example.com',
        'phone' => '1234567890',
        'address' => '123 Main St',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ];
    // Update the client
    $response = $this->put(route('providers.update', $provider->id), $newClientData);

    // Assert the client was updated successfully
    $response->assertStatus(403); // Assuming redirect after successful update

    // Assert the client exists in the database
    $this->assertDatabaseMissing('providers', $newClientData);
});

test('administrator_can_update_providers_without_phone_address', function () {

    $defaultUser = User::factory()->create();
    $this->actingAs($defaultUser);
    // Creamos un nuevo proveedor
    $provider = Provider::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);

    // Define the new data for the client
    $newClientData = [
        'name' => 'New Client',
        'alias' => Str::slug('New Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ];
    // Update the client
    $response = $this->put(route('providers.update', $provider->id), $newClientData);

    // Assert the client was updated successfully
    $response->assertStatus(403); // Assuming redirect after successful update

    // Assert the client exists in the database
    $this->assertDatabaseMissing('providers', $newClientData);
});

test('administrator_can_update_providers_without_changes', function () {

    // Creamos un nuevo proveedor
    $provider = Provider::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);

    // Define the new data for the client
    $newClientData = [
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ];
    // Update the client
    $response = $this->put(route('providers.update', $provider->id), $newClientData);

    // Assert the client was updated successfully
    $response->assertStatus(302); // Assuming redirect after successful update
    // Comprobamos que me redirija a la ruta de edición
    $response->assertRedirect(route('providers.edit', $provider->id));
    $response->assertSessionHas('success', 'Provider updated successfully.');

    // Assert the client exists in the database
    $this->assertDatabaseHas('providers', $newClientData);
});

test('administrator_can_update_providers_without_required_fields', function () {
    // Creamos un nuevo proveedor
    $provider = Provider::create([
        'name' => 'New Client',
        'alias' => Str::slug('New Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);

    // Define the new data for the client
    $newClientData = [
        'name' => '',
        'alias' => '',
        'email' => '',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ];
    // Update the client
    $response = $this->put(route('providers.update', $provider->id), $newClientData);

    // Assert the client exists in the database
    $this->assertDatabaseMissing('providers', $newClientData);
});

test('an_administrator_can_see_created_provider_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('providers.create'));
    $response->assertStatus(200);
});

test('non_administrator_can_see_created_provider_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('providers.create'));
    $response->assertStatus(403);
});

test('an_administrator_can_see_edit_provider_screen', function () {
    // Creamos un nuevo proveedor
    $provider = Provider::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    $response = $this->actingAs($this->admin)->get(route('providers.edit', $provider->id));
    $response->assertStatus(200);
});

test('non_administrator_can_see_edit_provider_screen', function () {

    $defaultUser = User::factory()->create();
    // Creamos un nuevo proveedor
    $provider = Provider::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    $response = $this->actingAs($defaultUser)->get(route('providers.edit', $provider->id));
    $response->assertStatus(403);
});

// Bulk delete action

test('administrator_can_delete_multiple_providers', function () {
    // Creamos un nuevo proveedor
    $provider = Provider::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    // Creamos un nuevo proveedor
    $provider2 = Provider::create([
        'name' => 'Client2',
        'alias' => Str::slug('Client2'),
        'email' => 'client2@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '1234567891',
        'status' => 1
    ]);

    $response = $this->actingAs($this->admin)->delete(route('providers.bulk-destroy'), [
        'ids' => [$provider->id, $provider2->id]
    ]);

    $response->assertStatus(302);
    $this->assertDatabaseMissing('providers', $provider->toArray());
    $this->assertDatabaseMissing('providers', $provider2->toArray());
});

test('non_administrator_can_delete_multiple_providers', function () {

    $defaultUser = User::factory()->create();
    // Creamos un nuevo proveedor
    $provider = Provider::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    // Creamos un nuevo proveedor
    $provider2 = Provider::create([
        'name' => 'Client2',
        'alias' => Str::slug('Client2'),
        'email' => 'client2@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '1234567891',
        'status' => 1
    ]);

    $response = $this->actingAs($defaultUser)->delete(route('providers.bulk-destroy'), [
        'ids' => [$provider->id, $provider2->id]
    ]);

    $response->assertStatus(403);
});


// Delete action
test('administrator_can_delete_single_providers', function () {
    // Creamos un nuevo proveedor
    $provider = Provider::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    // Creamos un nuevo proveedor
    $provider2 = Provider::create([
        'name' => 'Client2',
        'alias' => Str::slug('Client2'),
        'email' => 'client2@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '1234567891',
        'status' => 1
    ]);

    $response = $this->actingAs($this->admin)->delete(route('providers.destroy', $provider->id));

    $response->assertStatus(302);
    $this->assertCount(1, Provider::all());
    $this->assertDatabaseMissing('providers', $provider->toArray());
});

test('non_administrator_can_delete_single_providers', function () {

    $defaultUser = User::factory()->create();
    // Creamos un nuevo proveedor
    $provider = Provider::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    // Creamos un nuevo proveedor
    $provider2 = Provider::create([
        'name' => 'Client2',
        'alias' => Str::slug('Client2'),
        'email' => 'client2@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '1234567891',
        'status' => 1
    ]);

    $response = $this->actingAs($defaultUser)->delete(route('providers.destroy', $provider->id));

    $response->assertStatus(403);
    $this->assertCount(2, Provider::all());
});


test('administrator_can_see_index_screen', function () {

    $response = $this->actingAs($this->admin)->get(route('providers.index'));
    $response->assertStatus(200);
});
