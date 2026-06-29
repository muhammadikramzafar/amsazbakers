<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ReservationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\HomepageSettingController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\PromoBannerController;
use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\WhyChooseFeatureController;
use App\Http\Controllers\Admin\SignatureDishController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\InstagramPostController;
use App\Http\Controllers\Admin\CtaSectionController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\MenuController as FrontendMenuController;
use App\Http\Controllers\Frontend\RecipeController as FrontendRecipeController;
use App\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use App\Http\Controllers\Frontend\GalleryController as FrontendGalleryController;
use App\Http\Controllers\Frontend\CareerController as FrontendCareerController;
use App\Http\Controllers\Frontend\NewsletterController as FrontendNewsletterController;
use App\Http\Controllers\Admin\MenuCategoryController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\RecipeCategoryController;
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogTagController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\AwardController;
use App\Http\Controllers\Admin\JobListingController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\NewsletterAdminController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// Sitemap & robots (no middleware, publicly cached)
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt',  [SitemapController::class, 'robots'])->name('robots');

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::group([], function () {

    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Static pages
    Route::get('/about',  fn () => view('frontend.pages.about'))->name('pages.about');
    Route::get('/bakery', fn () => view('frontend.pages.bakery'))->name('pages.bakery');
    Route::get('/sweets', fn () => view('frontend.pages.sweets'))->name('pages.sweets');

    // Products / Shop
    Route::get('/products',                  [FrontendProductController::class, 'index'])->name('products.listing');
    Route::get('/products/{category:slug}',  [FrontendProductController::class, 'category'])->name('products.category');
    Route::get('/product/{product:slug}',    [FrontendProductController::class, 'show'])->name('products.show');
    Route::get('/search',                    [FrontendProductController::class, 'search'])->name('products.search');

    // Menu
    Route::get('/menu',                      [FrontendMenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/{menuItem:slug}',      [FrontendMenuController::class, 'show'])->name('menu.show');

    // Recipes
    Route::get('/recipes',                           [FrontendRecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/category/{slug}',           [FrontendRecipeController::class, 'category'])->name('recipes.category');
    Route::get('/recipes/{recipe:slug}',             [FrontendRecipeController::class, 'show'])->name('recipes.show');

    // Gallery
    Route::get('/gallery',              [FrontendGalleryController::class, 'index'])->name('gallery.index');
    Route::get('/gallery/{galleryAlbum:slug}', [FrontendGalleryController::class, 'show'])->name('gallery.show');
    Route::get('/testimonials',         [FrontendGalleryController::class, 'testimonials'])->name('testimonials.index');
    Route::get('/awards',               [FrontendGalleryController::class, 'awards'])->name('awards.index');

    // Blog
    Route::get('/blog',                        [FrontendBlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/category/{blogCategory:slug}', [FrontendBlogController::class, 'category'])->name('blog.category');
    Route::get('/blog/tag/{blogTag:slug}',     [FrontendBlogController::class, 'tag'])->name('blog.tag');
    Route::get('/blog/{blogPost:slug}',        [FrontendBlogController::class, 'show'])->name('blog.show');

    // Careers
    Route::get('/careers',                    [FrontendCareerController::class, 'index'])->name('careers.index');
    Route::get('/careers/{jobListing:slug}',  [FrontendCareerController::class, 'show'])->name('careers.show');
    Route::post('/careers/{jobListing:slug}/apply', [FrontendCareerController::class, 'apply'])
        ->middleware('throttle:apply')
        ->name('careers.apply');

    // Newsletter
    Route::post('/newsletter/subscribe', [FrontendNewsletterController::class, 'subscribe'])
        ->middleware('throttle:newsletter')
        ->name('newsletter.subscribe');

    // CMS dynamic pages (must come after named static routes to avoid catching them)
    Route::get('/page/{slug}', [FrontendPageController::class, 'show'])->name('pages.show');

    // Contact
    Route::get('/contact',  [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])
        ->middleware('throttle:contact')
        ->name('contact.store');

    // Reservation
    Route::get('/reservation',  [ReservationController::class, 'index'])->name('reservation');
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

    // Checkout
    Route::get('/checkout', fn() => view('frontend.checkout.index'))->name('checkout');

});

/*
|--------------------------------------------------------------------------
| Admin Routes  (auth + email-verified + admin role required)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'admin'])
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Content management
        Route::resource('categories', CategoryController::class);
        Route::resource('products',   ProductController::class);

        // Reservations (read + delete only)
        Route::resource('reservations', AdminReservationController::class)
            ->only(['index', 'show', 'destroy']);

        // Contact messages
        Route::get   ('contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
        Route::delete('contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
        Route::get   ('contacts',           [AdminContactController::class, 'index'])->name('contacts.index');

        // User management (Super Admin only)
        Route::middleware('role:super-admin')->group(function () {
            Route::resource('users', UserController::class)->except(['show']);
        });

        // CMS Pages
        Route::resource('pages', AdminPageController::class)->except(['show']);

        // Media Library
        Route::get   ('media',          [MediaController::class, 'index'])->name('media.index');
        Route::post  ('media',          [MediaController::class, 'store'])->name('media.store');
        Route::delete('media/{media}',  [MediaController::class, 'destroy'])->name('media.destroy');

        // Site Settings (single-record — no resource)
        Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');

        // ── Menu Management ───────────────────────────────────────────────
        Route::prefix('menu')->name('menu.')->group(function () {
            Route::resource('categories', MenuCategoryController::class)
                ->parameters(['categories' => 'menuCategory']);
            Route::resource('items', MenuItemController::class)
                ->parameters(['items' => 'menuItem']);
        });

        // ── Recipe Management ──────────────────────────────────────────────
        Route::resource('recipe-categories', RecipeCategoryController::class)
            ->parameters(['recipe-categories' => 'recipeCategory']);
        Route::resource('recipes', RecipeController::class);

        // ── Homepage Management ────────────────────────────────────────────
        Route::prefix('homepage')->name('homepage.')->group(function () {
            Route::get ('/',        [HomepageSettingController::class, 'index'])->name('index');
            Route::get ('/settings',[HomepageSettingController::class, 'settings'])->name('settings');
            Route::put ('/settings',[HomepageSettingController::class, 'updateSettings'])->name('settings.update');

            // Hero Slides
            Route::get   ('hero-slides',           [HeroSlideController::class, 'index'])->name('hero-slides.index');
            Route::get   ('hero-slides/create',    [HeroSlideController::class, 'create'])->name('hero-slides.create');
            Route::post  ('hero-slides',           [HeroSlideController::class, 'store'])->name('hero-slides.store');
            Route::get   ('hero-slides/{heroSlide}/edit', [HeroSlideController::class, 'edit'])->name('hero-slides.edit');
            Route::put   ('hero-slides/{heroSlide}',      [HeroSlideController::class, 'update'])->name('hero-slides.update');
            Route::delete('hero-slides/{heroSlide}',      [HeroSlideController::class, 'destroy'])->name('hero-slides.destroy');

            // Promo Banners
            Route::get   ('promo-banners',              [PromoBannerController::class, 'index'])->name('promo-banners.index');
            Route::get   ('promo-banners/create',       [PromoBannerController::class, 'create'])->name('promo-banners.create');
            Route::post  ('promo-banners',              [PromoBannerController::class, 'store'])->name('promo-banners.store');
            Route::get   ('promo-banners/{promoBanner}/edit', [PromoBannerController::class, 'edit'])->name('promo-banners.edit');
            Route::put   ('promo-banners/{promoBanner}',      [PromoBannerController::class, 'update'])->name('promo-banners.update');
            Route::delete('promo-banners/{promoBanner}',      [PromoBannerController::class, 'destroy'])->name('promo-banners.destroy');

            // About Section (single record)
            Route::get('about',    [AboutSectionController::class, 'edit'])->name('about.edit');
            Route::put('about',    [AboutSectionController::class, 'update'])->name('about.update');

            // Why Choose Features
            Route::get   ('why-choose',               [WhyChooseFeatureController::class, 'index'])->name('why-choose.index');
            Route::get   ('why-choose/create',        [WhyChooseFeatureController::class, 'create'])->name('why-choose.create');
            Route::post  ('why-choose',               [WhyChooseFeatureController::class, 'store'])->name('why-choose.store');
            Route::get   ('why-choose/{whyChooseFeature}/edit', [WhyChooseFeatureController::class, 'edit'])->name('why-choose.edit');
            Route::put   ('why-choose/{whyChooseFeature}',      [WhyChooseFeatureController::class, 'update'])->name('why-choose.update');
            Route::delete('why-choose/{whyChooseFeature}',      [WhyChooseFeatureController::class, 'destroy'])->name('why-choose.destroy');

            // Signature Dishes
            Route::get   ('signature-dishes',              [SignatureDishController::class, 'index'])->name('signature-dishes.index');
            Route::get   ('signature-dishes/create',       [SignatureDishController::class, 'create'])->name('signature-dishes.create');
            Route::post  ('signature-dishes',              [SignatureDishController::class, 'store'])->name('signature-dishes.store');
            Route::get   ('signature-dishes/{signatureDish}/edit', [SignatureDishController::class, 'edit'])->name('signature-dishes.edit');
            Route::put   ('signature-dishes/{signatureDish}',      [SignatureDishController::class, 'update'])->name('signature-dishes.update');
            Route::delete('signature-dishes/{signatureDish}',      [SignatureDishController::class, 'destroy'])->name('signature-dishes.destroy');

            // Testimonials
            Route::get   ('testimonials',              [TestimonialController::class, 'index'])->name('testimonials.index');
            Route::get   ('testimonials/create',       [TestimonialController::class, 'create'])->name('testimonials.create');
            Route::post  ('testimonials',              [TestimonialController::class, 'store'])->name('testimonials.store');
            Route::get   ('testimonials/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit');
            Route::put   ('testimonials/{testimonial}',      [TestimonialController::class, 'update'])->name('testimonials.update');
            Route::delete('testimonials/{testimonial}',      [TestimonialController::class, 'destroy'])->name('testimonials.destroy');

            // Instagram Posts
            Route::get   ('instagram',                  [InstagramPostController::class, 'index'])->name('instagram.index');
            Route::get   ('instagram/create',           [InstagramPostController::class, 'create'])->name('instagram.create');
            Route::post  ('instagram',                  [InstagramPostController::class, 'store'])->name('instagram.store');
            Route::get   ('instagram/{instagramPost}/edit', [InstagramPostController::class, 'edit'])->name('instagram.edit');
            Route::put   ('instagram/{instagramPost}',      [InstagramPostController::class, 'update'])->name('instagram.update');
            Route::delete('instagram/{instagramPost}',      [InstagramPostController::class, 'destroy'])->name('instagram.destroy');

            // CTA Sections
            Route::get   ('cta',                [CtaSectionController::class, 'index'])->name('cta.index');
            Route::get   ('cta/create',         [CtaSectionController::class, 'create'])->name('cta.create');
            Route::post  ('cta',                [CtaSectionController::class, 'store'])->name('cta.store');
            Route::get   ('cta/{ctaSection}/edit', [CtaSectionController::class, 'edit'])->name('cta.edit');
            Route::put   ('cta/{ctaSection}',      [CtaSectionController::class, 'update'])->name('cta.update');
            Route::delete('cta/{ctaSection}',      [CtaSectionController::class, 'destroy'])->name('cta.destroy');
        });

        // ── Blog Management ────────────────────────────────────────────────
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::resource('categories', BlogCategoryController::class)->parameters(['categories' => 'blogCategory']);
            Route::resource('tags', BlogTagController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::resource('posts', BlogPostController::class)->parameters(['posts' => 'blogPost']);
        });

        // ── Gallery Management ─────────────────────────────────────────────
        Route::prefix('gallery')->name('gallery.')->group(function () {
            Route::resource('albums', GalleryAlbumController::class)->parameters(['albums' => 'galleryAlbum']);
            Route::resource('albums.items', GalleryItemController::class)
                ->parameters(['albums' => 'galleryAlbum', 'items' => 'galleryItem'])
                ->shallow();
        });

        // ── Awards ────────────────────────────────────────────────────────
        Route::resource('awards', AwardController::class);

        // ── Careers ───────────────────────────────────────────────────────
        Route::prefix('careers')->name('careers.')->group(function () {
            Route::resource('listings', JobListingController::class)->parameters(['listings' => 'jobListing']);
            Route::resource('applications', JobApplicationController::class)
                ->parameters(['applications' => 'jobApplication'])
                ->only(['index', 'show', 'update', 'destroy']);
        });

        // ── Newsletter ────────────────────────────────────────────────────
        Route::prefix('newsletter')->name('newsletter.')->group(function () {
            Route::get('/',       [NewsletterAdminController::class, 'index'])->name('index');
            Route::delete('{newsletterSubscriber}', [NewsletterAdminController::class, 'destroy'])->name('destroy');
            Route::get('export',  [NewsletterAdminController::class, 'export'])->name('export');
        });

    });

/*
|--------------------------------------------------------------------------
| Breeze Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get   ('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch ('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
