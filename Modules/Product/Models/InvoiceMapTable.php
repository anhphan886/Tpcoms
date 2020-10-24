<?php


namespace Modules\Product\Models;


use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class InvoiceMapTable extends Model
{
    use ListTableTrait;
    protected $table = 'invoice_map';
    protected $primaryKey = 'invoice_map_id';

    public $timestamps = false;

    protected $fillable = [
        'invoice_map_id',
        'invoice_id',
        'receipt_id',
        'net',
        'vat',
        'amount',
        ];

    /**
     * Thêm mới
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }


}
