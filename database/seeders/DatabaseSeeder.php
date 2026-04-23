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
            'is_active' => true,
        ],
        [
            'category_id' => 2,
            'name' => 'Kemeja Flanel',
            'slug' => 'kemeja-flanel',
            'description' => 'Kemeja flannel dengan motif kotak-kotak klasik. Cocok untuk casual maupun semi-formal.',
            'price' => 219000,
            'stock' => 40,
            'sizes' => ['S', 'M', 'L', 'XL'],
            'colors' => ['Merah-Hitam', 'Biru-Hitam', 'Coklat-Hitam'],
            'is_active' => true,
        ],
        [
            'category_id' => 3,
            'name' => 'Jaket Denim',
            'slug' => 'jaket-denim',
            'description' => 'Jaket denim dengan desain washed yang memberikan kesan vintage.',
            'price' => 449000,
            'stock' => 15,
            'sizes' => ['M', 'L', 'XL'],
            'colors' => ['Light Blue', 'Dark Blue', 'Black Washed'],
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
            'is_active' => true,
        ],     
        ];
        foreach ($products as $prod){
            Product::create($prod);
        }
    }
}
