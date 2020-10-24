<?php

namespace Modules\Ticket\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class TicketIssueGroupTable extends Model
{
    use ListTableTrait;
    protected $table = 'ticket_issue_group';
    protected $primaryKey = 'portal_ticket_issue_group_id';
    protected $fillable = [
        'ticket_issue_group_id',
        'issue_group_name_vi',
        'issue_group_name_en',
        'queue_id',
        'date_created',
        'date_modified',
        'created_by',
        'modified_by',
        'is_deleted',
        'is_system',
    ];
    public $timestamps = false;
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';

    /**
     * Lấy danh sách nhóm vấn đề có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    protected function getListCore(array &$filters = [])
    {

        $select = $this->select(
            $this->table.'.portal_ticket_issue_group_id',
            $this->table.'.issue_group_name_vi',
            $this->table.'.issue_group_name_en',
            $this->table.'.date_created',
            $this->table.'.date_modified',
            $this->table.'.is_system',
            'ad1.full_name as created_by',
            'ad2.full_name as modified_by',
            'ticket_queue.queue_name',
            'ticket_queue.ticket_queue_id',
            'ticket_issue.portal_ticket_issue_group_id as tkisgID'
        )
            ->where('ticket_issue_group.is_deleted', 0)
            ->join('admin as ad1', 'ad1.id', '=', 'ticket_issue_group.created_by')
            ->join('admin as ad2', 'ad2.id', '=', 'ticket_issue_group.modified_by')
            ->leftJoin('ticket_queue', 'ticket_queue.ticket_queue_id', '=','ticket_issue_group.queue_id' )
            ->leftJoin('ticket_issue','ticket_issue.portal_ticket_issue_group_id', 'ticket_issue_group.portal_ticket_issue_group_id');

        if(isset($filters['keyword_ticket_issue_group$date_created']))
        {
            $tmp = Carbon::parse($filters['keyword_ticket_issue_group$date_created'])->format('Y-m-d');
            $select->where($this->table.'.date_created','like', '%' . $tmp.'%');
            unset($filters['keyword_ticket_issue_group$date_created']);
        }

        $select->groupBy('ticket_issue_group.portal_ticket_issue_group_id')->orderBy('ticket_issue_group.date_modified', 'desc');
//        dd($select->get()->toArray());
        return $select ;
    }

    /**
     * Lấy danh sách nhóm vấn đề không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = [])
    {
        $select = $this->getListCore($filters);
        if ($filters) {
            foreach ($filters as $key => $val) {
                if (trim($val) == ''||trim($val) == null) {
                    continue;
                }
                if (strpos($key, 'keyword_') !== false) {
                    $select->where(str_replace('$', '.', str_replace('keyword_', '', $key)), 'like', '%' . $val . '%');
                } elseif (strpos($key, 'sort_') !== false) {
                    $select->orderBy(str_replace('$', '.', str_replace('sort_', '', $key)), $val);
                } else {
                    $select->where(str_replace('$', '.', $key), $val);
                }
            }
        }
        return $select->get();
    }

    /**
     * Thêm nhóm vấn đề
     *
     * @param array $data
     * @return mixed
     */
    public function addItem(array $data)
    {
        return $this->create($data);
    }

    /**
     * get detail nhóm vấn đề
     *
     * @param int $portal_ticket_issue_group_id
     * @return mixed
     */
    public function  getDetail( $portal_ticket_issue_group_id)
    {
        return $this->LeftJoin('ticket_queue as tq', function ($join){
            $join->on('tq.ticket_queue_id', '=', $this->table.'.queue_id')
                ->where('tq.is_deleted',0);
        })
                ->where($this->primaryKey, $portal_ticket_issue_group_id)
                ->select(
                    $this->table.'.portal_ticket_issue_group_id',
                    $this->table.'.issue_group_name_vi',
                    $this->table.'.issue_group_name_en',
                    $this->table.'.queue_id',
                    $this->table.'.is_deleted',
                    'tq.ticket_queue_id',
                    'tq.queue_name'
                )
            ->first();
    }
    /**
     * update nhóm vấn đề
     *
     * @param array $data
     * @param int $portal_ticket_issue_group_id
     * @return mixed
    **/
    public function updateIssueGroup(array $data, $portal_ticket_issue_group_id)
    {
        return $this->where($this->primaryKey, $portal_ticket_issue_group_id)->update($data);
    }

    /**
     * deleted issue group where is_system !=1
    */

}
