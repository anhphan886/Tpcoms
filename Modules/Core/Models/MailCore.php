<?php


namespace Modules\Core\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class MailCore extends Model
{
    public function getList($array, $is_sent){

      $select =  $this->select($array)->where($this->table.'.'.$is_sent, 0);
      return $select;
    }
    public function updateByAttribute($id, $attribute, $value){
        return $this->where('id', $id)->update($attribute, $value);
    }
}
