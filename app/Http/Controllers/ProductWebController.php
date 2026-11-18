<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductWebController extends Controller
{
    /**
     * menampilkan daftar produk terbaru beserta kategori untuk halaman web.
     */
    public function index(Request $request): View
    {
        $search = $request->query('q', '');
        $search = is_scalar($search) ? trim((string) $search) : '';

        $categoryId = $request->query('kategori', '');
        $categoryId = is_scalar($categoryId) ? trim((string) $categoryId) : '';
        $categoryId = ctype_digit($categoryId) ? $categoryId : '';

        $sort = $request->query('urut', 'terbaru');
        $sort = is_string($sort) ? $sort : 'terbaru';

        if (! in_array($sort, ['terbaru', 'nama', 'harga_termurah', 'harga_termahal', 'stok_tersedikit'], true)) {
            $sort = 'terbaru';
        }

        $filtersApplied = $search !== '' || $categoryId !== '' || $sort !== 'terbaru';

        // menerapkan pencarian, filter kategori, dan pengurutan melalui parameter url.
        $productsQuery = Product::query()
            ->with('category')
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where('nama', 'like', '%'.$search.'%');
            })
            ->when($categoryId !== '', function (Builder $query) use ($categoryId): void {
                $query->where('category_id', $categoryId);
            });

        switch ($sort) {
            case 'nama':
                $productsQuery->orderBy('nama')->orderBy('id');
                break;
            case 'harga_termurah':
                $productsQuery->orderBy('harga')->orderBy('id');
                break;
            case 'harga_termahal':
                $productsQuery->orderByDesc('harga')->orderBy('id');
                break;
            case 'stok_tersedikit':
                $productsQuery->orderBy('stok')->orderBy('id');
                break;
            default:
                $productsQuery->latest();
                break;
        }

        $products = $productsQuery->paginate(10)->withQueryString();
        $categories = Category::query()->orderBy('name')->get();
        $totalProducts = Product::query()->count();
        $lowStockProducts = Product::query()->where('stok', '<', 20)->count();

        return view('products.index', compact(
            'products',
            'categories',
            'search',
            'categoryId',
            'sort',
            'filtersApplied',
            'totalProducts',
            'lowStockProducts',
        ));
    }

    /**
     * menyiapkan form tambah produk dengan opsi kategori dari database.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    /**
     * menyimpan produk baru setelah validasi berhasil dan redirect ke daftar produk.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * menampilkan form edit produk dengan data lama serta kategori yang tersedia.
     */
    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * memperbarui data produk yang dipilih setelah semua validasi terpenuhi.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * menghapus produk yang dipilih dan kembali ke daftar dengan notifikasi sukses.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
