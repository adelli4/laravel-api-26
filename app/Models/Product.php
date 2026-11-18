<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, SoftDeletes;

    // daftar kolom yang boleh diisi saat membuat atau memperbarui data produk.
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'sku',
        'category_id',
    ];

    // mengubah tipe beberapa field agar data numerik tetap konsisten saat diolah.
    protected $casts = [
        'harga' => 'integer',
        'stok' => 'integer',
        'category_id' => 'integer',
    ];

    // setiap produk hanya memiliki satu kategori dan relasi ini dipakai saat menampilkan nama kategori.
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
