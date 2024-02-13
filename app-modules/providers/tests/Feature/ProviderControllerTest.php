<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\PersonTypes\Models\PersonType;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Support\Str;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    // Creamos un usuario
    $this->admin = User::factory()->create();

    // Creamos un role
    $role = Role::create([
        'name' => 'administrator',
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
    $response = $this->post(route('providers.store'), $clientData);
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
