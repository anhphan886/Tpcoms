<?php

namespace Modules\Product\Models;

use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use MyCore\Models\Traits\ListTableTrait;

class ProvinceTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'province';
    protected $primaryKey = 'provinceid';
    public $timestamps = false;
    protected $fillable
        = [
           'provinceid',
            'name',
            'type',
            'location_id',
        ];

    /**
     * get list all province
    */
    public function getLisAllProvince()
    {
        $select = $this->select(
            'provinceid',
            'name',
            'type',
            'location_id'
        )->get();
        return $select;
    }

}
