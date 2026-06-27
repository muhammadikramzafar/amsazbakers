<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomepageSetting;
use App\Models\HeroSlide;
use App\Models\AboutSection;
use App\Models\WhyChooseFeature;
use App\Models\Testimonial;

class HomepageSeeder extends Seeder
{
    public function run(): void
    {
        // Homepage settings (single record)
        HomepageSetting::updateOrCreate(['id' => 1], [
            'hero_active'              => true,
            'categories_active'        => true,
            'bestsellers_active'       => true,
            'bestsellers_heading'      => 'Bestsellers',
            'bestsellers_subheading'   => 'Our most loved creations',
            'bestsellers_count'        => 4,
            'about_active'             => true,
            'promos_active'            => true,
            'featured_bakery_active'   => true,
            'featured_bakery_heading'  => 'From Our Bakery',
            'featured_bakery_subheading'=> 'Handcrafted with the finest ingredients',
            'featured_bakery_category' => 'bakery',
            'featured_bakery_count'    => 4,
            'featured_sweets_active'   => true,
            'featured_sweets_heading'  => 'Our Sweets',
            'featured_sweets_subheading'=> 'Traditional recipes, modern presentation',
            'featured_sweets_category' => 'sweets',
            'featured_sweets_count'    => 4,
            'signature_active'         => false,
            'signature_heading'        => 'Signature Dishes',
            'fresh_active'             => true,
            'fresh_heading'            => 'Fresh From The Oven',
            'fresh_subheading'         => "Today's special spotlights",
            'fresh_count'              => 3,
            'why_choose_active'        => true,
            'why_choose_heading'       => 'Why Choose Us',
            'why_choose_subheading'    => 'The Azmeer difference — quality you can taste',
            'cta_active'               => true,
            'testimonials_active'      => true,
            'testimonials_heading'     => 'A Slice of Happiness',
            'instagram_active'         => false,
            'instagram_heading'        => 'Follow Our Journey',
            'instagram_handle'         => '@azmeerbakery',
            'seo_title'                => 'Azmeer Bakery — Crafted with Love, Delivered Fresh',
            'seo_description'          => 'Discover handcrafted bakery delights, fresh-baked breads, traditional sweets and custom cakes from Azmeer Bakery in Lahore, Pakistan.',
            'seo_keywords'             => 'bakery Lahore, fresh bread, cakes, sweets, Pakistan bakery, custom cake, Azmeer',
        ]);

        // Hero slides
        if (HeroSlide::count() === 0) {
            HeroSlide::create([
                'title'      => 'Crafted with Love, Delivered Fresh',
                'subtitle'   => 'Bringing the authentic taste of tradition fused with modern craftsmanship to your celebrations.',
                'btn1_text'  => 'Shop Now',
                'btn1_url'   => '/products',
                'btn2_text'  => 'View Menu',
                'btn2_url'   => '/products',
                'is_active'  => true,
                'sort_order' => 1,
            ]);
        }

        // About section
        AboutSection::updateOrCreate(['id' => 1], [
            'heading'      => 'Our Story',
            'subheading'   => 'Baking happiness since 1998',
            'description'  => '<p>Azmeer Bakery was born from a simple belief: that every bite should tell a story of love, tradition, and craftsmanship. Founded in Lahore, we blend the finest ingredients with time-honored recipes to create bakery experiences that are truly unforgettable.</p><p>From humble beginnings to becoming one of Lahore\'s most trusted bakeries, our commitment to quality has never wavered. Every product that leaves our kitchen is made fresh, with care, and with the warmth of a family tradition.</p>',
            'btn_text'     => 'Read Our Full Story',
            'btn_url'      => '/page/our-story',
            'stat1_number' => '25+',
            'stat1_label'  => 'Years of Excellence',
            'stat2_number' => '200+',
            'stat2_label'  => 'Menu Items',
            'stat3_number' => '50K+',
            'stat3_label'  => 'Happy Customers',
        ]);

        // Why Choose features
        if (WhyChooseFeature::count() === 0) {
            $features = [
                ['icon_name' => 'quality',  'title' => 'Premium Ingredients',    'description' => 'We source only the finest ingredients — real butter, farm-fresh eggs, and imported chocolates.'],
                ['icon_name' => 'fresh',    'title' => 'Baked Fresh Daily',      'description' => 'Every item is baked fresh every morning. No preservatives, no shortcuts.'],
                ['icon_name' => 'hygiene',  'title' => 'Hygiene Standards',      'description' => 'Our kitchen meets the highest food safety standards, certified and regularly audited.'],
                ['icon_name' => 'custom',   'title' => 'Custom Orders',          'description' => 'Celebrate any occasion with a custom-designed cake or platter made just for you.'],
                ['icon_name' => 'clock',    'title' => 'Same Day Delivery',      'description' => 'Order before 3 PM and receive your fresh bakery items the same day.'],
                ['icon_name' => 'heart',    'title' => 'Made with Love',         'description' => 'More than a business — we treat every order as if it\'s for our own family.'],
            ];
            foreach ($features as $i => $f) {
                WhyChooseFeature::create($f + ['is_active' => true, 'sort_order' => $i + 1]);
            }
        }

        // Sample testimonials
        if (Testimonial::count() === 0) {
            $testimonials = [
                ['customer_name' => 'Sarah Mansoor', 'customer_role' => 'Regular Customer, Lahore',    'quote' => 'The Gulab Jamun Cheesecake was the star of our dinner party. Absolutely sublime and unique!',                          'rating' => 5],
                ['customer_name' => 'Ahmed Raza',    'customer_role' => 'Wedding Client',              'quote' => 'Every cake is a masterpiece. Ordered for my wedding anniversary and everyone was blown away!',                         'rating' => 5],
                ['customer_name' => 'Nadia Khan',    'customer_role' => 'Corporate Client, Islamabad', 'quote' => 'Fast delivery and gorgeous packaging. The Pistachio Rose Pastry is my weekly indulgence!',                           'rating' => 5],
            ];
            foreach ($testimonials as $i => $t) {
                Testimonial::create($t + ['is_active' => true, 'sort_order' => $i + 1]);
            }
        }
    }
}
