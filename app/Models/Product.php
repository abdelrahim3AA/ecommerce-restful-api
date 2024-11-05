<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;

class Product extends Model
{/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     @OA\Property(property="data", type="object",
 *         @OA\Property(property="name", type="string", example="ipsam"),
 *         @OA\Property(property="description", type="string", example="Est est eum vitae voluptatem natus nemo."),
 *         @OA\Property(property="price", type="number", format="float", example=355.00),
 *         @OA\Property(property="stock", type="integer", example=31),
 *         @OA\Property(property="discount", type="integer", example=12),
 *         @OA\Property(property="rating", type="number", format="float", example=2.5),
 *         @OA\Property(property="totalPrice", type="number", format="float", example=312.40),
 *         @OA\Property(property="link", type="object",
 *             @OA\Property(property="reviews", type="string", example="http://localhost:8000/api/products/22/reviews")
 *         )
 *     )
 * )
 */

    use HasFactory;

    protected $fillable = [
        'name', 'detail', 'price', 'stock', 'discount'
    ];
    
    public function reviews() {

        return $this->hasMany(Review::class);
    }
}
