<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = max(1, min($request->integer('per_page', 10), 50));
        $search = $request->input('search');

        return ProductResource::collection(
            Product::query()

            // with('category') digunakan untuk memuat relasi kategori agar nama kategori dapat ditampilkan bersama data produk.
            // diambil dari model Product yang memiliki relasi belongsTo ke model Category. (Product.php)
                ->with('category')
                ->when($search, function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%");
                })
                ->orderBy('id', 'desc')
                ->paginate($perPage)
        )->response();
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:categories,id',
        ]);

        $product = Product::create($data);

        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $data = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'harga' => 'sometimes|integer|min:0',
            'stok' => 'sometimes|integer|min:0',
            'deskripsi' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:categories,id',
        ]);

        $product->update($data);

        return response()->json($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(null, 204);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }
}
