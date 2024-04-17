<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserProduct;

class UserProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Loop over the range of product IDs from 1 to 100
        for ($productID = 1; $productID <= 100; $productID++) {
            UserProduct::create([
                'userID' => 1,
                'productID' => $productID,
                'best_before' => now()->addDays(mt_rand(1, 365)), // Random date within next year
                'stock' => mt_rand(1, 100), // Random stock between 1 and 100
            ]);
        }
    }
}