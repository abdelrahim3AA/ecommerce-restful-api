<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product; // Import the Product model
use App\Models\User as User; // Import the User model

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),  // Random word
            'detail' => $this->faker->sentence(),  // Random sentence
            'price' => $this->faker->numberBetween(100, 1000),  // Random price
            'stock' => $this->faker->numberBetween(1, 50),  // Random stock amount
            'discount' => $this->faker->numberBetween(2, 30),  // Random discount percentage
            'user_id' => function () {
                return User::all()->random(); 
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
