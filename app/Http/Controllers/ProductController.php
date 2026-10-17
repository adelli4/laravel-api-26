<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // controller menangani proses data produk agar tidak menumpuk di file route.
    // mengirim seluruh daftar produk dalam format json.
    public function index()
    {
        return response()->json($this->products());
    }

    // menyediakan data produk yang dipakai oleh method index dan show.
    private function products(): array
    {
        return [
            [
                'id' => 1,
                'nama' => 'Kopi Arabika',
                'harga' => 10000,
            ],
            [
                'id' => 2,
                'nama' => 'Teh Hijau',
                'harga' => 20000,
            ],
            [
                'id' => 3,
                'nama' => 'Headphone Nirkabel',
                'harga' => 150000,
            ],
            [
                'id' => 4,
                'nama' => 'Kemeja Katun',
                'harga' => 85000,
            ],
            [
                'id' => 5,
                'nama' => 'Roti Cokelat',
                'harga' => 12000,
            ],
            [
                'id' => 6,
                'nama' => 'Mouse Nirkabel',
                'harga' => 75000,
            ],
            [
                'id' => 7,
                'nama' => 'Kaos Polos',
                'harga' => 50000,
            ],
            [
                'id' => 8,
                'nama' => 'Keripik Kentang',
                'harga' => 18000,
            ],
        ];
    }

    public function store(Request $request)
    {
        return response()->json([
            'pesan' => 'Produk diterima',
            'data' => $request->all(),
        ], 201);
    }

    public function show($id)
    {
        // mencari produk dengan id yang sama dengan id pada url.
        foreach ($this->products() as $product) {
            if ($product['id'] === (int) $id) {
                return response()->json($product);
            }
        }

        // mengembalikan respons 404 jika produk tidak ditemukan.
        abort(404);
    }

    public function update(Request $request, string $id)
    {
        return response()->json([
            'pesan' => 'Data pembaruan produk diterima',
            'id' => (int) $id,
            'data' => $request->all(),
        ]);
    }

    public function destroy(string $id)
    {
        return response()->json([
            'pesan' => 'Permintaan penghapusan produk diterima',
            'id' => (int) $id,
        ]);
    }
}
