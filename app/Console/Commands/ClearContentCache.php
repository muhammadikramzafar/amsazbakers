<?php

namespace App\Console\Commands;

use App\Services\CacheService;
use Illuminate\Console\Command;

class ClearContentCache extends Command
{
    protected $signature   = 'cache:clear-content {--all : Clear all cache including settings}';
    protected $description = 'Clear content-related caches (categories, featured items, sitemap)';

    public function handle(): int
    {
        if ($this->option('all')) {
            CacheService::clearAll();
            $this->info('All caches cleared.');
        } else {
            CacheService::clearContentCaches();
            $this->info('Content caches cleared (categories, featured items, sitemap).');
        }

        return self::SUCCESS;
    }
}
