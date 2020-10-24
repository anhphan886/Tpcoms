<?php


namespace Modules\Product\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use MyCore\Models\Traits\ListTableTrait;

class VoucherLogTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'vouchers_log';
    protected $primaryKey = 'voucher_log_id';

    protected $fillable
        = [
            'voucher_log_id', 'customer_account_id', 'order_id', 'voucher_id',
            'code', 'value', 'created_by', 'updated_by', 'created_at',
            'updated_at'
        ];

    /**
     * Đếm số lần sử dụng của voucher.
     * @param $code
     */
    public function countVoucher($code)
    {
        $select = $this->where('code', $code)->count();
        return $select;
    }

    public function getTotoUse($arrayCode)
    {
        $select = $this->select(
            'code',
            DB::raw("count(*) as used"))
            ->whereIn('code', $arrayCode)
        ->groupBy('code')->get();
        return $select;
    }
}
