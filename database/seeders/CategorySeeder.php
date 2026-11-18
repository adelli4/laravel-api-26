<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * menjalankan seed kategori agar dropdown produk memiliki pilihan yang valid.
     */
    public function run(): void
    {
        $categoryNames = ['elektronik', 'pakaian', 'makanan', 'rumah tangga', 'olahraga'];

        foreach ($categoryNames as $categoryName) {
            Category::firstOrCreate(['name' => $categoryName]);
        }

        // menghubungkan produk contoh lama yang belum memiliki kategori tanpa mengubah pilihan yang sudah tersimpan.
        $categoryAssignments = [
            'makanan' => [
                'Beras Pandan Wangi',
                'Minyak Goreng Kelapa Sawit',
                'Gula Pasir Putih',
                'Kopi Arabika',
                'Teh Hijau Celup',
                'Susu UHT Cokelat',
                'Air Mineral',
                'Mi Instan Goreng',
                'Roti Tawar Gandum',
                'Biskuit Cokelat',
                'Kecap Manis',
                'Saus Sambal',
                'Minyak Goreng Kelapa',
                'Kopi Instan',
            ],
            'rumah tangga' => [
                'Sabun Mandi',
                'Sampo Rambut',
                'Pasta Gigi',
                'Deterjen Bubuk',
                'Tisu Wajah',
                'Minyak Kayu Putih',
            ],
        ];

        foreach ($categoryAssignments as $categoryName => $productNames) {
            $categoryId = Category::query()->where('name', $categoryName)->value('id');

            Product::query()
                ->whereNull('category_id')
                ->whereIn('nama', $productNames)
                ->update(['category_id' => $categoryId]);
        }
    }
}
