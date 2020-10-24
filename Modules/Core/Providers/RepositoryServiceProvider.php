<?php

namespace Modules\Core\Providers;

use Modules\Core\Repositories\Admin\AdminRepository;
use Modules\Core\Repositories\Admin\AdminRepositoryInterface;
use Modules\Core\Repositories\AdminGroup\AdminGroupRepositoryInterface;
use Modules\Core\Repositories\AdminGroup\AdminGroupRepository;
use Modules\Core\Repositories\AdminAction\AdminActionRepositoryInterface;
use Modules\Core\Repositories\AdminAction\AdminActionRepository;
use Modules\Core\Repositories\AdminMenu\AdminMenuRepositoryInterface;
use Modules\Core\Repositories\AdminMenu\AdminMenuRepository;
use Modules\Core\Repositories\AdminHasGroup\AdminHasGroupRepositoryInterface;
use Modules\Core\Repositories\AdminHasGroup\AdminHasGroupRepository;
use Modules\Core\Repositories\AdminGroupMenu\AdminGroupMenuRepositoryInterface;
use Modules\Core\Repositories\AdminGroupMenu\AdminGroupMenuRepository;
use Modules\Core\Repositories\AdminMenuCategory\AdminMenuCategoryRepositoryInterface;
use Modules\Core\Repositories\AdminMenuCategory\AdminMenuCategoryRepository;
use Modules\Core\Repositories\AdminGroupAction\AdminGroupActionRepositoryInterface;
use Modules\Core\Repositories\AdminGroupAction\AdminGroupActionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Phân quyền
        $this->app->singleton(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->singleton(AdminGroupRepositoryInterface::class, AdminGroupRepository::class);
        $this->app->singleton(AdminActionRepositoryInterface::class, AdminActionRepository::class);
        $this->app->singleton(AdminMenuRepositoryInterface::class, AdminMenuRepository::class);
        $this->app->singleton(AdminHasGroupRepositoryInterface::class, AdminHasGroupRepository::class);
        $this->app->singleton(AdminGroupMenuRepositoryInterface::class, AdminGroupMenuRepository::class);
        $this->app->singleton(
            AdminMenuCategoryRepositoryInterface::class,
            AdminMenuCategoryRepository::class
        );
        $this->app->singleton(
            AdminGroupActionRepositoryInterface::class,
            AdminGroupActionRepository::class
        );
    }
}
