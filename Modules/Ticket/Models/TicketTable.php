<?php

namespace Modules\Ticket\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class TicketTable extends Model
{
    use ListTableTrait;

    protected $table = 'ticket';
    protected $primaryKey = 'ticket_id';
    protected $fillable = [
        'ticket_id',
        'ticket_code',
        'ticket_status_value',
        'ticket_title',
        'description',
        'issue_id',
        'issue_level',
        'crictical_level',
        'date_issue',
        'date_estimated',
        'date_expected',
        'date_finished',
        'customer_service_id',
        'customer_account_id',
        'customer_id',
        'order_id',
        'queue_process_id',
        'operate_by',
        'escalate_time',
        'platform',
        'date_created',
        'date_modified',
        'created_by',
        'modified_by',
        'is_deleted',
    ];
    public $timestamps = false;

    /**
     * Lấy danh sách ticket có phân trang (từ ListTableTrait)
     *
     * @param array $filters
     * @return mixed
     */
    protected function getListCore(array $filters = [])
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
                $this->table.'.date_created',
                $this->table.'.date_modified',
                $this->table.'.created_by',
                $this->table.'.modified_by'
            );

        return $result;
    }

    /**
     * Lấy danh sách ticket không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->getListCore();

        if (count($filters) > 0) {
            $result->where($filters);
        }

        return $result->get();
    }

    /**
     * Lấy danh sách ticket và đếm số ticket có cùng trạng thái
     *
     * @return mixed
     */
    public function getTotalGroupByStatus()
    {
        $result = $this->join('ticket_status as tstt', function ($join) {
            $join->on('tstt.ticket_status_value', '=', $this->table.'.ticket_status_value')
                ->where('tstt.is_deleted', 0);
        })
            ->where($this->table.'.is_deleted', 0)
            ->groupBy(
                $this->table.'.ticket_status_value',
                'tstt.ticket_status_name'
            )
            ->selectRaw("
                portal_tstt.ticket_status_name,
                portal_ticket.ticket_status_value,
                COUNT(portal_ticket.ticket_status_value) as total
            ")
            ->get();

        return $result;
    }

    /**
     * Lấy danh sách ticket kèm theo processors
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|TicketTable[]
     */
    public function getTicketWithProcessor(array $filters = [])
    {
        $result= $this->getListCore();
        $result->with(['processors' => function ($q) {
            $q->where('ticket_processor.is_deleted', 0);
        }])
            ->doesntHave('processors');


        $page    = (int) ($filters['page'] ?? 1);
        $display = (int) ($filters['perpage'] ?? PAGING_ITEM_PER_PAGE);

        unset($filters['page'], $filters['perpage']);

        if (count($filters) > 0) {
            foreach ($filters as $key => $val) {
                if (trim($val) == '' || $key == 'keyword') {
                    continue;
                }

                if (strpos($key, 'keyword_') !== false) {
                    $result->where(str_replace('$', '.', str_replace('keyword_', '', $key)), 'like', '%' . $val . '%');
                } elseif (strpos($key, 'sort_') !== false) {
                    $result->orderBy(str_replace('$', '.', str_replace('sort_', '', $key)), $val);
                } else {
                    $result->where(str_replace('$', '.', $key), $val);
                }
            }
        }

        return $result->paginate($display, $columns = ['*'], $pageName = 'page', $page);
    }

    /**
     * Quan hệ 1 nhiều giữa ticket và processors
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function processors()
    {
        return $this->hasMany(
            'Modules\Ticket\Models\TicketProcessorTable',
            'ticket_id'
        );
    }
    public function detail($id){
        return $this->where($this->primaryKey, $id)->first();
    }

    public function mailExport($ticketId, $comment = false){
        $arr = $this->select(
            $this->table.'.ticket_id',
            $this->table.'.ticket_code',
            $this->table.'.ticket_status_value',
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
            $this->table.'.customer_id',
            $this->table.'.customer_id',
            $this->table.'.order_id',
            $this->table.'.queue_process_id',
            $this->table.'.operate_by',
            $this->table.'.escalate_time',
            $this->table.'.platform',
            $this->table.'.date_created',
            $this->table.'.date_modified',
            $this->table.'.created_by',
            $this->table.'.modified_by',
            $this->table.'.is_deleted',
            'customer.customer_no',
            'customer.customer_name',
            'customer_service.customer_service_id',
            'customer_service.product_id',
            'product.product_name_vi',
            'ticket_issue.issue_name_vi',
            'ticket_status.ticket_status_name',
            'ticket_queue.queue_name',
            'issue_level_value',
            'admin.full_name as ticket_creator',
            'creator_queue.queue_name as creator_queue'
        )->where($this->table.'.'.$this->primaryKey, $ticketId)
        ->leftJoin('customer', 'customer.customer_id','=',$this->table.'.customer_id')
        ->leftJoin('customer_service','customer_service.customer_service_id','=',$this->table.'.customer_service_id')
        ->leftJoin('product', 'customer_service.product_id' , '=','product.product_id')
        ->leftJoin('ticket_issue','ticket_issue.portal_ticket_issue_id','=',$this->table.'.issue_id')
        ->leftJoin('ticket_issue_level', 'ticket_issue_level.portal_ticket_issue_level_id','=', $this->table.'.issue_level')
        ->leftJoin('ticket_status', 'ticket_status.ticket_status_value', '=', $this->table.'.ticket_status_value')
        ->leftJoin('ticket_queue','ticket_queue.ticket_queue_id','=', $this->table.'.queue_process_id')
        ->leftJoin('admin' , 'admin.id','=',$this->table.'.created_by')
        ->leftJoin('ticket_staff_queue', 'ticket_staff_queue.staff_id', '=', $this->table.'.created_by')
        ->leftJoin('ticket_queue as creator_queue', 'creator_queue.ticket_queue_id' , '=', 'ticket_staff_queue.queue_id')
        ->first()->toArray();
        $processors = $this
                        ->select(
                            'admin.full_name',
                            'ticket_processor.ticket_processor_id'
                        )
                            ->join('ticket_processor' , 'ticket_processor.ticket_id','=',$this->table.'.ticket_id')
                            ->join('admin','admin.id' , '=', 'ticket_processor.process_by')
                            ->groupBy('ticket_processor.ticket_processor_id')
                            ->where($this->table.'.ticket_id', $ticketId)
                    ->get()->toArray();
        $arr['processors'] = $processors;
        $arr['comment'] = $comment;
        return ['employee_mail' => view('ticket::mail.send-employee', ['data' => $arr, 'host' => request()->getSchemeAndHttpHost()])->render(),
        'user_mail' => view('ticket::mail.send-user', ['data' => $arr, 'host' => request()->getSchemeAndHttpHost()])->render(),
            'mail_warning' => view('ticket::mail.mail-warning', ['data' => $arr, 'host' => request()->getSchemeAndHttpHost()])->render()];
    }

    /**
     * function get survey ticket
    */
    public function getSurvey($ticket_id)
    {
        return $this->join('ticket_survey as tv', function ($join) {
            $join->on('tv.ticket_id', '=', $this->table.'.ticket_id');
        })
            ->join('customer_account as ca', function ($join){
                $join->on('ca.customer_account_id', '=', 'tv.customer_account_id');
            })
            ->where($this->table.'.'.$this->primaryKey, $ticket_id)
            ->select(
                'tv.point',
                'tv.comment',
                'tv.created_at',
                'tv.updated_at',
                'ca.account_name'
            )->get();
    }
    /**
     * lấy chi tiết ticket, kiểm tra ticket quá thời gian xử lý
     */
    public function detailTicketCheckDate()
    {
        $arr = $this->select(
            $this->table.'.ticket_id',
            $this->table.'.ticket_code',
            $this->table.'.ticket_status_value',
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
            $this->table.'.customer_id',
            $this->table.'.customer_account_id',
            $this->table.'.order_id',
            $this->table.'.queue_process_id',
            $this->table.'.operate_by',
            $this->table.'.escalate_time',
            $this->table.'.platform',
            $this->table.'.date_created',
            $this->table.'.date_modified',
            $this->table.'.created_by',
            $this->table.'.modified_by',
            $this->table.'.is_deleted',
            'ticket_queue.email_address as queue_email'
        )->leftJoin('ticket_queue','ticket_queue.ticket_queue_id', '=', $this->table.'.queue_process_id')
        ->where($this->table.'.date_estimated', '<=', date('Y-m-d H:i:s'))
        ->whereIn($this->table.'.ticket_status_value', [1,2])->groupBy($this->table.'.ticket_id')
        ->get()->toArray();
        return $arr;
    }
}
