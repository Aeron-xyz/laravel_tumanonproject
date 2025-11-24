<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        $stats = [
            'collections' => $categories->count(),
            'works' => Product::count(),
            'richest' => optional($categories->sortByDesc('products_count')->first())->name ?? 'N/A',
        ];

        return view('categories.index', compact('categories', 'stats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('createCategory', [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'color' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Collection created.');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validateWithBag('updateCategory', [
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id)],
            'color' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Collection updated.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Collection deleted.');
    }
}


