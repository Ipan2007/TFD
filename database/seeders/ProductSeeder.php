<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Jaket Trif Classic',
                'price' => 275000,
                'image' => 'images/jaket1.jpg',
                'description' => 'Jaket vintage premium dengan bahan tebal dan nyaman.',
            ],
            [
                'name' => 'Jaket Trif Street',
                'price' => 300000,
                'image' => 'images/jaket2.jpg',
                'description' => 'Gaya streetwear modern cocok untuk semua suasana.',
            ],
            [
                'name' => 'Jaket Trif Outdoor',
                'price' => 325000,
                'image' => 'images/jaket3.jpg',
                'description' => 'Jaket tahan angin, outdoor untuk aktivitas harian dan travel.',
            ],
            [
                'name' => 'Jaket Trif Premium',
                'price' => 350000,
                'image' => 'images/jaket4.jpg',
                'description' => 'Limited edition dengan detail bordir eksklusif.',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
