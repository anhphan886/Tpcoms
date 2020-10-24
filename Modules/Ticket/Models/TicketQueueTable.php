<?php

namespace Modules\Ticket\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class TicketQueueTable extends Model
{
    use ListTableTrait;
    protected $table = 'ticket_queue';
    protected $primaryKey = 'ticket_queue_id';
    protected $fillable = [
        'ticket_queue_id',
        'queue_name',
        'description',
        'email_address',
        'email_password',
        'date_created',
        'date_modified',
        'created_by',
        'modified_by',
        'is_deleted',
    ];
    public $timestamps = false;

    /**
     * Lấy danh sách queue có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    protected function getListCore(&$filters = [])
    {

        $select = $this->select(
            $this->table.'.ticket_queue_id',
            $this->table.'.queue_name',
            $this->table.'.description',
            $this->table.'.email_address',
            $this->table.'.date_created',
            $this->table.'.date_modified',
            'ad1.full_name as created_by',
            'ad2.full_name as modified_by',
            'ticket.queue_process_id',
            'ticket_issue.queue_id'
        )
            ->where('ticket_queue.is_deleted', 0)
            ->join(
                'admin as ad1',
                'ad1.id',
                '=',
                'ticket_queue.created_by'
            )
            ->join(
                'admin as ad2',
                'ad2.id',
                '=',
                'ticket_queue.modified_by'
            )->leftJoin(
                'ticket',
                'ticket.queue_process_id',
                '=',
                'ticket_queue.ticket_queue_id'
            )
            ->leftJoin(
                'ticket_issue',
                'ticket_issue.queue_id',
                '=',
                'ticket_queue.ticket_queue_id'
            );
        if(isset($filters['keyword_ticket_queue$date_created']))
        {
            $tmp = Carbon::parse($filters['keyword_ticket_queue$date_created'])->format('Y-m-d');
            $select->where($this->table.'.date_created','like', '%' . $tmp.'%');
            unset($filters['keyword_ticket_queue$date_created']);
        }
        $select->groupBy('ticket_queue.ticket_queue_id')->orderBy('ticket_queue.date_modified', 'desc');

        return $select;
    }

    /**
     * Lấy danh sách queue không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->getListCore();

        return $result->get();
    }


    /**
     * Lấy danh sách queue kèm theo danh sách ticket
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|TicketQueueTable[]
     */
    public function getListWithTicket()
    {
        $result = $this->with(['tickets' => function ($q) {
            $q->where('ticket.is_deleted', 0);
        }])
            ->get();

        return $result;
    }

    /**
     * Quan hệ 1 nhiều giữa queue và ticket_queue
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(
            'Modules\Ticket\Models\TicketTable',
            'queue_process_id'
        );
    }

    /**
     * Thêm queue
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    /**
     * Lấy thông tin chi tiết Queue
     *
     * @param int $ticket_queue_id
     * @return mixed
    */
    public function getDetai($ticket_queue_id)
    {
        $result = $this->where($this->primaryKey, $ticket_queue_id)
                ->where('is_deleted', 0)
                ->select(
                    'ticket_queue_id',
                    'queue_name',
                    'description',
                    'email_address',
                    'is_deleted'
                )
            ->first();
//        dd($result);
        return $result;
    }


    /**
     * Chỉnh sữa queue
     *
     * @param array $data
     * @param int $ticket_queue_id
     * @return mixed
    */
    public  function edit(array $data, $ticket_queue_id)
    {
        $result = $this->where($this->primaryKey, $ticket_queue_id)->update($data);

        return $result;
    }

}
