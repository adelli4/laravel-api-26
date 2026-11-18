<?php

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('filters the product list by name and category and sorts by lowest price', function () {
    $beverages = Category::create(['name' => 'minuman']);
    $electronics = Category::create(['name' => 'elektronik']);

    Product::factory()->create([
        'nama' => 'Kopi Hemat',
        'category_id' => $beverages->id,
        'harga' => 10000,
        'stok' => 12,
    ]);
    Product::factory()->create([
        'nama' => 'Kopi Premium',
        'category_id' => $beverages->id,
        'harga' => 25000,
        'stok' => 40,
    ]);
    Product::factory()->create([
        'nama' => 'Kopi Elektronik',
        'category_id' => $electronics->id,
        'harga' => 5000,
        'stok' => 10,
    ]);
    Product::factory()->create([
        'nama' => 'Teh Melati',
        'category_id' => $beverages->id,
        'harga' => 8000,
        'stok' => 50,
    ]);

    $this->get(route('produk.index', [
        'q' => 'Kopi',
        'kategori' => $beverages->id,
        'urut' => 'harga_termurah',
    ]))
        ->assertOk()
        ->assertSeeInOrder(['Kopi Hemat', 'Kopi Premium'])
        ->assertDontSee('Kopi Elektronik')
        ->assertDontSee('Teh Melati')
        ->assertSee('badge-category', false)
        ->assertViewHas('totalProducts', 4)
        ->assertViewHas('lowStockProducts', 2);
});

it('supports every product list sort option', function () {
    Product::factory()->create([
        'nama' => 'Zebra',
        'harga' => 30000,
        'stok' => 3,
        'created_at' => now(),
    ]);
    Product::factory()->create([
        'nama' => 'Apel',
        'harga' => 10000,
        'stok' => 25,
        'created_at' => now()->subHour(),
    ]);
    Product::factory()->create([
        'nama' => 'Mangga',
        'harga' => 20000,
        'stok' => 10,
        'created_at' => now()->subDay(),
    ]);

    $this->get(route('produk.index', ['urut' => 'terbaru']))
        ->assertOk()
        ->assertSeeInOrder(['Zebra', 'Apel', 'Mangga']);

    $this->get(route('produk.index', ['urut' => 'nama']))
        ->assertOk()
        ->assertSeeInOrder(['Apel', 'Mangga', 'Zebra']);

    $this->get(route('produk.index', ['urut' => 'harga_termahal']))
        ->assertOk()
        ->assertSeeInOrder(['Zebra', 'Mangga', 'Apel']);

    $this->get(route('produk.index', ['urut' => 'stok_tersedikit']))
        ->assertOk()
        ->assertSeeInOrder(['Zebra', 'Mangga', 'Apel']);
});

it('preserves filters in product pagination links', function () {
    $category = Category::create(['name' => 'minuman']);

    foreach (range(1, 11) as $number) {
        Product::factory()->create([
            'nama' => sprintf('Produk %02d', $number),
            'category_id' => $category->id,
        ]);
    }

    $this->get(route('produk.index', [
        'q' => 'Produk',
        'kategori' => $category->id,
        'urut' => 'nama',
    ]))
        ->assertOk()
        ->assertSee('page=2')
        ->assertSee('q=Produk')
        ->assertSee('kategori='.$category->id)
        ->assertSee('urut=nama');
});

it('shows a not found state when filters return no products', function () {
    $this->get(route('produk.index', ['q' => 'Produk Tidak Ada']))
        ->assertOk()
        ->assertSee('Produk tidak ditemukan')
        ->assertDontSee('Belum Ada Produk');
});

it('returns validation errors when required product fields are missing', function () {
    $this->from(route('produk.create'))
        ->post(route('produk.store'), [])
        ->assertRedirect(route('produk.create'))
        ->assertSessionHasErrors(['nama', 'category_id', 'harga', 'stok']);

    $this->assertDatabaseCount('products', 0);
});

it('creates a product and shows a success message', function () {
    $category = Category::create(['name' => 'minuman']);
    $productData = [
        'nama' => 'Kopi Demo',
        'category_id' => $category->id,
        'harga' => 15000,
        'stok' => 25,
    ];

    $this->post(route('produk.store'), $productData)
        ->assertRedirect(route('produk.index'))
        ->assertSessionHas('success', 'Produk berhasil ditambahkan.');

    $this->assertDatabaseHas('products', $productData);
});

it('updates a product and shows a success message', function () {
    $category = Category::create(['name' => 'minuman']);
    $product = Product::factory()->create(['category_id' => $category->id]);

    $this->put(route('produk.update', $product), [
        'nama' => 'Kopi Diperbarui',
        'category_id' => $category->id,
        'harga' => 22000,
        'stok' => 30,
    ])
        ->assertRedirect(route('produk.index'))
        ->assertSessionHas('success', 'Produk berhasil diperbarui.');

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'nama' => 'Kopi Diperbarui',
        'harga' => 22000,
        'stok' => 30,
    ]);
});

it('deletes a product and shows a success message', function () {
    $product = Product::factory()->create();

    $this->delete(route('produk.destroy', $product))
        ->assertRedirect(route('produk.index'))
        ->assertSessionHas('success', 'Produk berhasil dihapus.');

    $this->assertSoftDeleted($product);
});

it('does not show a separate row number in the product list', function () {
    Product::factory()->create();

    $this->get(route('produk.index'))
        ->assertOk()
        ->assertDontSee('<th>No.</th>', false)
        ->assertDontSee('class="row-number"', false);
});

it('seeds example products for every category without duplicating them', function () {
    $sampleProductCategories = [
        'Headphone Nirkabel' => 'elektronik',
        'Mouse Optik USB' => 'elektronik',
        'Kemeja Katun' => 'pakaian',
        'Jaket Denim' => 'pakaian',
        'Cokelat Batang' => 'makanan',
        'Kacang Panggang' => 'makanan',
        'Sapu Lantai' => 'rumah tangga',
        'Rak Serbaguna' => 'rumah tangga',
        'Bola Futsal' => 'olahraga',
        'Matras Yoga' => 'olahraga',
    ];

    $this->seed(ProductSeeder::class);
    $this->seed(ProductSeeder::class);

    foreach ($sampleProductCategories as $productName => $categoryName) {
        $categoryId = Category::query()->where('name', $categoryName)->value('id');

        $this->assertDatabaseHas('products', [
            'nama' => $productName,
            'category_id' => $categoryId,
        ]);
        expect(Product::query()->where('nama', $productName)->count())->toBe(1);
    }
});
