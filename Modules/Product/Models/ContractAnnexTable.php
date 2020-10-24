<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class ContractAnnexTable extends  BaseModel
{
    use ListTableTrait;
    protected $table = 'customer_contract_annex';
    protected $primaryKey = 'customer_contract_annex_id';
    protected $fillable = [
      'customer_contract_annex_id',
      'customer_contract_id',
      'contract_annex_no',
      'contract_annex_date',
      'created_at',
      'created_by',
      'updated_at',
      'updated_by',
    ];
    public $timestamps = false;

    /* get list
     *@param array $filters
     *@return mixed
     */
    public function getListCore(&$filter)
    {
        $select  = $this->select(
            $this->table.'.customer_contract_annex_id',
            $this->table.'.contract_annex_no',
            $this->table.'.contract_annex_date',
            $this->table.'.created_at',
            $this->table.'.created_by',
            $this->table.'.updated_at',
            $this->table.'.updated_by',
            'caf.contract_annex_file_id',
            'caf.file_name',
            'caf.file_type',
            'caf.link_file',
            'ad1.full_name as created_by',
            'ad2.full_name as updated_by',
            'customer_contract.contract_no',
            'customer.customer_name'
        );

           $select ->leftJoin('customer_contract', 'customer_contract.customer_contract_id', '=', $this->table.'.customer_contract_id')
            ->leftJoin('customer', 'customer.customer_id', '=', 'customer_contract.customer_id')
            ->leftJoin('contract_annex_file as caf', 'caf.customer_contract_annex_id', '=' , 'customer_contract_annex.customer_contract_id')
            ->leftJoin('admin as ad1', 'ad1.id', '=', 'customer_contract_annex.created_by' )
            ->leftJoin('admin as ad2', 'ad2.id', '=', 'customer_contract_annex.updated_by');

           if (isset($filter['contract_id'])) {
               $select->where($this->table . '.customer_contract_id', $filter['contract_id']);
               unset($filter['contract_id']);
           }

            if (isset($filter['keyword_customer_name$customer_name']) && $filter['keyword_customer_name$customer_name'] != '') {
                    $select->where(function ($query) use ($filter) {
                        $query->where(
                            'customer.customer_name', 'like', '%' . strtoupper($filter['keyword_customer_name$customer_name']) . '%'
                        );
                    });
                    unset($filter['keyword_customer_name$customer_name']);
            }
            if (isset($filter['keyword_customer_name$annex_no']) && $filter['keyword_customer_name$annex_no'] != '') {
                $select->where(function ($query) use ($filter) {
                    $query->where(
                        $this->table.'.contract_annex_no', 'like', '%' . strtoupper($filter['keyword_customer_name$annex_no']) . '%'
                    );
                });
                unset($filter['keyword_customer_name$annex_no']);
            }
        return $select->groupBy('customer_contract_annex.customer_contract_annex_id')
                        ->orderBy('customer_contract_annex.updated_at', 'desc');
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
     * get detail by ID
     * @param int $id
     * @return mixed
    */
    public function getDetailByID($id)
    {
        $select  = $this->select(
            $this->table.'.customer_contract_annex_id',
            $this->table.'.contract_annex_no',
            $this->table.'.contract_annex_date',
            $this->table.'.created_at',
            $this->table.'.created_by',
            $this->table.'.updated_at',
            $this->table.'.updated_by',
            'caf.contract_annex_file_id',
            'caf.file_name',
            'caf.file_type',
            'caf.link_file',
            'ad1.full_name as created_by',
            'ad2.full_name as updated_by',
            'customer_contract.contract_no',
            'customer.customer_name'
        )
            ->leftjoin('customer_contract', 'customer_contract.customer_contract_id', '=', $this->table.'.customer_contract_id')
            ->leftjoin('customer', 'customer.customer_id', '=', 'customer_contract.customer_id')
            ->leftjoin('contract_annex_file as caf', 'caf.customer_contract_annex_id', '=' , 'customer_contract_annex.customer_contract_id')
            ->join('admin as ad1', 'ad1.id', '=', 'customer_contract_annex.created_by' )
            ->join('admin as ad2', 'ad2.id', '=', 'customer_contract_annex.updated_by')
            ->where('customer_contract_annex.customer_contract_annex_id', $id)
            ->first();

        return $select;
    }

    public function updateData($id, $data)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }

}
