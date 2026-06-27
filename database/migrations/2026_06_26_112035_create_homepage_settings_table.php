<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();
            // Section toggles
            $table->boolean('hero_active')->default(true);
            $table->boolean('categories_active')->default(true);
            $table->boolean('bestsellers_active')->default(true);
            $table->string('bestsellers_heading')->default('Bestsellers');
            $table->string('bestsellers_subheading')->nullable();
            $table->unsignedTinyInteger('bestsellers_count')->default(4);
            $table->boolean('about_active')->default(true);
            $table->boolean('promos_active')->default(true);
            $table->boolean('featured_bakery_active')->default(true);
            $table->string('featured_bakery_heading')->default('From Our Bakery');
            $table->string('featured_bakery_subheading')->nullable();
            $table->string('featured_bakery_category')->default('bakery');
            $table->unsignedTinyInteger('featured_bakery_count')->default(4);
            $table->boolean('featured_sweets_active')->default(true);
            $table->string('featured_sweets_heading')->default('Our Sweets');
            $table->string('featured_sweets_subheading')->nullable();
            $table->string('featured_sweets_category')->default('sweets');
            $table->unsignedTinyInteger('featured_sweets_count')->default(4);
            $table->boolean('signature_active')->default(true);
            $table->string('signature_heading')->default('Signature Dishes');
            $table->string('signature_subheading')->nullable();
            $table->boolean('fresh_active')->default(true);
            $table->string('fresh_heading')->default('Fresh From The Oven');
            $table->string('fresh_subheading')->default("Today's special spotlights");
            $table->unsignedTinyInteger('fresh_count')->default(3);
            $table->boolean('why_choose_active')->default(true);
            $table->string('why_choose_heading')->default('Why Choose Us');
            $table->string('why_choose_subheading')->nullable();
            $table->boolean('cta_active')->default(true);
            $table->boolean('testimonials_active')->default(true);
            $table->string('testimonials_heading')->default('A Slice of Happiness');
            $table->boolean('instagram_active')->default(true);
            $table->string('instagram_heading')->default('Follow Our Journey');
            $table->string('instagram_handle')->nullable();
            // SEO
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_settings');
    }
};
