<?php


use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\Currencies\Models\Currency;
use Modules\PersonTypes\Models\PersonType;
use Modules\Providers\Models\Provider;
use Modules\Titles\Models\Title;

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
test('an_administrator_can_see_the_index_product_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('products.index'));

    $response->assertStatus(200);
});

test('non_administrator_can_see_the_index_product_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('products.index'));

    $response->assertStatus(403);
});


test('an_administrator_can_see_the_create_product_screen', function () {
    $response = $this->actingAs($this->admin)->get(route('products.create'));

    $response->assertStatus(200);
});

test('non_administrator_can_not_see_the_create_product_screen', function () {
    $defaultUser = User::factory()->create();
    $response = $this->actingAs($defaultUser)->get(route('products.create'));

    $response->assertStatus(403);
});


test('an_administrator_can_create_a_new_product', function () {
    $category = Category::create([
        'name' => 'test',
        'alias' => Str::slug('test'),
        'status' => 1
    ]);

    $title = Title::create([
        'name' => 'test',
        'alias' => Str::slug('test'),
        'status' => 1
    ]);

    $currency = Currency::create([
        'name' => 'test',
        'alias' => Str::slug('test'),
        'status' => 1
    ]);

    $brand = Brand::create([
        'name' => 'test',
        'alias' => Str::slug('test'),
        'status' => 1
    ]);

    $provider = Provider::create([
        'name' => 'test',
        'alias' => Str::slug('test'),
        'email' => 'test@mail.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    $data = [
        'sku' => 123,
        'barcode' => 123,
        'description' => 'test',
        'min_quantity' => 1,
        'max_quantity' => 10,
        'price' => 100,
        'category_id' => $category->id,
        'title_id' => $title->id,
        'currency_id' => $currency->id,
        'brand_id' => $brand->id,
        'provider_id' => $provider->id,
        'images' => [
            [
                'url' => 'test',
                'alt' => 'test'
            ]
        ],
        'fields' => [],
        'condition' => 'new',
        'status' => 1
    ];

    $response = $this->actingAs($this->admin)->post(route('products.store'), $data);

    $response->assertStatus(302);

    $this->assertDatabaseHas('products', [
        'sku' => 123,
        'barcode' => 123,
        'description' => 'test',
        'min_quantity' => 1,
        'max_quantity' => 10,
        'price' => 100,
        'category_id' => $category->id,
        'title_id' => $title->id,
        'currency_id' => $currency->id,
        'brand_id' => $brand->id,
        'provider_id' => $provider->id,
        'images' => json_encode([
            [
                'url' => 'test',
                'alt' => 'test'
            ]
        ]),
        'fields' => json_encode([]),
        'condition' => 'new',
        'status' => 1
    ]);
});


test('non_administrator_can_create_a_new_product', function () {

    $defaultUser = User::factory()->create();
    $category = Category::create([
        'name' => 'test',
        'alias' => Str::slug('test'),
        'status' => 1
    ]);

    $title = Title::create([
        'name' => 'test',
        'alias' => Str::slug('test'),
        'status' => 1
    ]);

    $currency = Currency::create([
        'name' => 'test',
        'alias' => Str::slug('test'),
        'status' => 1
    ]);

    $brand = Brand::create([
        'name' => 'test',
        'alias' => Str::slug('test'),
        'status' => 1
    ]);

    $provider = Provider::create([
        'name' => 'test',
        'alias' => Str::slug('test'),
        'email' => 'test@mail.com',
        'person_type_id' => $this->personType->id,
        'document_type_id' => $this->documentType->id,
        'document_number' => '123456789',
        'status' => 1
    ]);
    $data = [
        'sku' => 123,
        'barcode' => 123,
        'description' => 'test',
        'min_quantity' => 1,
        'max_quantity' => 10,
        'price' => 100,
        'category_id' => $category->id,
        'title_id' => $title->id,
        'currency_id' => $currency->id,
        'brand_id' => $brand->id,
        'provider_id' => $provider->id,
        'images' => [
            [
                'url' => 'test',
                'alt' => 'test'
            ]
        ],
        'fields' => [],
        'condition' => 'new',
        'status' => 1
    ];

    $response = $this->actingAs($defaultUser)->post(route('products.store'), $data);

    $response->assertStatus(403);

    $this->assertDatabaseMissing('products', [
        'sku' => 123,
        'barcode' => 123,
        'description' => 'test',
        'min_quantity' => 1,
        'max_quantity' => 10,
        'price' => 100,
        'category_id' => $category->id,
        'title_id' => $title->id,
        'currency_id' => $currency->id,
        'brand_id' => $brand->id,
        'provider_id' => $provider->id,
        'images' => json_encode([
            [
                'url' => 'test',
                'alt' => 'test'
            ]
        ]),
        'fields' => json_encode([]),
        'condition' => 'new',
        'status' => 1
    ]);
});


test('administrator_can_create_a_new_product_without_required_fields', function () {
    $data = [
        'sku' => '',
        'barcode' => '',
        'description' => 'test',
        'min_quantity' => '',
        'max_quantity' => '',
        'price' => '',
        'category_id' => '',
        'title_id' => '',
        'currency_id' => '',
        'brand_id' => '',
        'provider_id' => '',
        'images' => [
            [
                'url' => 'test',
                'alt' => 'test'
            ]
        ],
        'fields' => [],
        'condition' => 'holi',
        'status' => ''
    ];

    $response = $this->actingAs($this->admin)->post(route('products.store'), $data);

    $response->assertSessionHasErrors(['sku', 'barcode', 'min_quantity', 'max_quantity', 'price', 'category_id', 'title_id', 'currency_id', 'brand_id', 'provider_id', 'condition', 'status']);
});
