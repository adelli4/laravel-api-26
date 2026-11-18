<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns products with the newest product first', function () {
    $olderProduct = Product::factory()->create([
        'created_at' => now()->subDay(),
    ]);
    $newerProduct = Product::factory()->create([
        'created_at' => now(),
    ]);

    $this->getJson('/api/products')
        ->assertOk()
        ->assertJsonPath('data.0.id', $newerProduct->id)
        ->assertJsonPath('data.0.category_id', $newerProduct->category_id)
        ->assertJsonPath('data.0.url', route('products.show', $newerProduct))
        ->assertJsonPath('data.1.id', $olderProduct->id);
});

it('returns the requested product', function () {
    $product = Product::factory()->create();

    $this->getJson("/api/products/{$product->id}")
        ->assertOk()
        ->assertJsonFragment(['id' => $product->id]);
});

it('returns 404 when the requested product does not exist', function () {
    $this->getJson('/api/products/9999')->assertNotFound();
});

it('creates a product with status 201', function () {
    $productData = [
        'nama' => 'Gula Aren',
        'deskripsi' => 'Gula aren asli.',
        'harga' => 18000,
        'stok' => 50,
    ];

    $this->postJson('/api/products', $productData)
        ->assertCreated()
        ->assertJsonFragment($productData);

    $this->assertDatabaseHas('products', $productData);
});

it('updates the requested product', function () {
    $product = Product::factory()->create();
    $updatedData = ['harga' => 20000];

    $this->putJson("/api/products/{$product->id}", $updatedData)
        ->assertOk()
        ->assertJsonFragment($updatedData);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        ...$updatedData,
    ]);
});

it('returns 404 when updating a product that does not exist', function () {
    $this->putJson('/api/products/9999', ['harga' => 20000])->assertNotFound();
});

it('soft deletes the requested product and returns 204', function () {
    $product = Product::factory()->create();

    $this->deleteJson("/api/products/{$product->id}")->assertNoContent();

    $this->assertSoftDeleted($product);
    $this->getJson("/api/products/{$product->id}")->assertNotFound();
});

it('returns 404 when deleting a product that does not exist', function () {
    $this->deleteJson('/api/products/9999')->assertNotFound();
});
