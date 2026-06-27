<?php

namespace App\Http\Controllers;

use App\Services\SitemapService;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __construct(private SitemapService $sitemapService) {}

    public function index(): Response
    {
        return response($this->sitemapService->generate(), 200)
            ->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $content = $this->buildRobots();

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }

    private function buildRobots(): string
    {
        $sitemapUrl = url('/sitemap.xml');
        $env        = app()->environment('production');

        if (!$env) {
            return "User-agent: *\nDisallow: /\n";
        }

        return <<<ROBOTS
        User-agent: *
        Allow: /
        Disallow: /admin/
        Disallow: /login
        Disallow: /register
        Disallow: /forgot-password
        Disallow: /reset-password
        Disallow: /email/verify
        Disallow: /profile
        Crawl-delay: 1

        Sitemap: {$sitemapUrl}
        ROBOTS;
    }
}
