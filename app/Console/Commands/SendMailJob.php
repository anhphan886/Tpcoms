<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Models\JobsMailLog;
use Modules\Ticket\Repositories\Ticket\TicketRepositoryInterface;
use App\Mail\EmailCenter;


class SendMailJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:MailJob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $ticket;
    protected $EmailCenter;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mailCenter = new EmailCenter([
            \Modules\Product\Models\TicketEmailLogTable::class => [],
            \Modules\Product\Models\ReceiptEmailLogTable::class => [],
            \Modules\Admin\Models\JobsMailLog::class => [
                'to_address' => 'email_to',
                'body_html' => 'email_body',
                'is_sent' => 'is_sent',
                'date_sent' => 'date_sent',
            ],

        ]);
        $mailCenter->run();
    }
//        SendMailTicket::dispatch();

}
