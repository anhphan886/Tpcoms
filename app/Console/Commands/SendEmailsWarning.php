<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Ticket\Repositories\Ticket\TicketRepositoryInterface;

class SendEmailsWarning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendEmailWarning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $ticket;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        // TicketRepositoryInterface $ticket
    )
    {
        parent::__construct();
        // $this->ticket = $ticket;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->ticket->detailTicketCheckDate();
        return $data;
    }
}
