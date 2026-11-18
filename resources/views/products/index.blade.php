@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
    {{-- menampilkan judul halaman dan tombol utama untuk menambah produk baru. --}}
    <section class="page-header">
        <div>
            <p class="eyebrow">Produk</p>
            <h1 class="page-title">Manajemen Produk</h1>
        </div>

        <a href="{{ route('produk.create') }}" class="button button-primary">Tambah Produk</a>
    </section>

    {{-- menyediakan pencarian, filter kategori, dan pengurutan daftar produk. --}}
    <section class="filter-card">
        <form action="{{ route('produk.index') }}" method="GET">
            <div class="filter-grid">
                <div class="field">
                    <label for="q">Cari nama produk</label>
                    <input id="q" name="q" type="search" value="{{ $search }}" placeholder="Contoh: kopi arabika">
                </div>

                <div class="field">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori">
                        <option value="">Semua kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="urut">Urutkan</label>
                    <select id="urut" name="urut">
                        <option value="terbaru" {{ $sort === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="nama" {{ $sort === 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="harga_termurah" {{ $sort === 'harga_termurah' ? 'selected' : '' }}>Harga termurah</option>
                        <option value="harga_termahal" {{ $sort === 'harga_termahal' ? 'selected' : '' }}>Harga termahal</option>
                        <option value="stok_tersedikit" {{ $sort === 'stok_tersedikit' ? 'selected' : '' }}>Stok tersedikit</option>
                    </select>
                </div>
            </div>

            <div class="filter-actions">
                <a href="{{ route('produk.index') }}" class="button button-secondary">Reset</a>
                <button type="submit" class="button button-primary">Terapkan</button>
            </div>
        </form>
    </section>

    {{-- merangkum seluruh produk dan stok menipis tanpa mengikuti filter yang sedang dipakai. --}}
    <section class="summary-grid" aria-label="Ringkasan persediaan">
        <article class="summary-card">
            <span class="summary-label">Total produk</span>
            <strong>{{ number_format($totalProducts, 0, ',', '.') }}</strong>
            <span class="summary-detail">Produk terdaftar</span>
        </article>
        <article class="summary-card summary-card-warning">
            <span class="summary-label">Stok menipis</span>
            <strong>{{ number_format($lowStockProducts, 0, ',', '.') }}</strong>
            <span class="summary-detail">Produk dengan stok di bawah 20</span>
        </article>
    </section>

    @if ($products->isEmpty() && $filtersApplied)
        {{-- memberi tahu pengguna saat pencarian atau filter tidak menemukan produk. --}}
        <section class="card empty-state">
            <div class="icon">?</div>
            <h2>Produk tidak ditemukan</h2>
            <p>Coba ubah kata pencarian atau pilihan filter, atau tampilkan kembali semua produk.</p>
            <a href="{{ route('produk.index') }}" class="button button-secondary">Reset filter</a>
        </section>
    @else
    <section class="card">
        @if ($products->isEmpty())
            {{-- memberi informasi yang jelas ketika daftar produk masih kosong. --}}
            <div class="empty-state">
                <div class="icon">!</div>
                <h2>Belum Ada Produk</h2>
                <p>Belum ada produk yang tersimpan. Tambahkan produk untuk mulai mengelola persediaan.</p>
                <a href="{{ route('produk.create') }}" class="button button-primary" style="margin-top: 18px;">Tambah Produk</a>
            </div>
        @else
            {{-- menampilkan data produk beserta kategori, harga, stok, dan tombol aksi. --}}
            <div class="table-container" style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td><strong>{{ $product->nama }}</strong></td>
                                {{-- warna badge mengikuti nama kategori, stok di bawah 20 diberi warna merah. --}}
                                <td><span class="badge badge-category badge-{{ str_replace(' ', '-', strtolower($product->category?->name ?? '')) }}" style="--badge-hue: {{ abs(crc32($product->category?->name ?? 'kategori')) % 360 }};">{{ $product->category?->name ?? '-' }}</span></td>
                                <td class="price-cell">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td class="{{ $product->stok < 20 ? 'stok-menipis' : '' }} {{ $product->stok >= 20 && $product->stok < 50 ? 'stok-cukup' : '' }} {{ $product->stok >= 50 ? 'stok-aman' : '' }} stok-cell">{{ $product->stok }}</td>
                                <td style="text-align: right;">
                                    <div style="display: flex; justify-content: flex-end; gap: 8px; flex-wrap: wrap;">
                                        <a href="{{ route('produk.edit', $product) }}" class="button button-secondary" style="padding: 8px 12px; font-size: 0.8rem;">Ubah</a>

                                        <form action="{{ route('produk.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="button button-danger button-danger-outline" style="padding: 8px 12px; font-size: 0.8rem;">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $products->links() }}
            </div>
        @endif
    </section>
    @endif
@endsection