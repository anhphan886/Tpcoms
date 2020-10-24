<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use MyCore\Models\Traits\ListTableTrait;

class CustomerContractTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'customer_contract';
    protected $primaryKey = 'customer_contract_id';

    protected $fillable
        = [
            'customer_contract_id', 'contract_no',
            'contract_date', 'status', 'created_at', 'updated_at','customer_id',
            'created_by', 'updated_by'
        ];

    /**
     * Get list.
     * @param $filters
     * @return mixed
     */
    public function getListCore(&$filters)
    {
        $select = $this->select(
            'customer_contract.customer_contract_id',
            'customer_contract.contract_no',
            'customer_contract.contract_date',
            'customer_contract.status',
            'customer_contract.created_at',
            'customer_contract.updated_at',
            'customer_contract.created_by',
            'customer_contract.updated_by',
            'customer.customer_name',
            'province.type',
            'province.name',
            'contract_file.file_name',
            'contract_file.link_file',
            'contract_file.file_type',
            'customer_contract.time_contract',
            'customer_contract.expired_date'
        )
            ->join(
                'customer_service',
                'customer_service.customer_contract_id',
                '=',
                'customer_contract.customer_contract_id'
            )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'customer_service.customer_id'
            )
            ->leftJoin(
                'province',
                'province.provinceid',
                '=',
                'customer.province_id'
            )
            ->leftJoin(
                'contract_file',
                'contract_file.customer_contract_id',
                '=',
                'customer_contract.customer_contract_id'
            );
        if (isset($filters['keyword_customer_contract$contract_no'])) {
            if ($filters['keyword_customer_contract$contract_no'] != null
                && $filters['keyword_customer_contract$contract_no'] != '') {
                $select->where(
                    function ($query) use ($filters) {
                        $query->where('customer_contract.contract_no',
                            'like', '%' . strtoupper($filters['keyword_customer_contract$contract_no']) . '%'
                        )->orWhere('customer.customer_name', 'like',
                            '%' . strtoupper($filters['keyword_customer_contract$contract_no']) . '%');
                    }
                );
            }
            unset($filters['keyword_customer_contract$contract_no']);
        }
        if(isset($filters['id'])){

            $select->where('customer.customer_id','=',$filters['id']
            )->groupBy('customer_contract.customer_contract_id');
            unset($filters['id']);
        }
        $select->groupBy('customer_contract.customer_contract_id')
                ->orderBy('customer_contract.updated_at', 'desc');
        return $select;
    }

    /**
     * Thêm dữ liệu.
     * @param $data
     *
     * @return mixed
     */
    public function insertItem($data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    /**
     * Danh sách hợp đồng
     * @param $id
     *
     * @return mixed
     */
    public function getListContract($id)
    {
        $select = $this->select(
            'contract_file.contract_file_id',
            'contract_file.file_name',
            'contract_file.link_file',
            'contract_file.file_type',
            'contract_file.created_at',
            'contract_file.created_by',
            'customer_contract.contract_no',
            'customer_contract.customer_contract_id',
            'customer_contract.status',
            'customer_contract.customer_id',
            'customer_contract.contract_date'
        )
            ->leftJoin(
                'contract_file',
                'contract_file.customer_contract_id',
                '=',
                'customer_contract.customer_contract_id'
            )
            ->where('customer_contract.customer_id', $id)
            ->groupBy('customer_contract.customer_contract_id')->get();
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

    public function getItemByCode($code)
    {
        $select = $this->select(
            'customer_contract.customer_contract_id',
            'customer_contract.contract_no',
            'customer_contract.contract_date',
            'customer_contract.time_contract',
            'customer_contract.expired_date',
            'customer_contract.status',
            'customer_contract.created_at',
            'customer_contract.updated_at',
            'customer_contract.created_by',
            'customer_contract.updated_by',
            'customer.customer_name',
            'customer.customer_no',
            'province.type',
            'province.name',
            'contract_file.file_name',
            'contract_file.link_file',
            'contract_file.file_type',
            'a1.full_name as create_full_name',
            'a2.full_name as update_full_name'
        )
            ->join(
                'customer_service',
                'customer_service.customer_contract_id',
                '=',
                'customer_contract.customer_contract_id'
            )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'customer_service.customer_id'
            )
            ->leftJoin(
                'province',
                'province.provinceid',
                '=',
                'customer.province_id'
            )
            ->leftJoin(
                'contract_file',
                'contract_file.customer_contract_id',
                '=',
                'customer_contract.customer_contract_id'
            )
            ->where('customer_contract.customer_contract_id', $code)
            ->leftJoin(
                'admin as a1',
                'a1.id',
                '=',
                'customer_contract.created_by'
            )
            ->leftJoin(
                'admin as a2',
                'a2.id',
                '=',
                'customer_contract.updated_by'
            )
            ->first();
        return $select;
    }
    public function getContractForBilling(){
        return $this->select($this->fillable)
        ->where($this->table.'.status', 'approved')
        ->get()
        ->toArray();
    }

    public function updateData($id, $data)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }
}
