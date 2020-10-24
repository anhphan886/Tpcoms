<?php

namespace Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;

class TicketIssueLevelTable extends Model
{
    protected $table = 'ticket_issue_level';
    protected $primaryKey = 'portal_ticket_issue_level_id';
    protected $fillable = [
        'is_deleted',
    ];
    /**
     * Lấy danh sách cấp độ sự cố
     *
     * @return mixed
     */
    public function getListAll()
    {
        return $this->where('is_deleted', 0)->get();
    }
}
