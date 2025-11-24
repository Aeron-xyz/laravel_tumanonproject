<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::orderBy('name')->get();

        $stats = [
            'works' => $products->count(),
            'collections' => $categories->count(),
            'stockTotal' => Product::sum('stock'),
            'lowStock' => Product::where('stock', '<', 5)->count(),
        ];

        return view('dashboard', compact('products', 'categories', 'stats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('createProduct', [
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
            'material' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        Product::create($validated);

        return redirect()->route('dashboard')->with('success', 'Crochet work added successfully.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validateWithBag('updateProduct', [
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($product->id)],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
            'material' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $product->update($validated);

        return redirect()->route('dashboard')->with('success', 'Crochet work updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Crochet work removed.');
    }
}


