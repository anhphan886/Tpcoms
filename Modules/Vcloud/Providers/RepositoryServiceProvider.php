<?php

namespace Modules\Vcloud\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Vcloud\Repositories\Vcloud\VcloudRepository;
use Modules\Vcloud\Repositories\Vcloud\VcloudRepositoryInterface;
class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(VcloudRepositoryInterface::class, VcloudRepository::class);
    }
}
