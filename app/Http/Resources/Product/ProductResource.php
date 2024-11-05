<?php

namespace App\Http\Resources\Product;

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
            'name' => $this->name,
            'description' => $this->detail,
            'price' => $this->price,
            'stock' => ($this->stock > 0) ? $this->stock : 'Out Of Stock',
            'discount' => $this->discount,
            'rating' => $this->reviews->count() 
                        ? round($this->reviews->sum('star') / $this->reviews->count(), 2) 
                        : 'Non rating yet',
            'totalPrice' => round((1 - $this->discount / 100) * $this->price, 2),
            'link' => [
                'reviews' => route('reviews.index', $this->id)
            ]
        ];
    }
}
