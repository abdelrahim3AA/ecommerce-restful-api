<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Review extends Model
{
   /**
 * @OA\Schema(
 *     schema="Review",
 *     type="object",
 *     @OA\Property(property="data", type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="customer", type="string", example="John Doe"),
 *         @OA\Property(property="body", type="string", example="This product is amazing!"),
 *         @OA\Property(property="star", type="integer", example=5)
 *     )
 * )
 */


    use HasFactory;

    protected $fillable = [
        'customer',
        'star',
        'review'
    ]; 
    public function product() {

        return $this->belongsTo(Product::class);
    }
}
