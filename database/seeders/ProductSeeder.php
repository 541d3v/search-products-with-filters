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
        $products = [
            // Electronics
            ['name' => 'iPhone 14 Pro', 'price' => 999.99, 'category_id' => 1, 'in_stock' => true, 'rating' => 4.8],
            ['name' => 'Samsung Galaxy S23', 'price' => 899.99, 'category_id' => 1, 'in_stock' => true, 'rating' => 4.7],
            ['name' => 'iPad Air', 'price' => 599.99, 'category_id' => 1, 'in_stock' => true, 'rating' => 4.6],
            ['name' => 'MacBook Pro 16"', 'price' => 2499.99, 'category_id' => 1, 'in_stock' => true, 'rating' => 4.9],
            ['name' => 'Sony WH-1000XM5 Headphones', 'price' => 399.99, 'category_id' => 1, 'in_stock' => false, 'rating' => 4.7],

            // Clothing
            ['name' => 'Nike Air Max 270', 'price' => 129.99, 'category_id' => 2, 'in_stock' => true, 'rating' => 4.5],
            ['name' => 'Adidas Ultraboost 22', 'price' => 179.99, 'category_id' => 2, 'in_stock' => true, 'rating' => 4.6],
            ['name' => 'Levi\'s 501 Jeans', 'price' => 89.99, 'category_id' => 2, 'in_stock' => true, 'rating' => 4.4],
            ['name' => 'Columbia Winter Jacket', 'price' => 249.99, 'category_id' => 2, 'in_stock' => false, 'rating' => 4.3],

            // Books
            ['name' => 'The Great Gatsby', 'price' => 12.99, 'category_id' => 3, 'in_stock' => true, 'rating' => 4.2],
            ['name' => '1984', 'price' => 13.99, 'category_id' => 3, 'in_stock' => true, 'rating' => 4.5],
            ['name' => 'To Kill a Mockingbird', 'price' => 14.99, 'category_id' => 3, 'in_stock' => true, 'rating' => 4.7],
            ['name' => 'Clean Code', 'price' => 45.99, 'category_id' => 3, 'in_stock' => true, 'rating' => 4.8],

            // Home & Garden
            ['name' => 'Dyson V15 Vacuum', 'price' => 749.99, 'category_id' => 4, 'in_stock' => true, 'rating' => 4.7],
            ['name' => 'KitchenAid Mixer', 'price' => 329.99, 'category_id' => 4, 'in_stock' => true, 'rating' => 4.6],
            ['name' => 'LEGO Wall Shelf Set', 'price' => 49.99, 'category_id' => 4, 'in_stock' => false, 'rating' => 4.2],

            // Sports
            ['name' => 'Fitbit Charge 5', 'price' => 179.95, 'category_id' => 5, 'in_stock' => true, 'rating' => 4.3],
            ['name' => 'Peloton Bike+', 'price' => 1995.00, 'category_id' => 5, 'in_stock' => true, 'rating' => 4.6],
            ['name' => 'Yoga Mat Pro', 'price' => 79.99, 'category_id' => 5, 'in_stock' => true, 'rating' => 4.5],

            // Toys & Games
            ['name' => 'Nintendo Switch OLED', 'price' => 349.99, 'category_id' => 6, 'in_stock' => true, 'rating' => 4.8],
            ['name' => 'PlayStation 5', 'price' => 499.99, 'category_id' => 6, 'in_stock' => false, 'rating' => 4.7],
            ['name' => 'LEGO Star Wars Millennium Falcon', 'price' => 159.99, 'category_id' => 6, 'in_stock' => true, 'rating' => 4.9],

            // Beauty & Personal Care
            ['name' => 'Dyson Supersonic Hair Dryer', 'price' => 399.99, 'category_id' => 7, 'in_stock' => true, 'rating' => 4.6],
            ['name' => 'Clarisonic Mia Smart', 'price' => 299.99, 'category_id' => 7, 'in_stock' => true, 'rating' => 4.4],
            ['name' => 'Oral-B iO Series 9', 'price' => 149.99, 'category_id' => 7, 'in_stock' => true, 'rating' => 4.5],

            // Automotive
            ['name' => 'THULE Roof Rack', 'price' => 249.99, 'category_id' => 8, 'in_stock' => true, 'rating' => 4.5],
            ['name' => 'Michelin Defender T+H', 'price' => 189.99, 'category_id' => 8, 'in_stock' => true, 'rating' => 4.6],

            // Food & Beverages
            ['name' => 'Nespresso Vertuo Plus', 'price' => 199.99, 'category_id' => 9, 'in_stock' => true, 'rating' => 4.5],
            ['name' => 'Instant Pot Duo Plus', 'price' => 139.95, 'category_id' => 9, 'in_stock' => true, 'rating' => 4.7],

            // Pet Supplies
            ['name' => 'Roomba j7+', 'price' => 799.99, 'category_id' => 10, 'in_stock' => true, 'rating' => 4.6],
            ['name' => 'PetSafe Automatic Feeder', 'price' => 79.99, 'category_id' => 10, 'in_stock' => true, 'rating' => 4.3],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
