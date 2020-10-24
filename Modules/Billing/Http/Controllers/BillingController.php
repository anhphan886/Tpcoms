<?php

namespace Modules\Billing\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BillingController extends Controller
{
    public function __construct(){
    }
    public function billing(Request $request){
        $vali = $request->validate([
            'date' => 'required'
        ]);
        $billing = app()->get(\Modules\Billing\Repositories\Billing\BillingRepositoryInterface::class);
        $billing->billing($vali['date'] ?? Carbon::now());
    }
}
