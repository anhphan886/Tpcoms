<?php


namespace Modules\Core\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseCoreModel extends Model
{
    public function getListAllItem(){
        $oSelect = $this->get();
        return $this->getResultToArray($oSelect);
    }
    public function getDetailWhereInToArray($arrData, $field){
        $oSelect = $this->whereIn($field, $arrData)->get();
        return $this->getResultToArray($oSelect);
    }

    public function getDetailsToArray($id, $field){
        $oSelect = $this->where($field, $id)->get();
        return $this->getResultToArray($oSelect);
    }

    public function getDetailToArray($id, $field){
        $oSelect = $this->where($field, $id);
        return $this->getFirstResultToFirst($oSelect);
    }

    public function getNumberForCode(){
        return $this->getTotalItem() + 1;
    }
    public function getTotalItem(){
        $now = Carbon::now()->format('Y-m-d');
        return $this->whereDate('created_at', $now)->get()->count();
    }

    public function getDetailToObj($id, $field){
        return $this->where($field, $id)->first();
    }

    public function updateItem($id, $field, $data){
        return $this->where($field, $id)->update($data);
    }

    public function insertItem($data){
        return $this->insertGetId($data);
    }

    public function deleteItem($id, $field){
        return $this->where($field, $id)->delete();
    }

    public function deleteItemArray($arrData, $field){
        return $this->whereIn($field, $arrData)->delete();
    }

    public function getResultToArray($oSelect){
        if($oSelect->count()){
            return $oSelect->toArray();
        }

        return [];
    }

    public function getFirstResultToFirst($oSelect){
        if($oSelect->count()){
            return $oSelect->first()->toArray();
        }
        return [];
    }
}
