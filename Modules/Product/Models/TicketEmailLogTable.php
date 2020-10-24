<?php


namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Modules\Core\Models\MailCore;

class TicketEmailLogTable extends MailCore
{
    public $timestamps = false;
    protected $table = 'ticket_email_log';
    protected $primaryKey = 'ticket_email_log_id';
    protected $fillable = [
        'ticket_email_log_id', 'ticket_id', 'ticket_code', 'from_address', 'to_address',
        'cc_address', 'sent_email', 'subject', 'body_html', 'body',
        'file_attach', 'sent_by', 'date_created', 'date_modified',
        'is_sent', 'date_sent', 'date_overtime',
    ];
    /**
     * Thêm email.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    public function sent($ticket_email_log_id, $date_send = null)
    {
        if($date_send==null){
            $data_send = Carbon::now();
        }
        return $this->where($this->primaryKey, $ticket_email_log_id)->update([
            'is_sent' => 1,
            'date_send' => $date_send
        ]);
    }

    public function getByTicketId($ticket_id, $date_overtime){
        return $this->select($this->fillable)
        ->where($this->table.'.ticket_id', '=' , $ticket_id)
        ->where($this->table.'.date_overtime', '=' , $date_overtime)->get();
    }
}
