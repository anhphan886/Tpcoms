<?php


namespace Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use MyCore\Models\Traits\ListTableTrait;

use Carbon\Carbon;

class InvoiceTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'invoice';
    protected $primaryKey = 'invoice_id';
    protected $STATUS_PAID = 'paid';

    public $timestamps = false;

    protected $fillable
    = [
        'invoice_id', 'invoice_no', 'net', 'vat', 'amount', 'status',
        'invoice_by', 'invoice_at', 'invoice_number', 'created_at',
        'created_by', 'updated_at', 'updated_by', 'customer_id'
    ];

    /**
     * Get list invoice
     *
     * @return mixed
     */
    protected function getListCore(&$filters)
    {
        $select = $this->select(
            'invoice.invoice_id',
            'invoice.invoice_no',
            'invoice.status',
            'invoice.amount',
            'invoice.invoice_by',
            'invoice.invoice_at',
            'invoice.invoice_number',
            'customer_service.customer_id',
            'ad1.full_name as create_full_name',
            'customer.customer_id',
            'customer.customer_name',
            'customer.customer_no',
            'receipt.status as receipt_status'
        )
            ->leftJoin('invoice_map', 'invoice_map.invoice_id', '=', 'invoice.invoice_id')
            ->leftJoin('receipt', 'receipt.receipt_id', '=', 'invoice_map.receipt_id')
            ->leftJoin('admin as ad1', 'ad1.id', '=', 'invoice.invoice_by')
            ->leftJoin('receipt_map', 'receipt_map.receipt_id', '=', 'receipt.receipt_id')
            ->leftJoin(
                'customer_service',
                'receipt_map.customer_service_id',
                '=',
                'receipt_map.customer_service_id'
            )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'invoice.customer_id'
            );

        if (isset($filters['query']['search_invoice'])) {
            $keyword = $filters['query']['search_invoice'];
            $select->where(function ($query) use ($keyword) {
                $query->where('customer.customer_name', 'like', '%' . strtoupper($keyword) . '%')
                    ->orWhere('invoice.invoice_no', 'like', '%' . strtoupper($keyword) . '%');
            });
            unset($filters['query']);
        }
        if (isset($filters['date'])) {
            $select->whereDate($this->table . '.created_at', $filters['date'])
                ->where($this->table . '.status', 'new')
                ->where($this->table . '.invoice_by', null)
                ->where($this->table . '.invoice_at', null);
            unset($filters['date']);
        }

        $select->groupBy('invoice.invoice_id')
            ->orderBy('invoice.updated_at', 'desc');
        return $select;
    }
    /**
     * Tổng tiền của hóa đơn trong tháng - năm
     *
     * @param $month
     * @param $year
     *
     * @return mixed
     */
    public function sumTotalMoney($month, $year)
    {
        $select = $this->select(DB::raw("SUM(portal_invoice.amount) as amount"))
            ->whereMonth($this->table . '.created_at', $month)
            ->whereYear($this->table . '.created_at', '=', $year);
        return $select->first();
    }

    /**
     * Tổng tiền của hóa đơn từ ngày - ngày
     *
     * @param $month
     * @param $year
     *
     * @return mixed
     */
    public function sumTotalMoneyByDay($startTime, $endTime)
    {
        $select = $this->select(
            DB::raw("DATE(portal_invoice.created_at) as created_at"),
            DB::raw("SUM(portal_invoice.amount) as amount")
        )
            ->whereBetween($this->table . '.created_at', [$startTime, $endTime])
            ->groupBy(DB::raw('Date(portal_invoice.created_at)'))
            ->orderBy(DB::raw('Date(portal_invoice.created_at)'), 'DESC');
        return $select->get();
    }

    /**
     * Đếm số lượng hóa đơn cần xuất trong ngày
     * @param $filters
     *
     * @return mixed
     */
    public function getCountNeedExport($filters)
    {
        //        $select = $this->join(
        //            'customer',
        //            'customer.customer_id',
        //            '=',
        //            $this->table . '.customer_id')
        ////            ->leftJoin('invoice_map', 'invoice_map.invoice_id','=','invoice.invoice_id')
        ////            ->leftJoin('receipt', 'receipt.receipt_id','=','invoice_map.receipt_id')
        ////            ->leftJoin('admin as ad1', 'ad1.id', '=', 'invoice.invoice_by')
        ////            ->leftJoin('receipt_map', 'receipt_map.receipt_id','=','receipt.receipt_id')
        //            ->where($this->table . '.status', 'new')
        //            ->where($this->table . '.invoice_by', null)
        //            ->where($this->table . '.invoice_at', null)
        //            ->whereDate($this->table . '.created_at', $filters['date'])
        //            ->groupBy('invoice.invoice_id');
        //        return $select->count();
        $select = $this->select(
            'invoice.invoice_id',
            'invoice.invoice_no',
            'invoice.status',
            'invoice.amount',
            'invoice.invoice_by',
            'invoice.invoice_at',
            'invoice.invoice_number',
            'customer_service.customer_id',
            'ad1.full_name as create_full_name',
            'customer.customer_id',
            'customer.customer_name',
            'customer.customer_no',
            'receipt.status as receipt_status'
        )
            ->leftJoin('invoice_map', 'invoice_map.invoice_id', '=', 'invoice.invoice_id')
            ->leftJoin('receipt', 'receipt.receipt_id', '=', 'invoice_map.receipt_id')
            ->leftJoin('admin as ad1', 'ad1.id', '=', 'invoice.invoice_by')
            ->leftJoin('receipt_map', 'receipt_map.receipt_id', '=', 'receipt.receipt_id')
            ->leftJoin(
                'customer_service',
                'receipt_map.customer_service_id',
                '=',
                'receipt_map.customer_service_id'
            )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'invoice.customer_id'
            );
        if (isset($filters['date'])) {
            $select->whereDate($this->table . '.created_at', $filters['date'])
                ->where($this->table . '.status', 'new')
                ->where($this->table . '.invoice_by', null)
                ->where($this->table . '.invoice_at', null);
            unset($filters['date']);
        }
        $select->groupBy('invoice.invoice_id')
            ->orderBy('invoice.updated_at', 'desc');
        return count($select->get());
    }

    public function getDataExportInvoice($choose_day)
    {

        $arr_day = explode('-', $choose_day);

        $startDay = Carbon::createFromFormat('d/m/Y', trim($arr_day[0]))-> startOfDay()->toDateTimeString();
        $endDay = Carbon::createFromFormat('d/m/Y', trim($arr_day[1]))->endOfDay()->toDateTimeString();


        DB::statement(DB::raw('SET @empty = ""'));
        DB::statement(DB::raw('SET @empty = ""'));
        DB::statement(DB::raw('SET @zero = "0"'));
        DB::statement(DB::raw('SET @row_number = 0'));

        $select = $this->select(
            DB::raw('@zero as num'),
            'invoice.invoice_no',
            'invoice.created_at',
            'order.order_code',
            'customer.customer_name',
            'customer.customer_address',
            DB::raw('@empty as billing_period'),
            DB::raw('@zero as installation_fees'), //installation fees
            DB::raw('FORMAT(portal_order.amount,0)'),
            DB::raw('FORMAT(portal_order.vat,0)'),
            DB::raw('@zero as charges_incurred'), // Tổng cước phát sinh
            DB::raw('FORMAT((portal_order.amount),0) as tong_cuoc_phai_thu'), // Tổng cước phải thu
            DB::raw('FORMAT((portal_invoice.amount),0) as tong_cuoc_da_thu'),
            DB::raw('@zero as tong_cuoc_con_no'), // Cước còn nợ
            'pa.product_name_vi as parent_name',//Loại dịch vụ
            'product.product_name_vi',// Gói dịch vụ
            'customer_service.payment_type',
            'customer_service.status',//Tình tạng thuê bao
            'cs_admin.full_name',
            'customer_service.note',
            'receipt.receipt_id',
            'receipt_detail.receipt_detail_id'
        )
            ->join('invoice_map', 'invoice.invoice_id', '=', 'invoice_map.invoice_id')
            ->join('receipt', 'receipt.receipt_id', '=', 'invoice_map.receipt_id')
            ->join('customer_service', 'customer_service.customer_contract_id', '=', 'receipt.customer_contract_id')
            ->leftJoin('receipt_detail','receipt_detail.receipt_id', '=', 'receipt.receipt_id')
            ->join('customer_contract', 'customer_contract.customer_contract_id', '=', 'receipt.customer_contract_id')
            ->join('order', 'order.order_id', '=', 'receipt.order_id')
            ->join('customer', 'customer.customer_id', '=', 'order.customer_id')
            ->join('order_detail', 'order_detail.order_id', '=', 'order.order_id')
            ->join('product', 'customer_service.product_id', '=', 'product.product_id')
            ->leftJoin('product as pa','product.parent_id','=', 'pa.product_id')
            ->leftJoin('cs_admin', 'cs_admin.id', '=', 'order.staff_id')
            ->whereBetween('invoice.created_at', [$startDay, $endDay])
            ->groupBy('order.order_id')
            ->orderBy('invoice.created_at', 'DESC')
            ->get();

        return $select->toArray();
    }
}
