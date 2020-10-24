<?php


namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class TicketTable extends Model
{
    use ListTableTrait;

    protected $table = 'ticket';
    protected $primaryKey = 'ticket_id';
    public $timestamps = false;

    protected $fillable
        = [
            'ticket_id', 'ticket_code', 'ticket_status_value', 'ticket_title',
            'description', 'issue_id', 'issue_level', 'crictical_level',
            'date_issue', 'date_estimated', 'date_expected', 'date_finished',
            'customer_service_id', 'customer_account_id', 'customer_id',
            'order_id', 'queue_process_id', 'operate_by', 'escalate_time',
            'platform', 'type', 'date_created', 'date_modified', 'created_by',
            'modified_by', 'is_deleted'
        ];

    public function getTicketCount($filters)
    {
        $select = $this->join('ticket_status as tstt', function ($join) {
            $join->on('tstt.ticket_status_value', '=', $this->table.'.ticket_status_value')
                ->where('tstt.is_deleted', 0);
        })
            ->join('ticket_queue as tq', function ($join) {
                $join->on('tq.ticket_queue_id', '=', $this->table.'.queue_process_id')
                    ->where('tq.is_deleted', 0);
            })
            ->select(
                $this->table.'.ticket_id',
                $this->table.'.ticket_code',
                $this->table.'.ticket_status_value',
                'tstt.ticket_status_name',
                $this->table.'.ticket_title',
                $this->table.'.description',
                $this->table.'.issue_id',
                $this->table.'.issue_level',
                $this->table.'.crictical_level',
                $this->table.'.date_issue',
                $this->table.'.date_estimated',
                $this->table.'.date_expected',
                $this->table.'.date_finished',
                $this->table.'.customer_service_id',
                $this->table.'.customer_account_id',
                $this->table.'.order_id',
                $this->table.'.queue_process_id',
                'tq.queue_name',
                $this->table.'.operate_by',
                $this->table.'.escalate_time',
                $this->table.'.platform',
                $this->table.'.type',
                $this->table.'.date_created',
                $this->table.'.date_modified',
                $this->table.'.created_by',
                $this->table.'.modified_by'
            )
//            ->whereIn($this->table.'.type', ['staff_support', 'cs_support'])
            ->whereDate($this->table.'.date_created', $filters['date']);
        return $select->count();
    }

    /**
     * Lấy danh sách ticket
     * @param $filter
     *
     * @return mixed
     */
    public function getTicket($filter)
    {
        $result = $this->join('ticket_status as tstt', function ($join) {
            $join->on('tstt.ticket_status_value', '=', $this->table.'.ticket_status_value')
                ->where('tstt.is_deleted', 0);
        })
            ->join('ticket_queue as tq', function ($join) {
                $join->on('tq.ticket_queue_id', '=', $this->table.'.queue_process_id')
                    ->where('tq.is_deleted', 0);
            })
            ->leftJoin('ticket_issue as tis', function ($join) {
                $join->on('tis.portal_ticket_issue_id', '=', $this->table.'.issue_id')
                    ->where('tis.is_deleted', 0);
            })
            ->select(
                $this->table.'.ticket_id',
                $this->table.'.ticket_code',
                $this->table.'.ticket_status_value',
                'tstt.ticket_status_name',
                $this->table.'.ticket_title',
                $this->table.'.description',
                $this->table.'.issue_id',
                'tis.issue_name_vi',
                'tis.issue_name_en',
                $this->table.'.issue_level',
                $this->table.'.crictical_level',
                $this->table.'.date_issue',
                $this->table.'.date_estimated',
                $this->table.'.date_expected',
                $this->table.'.date_finished',
                $this->table.'.customer_service_id',
                $this->table.'.customer_account_id',
                $this->table.'.order_id',
                $this->table.'.queue_process_id',
                'tq.queue_name',
                $this->table.'.operate_by',
                $this->table.'.escalate_time',
                $this->table.'.platform',
                $this->table.'.type',
                $this->table.'.date_created',
                $this->table.'.date_modified',
                $this->table.'.created_by',
                $this->table.'.modified_by'
            );
        if (isset($filter['created_at'])) {
            $result->where($this->table.'.date_created', '>', $filter['created_at']);
        }
        if (isset($filter['array_ticket_id']) && isset($filter['array_ticket_type'])) {
            $result->whereIn($this->table . '.' . $this->primaryKey, $filter['array_ticket_id']);
            if ($filter['array_ticket_type'] == 'ticket_process') {
                $result->join(
                    'ticket_processor',
                    'ticket_processor.ticket_id',
                    '=',
                    $this->table . '.' . $this->primaryKey
                )
                ->addSelect('ticket_processor.process_by');
            }
            $result->join('notification', function ($join) {
                $join->on('notification.object_id', '=',  $this->table . '.' . $this->primaryKey)
                    ->where('notification.notification_category_id', 1);
            });
            $result->addSelect('notification.notification_id');
        }
        return $result->get();
    }
}
