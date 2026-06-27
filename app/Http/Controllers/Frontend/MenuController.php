<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = MenuCategory::active()
            ->withCount(['menuItems as active_items_count' => function ($q) {
                $q->where('is_active', true)->where('is_available', true);
            }])
            ->get();

        $query = MenuItem::with('category')
            ->where('is_active', true)
            ->where('is_available', true);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('short_description', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('label')) {
            match ($request->label) {
                'featured'         => $query->where('is_featured', true),
                'bestseller'       => $query->where('is_bestseller', true),
                'chef_recommended' => $query->where('is_chef_recommended', true),
                'seasonal'         => $query->where('is_seasonal', true),
                default            => null,
            };
        }

        match ($request->sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default      => $query->orderBy('sort_order'),
        };

        $items = $query->paginate(12)->withQueryString();

        $featuredItems = MenuItem::with('category')
            ->where('is_active', true)->where('is_available', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')->take(4)->get();

        $bestSellers = MenuItem::with('category')
            ->where('is_active', true)->where('is_available', true)
            ->where('is_bestseller', true)
            ->orderBy('sort_order')->take(4)->get();

        return view('frontend.menu.index', compact(
            'items', 'categories', 'featuredItems', 'bestSellers'
        ));
    }

    public function show(MenuItem $menuItem)
    {
        abort_if(!$menuItem->is_active, 404);

        $menuItem->load('category');

        $related = MenuItem::with('category')
            ->where('menu_category_id', $menuItem->menu_category_id)
            ->where('id', '!=', $menuItem->id)
            ->where('is_active', true)->where('is_available', true)
            ->take(4)->get();

        return view('frontend.menu.show', compact('menuItem', 'related'));
    }
}
