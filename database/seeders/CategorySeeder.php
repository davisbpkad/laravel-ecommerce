<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices, gadgets, and accessories'
            ],
            [
                'name' => 'Clothing',
                'description' => 'Fashion and apparel for men, women, and children'
            ],
            [
                'name' => 'Books',
                'description' => 'Books, magazines, and reading materials'
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home improvement, furniture, and garden supplies'
            ],
            [
                'name' => 'Sports & Fitness',
                'description' => 'Sports equipment, fitness gear, and outdoor activities'
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Toys, games, and entertainment for all ages'
            ],
            [
                'name' => 'Beauty & Health',
                'description' => 'Health products, beauty items, and personal care'
            ],
            [
                'name' => 'Automotive',
                'description' => 'Car parts, accessories, and automotive tools'
            ]
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
