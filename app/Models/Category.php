<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // menyimpan nama kategori sebagai dasar pengelompokan produk di form dan daftar.
    protected $fillable = ['name'];

    // satu kategori dapat digunakan oleh banyak produk yang terkait untuk kebutuhan CRUD web.
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
