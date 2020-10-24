<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Repositories\ReceiptEmail\ReceiptEmailRepositoryInterface;

class ReceiptEmailController extends Controller
{
    protected $receiptEmail;

    public function __construct(ReceiptEmailRepositoryInterface $receiptEmail)
    {
        $this->receiptEmail = $receiptEmail;
    }

    /**
     * Index
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index()
    {
       $this->receiptEmail->getReceiptPayExpired();
    }

}
