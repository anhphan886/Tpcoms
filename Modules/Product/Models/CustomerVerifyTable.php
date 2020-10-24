<?php


namespace Modules\Product\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class CustomerVerifyTable extends Model
{
    use ListTableTrait;
    protected $table = 'customer_verify';
    protected $primaryKey = 'customer_verify_id';

    public function createVerify($filter)
    {
        $oSelect = $this->insertGetId($filter);
        return $oSelect;
    }

    public function check($filter)
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $oSelect = $this
            ->where('verify_code',$filter)
            ->where('status',"0")
            ->where('verify_expire','>=',$now)
            ->orderBy('customer_verify_id','DESC')
            ->first();
        return $oSelect;
    }

    public function updateCustomerVerify($verify_code)
    {
        $oSelect = $this
            ->where('verify_code',$verify_code)->update(['verify_at' => Carbon::now(),'status' => "1", 'updated_at' => Carbon::now()]);
        return $oSelect;
    }

    public function updateStatus($verify)
    {
        $oSelect = $this
            ->where('customer_account_id',$verify['customer_account_id'])
            ->where('type',$verify['type'])
            ->update(['status'=> "1",'verify_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        return $oSelect;
    }

}
