<?php

test('about menampilkan nama dan nim sebagai teks biasa', function () {
    $this->get('/about')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
        ->assertSeeText('Eka Adellia Agustin')
        ->assertSeeText('2455201019');
});

test('categories menampilkan sedikitnya tiga kategori dalam json', function () {
    $response = $this->get('/categories')
        ->assertOk()
        ->assertJsonFragment(['nama' => 'Elektronik'])
        ->assertJsonFragment(['nama' => 'Pakaian'])
        ->assertJsonFragment(['nama' => 'Makanan']);

    expect(count($response->json()))->toBeGreaterThanOrEqual(3);
});

test('products menampilkan satu produk berdasarkan id', function () {
    $this->get('/products/2')
        ->assertOk()
        ->assertExactJson([
            'id' => 2,
            'nama' => 'Teh Hijau',
            'harga' => 20000,
        ]);
});

test('products menampilkan daftar produk lama dan tambahan', function () {
    $this->get('/products')
        ->assertOk()
        ->assertJsonCount(8)
        ->assertJsonFragment([
            'id' => 6,
            'nama' => 'Mouse Nirkabel',
            'harga' => 75000,
        ]);
});

test('products menampilkan satu produk tambahan berdasarkan id', function () {
    $this->get('/products/8')
        ->assertOk()
        ->assertExactJson([
            'id' => 8,
            'nama' => 'Keripik Kentang',
            'harga' => 18000,
        ]);
});

test('products menampilkan not found jika id tidak terdaftar', function () {
    $this->get('/products/99')->assertNotFound();
});

test('store menerima data produk dan mengembalikan status created', function () {
    $this->postJson('/products', [
        'nama' => 'Gula Aren',
        'harga' => 18000,
    ])
        ->assertCreated()
        ->assertExactJson([
            'pesan' => 'Produk diterima',
            'data' => [
                'nama' => 'Gula Aren',
                'harga' => 18000,
            ],
        ]);
});

test('update menerima data pembaruan untuk id produk', function () {
    $this->putJson('/products/2', [
        'nama' => 'Teh Hijau Premium',
        'harga' => 25000,
    ])
        ->assertOk()
        ->assertExactJson([
            'pesan' => 'Data pembaruan produk diterima',
            'id' => 2,
            'data' => [
                'nama' => 'Teh Hijau Premium',
                'harga' => 25000,
            ],
        ]);
});

test('destroy menerima permintaan penghapusan untuk id produk', function () {
    $this->deleteJson('/products/2')
        ->assertOk()
        ->assertExactJson([
            'pesan' => 'Permintaan penghapusan produk diterima',
            'id' => 2,
        ]);
});
