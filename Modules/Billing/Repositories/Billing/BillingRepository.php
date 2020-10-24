<?php

namespace Modules\Billing\Repositories\Billing;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\InvoiceTable;
use Modules\Admin\Models\OrderTable;
use Modules\Product\Models\ReceiptTable;
use Modules\Product\Models\CustomerServiceTable;
use Modules\Product\Models\InvoiceMapTable;
use Modules\Ticket\Repositories\Ticket\TicketRepository;

class BillingRepository implements BillingRepositoryInterface
{

    private $cusService;
    private $mReceipt;
    private $mInvoice;
    private $invoiceMapTable;
    public function __construct(
        CustomerServiceTable $cusTable,
        ReceiptTable $receiptTable,
        InvoiceTable $mInvoice,
        InvoiceMapTable $invoiceMapTable
    ) {
        $this->cusService = $cusTable;
        $this->mReceipt = $receiptTable;
        $this->mInvoice = $mInvoice;
        $this->invoiceMapTable = $invoiceMapTable;
    }
    public function calcAmountPayuse($service, $billingDate)
    {
        // billing history contains deleted and update, creating resource
        // calc current billing first -> total billing .ServiceVMAttributeTable
        $serviceVMTable = app()->get(\Modules\Billing\Models\ServiceVMTable::class);
        $serviceVMAttributeTable = app()->get(\Modules\Billing\Models\ServiceVMAttributeTable::class);
        $serviceBillingHistory = app()->get(\Modules\Billing\Models\ServiceBillingHistoryTable::class);
        $vms = $serviceVMTable->getVM($service['customer_service_id'], false);
        foreach ($vms as $vm) {
            $vmAttrs = $serviceVMAttributeTable->getAttributeByVMId($vm['vm_id']);
            foreach ($vmAttrs as $vmAttr) {
                $totalAttrPrice = 0;
                $createVm = Carbon::parse($vmAttr['updated_at']);
                if ($createVm >= $billingDate->startOfMonth() && $createVm <= $billingDate->endOfMonth()) {
                    $totalAttrPrice = ($billingDate->endOfMonth()->diffInHours($createVm) + 1) * ($vmAttr['price'] / 30 / 24);
                } else {
                    $totalAttrPrice = $vmAttr['price'];
                }
                $serviceBillingHistory->insertItem([
                    'vm_id' => $vm['vm_id'],
                    'product_attribute_id' => $vmAttr['vm_attribute_id'],
                    'from_value' => $vmAttr['value'],
                    'to_value' => $vmAttr['value'],
                    'from_date' => $vmAttr['updated_at'],
                    'to_date' => $billingDate->endOfMonth(),
                    'price' => $vmAttr['price'],
                    'amount' => $totalAttrPrice,
                    'billing_date' => $billingDate,
                    'last_billing' => $billingDate->endOfMonth(),
                    'created_at' => Carbon::now()
                ]);
            }
        }
        return $this->calcBillingDate($service['customer_service_id'], $billingDate);
    }
    public function calcBillingDate($customer_service_id, $billingDate)
    {
        $serviceHistory = app()->get(\Modules\Billing\Models\ServiceBillingHistoryTable::class);
        return $serviceHistory->calcBillingByService($customer_service_id, $billingDate);
    }
    /**
     * @param $date datetime : time contains months that billing scan.
     * date = marrch -> billing for february
     */
    public function billing($billingDate)
    {
        $billingDate = Carbon::parse($billingDate);
        if (Carbon::now() < $billingDate->endOfMonth()) {
            exit('Date must be smaller than current date.');
        }
        // customer service type real.
        $contractIns = app()->get(\Modules\Product\Models\CustomerContractTable::class);
        $billing = app()->get(\Modules\Billing\Models\BillingTable::class);
        $billingDetail = app()->get(\Modules\Billing\Models\BillingDetailTable::class);
        $listContract = $contractIns->getContractForBilling();
        foreach ($listContract as $contract) {
            if ($billing->checkExist($billingDate, $contract['customer_contract_id'])) {
                continue;
            }
            DB::beginTransaction();
            $services = $this->cusService->getBillingListByContract($contract['customer_contract_id']);
            $newBillingId = $billing->insertItem([
                'contract_id' => $contract['customer_contract_id'],
                'billing_date' => $billingDate,
                'created_at' => Carbon::now()
            ]);
            $totalBillingDetail = 0;
            foreach ($services as $service) {
                $newBillingDetailId = $billingDetail->insertItem([
                    'customer_service_id' => $service['customer_service_id'],
                    'billing_date' => $billingDate,
                    'contract_id' => $contract['customer_contract_id'],
                    'created_at' => Carbon::now()
                ]);
                try {
                    $changedDate = false;
                    $startDay = Carbon::parse($billingDate)->startOfMonth();
                    $endDay = Carbon::parse($billingDate)->endOfMonth();
                    $stopPaymentAt = Carbon::parse($service['stop_payment_at']);

                    if ($service['stop_payment'] == 1) {
                        if ($stopPaymentAt->isBetween($startDay, $endDay)) {
                            $endDay = $stopPaymentAt;
                            $changedDate = true;
                        }
                    }
                    if ($service['payment_type'] == MODE_POSTPAID) {
                        $lastBilling = Carbon::parse($service['last_billing']);
                        if ($lastBilling->isBetween($startDay, $endDay)) {
                            $startDay = $lastBilling;
                            $changedDate = true;
                        }
                        if ($startDay > $endDay) {
                            continue;
                        }
                        if ($changedDate) {
                            $days = $startDay->diffInDays($endDay) + 1;
                            $billingDetail->updateItem([
                                'total' => $days * $service['price'] / 30
                            ], $newBillingDetailId);
                        } else {
                            $billingDetail->updateItem([
                                'total' => $service['price']
                            ], $newBillingDetailId);
                        }
                        $this->cusService->updateLastBilling($service['customer_service_id'], $endDay);
                    } else if ($service['payment_type'] == MODE_PAYUSE) {
                        // calculate attribute log
                        // billing history contains deleted and update, creating resource
                        // calc current billing first -> total billing .ServiceVMAttributeTable
                        $serviceVMTable = app()->get(\Modules\Billing\Models\ServiceVMTable::class);
                        $serviceVMAttributeTable = app()->get(\Modules\Billing\Models\ServiceVMAttributeTable::class);
                        $serviceBillingHistory = app()->get(\Modules\Billing\Models\ServiceBillingHistoryTable::class);
                        $vms = $serviceVMTable->getVM($service['customer_service_id'], false);
                        foreach ($vms as $vm) {
                            $vmAttrs = $serviceVMAttributeTable->getAttributeByVMId($vm['vm_id']);
                            foreach ($vmAttrs as $vmAttr) {
                                $changedAttrDate = false;
                                $startDay = Carbon::parse($billingDate)->startOfMonth();
                                $lastBilling = Carbon::parse($vmAttr['last_billing']);
                                if ($lastBilling->isBetween($startDay, $endDay)) {
                                    $startDay = $lastBilling;
                                    $changedAttrDate = true;
                                }
                                if($startDay > $endDay){
                                    continue;
                                }
                                $totalAttrPrice = 0; 

                                if ($changedDate == true && $changedAttrDate == true) {
                                    $totalAttrPrice = ($startDay->diffInHours($endDay) + 1) * ($vmAttr['price'] / 30 / 24) * $vmAttr['value'];
                                } else {
                                    $totalAttrPrice = $vmAttr['price'] * $vmAttr['value'];
                                }
                                $serviceBillingHistory->insertItem([
                                    'vm_id' => $vm['vm_id'],
                                    'product_attribute_id' => $vmAttr['vm_attribute_id'],
                                    'from_value' => $vmAttr['value'],
                                    'to_value' => $vmAttr['value'],
                                    'from_date' => $vmAttr['updated_at'],
                                    'to_date' => $billingDate->endOfMonth(),
                                    'price' => $vmAttr['price'],
                                    'amount' => $totalAttrPrice,
                                    'billing_date' => $billingDate,
                                    'last_billing' => $billingDate->endOfMonth(),
                                    'created_at' => Carbon::now()
                                ]);
                            }
                        }
                        $totalAllVm = $this->calcBillingDate($service['customer_service_id'], $billingDate);
                        $billingDetail->updateItem([
                            'total' => $totalAllVm
                        ], $newBillingDetailId);
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    continue;
                }
                $calcBillingDetail = $billingDetail->calcByCustomerDate($service['customer_service_id'], $billingDate);
                $billingDetail->updateItem([
                    'total' => $calcBillingDetail
                ], $newBillingDetailId);
            }
            // tính lại total billing ở đây.
            $totalDetailBilling = $billingDetail->calcByContractDate($contract['customer_contract_id'], $billingDate);
            $billingDetail->updateItem([
                'total' => $totalDetailBilling
            ], $newBillingId);
            // calculate total billing
            if (!$this->mReceipt->checkReceipt(Carbon::parse($billingDate)->subMonth(), $contract['customer_contract_id']) && count($services) > 0) {
                $receipt_no = getCode(CODE_RECEIPT, $this->mReceipt->getNumberForCode());
                $receiptId = $this->mReceipt->add([
                    'receipt_no' => $receipt_no,
                    'customer_contract_id' => $contract['customer_contract_id'],
                    'amount' => $totalBillingDetail,
                    'pay_expired' => Carbon::now()->addMonths(1), // hardcode
                    'vat' => $totalBillingDetail * 0.1,
                    'status' => 'unpaid',
                    'receipt_content' => 'Phiếu thu tạo bở BILLING',
                    'is_actived' => 1,
                    'is_deleted' => 0,
                    'created_by' => Auth::id(),
                    'created_at' => Carbon::now(),
                    'modified_by' => Auth::id(),
                    'modified_at' => Carbon::now()
                ]);
                $dataInsertInvoice = [
                    'invoice_no' => getCode(CODE_INVOICE, $this->mInvoice->getNumberForCode()),
                    'net' => $totalBillingDetail,
                    'vat' => $totalBillingDetail * 0.1,
                    'amount' => $totalBillingDetail * 1.1,
                    'status' => 'new',
                    'customer_id' => $service['customer_id'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => Auth::id(),
                ];
                $invoiceId = $this->mInvoice->add($dataInsertInvoice);
                $dataInvoiceMap = [
                    'invoice_id' => $invoiceId,
                    'receipt_id' => $receiptId,
                    'net' => intval($dataInsertInvoice['net']),
                    'vat' => $dataInsertInvoice['vat'],
                    'amount' => $dataInsertInvoice['amount'],
                ];
                $this->invoiceMapTable->add($dataInvoiceMap);
                DB::commit();
            } else {
                DB::rollBack();
            }
        }
    }
}
