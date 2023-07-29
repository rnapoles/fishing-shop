<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve category by name or create it if it doesn't exist...
        $category = Category::firstOrCreate([
            'name' => 'Gama Baja',
        ]);

        // Retrieve category by name or create it if it doesn't exist...
        $category = Category::firstOrCreate([
            'name' => 'Gama Media',
        ]);

        // Retrieve category by name or create it if it doesn't exist...
        $category = Category::firstOrCreate([
            'name' => 'Gama Alta',
        ]);
    }
}
