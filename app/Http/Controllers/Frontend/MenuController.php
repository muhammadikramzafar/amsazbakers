<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = \App\Models\Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $query = \App\Models\Product::with('category')
            ->where('is_active', true);

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        $products = $query->orderBy('sort_order')->paginate(12);

        return view('frontend.menu', compact('categories', 'products'));
    }
}
