<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * membolehkan deskripsi produk kosong agar form tambah dan edit lebih fleksibel.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->change();
        });
    }

    /**
     * mengembalikan struktur lama kolom deskripsi jika migrasi dibatalkan.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('deskripsi')->nullable(false)->change();
        });
    }
};
