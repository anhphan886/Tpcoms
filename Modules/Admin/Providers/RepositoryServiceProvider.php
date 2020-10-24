<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Repositories\Config\ConfigRepositoryInterface;
use Modules\Admin\Repositories\dashboard\DashboardRepository;
use Modules\Admin\Repositories\dashboard\DashboardRepositoryInterface;
use Modules\Admin\Repositories\Config\ConfigRepository;
use Modules\Admin\Repositories\Notification\NotificationRepository;
use Modules\Admin\Repositories\Notification\NotificationRepositoryInterface;
use Modules\Admin\Repositories\ReceiptEmail\ReceiptEmailRepository;
use Modules\Admin\Repositories\ReceiptEmail\ReceiptEmailRepositoryInterface;
use Modules\Admin\Repositories\Report\ReportRepository;
use Modules\Admin\Repositories\Report\ReportRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DashboardRepositoryInterface::class, DashboardRepository::class);
        $this->app->singleton(ReportRepositoryInterface::class, ReportRepository::class);
        $this->app->singleton(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->singleton(ConfigRepositoryInterface::class, ConfigRepository::class);
        $this->app->singleton(ReceiptEmailRepositoryInterface::class, ReceiptEmailRepository::class);
    }
}
