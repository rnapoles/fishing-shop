<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $purchase = fake()->randomFloat(2, 10, 20);
        $sale = fake()->randomFloat(2, 21, 30);

        if ($purchase < 20) {
            $sale = fake()->randomFloat(2, $purchase + 1, $purchase + 5);
        }

        return [
            'name' => strtoupper(fake()->randomLetter()),
            'purchase_price' => $purchase,
            'sale_price' => $sale,
            'units_in_stock' => fake()->numberBetween(1, 5),
            'category_id' => fake()->numberBetween(1, 3),
        ];
    }
}
