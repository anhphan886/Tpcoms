<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use MyCore\Models\Traits\ListTableTrait;

class CustomerTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';

    protected $fillable
        = [
            'customer_id', 'customer_no', 'customer_type', 'customer_name',
            'customer_id_num', 'customer_address', 'customer_address_desc',
            'street_id', 'ward_id', 'district_id', 'province_id', 'block_service_time',
            'customer_phone', 'customer_phone2', 'customer_email',
            'customer_email2', 'customer_website', 'created_by', 'created_at',
            'modified_by', 'updated_at', 'status', 'is_deleted', 'segment_id', 'is_active'
        ];

    public function getListCore(&$filters)
    {
        $select = $this->select(
            'customer.customer_id',
            'customer.customer_no',
            'customer.customer_type',
            'customer.customer_name',
            'customer.customer_id_num',
            'customer.customer_address',
            'customer.customer_address_desc',
            'customer.street_id',
            'customer.ward_id',
            'customer.district_id',
            'customer.province_id',
            'customer.customer_phone',
            'customer.customer_phone2',
            'customer.customer_email',
            'customer.customer_email2',
            'customer.customer_website',
            'customer.created_by',
            'customer.created_at',
            'customer.modified_by',
            'customer.updated_at',
            'customer.status',
            'ca.is_active',
            'province.type as province_type',
            'province.name as province_name',
            'district.type as district_type',
            'district.name as district_name'
        )
            ->leftJoin(
                'province',
                'province.provinceid',
                '=',
                'customer.province_id'
            )
            ->leftJoin(
                'district',
                'district.districtid',
                '=',
                'customer.district_id'
            )->join(
                'customer_account as ca',
                'ca.customer_id',
                '=',
                $this->table.'.customer_id'
            )
            ->where('customer.is_deleted', 0);
        if (isset($filters['keyword'])) {
            if ($filters['keyword'] != null && $filters['keyword'] != '') {

                $select->where('customer.customer_name', 'like', '%' . $filters['keyword'] . '%');
//                    function ($query) use ($filters){
//                        $query->where('customer.customer_name', 'like', '%' . $filters['keyword'] . '%');
////                        )->orWhere('customer.customer_name', 'like', '%' . $filters['keyword'] . '%')
////                        ->orWhere('customer.customer_email', 'like', '%' . $filters['keyword'] . '%')
////                        ->orWhere('customer.customer_phone', 'like', '%' . $filters['keyword'] . '%')
////                        ->orWhere('customer.customer_phone2', 'like', '%' . $filters['keyword'] . '%');
//                    }
//                );
            }
            unset($filters['keyword']);
        }
        if (isset($filters['created_at'])) {
            if ($filters['created_at']['from'] != '' && $filters['created_at']['to'] != '') {
                $select->whereBetween(
                    'customer.created_at', [$filters['created_at']['from'],$filters['created_at']['to'] ]
                );
            }
            unset($filters['created_at']);
        }
        if (isset($filters['customer$province_id'])) {
            $id_province = sprintf("%02d", $filters['customer$province_id']);
            $select->where('customer.province_id', $id_province);
            unset($filters['customer$province_id']);
        }
        if (isset($filters['customer$district_id'])) {
            $id_district = sprintf("%03d", $filters['customer$district_id']);
            $select->where('customer.district_id', $id_district);
            unset($filters['customer$district_id']);
        }
//        if(isset($filters['id'])){
//            $select->where
//        }
        return $select->orderBy('customer.updated_at', 'desc')->groupBy($this->table.'.customer_id');
    }

    public function getListAll(){
        $oSelect = $this->where('is_deleted', 0)->where('status', 'verified')->orderBy('customer_name', 'asc')->get();

        return $this->getResultToArray($oSelect);
    }

    /**
     * Thêm thuộc tính sản phẩm.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    public function createAccount($data)
    {
        return $this->insertGetId($data);
    }
    public function detailAcc($id)
    {
        $select = $this->select(
            'customer.customer_id',
            'customer.customer_no',
            'customer.customer_type',
            'customer.customer_name',
            'customer.customer_id_num',
            'customer.customer_address',
            'customer.customer_address_desc',
            'customer.street_id',
            'customer.ward_id',
            'customer.district_id',
            'customer.province_id',
            'customer.customer_phone',
            'customer.customer_phone2',
            'customer.customer_email',
            'customer.customer_email2',
            'customer.customer_website',
            'customer.created_by',
            'customer.created_at',
            'customer.modified_by',
            'customer.updated_at',
            'customer.status',
            'customer.is_active',
            'province.type as province_type',
            'province.name as province_name',
            'district.type as district_type',
            'district.name as district_name',
            'ad1.full_name as create_full_name',
            'ad2.full_name as update_full_name'
        )
            ->leftJoin(
                'province',
                'province.provinceid',
                '=',
                'customer.province_id'
            )
            ->leftJoin(
                'district',
                'district.districtid',
                '=',
                'customer.district_id'
            )->leftJoin(
                'admin as ad1',
                'ad1.id',
                '=',
                'customer.created_by'
            )
            ->leftJoin(
                'admin as ad2',
                'ad2.id',
                '=',
                'customer.modified_by'
            )
            ->leftJoin('customer_account', 'customer_account.customer_id','=',$this->table.'.'.$this->primaryKey)
            ->where('customer.customer_id', $id)
            ->first();
        return $select;
    }
    public function detail($id)
    {
        $select = $this->select(
            'customer.customer_id',
            'customer.customer_no',
            'customer.customer_type',
            'customer.block_service_time',
            'customer.segment_id',
            'customer.customer_name',
            'customer.customer_id_num',
            'customer.customer_address',
            'customer.customer_address_desc',
            'customer.street_id',
            'customer.ward_id',
            'customer.district_id',
            'customer.province_id',
            'customer.customer_phone',
            'customer.customer_phone2',
            'customer.customer_email',
            'customer.customer_email2',
            'customer.customer_website',
            'customer.created_by',
            'customer.created_at',
            'customer.modified_by',
            'customer.updated_at',
            'customer.status',
            'customer.is_active',
            'province.type as province_type',
            'province.name as province_name',
            'district.type as district_type',
            'district.name as district_name',
            'ad1.full_name as create_full_name',
            'ad2.full_name as update_full_name'
        )
            ->leftJoin(
                'province',
                'province.provinceid',
                '=',
                'customer.province_id'
            )
            ->leftJoin(
                'district',
                'district.districtid',
                '=',
                'customer.district_id'
            )->leftJoin(
                'admin as ad1',
                'ad1.id',
                '=',
                'customer.created_by'
            )
            ->leftJoin(
                'admin as ad2',
                'ad2.id',
                '=',
                'customer.modified_by'
            )
            ->where('customer.customer_id', $id)
            ->first();
        return $select;
    }

    /**
     * Update
     * @param array $data
     * @param       $id
     * @return mixed
     */
    public function edit(array $data, $id)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }

    public function getOption()
    {
        $select = $this->select(
            'customer_name',
            'customer_id'
        )->where('is_deleted', 0);
        return $select->get();
    }

    /**
     * function get list child account with customer_id
     * @param int $customer_id
     * @return mixed
    */
    public function getListChildAccount($id)
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
            'province.name',
            'province.type'
        )
            ->join('customer_account', 'customer_account.customer_id', '=', 'customer.customer_id')
            ->join('province', 'province.provinceid', '=', 'customer_account.province_id')
            ->where('customer.customer_id', $id)
            ->where('customer_account.is_deleted', 0);

//        dd($select->get()->toArray());
        return $select->get();
    }
}
