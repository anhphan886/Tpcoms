<?php

namespace Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;

class TiketStaffQueueTable extends Model
{
    protected $table = 'ticket_staff_queue';
    protected $primaryKey = 'ticket_staff_queue_id';
    public $timestamps = false;
    protected $fillable = [
        'staff_id',
        'queue_id',
        'role',
    ];
    /**
     * Lấy danh sách nhân viên theo queue
     *
     * @param int $queueId
     * @return mixed
     */
    public function getListStaffByQueue($queueId)
    {
        return $this->where($this->table.'.queue_id', $queueId)
            ->join('ticket_queue as qu', function ($join) {
                $join->on('qu.ticket_queue_id', '=', $this->table.'.queue_id')
                    ->where('qu.is_deleted', 0);
            })
            ->join('admin as ad', function ($join) {
                $join->on('ad.id', '=', $this->table.'.staff_id')
                    ->where('ad.is_deleted', 0);
            })
            ->select(
                'ticket_staff_queue_id',
                'role',
                'qu.queue_name',
                'qu.ticket_queue_id',
                'ad.full_name',
                'ad.id'
            )
            ->get();
    }

    /**
     * Thêm staff queue
     *
     * @param array $data
     * @return mixed
     */
    public function addStaff(array $data)
    {
        return $this->create($data);
    }

    /**
     * edit staff by queue
     *
     * @param array $data
     * @return mixed
     */
    public function editStaff(array $data, $queueId)
    {
        $result = $this->where('ticket_staff_queue.queue_id', $queueId)->update($data);
        return $result;
    }

    /**
     * delete staff by queue
     *
     * @param array $data
     * @return mixed
     */
    public function deleteStaffByQueue($queueID)
    {
        $result =$this->where('ticket_staff_queue.queue_id', $queueID)->delete();
        return $result;
    }

    public function getListAll()
    {
        $result = $this->select(
            $this->table.'.ticket_staff_queue_id as tsq',
            $this->table.'.staff_id',
            $this->table.'.queue_id',
            $this->table.'.role',
            'admin.full_name',
            'pts.queue_name'
        )
            ->join('admin', 'admin.id', '=', 'ticket_staff_queue.staff_id')
            ->join('ticket_queue as pts', 'pts.ticket_queue_id', '=', 'ticket_staff_queue.queue_id')
            ->get();
        return $result;
    }

    public function getOperatorByID($id)
    {
        $result = $this->select(
            $this->table.'.staff_id'
        )
            ->where($this->table.'.role', 'operator')
            ->where($this->table.'.queue_id', $id)
            ->get();

        return $result;
    }
}
