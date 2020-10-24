<?php


namespace Modules\Product\Models;


use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\MailCore;

class ReceiptEmailLogTable extends MailCore
{
    protected $table = 'receipt_email_log';
    protected $primaryKey = 'receipt_email_log_id';
    public $timestamps = false;

    protected $fillable
        = [
            'receipt_email_log_id', 'obj_id', 'obj_code', 'from_address',
            'to_address', 'cc_address', 'sent_email', 'subject', 'body_html',
            'body', 'file_attach', 'sent_by', 'date_created', 'date_modified',
            'date_overtime', 'is_sent', 'date_sent', 'obj_type', 'pay_expired'
        ];

    /**
     * add
     *
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    public function getEmailReceiptExpired($dateTime)
    {
        $select = $this->select('obj_id')
            ->where('obj_type', 'receipt_expired')
            ->whereDate('pay_expired', $dateTime);
        return $this->getResultToArray($select->get());
    }
}
