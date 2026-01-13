<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TrashController extends Controller
{
    public function index(): View
    {
        $products = Product::onlyTrashed()->with('category')->latest('deleted_at')->get();
        $categories = Category::onlyTrashed()->withCount('products')->latest('deleted_at')->get();

        return view('trash.index', compact('products', 'categories'));
    }

    public function restoreProduct(int $id): RedirectResponse
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('trash.index')->with('success', 'Crochet work restored successfully.');
    }

    public function forceDeleteProduct(int $id): RedirectResponse
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        
        // Delete photo if exists
        if ($product->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->photo)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->photo);
        }
        
        $product->forceDelete();

        return redirect()->route('trash.index')->with('success', 'Crochet work permanently deleted.');
    }

    public function restoreCategory(int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('trash.index')->with('success', 'Collection restored successfully.');
    }

    public function forceDeleteCategory(int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('trash.index')->with('success', 'Collection permanently deleted.');
    }
}
