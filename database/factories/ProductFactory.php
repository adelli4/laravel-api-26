<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * @return array<int, array{nama: string, deskripsi: string, harga: int}>
     */
    public static function catalog(): array
    {
        return [
            [
                'nama' => 'Beras Pandan Wangi',
                'deskripsi' => 'Beras berkualitas dengan aroma pandan yang harum dan tekstur pulen setelah dimasak.',
                'harga' => 75000,
            ],
            [
                'nama' => 'Minyak Goreng Kelapa Sawit',
                'deskripsi' => 'Minyak goreng untuk memasak dan mengolah berbagai hidangan sehari-hari.',
                'harga' => 18000,
            ],
            [
                'nama' => 'Gula Pasir Putih',
                'deskripsi' => 'Gula pasir putih untuk pemanis minuman dan bahan campuran aneka kue.',
                'harga' => 16000,
            ],
            [
                'nama' => 'Kopi Arabika',
                'deskripsi' => 'Biji kopi arabika dengan cita rasa khas yang cocok diseduh sebagai minuman.',
                'harga' => 55000,
            ],
            [
                'nama' => 'Teh Hijau Celup',
                'deskripsi' => 'Teh hijau dalam kantong celup yang praktis diseduh dengan air panas.',
                'harga' => 12000,
            ],
            [
                'nama' => 'Susu UHT Cokelat',
                'deskripsi' => 'Susu cair rasa cokelat yang telah diproses dengan suhu tinggi dan siap diminum.',
                'harga' => 8500,
            ],
            [
                'nama' => 'Air Mineral',
                'deskripsi' => 'Air minum dalam kemasan yang praktis dibawa untuk memenuhi kebutuhan cairan.',
                'harga' => 5000,
            ],
            [
                'nama' => 'Mi Instan Goreng',
                'deskripsi' => 'Mi instan dengan bumbu rasa gurih yang mudah disiapkan sebagai hidangan.',
                'harga' => 3500,
            ],
            [
                'nama' => 'Roti Tawar Gandum',
                'deskripsi' => 'Roti tawar berbahan gandum yang dapat disajikan sebagai sarapan atau kudapan.',
                'harga' => 22000,
            ],
            [
                'nama' => 'Biskuit Cokelat',
                'deskripsi' => 'Biskuit renyah dengan rasa cokelat untuk dinikmati bersama minuman.',
                'harga' => 11000,
            ],
            [
                'nama' => 'Kecap Manis',
                'deskripsi' => 'Kecap bercita rasa manis untuk pelengkap masakan dan hidangan.',
                'harga' => 14000,
            ],
            [
                'nama' => 'Saus Sambal',
                'deskripsi' => 'Saus dengan rasa pedas untuk pelengkap berbagai makanan.',
                'harga' => 12500,
            ],
            [
                'nama' => 'Sabun Mandi',
                'deskripsi' => 'Sabun untuk membersihkan tubuh saat mandi.',
                'harga' => 6000,
            ],
            [
                'nama' => 'Sampo Rambut',
                'deskripsi' => 'Sampo untuk membersihkan rambut dan kulit kepala.',
                'harga' => 18000,
            ],
            [
                'nama' => 'Pasta Gigi',
                'deskripsi' => 'Pasta untuk membantu membersihkan gigi saat menyikat gigi.',
                'harga' => 10000,
            ],
            [
                'nama' => 'Deterjen Bubuk',
                'deskripsi' => 'Deterjen bubuk untuk mencuci pakaian dan membersihkan noda.',
                'harga' => 17000,
            ],
            [
                'nama' => 'Tisu Wajah',
                'deskripsi' => 'Tisu lembut untuk mengusap wajah atau membersihkan permukaan benda.',
                'harga' => 9000,
            ],
            [
                'nama' => 'Minyak Kayu Putih',
                'deskripsi' => 'Minyak gosok beraroma khas yang digunakan untuk menghangatkan tubuh.',
                'harga' => 21000,
            ],
            [
                'nama' => 'Minyak Goreng Kelapa',
                'deskripsi' => 'Minyak kelapa untuk menggoreng dan mengolah bahan makanan.',
                'harga' => 26000,
            ],
            [
                'nama' => 'Kopi Instan',
                'deskripsi' => 'Kopi instan dalam kemasan praktis yang mudah disajikan dengan air panas.',
                'harga' => 8000,
            ],
        ];
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = fake()->randomElement(self::catalog());

        return [
            ...$product,
            'sku' => 'PRD-'.fake()->unique()->numerify('#####'),
            'stok' => fake()->numberBetween(0, 100),
        ];
    }
}
