<?php


namespace Modules\Product\Models;

class InvoiceExtendsTable extends BaseModel
{
    protected $table = 'invoice_extends';
    protected $primaryKey = 'invoice_extends_id';
    public $timestamps = false;

    protected $fillable = ['invoice_extends_code','invoice_id','price','content','is_deleted','created_at', 'created_by','updated_at'];

    public function getByInvoice($invoice_id){
        return $this->select([
            $this->table.'.invoice_extends_code',
            $this->table.'.invoice_id',
            $this->table.'.price',
            $this->table.'.content',
            $this->table.'.is_deleted',
            $this->table.'.created_at',
            $this->table.'.updated_at',
            'admin.full_name as created_by'])
        ->join('admin', 'admin.id', $this->table.'.created_by')
        ->where($this->table.'.invoice_id', $invoice_id)
        ->where($this->table.'.is_deleted', 0)
        ->get();
    }
    public function getByInvoiceSum($invoice_id){
        return $this->select($this->fillable)->where($this->table.'.invoice_id', $invoice_id)->where($this->table.'.is_deleted', 0)->sum('price');
    }
    public function removeItem($invoice_extends_code){
        return $this->where($this->table. '.invoice_extends_code', $invoice_extends_code)->update(['is_deleted' => 1]);
    }
    public function getDetailByCode($invoice_extends_code){
        return $this->select($this->fillable)->where($this->table.'.invoice_extends_code', $invoice_extends_code)->first();
    }
    public function editItem($data, $invoice_extends_code){
        return $this->where($this->table.'.invoice_extends_code', $invoice_extends_code)->update($data);
    }
}
