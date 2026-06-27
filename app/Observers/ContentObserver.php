<?php

namespace App\Observers;

use App\Services\CacheService;

class ContentObserver
{
    public function saved($model): void
    {
        CacheService::clearContentCaches();
    }

    public function deleted($model): void
    {
        CacheService::clearContentCaches();
    }
}
