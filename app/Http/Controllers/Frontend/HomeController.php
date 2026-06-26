<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->where('is_featured', true)
            ->where('is_active', true)
            ->where('is_available', true)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        $freshProducts = Product::with('category')
            ->where('is_active', true)
            ->where('is_available', true)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.home.index', compact('featuredProducts', 'freshProducts'));
    }
}