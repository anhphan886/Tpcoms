<?php

namespace Modules\Product\Models;

use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use MyCore\Models\Traits\ListTableTrait;

class CustomerAccountTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'customer_account';
    protected $primaryKey = 'customer_account_id';
    public $timestamps = false;

    protected $fillable
        = [
            'customer_account_id', 'customer_id', 'account_code', 'account_password',
            'salt', 'account_type', 'title',
            'account_email', 'account_phone', 'account_id_num', 'account_name',
            'address', 'created_by', 'created_at',
            'modified_by', 'date_modified', 'is_deleted', 'is_admin',
            'is_active', 'updated_at'
        ];

    public function getListCore(&$filters)
    {
        $select = $this->select (
            'customer.customer_id',
            'customer_account.customer_id',
            'customer_account.account_code',
            'customer_account.account_type',
            'customer_account.account_email',
            'customer_account.account_phone',
            'customer_account.account_id_num',
            'customer_account.address',
            'customer_account.account_name',
            'customer_account.is_active',
            'customer_account.customer_account_id',
            'customer_account.province_id',
            'province.type as province_type',
            'province.name as province_name'
        )
            ->leftJoin('customer', 'customer.customer_id', '=', 'customer_account.customer_id')
            ->leftJoin('province', 'province.provinceid', '=', 'customer_account.province_id')
            ->where('customer_account.is_deleted', 0);
        if (isset($filters['customer_id']) && isset($filters['customer_email'])) {
            $select->where('customer_account.customer_id', '=', $filters['customer_id'])
                    ->where('customer_account.account_email', '<>', $filters['customer_email']);
        }

        unset($filters['customer_email']);
        unset($filters['customer_id']);
        return $select->orderBy('customer_account.updated_at', 'desc');
    }


    public function getListAll(){
        $oSelect = $this->where('is_deleted', 0)->where('is_active', 1)->get();

        return $this->getResultToArray($oSelect);
    }

    public function getAdmin($customerId){
        $oSelect = $this->where('customer_id', $customerId)
            ->where('is_admin',1)
            ->where('is_deleted', 0)
            ->where('is_active', 1)->get();

        return $this->getFirstResultToFirst($oSelect);
    }
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    public function edit(array $data, $email)
    {
        return $this->where('account_email', $email)->update($data);
    }

    public function getTotalAccount($customer_no)
    {
        $oSelect = $this
                ->where('created_at',Carbon::now())
                ->where('account_code','like','%'.$customer_no.'%')
                ->get()
                ->count() + 1;
        return $oSelect;
    }

    /**
     * function change Status of customer account
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function changeStatus(array $data, $id)
    {
        return $this->where('customer_account_id', $id)->update($data);
    }

    /**
     * function update info child accoount
     * @param int $customer_account_id
     * @param array $data
     * @return mixed
    */
    public function updateChildAccount(array  $data, $id)
    {
//        dd($id);
        $result = $this->where('customer_account.customer_account_id', $id)->update($data);
        return $result;
    }

    /**
     * function get detail info child account
     * @param int $customer_account_id
    */
    public function getDetailChildAccount($id)
    {
        $select = $this->select(
            'customer.customer_id',
            'customer_account.customer_id',
            'customer_account.account_code',
            'customer_account.account_type',
            'customer_account.account_email',
            'customer_account.account_phone',
            'customer_account.account_id_num',
            'customer_account.address',
            'customer_account.account_name',
            'customer_account.is_active',
            'customer_account.customer_account_id',
            'customer_account.province_id',
            'customer_account.account_password',
            'customer_account.salt'
        )
            ->leftJoin('customer', 'customer.customer_id', '=', 'customer_account.customer_id')
            ->where('customer_account.customer_account_id', $id)
            ->first();

        return $select;
    }

    /**
     * function get total  child account
     * @param int $customer_account_id
     * @return total
     */
    public function getTotalChildAccount($id, $param)
    {
        $select = $this->select (
            'customer_account.customer_id'
        )
            ->where('customer_account.account_email', '<>', $param)
            ->where('customer_account.is_deleted', 0)
            ->where('customer_account.customer_id', '=', $id)
            ->get();

        return $select->count();
    }

    /**
     * get account type
    */
    public function getAccountType()
    {
        $select = $this->select(
            'account_type'
        )
            ->where('customer_account.is_deleted', 0)
            ->get();
        return $select->groupBy('account_type');
    }

    /**
     * create tài khoản con with customer_id
     *@param array $data
     * @return mixed
    */
    public function  createAccount(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    public function getDetailByCusId($id)
    {
        $oSelect = $this->select('customer.customer_id', 'customer.customer_no',  'customer_account.customer_id')
            ->join('customer', 'customer.customer_id', '=',  'customer_account.customer_id')
            ->where('customer_account_id', $id)
            ->first();
        return $oSelect;
    }
}
