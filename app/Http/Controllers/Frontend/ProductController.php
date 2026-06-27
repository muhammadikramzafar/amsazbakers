<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $topCategories = $this->getTopCategories();

        $query = Product::with(['category', 'subcategory'])
            ->where('is_active', true)
            ->where('is_available', true);

        $this->applyFilters($query, $request);

        $products = $query->paginate(12);

        return view('frontend.products.listing', compact('products', 'topCategories'));
    }

    public function category(Request $request, Category $category)
    {
        $topCategories = $this->getTopCategories();

        $query = Product::with(['category', 'subcategory'])
            ->where('is_active', true)
            ->where('is_available', true);

        if ($category->is_subcategory) {
            $query->where('subcategory_id', $category->id);
        } else {
            $query->where(function ($q) use ($category) {
                $q->where('category_id', $category->id)
                  ->orWhereHas('subcategory', fn($sq) => $sq->where('parent_id', $category->id));
            });
        }

        $this->applyFilters($query, $request);

        $products = $query->paginate(12);

        return view('frontend.products.listing', compact('products', 'topCategories', 'category'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);

        $product->load(['category', 'subcategory']);

        // Related products (same category)
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where('is_available', true)
            ->take(4)
            ->get();

        // Recipe — match by product name keywords, then category, then featured
        $recipe = null;
        $categorySlug = $product->category?->slug ?? '';
        $nameWords = collect(explode(' ', $product->name))
            ->filter(fn ($w) => strlen($w) > 3)
            ->take(2);

        if ($nameWords->isNotEmpty()) {
            $query = Recipe::published();
            foreach ($nameWords as $word) {
                $query->orWhere('title', 'like', "%{$word}%");
            }
            $recipe = $query->first();
        }

        if (!$recipe && $categorySlug) {
            $recipe = Recipe::published()
                ->whereHas('category', fn ($q) => $q->where('slug', 'like', "%{$categorySlug}%"))
                ->first();
        }

        if (!$recipe) {
            $recipe = Recipe::published()->where('is_featured', true)->inRandomOrder()->first();
        }

        return view('frontend.products.show', compact('product', 'relatedProducts', 'recipe'));
    }

    public function search(Request $request)
    {
        $q             = $request->input('q', '');
        $topCategories = $this->getTopCategories();
        $products      = collect();

        if (strlen(trim($q)) >= 2) {
            $query = Product::with(['category', 'subcategory'])
                ->where('is_active', true)
                ->where('is_available', true)
                ->where(function ($builder) use ($q) {
                    $builder->where('name', 'like', "%{$q}%")
                            ->orWhere('description', 'like', "%{$q}%")
                            ->orWhere('short_description', 'like', "%{$q}%")
                            ->orWhere('badge', 'like', "%{$q}%");
                })
                ->orderBy('sort_order');

            $products = $query->paginate(12);
        }

        return view('frontend.products.search', compact('products', 'topCategories', 'q'));
    }

    private function getTopCategories()
    {
        return Category::with(['children' => function ($q) {
            $q->active()->withCount(['products as active_products_count' => function ($pq) {
                $pq->where('is_active', true)->where('is_available', true);
            }])->orderBy('sort_order');
        }])
        ->whereNull('parent_id')
        ->active()
        ->withCount(['products as active_products_count' => function ($q) {
            $q->where('is_active', true)->where('is_available', true);
        }])
        ->orderBy('sort_order')
        ->get();
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
        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }
        if ($request->boolean('bestseller')) {
            $query->where('is_bestseller', true);
        }
        match ($request->sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'newest'     => $query->latest(),
            default      => $query->orderBy('sort_order'),
        };
    }
}
