<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = \App\Models\Product::with('category')
            ->where('is_featured', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $categories = \App\Models\Category::where('is_active', true)
            ->withCount(['activeProducts'])
            ->orderBy('sort_order')
            ->get();

        $galleryImages = \App\Models\GalleryImage::where('is_active', true)
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        return view('frontend.home', compact('featuredProducts', 'categories', 'galleryImages'));
    }
}
