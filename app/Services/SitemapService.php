<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\GalleryAlbum;
use App\Models\JobListing;
use App\Models\MenuItem;
use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class SitemapService
{
    public function generate(): string
    {
        return Cache::remember('sitemap_xml', now()->addHour(), fn () => $this->build());
    }

    private function build(): string
    {
        $urls = $this->staticUrls();
        $urls = array_merge($urls, $this->blogUrls());
        $urls = array_merge($urls, $this->productUrls());
        $urls = array_merge($urls, $this->menuUrls());
        $urls = array_merge($urls, $this->galleryUrls());
        $urls = array_merge($urls, $this->careerUrls());
        $urls = array_merge($urls, $this->recipeUrls());

        return $this->renderXml($urls);
    }

    private function staticUrls(): array
    {
        $now = Carbon::now()->toAtomString();

        return [
            ['loc' => route('home'),              'priority' => '1.0', 'freq' => 'daily',   'mod' => $now],
            ['loc' => route('menu.index'),        'priority' => '0.9', 'freq' => 'weekly',  'mod' => $now],
            ['loc' => route('products.listing'),  'priority' => '0.9', 'freq' => 'weekly',  'mod' => $now],
            ['loc' => route('recipes.index'),     'priority' => '0.8', 'freq' => 'weekly',  'mod' => $now],
            ['loc' => route('blog.index'),        'priority' => '0.8', 'freq' => 'daily',   'mod' => $now],
            ['loc' => route('gallery.index'),     'priority' => '0.7', 'freq' => 'weekly',  'mod' => $now],
            ['loc' => route('careers.index'),     'priority' => '0.6', 'freq' => 'weekly',  'mod' => $now],
            ['loc' => route('contact'),           'priority' => '0.5', 'freq' => 'monthly', 'mod' => $now],
            ['loc' => route('testimonials.index'),'priority' => '0.5', 'freq' => 'weekly',  'mod' => $now],
            ['loc' => route('awards.index'),      'priority' => '0.4', 'freq' => 'monthly', 'mod' => $now],
        ];
    }

    private function blogUrls(): array
    {
        return BlogPost::published()
            ->select(['slug', 'updated_at'])
            ->orderByDesc('updated_at')
            ->get()
            ->map(fn ($p) => [
                'loc'      => route('blog.show', $p->slug),
                'priority' => '0.7',
                'freq'     => 'monthly',
                'mod'      => $p->updated_at->toAtomString(),
            ])->toArray();
    }

    private function productUrls(): array
    {
        return Product::where('is_active', true)
            ->select(['slug', 'updated_at'])
            ->get()
            ->map(fn ($p) => [
                'loc'      => route('products.show', $p->slug),
                'priority' => '0.6',
                'freq'     => 'monthly',
                'mod'      => $p->updated_at->toAtomString(),
            ])->toArray();
    }

    private function menuUrls(): array
    {
        return MenuItem::where('is_active', true)
            ->select(['slug', 'updated_at'])
            ->get()
            ->map(fn ($m) => [
                'loc'      => route('menu.show', $m->slug),
                'priority' => '0.6',
                'freq'     => 'monthly',
                'mod'      => $m->updated_at->toAtomString(),
            ])->toArray();
    }

    private function galleryUrls(): array
    {
        return GalleryAlbum::where('is_active', true)
            ->select(['slug', 'updated_at'])
            ->get()
            ->map(fn ($a) => [
                'loc'      => route('gallery.show', $a->slug),
                'priority' => '0.5',
                'freq'     => 'monthly',
                'mod'      => $a->updated_at->toAtomString(),
            ])->toArray();
    }

    private function careerUrls(): array
    {
        return JobListing::where('is_active', true)
            ->select(['slug', 'updated_at'])
            ->get()
            ->map(fn ($j) => [
                'loc'      => route('careers.show', $j->slug),
                'priority' => '0.5',
                'freq'     => 'weekly',
                'mod'      => $j->updated_at->toAtomString(),
            ])->toArray();
    }

    private function recipeUrls(): array
    {
        try {
            return Recipe::where('is_published', true)
                ->select(['slug', 'updated_at'])
                ->get()
                ->map(fn ($r) => [
                    'loc'      => route('recipes.show', $r->slug),
                    'priority' => '0.6',
                    'freq'     => 'monthly',
                    'mod'      => $r->updated_at->toAtomString(),
                ])->toArray();
        } catch (\Throwable) {
            return [];
        }
    }

    private function renderXml(array $urls): string
    {
        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . e($url['loc']) . "</loc>\n";
            $xml .= '    <lastmod>' . $url['mod'] . "</lastmod>\n";
            $xml .= '    <changefreq>' . $url['freq'] . "</changefreq>\n";
            $xml .= '    <priority>' . $url['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    public function clearCache(): void
    {
        Cache::forget('sitemap_xml');
    }
}
