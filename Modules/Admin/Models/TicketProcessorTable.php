<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class TicketProcessorTable extends Model
{
    protected $table = 'ticket_processor';
    protected $primaryKey = 'ticket_processor_id';
    protected $fillable = ['ticket_processor_id','ticket_id','process_by','date_created','date_modified','created_by','modified_by','is_deleted'];

    /**
     * Lấy nhân viên xử lý theo ticket_id
     * @param $ticket_id
     *
     * @return mixed
     */
    public function getByTicketId($ticket_id)
    {
        return $this->select($this->fillable)->where('ticket_id', $ticket_id)->get();
    }
}
