<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop Gaming ASUS ROG',
                'description' => 'Laptop gaming dengan spesifikasi tinggi, RAM 16GB, SSD 512GB, RTX 4060',
                'price' => 18500000,
                'stock' => 15,
                'category' => 'Electronics',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Smartphone Apple terbaru dengan chip A17 Pro, kamera 48MP, storage 256GB',
                'price' => 19999000,
                'stock' => 25,
                'category' => 'Electronics',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Flagship Android dengan S Pen, kamera 200MP, RAM 12GB, storage 256GB',
                'price' => 16999000,
                'stock' => 20,
                'category' => 'Electronics',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'MacBook Air M3',
                'description' => 'Laptop ultra-thin dengan chip M3, RAM 8GB, SSD 256GB, layar Retina 13"',
                'price' => 16999000,
                'stock' => 12,
                'category' => 'Electronics',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Headphone wireless dengan noise cancelling terbaik, battery 30 jam',
                'price' => 4999000,
                'stock' => 30,
                'category' => 'Audio',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'description' => 'Console gaming portable dengan layar OLED 7", storage 64GB',
                'price' => 4299000,
                'stock' => 18,
                'category' => 'Gaming',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'iPad Pro 12.9" M2',
                'description' => 'Tablet profesional dengan chip M2, layar Liquid Retina XDR, storage 128GB',
                'price' => 14999000,
                'stock' => 10,
                'category' => 'Electronics',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Mechanical Keyboard Keychron K8',
                'description' => 'Keyboard mechanical wireless dengan switch Gateron, RGB backlight',
                'price' => 1299000,
                'stock' => 35,
                'category' => 'Accessories',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Logitech MX Master 3S',
                'description' => 'Mouse wireless ergonomis untuk produktivitas, sensor 8000 DPI',
                'price' => 1599000,
                'stock' => 40,
                'category' => 'Accessories',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Monitor LG 27" 4K',
                'description' => 'Monitor 4K UHD dengan IPS panel, USB-C, HDR10 support',
                'price' => 5999000,
                'stock' => 22,
                'category' => 'Electronics',
                'image' => null,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
