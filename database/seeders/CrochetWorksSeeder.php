<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CrochetWorksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create categories
        $cozyThrows = Category::firstOrCreate(
            ['name' => 'Cozy Throws'],
            ['color' => '#a855f7', 'description' => 'Layered blankets and snuggle-ready throws']
        );
        
        $homeAccents = Category::firstOrCreate(
            ['name' => 'Home Accents'],
            ['color' => '#f97316', 'description' => 'Planter sleeves, baskets and coasters']
        );
        
        $babyKeepsakes = Category::firstOrCreate(
            ['name' => 'Baby Keepsakes'],
            ['color' => '#ec4899', 'description' => 'Blankets and rattles for little ones']
        );

        // 15 crochet products based on provided images
        $crochetWorks = [
            // Based on Image 1: Navy Blue Chunky Cable Knit Blanket
            [
                'name' => 'Navy Blue Chunky Cable Knit Blanket',
                'price' => 4200.00,
                'stock' => 8,
                'material' => 'Chunky wool yarn',
                'description' => 'Thick, chunky cable-knit blanket in deep navy blue. Features beautiful braided cable patterns with ribbed sections. Perfect for cozy winter evenings on the sofa.',
                'category_id' => $cozyThrows->id,
                'image_color' => '1e3a5f', // Navy blue
            ],
            [
                'name' => 'Grey Chunky Cable Throw',
                'price' => 3800.00,
                'stock' => 10,
                'material' => 'Chunky wool blend',
                'description' => 'Luxurious chunky cable-knit throw in soft grey. Same beautiful cable pattern as our navy version, perfect for modern living spaces.',
                'category_id' => $cozyThrows->id,
                'image_color' => '6b7280', // Grey
            ],
            
            // Based on Image 2: Multi-Colored Granny Square Blanket
            [
                'name' => 'Vibrant Purple Granny Square Blanket',
                'price' => 3500.00,
                'stock' => 6,
                'material' => 'Cotton yarn',
                'description' => 'Stunning granny square blanket with vibrant purple background. Each square features a unique explosion of colors including pink, blue, green, yellow, orange, and red. Finished with decorative scalloped border.',
                'category_id' => $cozyThrows->id,
                'image_color' => '7c3aed', // Purple
            ],
            [
                'name' => 'Rainbow Granny Square Throw',
                'price' => 3200.00,
                'stock' => 9,
                'material' => 'Acrylic cotton blend',
                'description' => 'Colorful granny square throw with rainbow-colored squares joined together. Each square is a miniature work of art with concentric rounds of bright colors.',
                'category_id' => $cozyThrows->id,
                'image_color' => 'ec4899', // Pink
            ],
            
            // Based on Image 3: Ripple Wave Blanket
            [
                'name' => 'Sage Green Ripple Wave Blanket',
                'price' => 2800.00,
                'stock' => 12,
                'material' => 'Organic cotton',
                'description' => 'Beautiful ripple or wave stitch blanket in white, pastel pink, and muted sage green. The wavy pattern creates a dynamic flow. Perfect for baby or home decor.',
                'category_id' => $babyKeepsakes->id,
                'image_color' => '9ca3af', // Sage green tone
            ],
            [
                'name' => 'Pastel Ripple Baby Blanket',
                'price' => 2600.00,
                'stock' => 15,
                'material' => 'Bamboo cotton blend',
                'description' => 'Soft ripple stitch baby blanket in gentle pastel colors. The wave pattern is soothing and the yarn is ultra-soft for sensitive skin.',
                'category_id' => $babyKeepsakes->id,
                'image_color' => 'f9a8d4', // Pastel pink
            ],
            [
                'name' => 'Ocean Wave Throw Blanket',
                'price' => 3000.00,
                'stock' => 11,
                'material' => 'Cotton yarn',
                'description' => 'Elegant ripple wave blanket in ocean-inspired colors. The flowing wave pattern mimics gentle ocean waves, creating a calming atmosphere.',
                'category_id' => $cozyThrows->id,
                'image_color' => '38bdf8', // Blue
            ],
            
            // Based on Image 4: Vibrant Mandala Square Pillow
            [
                'name' => 'Vibrant Mandala Square Pillow',
                'price' => 1800.00,
                'stock' => 14,
                'material' => 'Cotton acrylic mix',
                'description' => 'Stunning square crochet pillow featuring a mandala-like design in the center. Bright colors including orange, yellow, blue, pink, green, and purple create a vibrant, cheerful accent piece.',
                'category_id' => $homeAccents->id,
                'image_color' => 'f97316', // Orange
            ],
            [
                'name' => 'Sunset Mandala Pillow',
                'price' => 1650.00,
                'stock' => 16,
                'material' => 'Cotton yarn',
                'description' => 'Beautiful mandala pillow with warm sunset colors. Features intricate shell stitches and scalloped edges in shades of orange, pink, and yellow.',
                'category_id' => $homeAccents->id,
                'image_color' => 'fb923c', // Orange
            ],
            [
                'name' => 'Ocean Mandala Pillow',
                'price' => 1750.00,
                'stock' => 13,
                'material' => 'Cotton blend',
                'description' => 'Cool-toned mandala pillow in ocean blues and teals. The circular mandala pattern transitions to a square border, perfect for coastal-themed decor.',
                'category_id' => $homeAccents->id,
                'image_color' => '0ea5e9', // Blue
            ],
            
            // Based on Image 5: Geometric Pattern Blanket
            [
                'name' => 'Mint Geometric Diamond Blanket',
                'price' => 3200.00,
                'stock' => 7,
                'material' => 'Cotton yarn',
                'description' => 'Stunning geometric blanket with concentric square pattern in white, light mint green, and dusty teal. Features shell stitches creating a rich, textured fabric with visible depth.',
                'category_id' => $cozyThrows->id,
                'image_color' => '6ee7b7', // Mint green
            ],
            [
                'name' => 'Teal Geometric Throw',
                'price' => 2900.00,
                'stock' => 9,
                'material' => 'Wool cotton blend',
                'description' => 'Modern geometric throw with diamond pattern in white, mint, and teal. The alternating color bands create a sophisticated, calming aesthetic.',
                'category_id' => $cozyThrows->id,
                'image_color' => '14b8a6', // Teal
            ],
            [
                'name' => 'Pastel Geometric Baby Blanket',
                'price' => 2400.00,
                'stock' => 12,
                'material' => 'Organic cotton',
                'description' => 'Soft geometric pattern baby blanket in gentle pastel colors. The shell stitch texture provides visual interest while remaining soft and safe for little ones.',
                'category_id' => $babyKeepsakes->id,
                'image_color' => 'a7f3d0', // Light mint
            ],
            
            // Additional variations
            [
                'name' => 'Cream Cable Knit Blanket',
                'price' => 4000.00,
                'stock' => 8,
                'material' => 'Chunky merino wool',
                'description' => 'Luxurious chunky cable-knit blanket in cream. Features the same beautiful braided cable pattern, perfect for neutral home decor.',
                'category_id' => $cozyThrows->id,
                'image_color' => 'fef3c7', // Cream
            ],
            [
                'name' => 'Burgundy Granny Square Blanket',
                'price' => 3400.00,
                'stock' => 7,
                'material' => 'Cotton yarn',
                'description' => 'Rich burgundy granny square blanket with colorful accent squares. Each square features unique color combinations, creating a vibrant patchwork effect.',
                'category_id' => $cozyThrows->id,
                'image_color' => '991b1b', // Burgundy
            ],
            [
                'name' => 'Floral Mandala Pillow',
                'price' => 1900.00,
                'stock' => 11,
                'material' => 'Cotton acrylic mix',
                'description' => 'Elegant floral mandala pillow with soft pastel colors. Features intricate crochet work with shell stitches and decorative borders, perfect for adding charm to any room.',
                'category_id' => $homeAccents->id,
                'image_color' => 'f472b6', // Pink
            ],
        ];

        // Create products with placeholder images
        foreach ($crochetWorks as $work) {
            // Check if product already exists
            $existing = Product::where('name', $work['name'])->first();
            if ($existing) {
                continue; // Skip if already exists
            }
            
            $photoPath = $this->downloadPlaceholderImage($work['name'], $work['image_color']);
            
            Product::create([
                'name' => $work['name'],
                'photo' => $photoPath,
                'price' => $work['price'],
                'stock' => $work['stock'],
                'material' => $work['material'],
                'description' => $work['description'],
                'category_id' => $work['category_id'],
            ]);
        }
    }

    /**
     * Create placeholder image using GD library
     */
    private function downloadPlaceholderImage(string $name, string $color): ?string
    {
        // Ensure products directory exists
        Storage::disk('public')->makeDirectory('products');
        
        // Try GD library first
        if (function_exists('imagecreatetruecolor')) {
            return $this->createGDImage($name, $color);
        }
        
        // Fallback: try downloading from placeholder service
        try {
            $width = 400;
            $height = 400;
            $text = Str::limit(str_replace(' ', '+', $name), 20);
            $url = "https://via.placeholder.com/{$width}x{$height}/{$color}/ffffff.png?text={$text}";
            
            $filename = 'products/' . Str::slug($name) . '_' . time() . '.png';
            $path = storage_path('app/public/' . $filename);
            
            // Try file_get_contents first
            $imageContent = @file_get_contents($url);
            
            if ($imageContent === false || strlen($imageContent) < 100) {
                // Try with Http facade
                try {
                    $response = Http::timeout(10)->get($url);
                    if ($response->successful()) {
                        $imageContent = $response->body();
                    }
                } catch (\Exception $e) {
                    // Continue
                }
            }
            
            if ($imageContent && strlen($imageContent) > 100) {
                file_put_contents($path, $imageContent);
                return $filename;
            }
        } catch (\Exception $e) {
            // Continue to create placeholder
        }
        
        // Create a simple placeholder file
        $filename = 'products/' . Str::slug($name) . '_' . time() . '.txt';
        $path = storage_path('app/public/' . $filename);
        file_put_contents($path, 'placeholder');
        return $filename;
    }

    /**
     * Create image using GD library
     */
    private function createGDImage(string $name, string $color): ?string
    {
        $width = 400;
        $height = 400;
        $image = imagecreatetruecolor($width, $height);
        
        // Convert hex color to RGB
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));
        
        $bgColor = imagecolorallocate($image, $r, $g, $b);
        imagefill($image, 0, 0, $bgColor);
        
        // Add white text
        $textColor = imagecolorallocate($image, 255, 255, 255);
        $fontSize = 5;
        $text = Str::limit($name, 25);
        $textX = ($width - strlen($text) * imagefontwidth($fontSize)) / 2;
        $textY = ($height - imagefontheight($fontSize)) / 2;
        imagestring($image, $fontSize, $textX, $textY, $text, $textColor);
        
        // Save to storage
        $filename = 'products/' . Str::slug($name) . '_' . time() . '.jpg';
        $path = storage_path('app/public/' . $filename);
        
        imagejpeg($image, $path, 85);
        imagedestroy($image);
        
        return $filename;
    }
}
