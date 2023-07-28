<?php

namespace Database\Seeders;

use App\Models\CategoryId;
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
            $product->category_id = $this->getCategory($product->purchase_price, $product->sale_price);
            $product->save();
        }

    }

    private function getCategory($purchasePrice, $salePrice): int
    {

        // calc profit margin percent
        $gainPercent = (($salePrice - $purchasePrice) / $purchasePrice) * 100;

        if ($gainPercent < 10) {
            return CategoryId::LowRange->value;
        } elseif ($gainPercent >= 10 && $gainPercent <= 20) {
            return CategoryId::MidRange->value;
        } else {
            return CategoryId::HightRange->value;
        }

    }
}
