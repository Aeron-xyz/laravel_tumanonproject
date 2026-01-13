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
        // Get or create a category
        $category = Category::first();
        if (!$category) {
            $category = Category::create([
                'name' => 'Blankets',
                'color' => '#c084fc',
                'description' => 'Cozy crochet blankets',
            ]);
        }

        // Sample crochet works data
        $crochetWorks = [
            [
                'name' => 'Starlight Shell Blanket',
                'price' => 950.00,
                'stock' => 23,
                'material' => 'Acrylic yarn',
                'description' => 'A beautiful shell stitch blanket in soft pastel colors. Perfect for cozy evenings.',
                'category_id' => $category->id,
                'image_color' => 'c084fc', // Purple
            ],
            [
                'name' => 'Vibrant Granny Square',
                'price' => 1200.00,
                'stock' => 10,
                'material' => 'Cotton yarn',
                'description' => 'Vibrant granny square blanket with rainbow colors. Handmade with love.',
                'category_id' => $category->id,
                'image_color' => 'f472b6', // Pink
            ],
            [
                'name' => 'Elegant Cable Throw',
                'price' => 800.00,
                'stock' => 12,
                'material' => 'Wool yarn',
                'description' => 'Elegant cable stitch throw blanket. Warm and luxurious.',
                'category_id' => $category->id,
                'image_color' => '38bdf8', // Blue
            ],
            [
                'name' => 'Decorative Mandala Pillow',
                'price' => 650.00,
                'stock' => 18,
                'material' => 'Cotton acrylic mix',
                'description' => 'Decorative mandala pillow cover with floral patterns. Adds charm to any room.',
                'category_id' => $category->id,
                'image_color' => 'f97316', // Orange
            ],
            [
                'name' => 'Soft Ripple Baby Blanket',
                'price' => 750.00,
                'stock' => 15,
                'material' => 'Organic cotton',
                'description' => 'Soft ripple stitch baby blanket. Gentle on sensitive skin.',
                'category_id' => $category->id,
                'image_color' => 'ec4899', // Rose
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
