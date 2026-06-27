<?php

namespace App\Providers;

use App\Services\ImageService;
use App\Services\SitemapService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ImageService::class);
        $this->app->singleton(SitemapService::class);
    }

    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        Gate::policy(\App\Models\BlogPost::class, \App\Policies\BlogPostPolicy::class);

        $observer = \App\Observers\ContentObserver::class;
        \App\Models\BlogPost::observe($observer);
        \App\Models\Product::observe($observer);
        \App\Models\MenuItem::observe($observer);

        Paginator::defaultView('vendor.pagination.custom');
        Paginator::defaultSimpleView('vendor.pagination.custom');

        $this->configureRateLimiters();
        $this->shareViewData();
    }

    private function configureRateLimiters(): void
    {
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perHour(5)->by($request->ip());
        });

        RateLimiter::for('newsletter', function (Request $request) {
            return Limit::perHour(3)->by($request->ip());
        });

        RateLimiter::for('apply', function (Request $request) {
            return Limit::perDay(10)->by($request->ip());
        });
    }

    private function shareViewData(): void
    {
        View::composer('*', function ($view) {
            static $settings;

            $settings ??= Cache::remember('site_settings', 3600, function () {
                try {
                    return \App\Models\SiteSetting::first()
                        ?? new \App\Models\SiteSetting(['website_name' => config('app.name')]);
                } catch (\Throwable) {
                    return new \App\Models\SiteSetting(['website_name' => config('app.name')]);
                }
            });

            $view->with('siteSettings', $settings);
        });
    }
}
