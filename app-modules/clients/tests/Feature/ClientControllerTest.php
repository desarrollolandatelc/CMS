<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\PersonTypes\Models\PersonType;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\Clients\Models\Client;
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
});

test('an_administrator_can_create_clients_without_discounts_address_or_phone', function () {

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
    $response = $this->actingAs($this->admin)->post(route('clients.store'), $clientData);
    // Assert the client was created successfully
    $response->assertStatus(302); // Assuming redirect after successful creation
    $response->assertSessionHas('success', 'Client created successfully.');

    // Assert the client exists in the database
    $this->assertDatabaseHas('clients', $clientData);
});

test('an_administrator_can_create_clients_with_discounts_address_and_phone', function () {
    // Creamos un proveedor
    $provider = Provider::create([
        'name' => 'Mi proveedor',
        'alias' => Str::slug('Mi proveedor'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    // Define the data for the new client
    $clientData = [
        'name' => 'New Client',
        'alias' => Str::slug('New Client'),
        'email' => 'client@example.com',
        'phone' => '1234567890',
        'address' => '123 Main St',
        'discounts' => [
            [
                'provider_name' => 'Mi proveedor',
                'percentage' => 10
            ]
        ],
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ];

    // Perform the post request to the client registration route
    $response = $this->actingAs($this->admin)->post(route('clients.store'), $clientData);
    // Assert the client was created successfully
    $response->assertStatus(302); // Assuming redirect after successful creation
    $response->assertSessionHas('success', 'Client created successfully.');

    // Assert the client exists in the database
    $this->assertDatabaseHas('clients', [
        'name' => 'New Client',
        'alias' => Str::slug('New Client'),
        'email' => 'client@example.com',
        'phone' => '1234567890',
        'address' => '123 Main St',
        'discounts' => json_encode([
            [
                'provider_name' => 'Mi proveedor',
                'percentage' => 10
            ]
        ]),
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
});

test('an_non_administrator_cannot_create_clients', function () {

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
    $response = $this->post(route('clients.store'), $clientData);
    // Assert the client was created successfully
    $response->assertStatus(403);

    // Assert the client exists in the database
    $this->assertDatabaseMissing('clients', $clientData);
});

test('an_administrator_can_update_clients_without_discounts_address_or_phone', function () {
    $client = Client::create([
        'name' => 'Old Client',
        'alias' => Str::slug('Old Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    // Define the data for the new client
    $clientData = [
        'name' => 'Changed Client',
        'alias' => Str::slug('Changed Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ];

    // Perform the post request to the client registration route
    $response = $this->actingAs($this->admin)->put(route('clients.update', $client->id), $clientData);
    // Assert the client was created successfully
    $response->assertStatus(302); // Assuming redirect after successful creation
    $response->assertSessionHas('success', 'Client updated successfully.');

    // Assert the client exists in the database
    $this->assertDatabaseHas('clients', $clientData);
});


test('an_administrator_can_update_clients_without_changes', function () {
    $client = Client::create([
        'name' => 'Old Client',
        'alias' => Str::slug('Old Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    // Define the data for the new client
    $clientData = [
        'name' => 'Old Client',
        'alias' => Str::slug('Old Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ];

    // Perform the post request to the client registration route
    $response = $this->actingAs($this->admin)->put(route('clients.update', $client->id), $clientData);
    // Assert the client was created successfully
    $response->assertStatus(302); // Assuming redirect after successful creation
    $response->assertSessionHas('success', 'Client updated successfully.');

    // Assert the client exists in the database
    $this->assertDatabaseHas('clients', $clientData);
});

test('non_administrator_can_update_clients', function () {

    $defaultUser = User::factory()->create();

    $client = Client::create([
        'name' => 'Old Client',
        'alias' => Str::slug('Old Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    // Define the data for the new client
    $clientData = [
        'name' => 'changed Client',
        'alias' => Str::slug('changed Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ];

    // Perform the post request to the client registration route
    $response = $this->actingAs($defaultUser)->put(route('clients.update', $client->id), $clientData);
    // Assert the client was created successfully
    $response->assertStatus(403);

    // Assert the client exists in the database
    $this->assertDatabaseMissing('clients', $clientData);
});

test('an_administrator_can_see_created_client_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('clients.create'));
    $response->assertStatus(200);
});

test('non_administrator_can_see_created_client_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('clients.create'));
    $response->assertStatus(403);
});

test('an_administrator_can_see_edit_client_screen', function () {
    $client = Client::create([
        'name' => 'Old Client',
        'alias' => Str::slug('Old Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    $response = $this->actingAs($this->admin)->get(route('clients.edit', $client->id));
    $response->assertStatus(200);
});

test('non_administrator_can_see_edit_client_screen', function () {
    $defaultUser = User::factory()->create();
    $client = Client::create([
        'name' => 'Old Client',
        'alias' => Str::slug('Old Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    $response = $this->actingAs($defaultUser)->get(route('clients.edit', $client->id));
    $response->assertStatus(403);
});

// Bulk delete action
test('administrator_can_delete_multiple_clients', function () {
    // Creamos un nuevo proveedor
    $client = Client::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    // Creamos un nuevo proveedor
    $client2 = Client::create([
        'name' => 'Client2',
        'alias' => Str::slug('Client2'),
        'email' => 'client2@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '1234567891',
        'status' => 1
    ]);

    $response = $this->actingAs($this->admin)->delete(route('clients.bulk-destroy'), [
        'ids' => [$client->id, $client2->id]
    ]);

    $response->assertStatus(302);
    $this->assertDatabaseMissing('clients', $client->toArray());
    $this->assertDatabaseMissing('clients', $client2->toArray());
});

test('non_administrator_can_delete_multiple_clients', function () {
    $defaultUser = User::factory()->create();

    // Creamos un nuevo cliente
    $client = Client::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    // Creamos un nuevo cliente
    $client2 = Client::create([
        'name' => 'Client2',
        'alias' => Str::slug('Client2'),
        'email' => 'client2@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '1234567891',
        'status' => 1
    ]);

    $response = $this->actingAs($defaultUser)->delete(route('clients.bulk-destroy'), [
        'ids' => [$client->id, $client2->id]
    ]);

    $response->assertStatus(403);
});

// Delete action
test('administrator_can_delete_single_clients', function () {
    // Creamos un nuevo proveedor
    $client = Client::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    // Creamos un nuevo proveedor
    $client2 = Client::create([
        'name' => 'Client2',
        'alias' => Str::slug('Client2'),
        'email' => 'client2@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '1234567891',
        'status' => 1
    ]);

    $response = $this->actingAs($this->admin)->delete(route('clients.destroy', $client->id));

    $response->assertStatus(302);
    $this->assertCount(1, Client::all());
    $this->assertDatabaseMissing('providers', $client->toArray());
});

test('non_administrator_can_delete_single_clients', function () {
    $defaultUser = User::factory()->create();
    // Creamos un nuevo proveedor
    $client = Client::create([
        'name' => 'Client',
        'alias' => Str::slug('Client'),
        'email' => 'client@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    // Creamos un nuevo proveedor
    $client2 = Client::create([
        'name' => 'Client2',
        'alias' => Str::slug('Client2'),
        'email' => 'client2@example.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '1234567891',
        'status' => 1
    ]);

    $response = $this->actingAs($defaultUser)->delete(route('clients.destroy', $client->id));

    $response->assertStatus(403);
    $this->assertCount(2, Client::all());
});
