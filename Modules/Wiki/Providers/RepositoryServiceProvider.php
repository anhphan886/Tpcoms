<?php

namespace Modules\Wiki\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Wiki\Repositories\Wiki\WikiRepository;
use Modules\Wiki\Repositories\Wiki\WikiRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WikiRepositoryInterface::class , WikiRepository::class);
    }
}
