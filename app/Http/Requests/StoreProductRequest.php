<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * menentukan apakah request ini boleh diproses oleh user yang sedang masuk.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * aturan validasi yang dipakai saat menambahkan produk baru melalui form web.
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * pesan validasi yang mudah dipahami pengguna agar error lebih jelas saat form diisi.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'nama produk wajib diisi.',
            'nama.string' => 'nama produk harus berupa teks.',
            'nama.max' => 'nama produk maksimal 255 karakter.',
            'category_id.required' => 'kategori wajib dipilih.',
            'category_id.exists' => 'kategori yang dipilih tidak tersedia.',
            'harga.required' => 'harga produk wajib diisi.',
            'harga.integer' => 'harga produk harus berupa angka bulat.',
            'harga.min' => 'harga produk tidak boleh kurang dari 0.',
            'stok.required' => 'stok produk wajib diisi.',
            'stok.integer' => 'stok produk harus berupa angka bulat.',
            'stok.min' => 'stok produk tidak boleh kurang dari 0.',
        ];
    }
}
