<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use MyCore\Models\Traits\ListTableTrait;

class SegmentTable extends Model
{
    use ListTableTrait;
    protected $table = 'segment';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable
        = ['id', 'name', 'name_en', 'created_at','created_by', 'updated_at', 'updated_by', 'is_deleted'];

    /**
     * Danh sách lĩnh vực
     *
     * @param $filters
     *
     * @return mixed
     */
    public function getListCore(&$filters)
    {
        $select = $this->select(
            $this->table.'.id',
            $this->table.'.name',
            $this->table.'.name_en',
            $this->table.'.created_at',
            $this->table.'.updated_at',
            'ad1.full_name as created_by',
            'ad2.full_name as updated_by',
            'customer.segment_id as cus_segment_id',
            'customer.customer_name'
        )
            ->leftJoin('admin as ad1', 'ad1.id','=', 'segment.created_by')
            ->leftJoin('admin as ad2', 'ad2.id', '=', 'segment.updated_by')
            ->leftJoin('customer', 'customer.segment_id', '=', 'segment.id')
            ->where($this->table . '.is_deleted', 0);

        if (isset($filters['keyword'])) {
            if ($filters['keyword'] != null && $filters['keyword'] != '') {
                $select->where(
                    DB::raw('upper(portal_segment.name)'), 'like',
                    '%' . strtoupper($filters['keyword']) . '%'
                );
            }
            unset($filters['keyword']);
        }
        $select->groupBy('segment.id')->orderBy($this->table.'.updated_at', 'desc');
        return $select;
    }

    /**
     * Option.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getOption()
    {
        $select = $this->select(
            'id',
            'name',
            'name_en'
        )
        ->where('segment.is_deleted',0)
        ->get();
        return $select;

    }

    public function getItem($id)
    {
        $select = $this->select(
            $this->table.'.id',
            $this->table.'.name',
            $this->table.'.name_en',
            $this->table.'.created_at',
            $this->table.'.updated_at',
            'ad1.full_name as created_by',
            'ad2.full_name as updated_by',
            'customer.segment_id as cus_segment_id',
            'customer.customer_name'
        )
            ->leftJoin('admin as ad1', 'ad1.id','=', 'segment.created_by')
            ->leftJoin('admin as ad2', 'ad2.id', '=', 'segment.updated_by')
            ->leftJoin('customer', 'customer.segment_id', '=', 'segment.id')
            ->where($this->table . '.is_deleted', 0)
            ->where('segment.id', $id)
            ->first();
        return $select;
    }

    /**
     * them linh vực
    */
    public function add($data)
    {
        $result = $this->create($data)->{$this->primaryKey};
        return $result;
    }

    /**
     * update lĩnh vực
    **/
    public function editSegment($id, $data)
    {
        $result = $this->where($this->primaryKey, $id)->update($data);
        return $result;
    }
}
