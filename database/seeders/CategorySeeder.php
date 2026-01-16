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
        $categories = [
            'Electronics',
            'Clothing',
            'Books',
            'Home & Garden',
            'Sports',
            'Toys & Games',
            'Beauty & Personal Care',
            'Automotive',
            'Food & Beverages',
            'Pet Supplies',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
