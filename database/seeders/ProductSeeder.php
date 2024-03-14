<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['artist' => 'Dave', 'title' => 'Dave\'s song', 'price' => 500],
            ['artist' => 'John', 'title' => 'John\'s song', 'price' => 350],
        ];

        $defaultImage = asset('PlaceholderVinyl.jpg');

        foreach ($products as $product) {
            Product::create([
                'artist' => $product['artist'],
                'title' => $product['title'],
                'price' => $product['price'],
                'image' => '1704238410_download.jfif'
            ]);
        }
        Product::factory()->times(100)->create();
    }
}

