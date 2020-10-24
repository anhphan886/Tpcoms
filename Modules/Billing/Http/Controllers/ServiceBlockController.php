<?php

namespace Modules\Billing\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ServiceBlockController extends Controller
{
    public function __construct(){
    }
    public function serviceBlockExpired(Request $request){
        $date = $request->validate([
            'date' => 'nullable'
        ]);
        // $customer = app()->get(\Modules);
        // get customer
        $serviceRepo = app()->get(\Modules\Product\Repositories\Customer\CustomerRepositoryInterface::class);
        $serviceRepo->blockServiceExpired($date['date'] ?? Carbon::now());
    }
    public function serviceBlockPayment(Request $request){
        $date = $request->validate([
            'date' => 'nullable'
        ]);
        // $customer = app()->get(\Modules);
        // get customer
        $serviceRepo = app()->get(\Modules\Product\Repositories\Customer\CustomerRepositoryInterface::class);
        $serviceRepo->blockServicePayment($date['date'] ?? Carbon::now());
    }
}
