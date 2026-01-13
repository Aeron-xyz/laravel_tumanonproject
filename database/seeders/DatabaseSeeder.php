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
            ['name' => 'Luna Shell Blanket', 'price' => 4200, 'stock' => 7, 'category' => 'Cozy Throws', 'material' => 'Merino wool', 'description' => 'Starburst stitch blanket in lavender gradients'],
            ['name' => 'Aurora Bunny Plush', 'price' => 1500, 'stock' => 15, 'category' => 'Amigurumi Friends', 'material' => 'Cotton acrylic mix', 'description' => 'Pastel bunny with removable scarf'],
            ['name' => 'Driftwood Basket Set', 'price' => 2800, 'stock' => 5, 'category' => 'Home Accents', 'material' => 'Jute cotton mix', 'description' => 'Nested storage baskets with leather tabs'],
            ['name' => 'Solstice Bandana', 'price' => 950, 'stock' => 18, 'category' => 'Wearables', 'material' => 'Mercerized cotton', 'description' => 'Tri-tone granny bandana with tassels'],
            ['name' => 'Petal Bloom Beanie', 'price' => 1200, 'stock' => 10, 'category' => 'Wearables', 'material' => 'Alpaca wool', 'description' => 'Double-layered beanie with faux-fur pom'],
            ['name' => 'Cloudlet Baby Rattle', 'price' => 800, 'stock' => 20, 'category' => 'Baby Keepsakes', 'material' => 'Organic cotton', 'description' => 'Soft rattle with wooden grip ring'],
            ['name' => 'Stardust Scarf', 'price' => 1100, 'stock' => 12, 'category' => 'Wearables', 'material' => 'Acrylic yarn', 'description' => 'Sparkly infinity scarf with fringe ends'],
            ['name' => 'Moonlight Amigurumi Bear', 'price' => 1800, 'stock' => 8, 'category' => 'Amigurumi Friends', 'material' => 'Chenille yarn', 'description' => 'Soft teddy bear with embroidered eyes'],
            ['name' => 'Coastal Throw Pillow', 'price' => 1600, 'stock' => 14, 'category' => 'Home Accents', 'material' => 'Cotton yarn', 'description' => 'Textured pillow cover in ocean blues'],
            ['name' => 'Sunrise Baby Blanket', 'price' => 3500, 'stock' => 6, 'category' => 'Baby Keepsakes', 'material' => 'Bamboo yarn', 'description' => 'Ultra-soft blanket in warm sunrise colors'],
            ['name' => 'Twilight Shawl', 'price' => 2200, 'stock' => 9, 'category' => 'Wearables', 'material' => 'Silk blend', 'description' => 'Elegant triangular shawl with delicate lace pattern'],
            ['name' => 'Forest Friend Fox', 'price' => 1900, 'stock' => 11, 'category' => 'Amigurumi Friends', 'material' => 'Wool yarn', 'description' => 'Adorable fox with bushy tail and button eyes'],
            ['name' => 'Garden Planter Cozy', 'price' => 750, 'stock' => 22, 'category' => 'Home Accents', 'material' => 'Cotton yarn', 'description' => 'Decorative cover for plant pots in earthy tones'],
            ['name' => 'Cozy Cabin Throw', 'price' => 3800, 'stock' => 8, 'category' => 'Cozy Throws', 'material' => 'Wool yarn', 'description' => 'Chunky cable-knit blanket perfect for winter nights'],
            ['name' => 'Ocean Wave Coasters', 'price' => 650, 'stock' => 25, 'category' => 'Home Accents', 'material' => 'Cotton yarn', 'description' => 'Set of four coasters with wave pattern'],
            ['name' => 'Sweet Dreams Baby Mobile', 'price' => 2400, 'stock' => 7, 'category' => 'Baby Keepsakes', 'material' => 'Acrylic yarn', 'description' => 'Colorful mobile with stars and moons'],
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
