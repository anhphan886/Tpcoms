<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use MyCore\Models\Traits\ListTableTrait;

class ContractFileTable extends Model
{
    use ListTableTrait;
    protected $table = 'contract_file';
    protected $primaryKey = 'contract_file_id';
    public $timestamps = false;

    protected $fillable
        = [
            'contract_file_id', 'customer_contract_id',
            'file_name', 'link_file', 'file_type','created_at',
             'created_by'
        ];
    /**
     * Thêm file contract.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    /**
     * Xóa file của hợp đồng
     * @param $id
     *
     * @return mixed
     */
    public function removeFile($id)
    {
        $select = $this->where('customer_contract_id', $id)
            ->where('file_type', 'contract_sample')
            ->delete();
        return $select;
    }

    /**
     * Get all contract file.
     * @return mixed
     */
    public function getContractFile()
    {
        $select = $this->select(
            'customer_contract_id',
            'file_name', 'link_file', 'file_type'
        )
            ->get();
        return $select;
    }

    public function getContractFileById($id)
    {
        $select = $this->select(
            'customer_contract_id',
            'file_name', 'link_file', 'file_type'
        )
            ->where('customer_contract_id', $id)
            ->get();
        return $select;
    }
}
