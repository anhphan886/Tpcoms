<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Modules\Billing\Http\Controllers\BillingController;


class BillingJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:Billing';

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
        $billingController = app()->get(\Modules\Billing\Repositories\Billing\BillingRepositoryInterface::class);
        $billingController->billing(Carbon::now());
    }


}
