<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount(['products as active_products_count' => function ($q) {
            $q->where('is_active', true)->where('is_available', true);
        }])->where('is_active', true)->orderBy('sort_order')->get();

        $query = Product::with('category')
            ->where('is_active', true)
            ->where('is_available', true);

        $this->applyFilters($query, $request);

        $products = $query->paginate(12);

        return view('frontend.products.listing', compact('products', 'categories'));
    }

    public function category(Request $request, Category $category)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $query = Product::with('category')
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->where('is_available', true);

        $this->applyFilters($query, $request);

        $products = $query->paginate(12);

        return view('frontend.products.listing', compact('products', 'categories', 'category'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where('is_available', true)
            ->take(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('categories')) {
            $query->whereHas('category', fn($q) => $q->whereIn('slug', $request->categories));
        }
        match ($request->sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'newest'     => $query->latest(),
            default      => $query->orderBy('sort_order'),
        };
    }
}
