<?php

namespace Modules\Ticket\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Ticket\Repositories\Issue\IssueRepository;
use Modules\Ticket\Repositories\Issue\IssueRepositoryInterface;
use Modules\Ticket\Repositories\IssueGroup\IssueGroupRepository;
use Modules\Ticket\Repositories\IssueGroup\IssueGroupRepositoryInterface;
use Modules\Ticket\Repositories\Ticket\TicketRepository;
use Modules\Ticket\Repositories\Ticket\TicketRepositoryInterface;
use Modules\Ticket\Repositories\TicketProcessHistory\TicketProcessHistoryRepository;
use Modules\Ticket\Repositories\TicketProcessHistory\TicketProcessHistoryRepositoryInterface;
use Modules\Ticket\Repositories\TicketQueue\TicketQueueRepository;
use Modules\Ticket\Repositories\TicketQueue\TicketQueueRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TicketRepositoryInterface::class, TicketRepository::class);
        $this->app->singleton(TicketQueueRepositoryInterface::class, TicketQueueRepository::class);
        $this->app->singleton(IssueGroupRepositoryInterface::class, IssueGroupRepository::class);
        $this->app->singleton(IssueRepositoryInterface::class, IssueRepository::class);
        $this->app->singleton(
            TicketProcessHistoryRepositoryInterface::class,
            TicketProcessHistoryRepository::class
        );
    }
}
