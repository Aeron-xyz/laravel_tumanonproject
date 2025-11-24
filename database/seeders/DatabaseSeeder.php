<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $categories = collect([
            ['name' => 'Cozy Throws', 'color' => '#a855f7', 'description' => 'Layered blankets and snuggle-ready throws'],
            ['name' => 'Amigurumi Friends', 'color' => '#f472b6', 'description' => 'Handmade plushies with friendly faces'],
            ['name' => 'Wearables', 'color' => '#38bdf8', 'description' => 'Scarves, beanies and statement pieces'],
            ['name' => 'Home Accents', 'color' => '#f97316', 'description' => 'Planter sleeves, baskets and coasters'],
            ['name' => 'Baby Keepsakes', 'color' => '#ec4899', 'description' => 'Blankets and rattles for little ones'],
        ])->mapWithKeys(function ($data) {
            $category = Category::create($data);

            return [$category->name => $category->id];
        });

        $products = [
            ['name' => 'Luna Shell Blanket', 'price' => 4200, 'stock' => 7, 'category' => 'Cozy Throws', 'material' => 'Merino blend', 'description' => 'Starburst stitch blanket in lavender gradients'],
            ['name' => 'Aurora Bunny Plush', 'price' => 1500, 'stock' => 15, 'category' => 'Amigurumi Friends', 'material' => 'Cotton acrylic', 'description' => 'Pastel bunny with removable scarf'],
            ['name' => 'Driftwood Basket Set', 'price' => 2800, 'stock' => 5, 'category' => 'Home Accents', 'material' => 'Jute cotton mix', 'description' => 'Nested storage baskets with leather tabs'],
            ['name' => 'Solstice Bandana', 'price' => 950, 'stock' => 18, 'category' => 'Wearables', 'material' => 'Mercerized cotton', 'description' => 'Tri-tone granny bandana with tassels'],
            ['name' => 'Petal Bloom Beanie', 'price' => 1200, 'stock' => 10, 'category' => 'Wearables', 'material' => 'Alpaca wool', 'description' => 'Double-layered beanie with faux-fur pom'],
            ['name' => 'Cloudlet Baby Rattle', 'price' => 800, 'stock' => 20, 'category' => 'Baby Keepsakes', 'material' => 'Organic cotton', 'description' => 'Soft rattle with wooden grip ring'],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'description' => $product['description'],
                'material' => $product['material'] ?? null,
                'category_id' => $categories[$product['category']] ?? null,
            ]);
        }
    }
}
