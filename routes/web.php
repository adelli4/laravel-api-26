<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// file ini mendaftarkan url dan menentukan kode yang menangani setiap request.
// respons sederhana dapat ditulis langsung di sini, sedangkan proses data produk
// diarahkan ke controller agar logika aplikasi lebih teratur.

// menampilkan nama dan nim sebagai teks biasa.
Route::get('/about', function () {
    return response('Eka Adellia Agustin |  2455201019', 200)
        ->header('Content-Type', 'text/plain; charset=UTF-8');
});

// menampilkan daftar kategori dalam bentuk json.
Route::get('/categories', function () {
    return response()->json([
        ['id' => 1, 'nama' => 'Elektronik'],
        ['id' => 2, 'nama' => 'Pakaian'],
        ['id' => 3, 'nama' => 'Makanan'],
    ]);
});

// menghubungkan url daftar produk dan detail produk ke method di controller.
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// route lain dengan respons sederhana langsung mengembalikan hasil dari web.php.
Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return ('Halo, Laravel!');
});

Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::post('/products', [ProductController::class, 'store']);

Route::get('products/{id}/edit', function ($id) {
    return 'Form Edit Produk: ' . $id;  
})->name('products.edit');
