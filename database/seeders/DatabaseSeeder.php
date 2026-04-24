<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tokobaju.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Rudi Haryono',
            'email' =>'rudye@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
        
        $categories = [
            ['name' => 'Kaos', 'slug' => 'kaos'],
            ['name' => 'Kemeja', 'slug' => 'kemeja'],
            ['name' => 'Jaket', 'slug' => 'jaket'],
            ['name' => 'Celana', 'slug' => 'celana'],
            ['name' => 'Hoodie', 'slug' => 'hoodie'],
        ];

        foreach ($categories as $cat){
            Category::create($cat);
        }

        $products = [[
            'category_id' => 1,
            'name' => 'Kaos Oversize',
            'slug' => 'kaos-oversize',
            'description' => 'Kaos oversize dengan bahan katun berkualitas tinggi, nyaman.',
            'price' => 150000,
            'stock' => 50,
            'sizes' => ['S', 'M', 'L', 'XL'],
            'colors' => ['Hitam', 'Putih', 'Abu-abu'],
            'image' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=400',
            'is_active' => true,
        ],
        [
            'category_id' => 1,
            'name' => 'Kaos Polos',
            'slug' => 'kaos-polos',
            'description' => 'Kaos polos dengan bahan katun berkualitas tinggi, nyaman dan anti bau.',
            'price' => 120000,
            'stock' => 100,
            'sizes' => ['S', 'M', 'L', 'XL'],
            'colors' => ['Merah', 'Putih', 'Navy', 'Hitam'],
            'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400',
            'is_active' => true,
        ],
        [
            'category_id' => 2,
            'name' => 'Kemeja Slim Fit',
            'slug' => 'kemeja-slim-fit',
            'description' => 'Kemeja  dengan potongan slim fit yang elegan. Ideal untuk acara formal maupun kasual.',
            'price' => 249000,
            'stock' => 30,
            'sizes' => ['S', 'M', 'L', 'XL'],
            'colors' => ['Hitam', 'Putih', 'Abu-abu'],
            'image' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=400',
            'is_active' => true,
        ],
        [
            'category_id' => 3,
            'name' => 'Jaket Bomber Varsity',
            'slug' => 'jaket-bomber-varsity',
            'description' => 'Jaket bomber dengan desain varsity yang klasik.',
            'price' => 549000,
            'stock' => 20,
            'sizes' => ['M', 'L', 'XL', 'XXL'],
            'colors' => ['Hitam', 'Navy', 'Maroon'],
            'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400',
            'is_active' => true,
        ],
        [
            'category_id' => 5,
            'name' => 'Hoodie Fleece',
            'slug' => 'hoodie-fleece',
            'description' => 'Hoodie fleece dengan bahan yang lembut dan nyaman.',
            'price' => 299000,
            'stock' => 25,
            'sizes' => ['S', 'M', 'L', 'XL'],
            'colors' => ['Hitam', 'Navy', 'Abu-Abu', 'Kuning'],
            'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400',
            'is_active' => true,
        ],
        [
            'category_id' => 4,
            'name' => 'Celana Chino',
            'slug' => 'celana-chino',
            'description' => 'Celana chino dengan bahan yang nyaman dan tampilan klasik.',
            'price' => 199000,
            'stock' => 35,
            'sizes' => ['28', '29', '30', '31', '32'],
            'colors' => ['Hitam', 'Navy', 'Abu-Abu', 'Kuning'],
            'image' => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=400',
            'is_active' => true,
        ],     
        ];
        foreach ($products as $prod){
            Product::create($prod);
        }
    }
}
