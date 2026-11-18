<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductWebController;
use Illuminate\Support\Facades\Route;

// file ini mendaftarkan url halaman web dan menjaga agar controller API lama tidak bercampur dengan CRUD blade.
Route::get('/about', function () {
    return response('Eka Adellia Agustin |  2455201019', 200)
        ->header('Content-Type', 'text/plain; charset=UTF-8');
});

Route::resource('categories', CategoryController::class);

// redirect halaman utama ke daftar produk agar alur web lebih konsisten.
Route::get('/', function () {
    return redirect()->route('produk.index');
});

// Route::get('/hello', function () {
//     return 'Halo, Laravel!';
// });

// route halaman web produk yang dipisahkan dari route API agar proses CRUD tetap aman.
Route::get('/produk', [ProductWebController::class, 'index'])->name('produk.index');
Route::get('/produk/create', [ProductWebController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProductWebController::class, 'store'])->name('produk.store');
Route::get('/produk/{product}/edit', [ProductWebController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{product}', [ProductWebController::class, 'update'])->name('produk.update');
Route::delete('/produk/{product}', [ProductWebController::class, 'destroy'])->name('produk.destroy');

// route api lama tetap dipertahankan agar fitur sebelumnya tidak rusak.
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::put('/products/{id}', [ProductController::class, 'update']);
