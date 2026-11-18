<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'url' => route('products.show', $this->id),
            'nama' => $this->nama,
            'harga' => $this->harga,
            'harga_format' => 'Rp '.number_format($this->harga, 0, ',', '.'),
            'stok' => $this->stok,
            'dibuat' => $this->created_at?->format('d-m-Y'),
        ];
    }
}
