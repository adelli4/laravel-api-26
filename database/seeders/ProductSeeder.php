<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // memastikan kategori utama sudah ada sebelum produk dibuat agar relasi tidak kosong.
        $categories = [
            'elektronik',
            'pakaian',
            'makanan',
            'rumah tangga',
            'olahraga',
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(['name' => $categoryName]);
        }

        // membuat beberapa produk awal agar halaman daftar produk langsung berisi data yang relevan.
        Product::factory()->count(20)->create();

        // menambahkan contoh produk untuk setiap kategori tanpa menggandakan produk bernama sama.
        $productsByCategory = [
            'elektronik' => [
                [
                    'nama' => 'Headphone Nirkabel',
                    'deskripsi' => 'Headphone nirkabel dengan suara jernih untuk bekerja dan menikmati hiburan.',
                    'harga' => 275000,
                    'stok' => 18,
                ],
                [
                    'nama' => 'Mouse Optik USB',
                    'deskripsi' => 'Mouse optik dengan koneksi USB untuk kebutuhan komputer sehari-hari.',
                    'harga' => 85000,
                    'stok' => 35,
                ],
            ],
            'pakaian' => [
                [
                    'nama' => 'Kemeja Katun',
                    'deskripsi' => 'Kemeja katun ringan yang nyaman digunakan untuk kegiatan sehari-hari.',
                    'harga' => 145000,
                    'stok' => 24,
                ],
                [
                    'nama' => 'Jaket Denim',
                    'deskripsi' => 'Jaket denim dengan potongan kasual untuk melengkapi pakaian harian.',
                    'harga' => 320000,
                    'stok' => 12,
                ],
            ],
            'makanan' => [
                [
                    'nama' => 'Cokelat Batang',
                    'deskripsi' => 'Cokelat batang sebagai camilan manis untuk dinikmati kapan saja.',
                    'harga' => 18000,
                    'stok' => 42,
                ],
                [
                    'nama' => 'Kacang Panggang',
                    'deskripsi' => 'Kacang panggang renyah yang cocok disajikan sebagai camilan.',
                    'harga' => 22000,
                    'stok' => 28,
                ],
            ],
            'rumah tangga' => [
                [
                    'nama' => 'Sapu Lantai',
                    'deskripsi' => 'Sapu ringan untuk membantu membersihkan lantai rumah.',
                    'harga' => 35000,
                    'stok' => 16,
                ],
                [
                    'nama' => 'Rak Serbaguna',
                    'deskripsi' => 'Rak serbaguna untuk menyimpan perlengkapan rumah agar lebih tertata.',
                    'harga' => 125000,
                    'stok' => 9,
                ],
            ],
            'olahraga' => [
                [
                    'nama' => 'Bola Futsal',
                    'deskripsi' => 'Bola futsal untuk latihan dan pertandingan di lapangan dalam ruangan.',
                    'harga' => 165000,
                    'stok' => 14,
                ],
                [
                    'nama' => 'Matras Yoga',
                    'deskripsi' => 'Matras yoga dengan permukaan nyaman untuk latihan peregangan dan kebugaran.',
                    'harga' => 110000,
                    'stok' => 22,
                ],
            ],
        ];

        foreach ($productsByCategory as $categoryName => $products) {
            $categoryId = Category::query()->where('name', $categoryName)->value('id');

            foreach ($products as $productData) {
                Product::updateOrCreate(
                    ['nama' => $productData['nama']],
                    [
                        ...$productData,
                        'category_id' => $categoryId,
                    ]
                );
            }
        }
    }
}
