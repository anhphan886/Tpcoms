<?php

namespace Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;

class TicketProcessorTable extends Model
{
    protected $table = 'ticket_processor';
    protected $primaryKey = 'ticket_processor_id';
    protected $fillable = ['ticket_processor_id','ticket_id','process_by','date_created','date_modified','created_by','modified_by','is_deleted'];
    public function getListAll(array $condition = [])
    {
        $result = $this->join('ticket as tk', function ($join) {
            $join->on('tk.ticket_id', '=', $this->table.'.ticket_id')
                ->where('tk.is_deleted', 0);
        })
            ->where($this->table.'.is_deleted', 0);

        if (count($condition) > 0) {
            $result->where($condition);
        }

        $result->select(
            $this->table.'.ticket_processor_id',
            $this->table.'.ticket_id',
            'tk.ticket_status_value',
            $this->table.'.process_by'
        );

        return $result->get();
    }
    public function getDetail($id){
        return $this->select($this->fillable)->where($this->primaryKey, $id)->first();
    }
}
