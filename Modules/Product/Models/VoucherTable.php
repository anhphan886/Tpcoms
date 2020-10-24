<?php


namespace Modules\Product\Models;


use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class VoucherTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'vouchers';
    protected $primaryKey = 'voucher_id';

    protected $fillable
        = ['voucher_id', 'code', 'is_all', 'type', 'percent', 'cash',
            'max_price', 'required_price', 'object_type', 'object_type_id',
            'expired_date', 'branch_id', 'quota', 'total_use', 'is_actived'
            , 'is_deleted', 'created_by', 'updated_by', 'created_at', 'updated_at', 'slug'];

    public function insertItem($data){
        return $this->insertGetId($data);
    }

    /**
     * Get list voucher
     *
     * @return mixed
     */
    protected function getListCore(&$filters)
    {
        $select = $this->select(
            'vouchers.voucher_id',
            'vouchers.code',
            'vouchers.type',
            'vouchers.percent',
            'vouchers.total_use',
            'vouchers.cash',
            'vouchers.expired_date',
            'vouchers.quota',
            'vouchers.is_actived',
            'order.voucher_code'
        )
            ->leftJoin('vouchers_log', 'vouchers_log.voucher_id','=','vouchers.voucher_id')
            ->leftJoin('order', 'order.voucher_code', '=', 'vouchers.code');

        if (isset($filters['vouchers$code'])) {
            if ($filters['vouchers$code'] != '') {
                $select->where(function ($query) use ($filters) {
                    $query->where(
                        'vouchers.code', 'like', '%' . $filters['vouchers$code'] . '%'
                    );
                });
                unset($filters['vouchers$code']);
            }
        }
        $select->where('vouchers.is_deleted',0)
            ->groupBy('vouchers.voucher_id')
            ->orderBy('vouchers.voucher_id', 'desc');

        return $select;
    }

    /**
     * Thêm mới
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
     * get list voucher by id
     * @param $id
     *
     * @return mixed
     */
    public function getItemById($id)
    {
        $select = $this->select(
            'vouchers.voucher_id',
            'vouchers.code',
            'vouchers.type',
            'vouchers.percent',
            'vouchers.total_use',
            'vouchers.cash',
            'vouchers.expired_date',
            'vouchers.quota',
            'vouchers.is_actived',
            'vouchers.required_price',
            'vouchers.max_price'
        )
            ->leftJoin('vouchers_log', 'vouchers_log.voucher_id', '=', 'vouchers.voucher_id')
            ->where('vouchers.voucher_id',$id);
//        dd($select);
        return $select->first();
    }
    /**
     * edit
     * @param array $data
     * @param       $id
     *
     * @return mixed
     */
    public function edit(array $data, $id)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }

    public function changeStatus(array $data, $id)
    {
        return $this->where('voucher_id', $id)->update($data);
    }
}
