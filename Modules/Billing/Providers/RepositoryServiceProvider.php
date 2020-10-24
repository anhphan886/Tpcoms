<?php

namespace Modules\Billing\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Billing\Repositories\Billing\BillingRepository;
use Modules\Billing\Repositories\Billing\BillingRepositoryInterface;//CustomerServiceRepository
use Modules\Billing\Repositories\CustomerService\CustomerServiceRepository;
use Modules\Billing\Repositories\CustomerService\CustomerServiceRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(BillingRepositoryInterface::class, BillingRepository::class);
        $this->app->singleton(CustomerServiceRepositoryInterface::class, CustomerServiceRepository::class);
    }
}
