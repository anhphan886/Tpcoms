<?php


namespace Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class SegmentTable extends Model
{
    protected $table = 'segment';
    protected $primaryKey = 'id';

    public function getOption()
    {
        return $this->select('id', 'name')
            ->where('is_deleted', 0)->get();
    }
}
