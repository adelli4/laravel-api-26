<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * membuat tabel kategori yang dipakai sebagai referensi produk dan dropdown form.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * menghapus tabel kategori jika migrasi dibatalkan.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
