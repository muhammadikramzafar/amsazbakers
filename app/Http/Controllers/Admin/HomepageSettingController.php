<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use App\Models\HeroSlide;
use App\Models\PromoBanner;
use App\Models\AboutSection;
use App\Models\WhyChooseFeature;
use App\Models\SignatureDish;
use App\Models\Testimonial;
use App\Models\InstagramPost;
use App\Models\CtaSection;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class HomepageSettingController extends Controller
{
    public function index()
    {
        $settings = HomepageSetting::get();
        $counts   = [
            'hero'       => HeroSlide::count(),
            'promos'     => PromoBanner::count(),
            'about'      => AboutSection::exists(),
            'why_choose' => WhyChooseFeature::count(),
            'signature'  => SignatureDish::count(),
            'testimonials'=> Testimonial::count(),
            'instagram'  => InstagramPost::count(),
            'cta'        => CtaSection::count(),
        ];
        return view('admin.homepage.index', compact('settings', 'counts'));
    }

    public function settings()
    {
        $settings = HomepageSetting::get();
        return view('admin.homepage.settings', compact('settings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $settings = HomepageSetting::get();

        $data = $request->validate([
            'hero_active'             => 'nullable|boolean',
            'categories_active'       => 'nullable|boolean',
            'bestsellers_active'      => 'nullable|boolean',
            'bestsellers_heading'     => 'required|string|max:255',
            'bestsellers_subheading'  => 'nullable|string|max:255',
            'bestsellers_count'       => 'required|integer|min:1|max:12',
            'about_active'            => 'nullable|boolean',
            'promos_active'           => 'nullable|boolean',
            'featured_bakery_active'  => 'nullable|boolean',
            'featured_bakery_heading' => 'required|string|max:255',
            'featured_bakery_subheading' => 'nullable|string|max:255',
            'featured_bakery_category'   => 'required|string|max:100',
            'featured_bakery_count'      => 'required|integer|min:1|max:12',
            'featured_sweets_active'     => 'nullable|boolean',
            'featured_sweets_heading'    => 'required|string|max:255',
            'featured_sweets_subheading' => 'nullable|string|max:255',
            'featured_sweets_category'   => 'required|string|max:100',
            'featured_sweets_count'      => 'required|integer|min:1|max:12',
            'signature_active'        => 'nullable|boolean',
            'signature_heading'       => 'required|string|max:255',
            'signature_subheading'    => 'nullable|string|max:255',
            'fresh_active'            => 'nullable|boolean',
            'fresh_heading'           => 'required|string|max:255',
            'fresh_subheading'        => 'nullable|string|max:255',
            'fresh_count'             => 'required|integer|min:1|max:12',
            'why_choose_active'       => 'nullable|boolean',
            'why_choose_heading'      => 'required|string|max:255',
            'why_choose_subheading'   => 'nullable|string|max:255',
            'cta_active'              => 'nullable|boolean',
            'testimonials_active'     => 'nullable|boolean',
            'testimonials_heading'    => 'required|string|max:255',
            'instagram_active'        => 'nullable|boolean',
            'instagram_heading'       => 'required|string|max:255',
            'instagram_handle'        => 'nullable|string|max:100',
            'seo_title'               => 'nullable|string|max:255',
            'seo_description'         => 'nullable|string|max:500',
            'seo_keywords'            => 'nullable|string|max:500',
            'og_title'                => 'nullable|string|max:255',
            'og_description'          => 'nullable|string|max:500',
            'og_image'                => 'nullable|string|max:500',
        ]);

        // Convert checkboxes (unchecked sends nothing)
        foreach (['hero_active','categories_active','bestsellers_active','about_active','promos_active',
                  'featured_bakery_active','featured_sweets_active','signature_active','fresh_active',
                  'why_choose_active','cta_active','testimonials_active','instagram_active'] as $toggle) {
            $data[$toggle] = $request->boolean($toggle);
        }

        $settings->update($data);
        return back()->with('success', 'Homepage settings saved.');
    }
}
