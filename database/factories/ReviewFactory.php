<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Review;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::all()->random()->id,  // Random existing product
            'customer' => $this->faker->name(),  // Random customer name
            'review' => $this->faker->paragraph(),  // Random review text
            'star' => $this->faker->numberBetween(1, 5),  // Random star rating (1-5)
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
