<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\HomepageSetting;
use App\Models\HeroSlide;
use App\Models\PromoBanner;
use App\Models\AboutSection;
use App\Models\WhyChooseFeature;
use App\Models\SignatureDish;
use App\Models\Testimonial;
use App\Models\InstagramPost;
use App\Models\CtaSection;

class HomeController extends Controller
{
    public function index()
    {
        $hp = HomepageSetting::get();

        // Hero slides
        $heroSlides = $hp->hero_active
            ? HeroSlide::active()->get()
            : collect();

        // Bestsellers (featured products)
        $featuredProducts = $hp->bestsellers_active
            ? Product::with('category')
                ->where('is_featured', true)->where('is_active', true)->where('is_available', true)
                ->orderBy('sort_order')->take($hp->bestsellers_count)->get()
            : collect();

        // About section
        $about = $hp->about_active ? AboutSection::get() : null;

        // Promo banners
        $promoBanners = $hp->promos_active
            ? PromoBanner::active()->get()
            : collect();

        // Featured bakery products
        $featuredBakery = $hp->featured_bakery_active
            ? Product::with('category')
                ->whereHas('category', fn($q) => $q->where('slug', $hp->featured_bakery_category))
                ->where('is_active', true)->where('is_available', true)
                ->orderBy('sort_order')->take($hp->featured_bakery_count)->get()
            : collect();

        // Featured sweets
        $featuredSweets = $hp->featured_sweets_active
            ? Product::with('category')
                ->whereHas('category', fn($q) => $q->where('slug', $hp->featured_sweets_category))
                ->where('is_active', true)->where('is_available', true)
                ->orderBy('sort_order')->take($hp->featured_sweets_count)->get()
            : collect();

        // Signature dishes
        $signatureDishes = $hp->signature_active
            ? SignatureDish::active()->get()
            : collect();

        // Fresh from the oven
        $freshProducts = $hp->fresh_active
            ? Product::with('category')
                ->where('is_active', true)->where('is_available', true)
                ->latest()->take($hp->fresh_count)->get()
            : collect();

        // Why choose us
        $whyChooseFeatures = $hp->why_choose_active
            ? WhyChooseFeature::active()->get()
            : collect();

        // CTA sections
        $ctaSections = $hp->cta_active
            ? CtaSection::active()->get()
            : collect();

        // Testimonials
        $testimonials = $hp->testimonials_active
            ? Testimonial::active()->get()
            : collect();

        // Instagram posts
        $instagramPosts = $hp->instagram_active
            ? InstagramPost::active()->take(9)->get()
            : collect();

        return view('frontend.home.index', compact(
            'hp',
            'heroSlides',
            'featuredProducts',
            'about',
            'promoBanners',
            'featuredBakery',
            'featuredSweets',
            'signatureDishes',
            'freshProducts',
            'whyChooseFeatures',
            'ctaSections',
            'testimonials',
            'instagramPosts'
        ));
    }
}
