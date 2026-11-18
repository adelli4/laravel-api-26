@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    {{-- form tambah produk menampung data utama agar data dapat disimpan ke database dengan kategori yang tepat. --}}
    <section class="page-header">
        <div>
            <p class="eyebrow">Produk</p>
            <h1 class="page-title">Tambah Produk</h1>
            {{-- tambahan: subjudul halaman --}}
            <p class="page-subtitle">Isi data produk baru untuk menambahkannya ke daftar persediaan.</p>
        </div>

        <a href="{{ route('produk.index') }}" class="button button-secondary">
            {{-- tambahan: ikon panah kembali --}}
            <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </section>

    @if ($errors->any())
        {{-- tambahan: pemberitahuan bila ada isian yang belum valid --}}
        <div class="alert alert-error" role="alert">
            Data belum bisa disimpan. Periksa kembali isian yang ditandai merah.
        </div>
    @endif

    <section class="form-card">
        {{-- tambahan: judul kecil di dalam kartu form --}}
        <div class="form-card-head">
            <h2>Informasi Produk</h2>
            <p>Nama, kategori, harga, dan jumlah stok awal produk.</p>
        </div>

        <form action="{{ route('produk.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="field">
                    <label for="nama">Nama Produk</label>
                    <input id="nama" name="nama" type="text" value="{{ old('nama') }}" placeholder="Masukkan nama produk" class="@error('nama') is-invalid @enderror">
                    @error('nama')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="category_id">Kategori</label>
                    <select id="category_id" name="category_id" class="@error('category_id') is-invalid @enderror">
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="harga">Harga</label>
                    {{-- tambahan: awalan "Rp" di dalam kolom harga --}}
                    <div class="input-group">
                        <span class="input-prefix" aria-hidden="true">Rp</span>
                        <input id="harga" name="harga" type="number" min="0" value="{{ old('harga') }}" placeholder="Masukkan harga produk" class="@error('harga') is-invalid @enderror">
                    </div>
                    {{-- tambahan: pratinjau harga dalam format rupiah --}}
                    <span class="field-hint" id="harga-preview" aria-live="polite">Harga akan tampil sebagai Rp 0</span>
                    @error('harga')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="stok">Stok</label>
                    <input id="stok" name="stok" type="number" min="0" value="{{ old('stok') }}" placeholder="Masukkan jumlah stok" class="@error('stok') is-invalid @enderror">
                    {{-- tambahan: petunjuk singkat --}}
                    <span class="field-hint">Isi 0 jika belum ada persediaan.</span>
                    @error('stok')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('produk.index') }}" class="button button-secondary">Batal</a>
                <button type="submit" class="button button-primary">
                    {{-- tambahan: ikon centang --}}
                    <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                    Simpan
                </button>
            </div>
        </form>
    </section>

    {{-- tambahan: script pratinjau harga, fokus otomatis, dan mencegah klik ganda saat menyimpan --}}
    <script>
        (function () {
            var form = document.querySelector('.form-card form');
            var harga = document.getElementById('harga');
            var preview = document.getElementById('harga-preview');
            var submit = form ? form.querySelector('button[type="submit"]') : null;
            if (!form || !harga || !preview) return;

            function formatHarga() {
                var nilai = parseInt(harga.value, 10);
                if (isNaN(nilai) || nilai < 0) nilai = 0;
                preview.textContent = 'Harga akan tampil sebagai Rp ' + nilai.toLocaleString('id-ID');
            }

            harga.addEventListener('input', formatHarga);
            formatHarga();

            // fokus ke isian pertama yang error, atau ke nama produk bila belum ada error
            var galat = document.querySelector('.error-message');
            var target = galat ? galat.closest('.field').querySelector('input, select') : document.getElementById('nama');
            if (target) target.focus();

            // cegah klik ganda saat data dikirim
            form.addEventListener('submit', function () {
                if (!submit) return;
                submit.disabled = true;
                submit.classList.add('is-loading');
            });

            // aktifkan kembali tombol bila halaman dimuat ulang dari tombol "kembali" browser
            window.addEventListener('pageshow', function () {
                if (!submit) return;
                submit.disabled = false;
                submit.classList.remove('is-loading');
            });
        })();
    </script>
@endsection