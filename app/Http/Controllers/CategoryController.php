<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * menampilkan semua kategori dummy dalam bentuk json.
     */
    public function index(): JsonResponse
    {
        return response()->json($this->categories());
    }

    /**
     * memberi petunjuk untuk menambahkan kategori melalui endpoint store.
     */
    public function create(): JsonResponse
    {
        return response()->json([
            'pesan' => 'Gunakan POST /categories untuk menambahkan kategori',
        ]);
    }

    /**
     * mengambil nama dan stok dari request lalu mengembalikannya sebagai json.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->only(['nama', 'stok']);

        return response()->json([
            'pesan' => 'Kategori diterima',
            'data' => $data,
        ], 201);
    }

    /**
     * mencari kategori berdasarkan id dan mengembalikan json 404 jika tidak ditemukan.
     */
    public function show(string $id): JsonResponse
    {
        $category = $this->findCategory($id);

        if ($category === null) {
            return response()->json([
                'pesan' => 'Kategori tidak ditemukan',
            ], 404);
        }

        return response()->json($category);
    }

    /**
     * menampilkan data kategori yang akan diubah.
     */
    public function edit(string $id): JsonResponse
    {
        return $this->show($id);
    }

    /**
     * memeriksa id kategori lalu mengembalikan data pembaruan dalam bentuk json.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        if ($this->findCategory($id) === null) {
            return response()->json([
                'pesan' => 'Kategori tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'pesan' => 'Data pembaruan kategori diterima',
            'id' => (int) $id,
            'data' => $request->all(),
        ]);
    }

    /**
     * memeriksa id kategori lalu mengembalikan konfirmasi penghapusan.
     */
    public function destroy(string $id): JsonResponse
    {
        if ($this->findCategory($id) === null) {
            return response()->json([
                'pesan' => 'Kategori tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'pesan' => 'Permintaan penghapusan kategori diterima',
            'id' => (int) $id,
        ]);
    }

    /**
     * menyediakan daftar kategori contoh yang tidak disimpan ke database.
     *
     * @return array<int, array{id: int, nama: string}>
     */
    private function categories(): array
    {
        return [
            ['id' => 1, 'nama' => 'Elektronik'],
            ['id' => 2, 'nama' => 'Pakaian'],
            ['id' => 3, 'nama' => 'Makanan'],
        ];
    }

    /**
     * mencari kategori dengan id yang diberikan atau mengembalikan null.
     *
     * @return array{id: int, nama: string}|null
     */
    private function findCategory(string $id): ?array
    {
        foreach ($this->categories() as $category) {
            if ($category['id'] === (int) $id) {
                return $category;
            }
        }

        return null;
    }
}
