<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    const TTL_SETTINGS    = 3600;   // 1 hour
    const TTL_CATEGORIES  = 1800;   // 30 min
    const TTL_FEATURED    = 900;    // 15 min
    const TTL_BLOG        = 600;    // 10 min
    const TTL_STATIC      = 86400;  // 24 hours

    public static function rememberSettings(callable $callback): mixed
    {
        return Cache::remember('site_settings', self::TTL_SETTINGS, $callback);
    }

    public static function rememberCategories(callable $callback): mixed
    {
        return Cache::remember('nav_categories', self::TTL_CATEGORIES, $callback);
    }

    public static function rememberFeaturedProducts(callable $callback): mixed
    {
        return Cache::remember('featured_products', self::TTL_FEATURED, $callback);
    }

    public static function rememberFeaturedPosts(callable $callback): mixed
    {
        return Cache::remember('featured_posts', self::TTL_BLOG, $callback);
    }

    public static function clearContentCaches(): void
    {
        Cache::forget('nav_categories');
        Cache::forget('featured_products');
        Cache::forget('featured_posts');
        Cache::forget('sitemap_xml');
    }

    public static function clearAll(): void
    {
        Cache::flush();
    }
}
