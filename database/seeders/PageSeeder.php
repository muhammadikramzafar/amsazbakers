<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title'             => 'About Us',
                'slug'              => 'about-us',
                'short_description' => 'Learn about the story, values, and people behind Azmeer Bakery.',
                'description'       => '<p>Azmeer Bakery was founded in 1995 with a simple mission: to bring freshly baked joy to every table. What started as a small neighborhood bakery in Lahore has grown into a beloved destination for families across Pakistan.</p><p>We believe in using the finest ingredients, time-honored recipes, and a whole lot of love in everything we bake.</p>',
                'seo_title'         => 'About Us — Azmeer Bakery',
                'meta_description'  => 'Learn about the story, values, and team behind Azmeer Bakery — serving Pakistan since 1995.',
                'status'            => 'published',
            ],
            [
                'title'             => 'Our Story',
                'slug'              => 'our-story',
                'short_description' => 'From a single oven to a full bakery — the journey of Azmeer Bakery.',
                'description'       => '<p>It all started with a family recipe and a single oven. Our founder, Azmeer Khan, began baking bread for his neighbors in Gulberg before sunrise every morning. Word spread quickly, and soon the small kitchen became a proper bakery.</p><p>Today, we operate with a team of passionate bakers who carry on that original spirit of quality and care.</p>',
                'seo_title'         => 'Our Story — Azmeer Bakery',
                'meta_description'  => 'Discover the humble origins and growth story of Azmeer Bakery — from a single oven to a beloved brand.',
                'status'            => 'published',
            ],
            [
                'title'             => 'Privacy Policy',
                'slug'              => 'privacy-policy',
                'short_description' => 'How we collect, use, and protect your personal information.',
                'description'       => '<h2>Information We Collect</h2><p>We collect information you provide when placing orders, making reservations, or contacting us through our website.</p><h2>How We Use Your Information</h2><p>Your information is used solely to fulfill your orders and improve our services. We do not sell or share your data with third parties.</p><h2>Contact</h2><p>For privacy-related questions, email us at info@azmeerbakery.pk.</p>',
                'seo_title'         => 'Privacy Policy — Azmeer Bakery',
                'meta_description'  => 'Read the Azmeer Bakery privacy policy to understand how we handle your personal information.',
                'status'            => 'published',
            ],
            [
                'title'             => 'Terms & Conditions',
                'slug'              => 'terms-conditions',
                'short_description' => 'Terms governing use of our website and services.',
                'description'       => '<h2>Use of Website</h2><p>By using this website, you agree to these terms. If you disagree, please do not use the site.</p><h2>Orders & Payments</h2><p>All orders are subject to availability. Prices are listed in Pakistani Rupees (PKR) and are inclusive of applicable taxes.</p><h2>Liability</h2><p>Azmeer Bakery is not liable for any indirect or consequential loss arising from use of this website.</p>',
                'seo_title'         => 'Terms & Conditions — Azmeer Bakery',
                'meta_description'  => 'Read the terms and conditions for using the Azmeer Bakery website and services.',
                'status'            => 'published',
            ],
            [
                'title'             => 'FAQ',
                'slug'              => 'faq',
                'short_description' => 'Answers to common questions about our products, orders, and services.',
                'description'       => '<h2>Do you offer custom cakes?</h2><p>Yes! We take custom cake orders with at least 48 hours notice. Contact us via WhatsApp or our contact form.</p><h2>What are your delivery areas?</h2><p>We currently deliver within Lahore city limits. Minimum order for delivery is Rs. 1,500.</p><h2>Can I visit the bakery?</h2><p>Absolutely — we welcome walk-in customers every day from 8 AM to 10 PM (closed Sundays).</p>',
                'seo_title'         => 'FAQ — Azmeer Bakery',
                'meta_description'  => 'Frequently asked questions about Azmeer Bakery products, delivery, and custom orders.',
                'status'            => 'published',
            ],
        ];

        foreach ($pages as $data) {
            Page::firstOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
