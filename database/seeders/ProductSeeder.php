<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Electronics', 'Clothing', 'Books', 'Home & Garden', 'Sports'];
        $products = ['ElectroV2.24', 'CloV6.24', 'BookV7.24', 'Home & GardenV3.24', 'SportsV6.24'];

        for ($i = 1; $i <= 500; $i++) {
            Product::create([
                'name' => $products[array_rand($products)] . " #{$i}",
                'description' => "This is a detailed description for product {$i}. It's a high-quality item that you'll love!",
                'price' => rand(10, 500) + 0.99,
                'stock' => rand(0, 100),
                'sku' => 'SKU' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'category' => $categories[array_rand($categories)],
                'is_active' => rand(0, 1) ? true : false,
            ]);
        }
    }
}
