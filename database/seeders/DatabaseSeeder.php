<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 users
        User::factory(10)->create();

        // Create a single test user
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Create 5 products
        $products = Product::factory(count: 50)->create();

        // Generate 3 reviews for each product
        $products->each(function ($product) {
            Review::factory(4)->create([
                'product_id' => $product->id,
            ]);
        });
    }
}
