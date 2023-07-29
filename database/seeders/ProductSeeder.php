<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if (Product::count()) {
            return;
        }

        $products = Product::factory()
            ->count(5)
            ->make();

        $i = 1;
        foreach ($products as $product) {
            $product->name = 'Product '.$i++;
            $product->updateCalculateFields();
            $product->save();
        }

    }
}
