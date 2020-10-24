<?php

namespace Modules\Ticket\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;
use function foo\func;

class TicketIssueTable extends Model
{
    use ListTableTrait;

    protected $table = 'ticket_issue';
    protected $primaryKey = 'portal_ticket_issue_id';
    protected $fillable = [
        'portal_ticket_issue_id',
        'issue_name_vi',
        'issue_name_en',
        'portal_ticket_issue_group_id',
        'portal_ticket_issue_level_id',
        'process_time',
        'crictical_time2',
        'crictical_time3',
        'crictical_time4',
        'queue_id',
        'date_created',
        'date_modified',
        'created_by',
        'modified_by',
        'is_deleted',
        'is_system'
    ];
    public $timestamps = false;
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';

    /**
     * Lấy danh sách vấn đề có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    protected function getListCore(&$filters = [])
    {
       $select = $this->select(
           $this->table.'.portal_ticket_issue_id',
           $this->table.'.issue_name_vi',
           $this->table.'.issue_name_en',
           $this->table.'.process_time',
           $this->table.'.crictical_time2',
           $this->table.'.crictical_time3',
           $this->table.'.crictical_time4',
           $this->table.'.date_created',
           $this->table.'.date_modified',
           $this->table.'.is_system',
           'ad1.full_name as created_by',
           'ad2.full_name as modified_by',
           'ptig.issue_group_name_vi as igname_vi',
           'ptig.issue_group_name_en as igname_en',
           'ptil.issue_level_value as level',
           'ticket.issue_id'
       )
           ->where('ticket_issue.is_deleted', 0)
           ->leftJoin('admin as ad1', 'ad1.id', '=', 'ticket_issue.created_by')
           ->leftJoin('admin as ad2', 'ad2.id', '=', 'ticket_issue.modified_by')
           ->leftJoin('ticket_issue_group as ptig', 'ptig.portal_ticket_issue_group_id', '=', 'ticket_issue.portal_ticket_issue_group_id' )
           ->leftJoin('ticket_issue_level as ptil', 'ptil.portal_ticket_issue_level_id',  '=', 'ticket_issue.portal_ticket_issue_level_id' )
           ->leftJoin('ticket', 'ticket.issue_id', '=', 'ticket_issue.portal_ticket_issue_id' );

        if (isset($filters['keyword_ticket_issue$date_created']))  {
//            dd($filters['keyword_ticket_queue$date_created']);
                $tmp = Carbon::parse($filters['keyword_ticket_issue$date_created'])->format('Y-m-d');
                $select->where($this->table.'.date_created','like', '%' . $tmp.'%');
                unset($filters['keyword_ticket_issue$date_created']);
        }
        return $select->groupBy('ticket_issue.portal_ticket_issue_id')->orderBy('date_modified', 'desc');
    }

    /**
     * Lấy danh sách vấn đề không phân trang
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
     * Lấy chi tiết vấn đề
     *
     * @param $issueId
     * @return mixed
     */
    public function getDetail($portal_ticket_issue_id)
    {
        return $this->leftjoin('ticket_issue_level as lv', function($join){
            $join->on('lv.portal_ticket_issue_level_id', '=', $this->table.'.portal_ticket_issue_level_id')
                ->where('lv.is_deleted', 0);
        })
            ->leftjoin('ticket_queue as tq', function($join){
                $join->on('tq.ticket_queue_id', '=', $this->table.'.queue_id')
                    ->where('tq.is_deleted', 0);
            })
            ->leftjoin('ticket_issue_group as tig', function($join){
                $join->on('tig.portal_ticket_issue_group_id', '=', $this->table.'.portal_ticket_issue_group_id')
                    ->where('tig.is_deleted', 0);
            })
            ->where($this->table.'.'.$this->primaryKey, $portal_ticket_issue_id)
            ->select (
                $this->table.'.portal_ticket_issue_id',
                $this->table.'.issue_name_vi',
                $this->table.'.issue_name_en',
                $this->table.'.portal_ticket_issue_group_id',
                $this->table.'.portal_ticket_issue_level_id',
                $this->table.'.process_time',
                $this->table.'.crictical_time2',
                $this->table.'.crictical_time3',
                $this->table.'.crictical_time4',
                $this->table.'.queue_id',
                $this->table.'.date_created',
                $this->table.'.date_modified',
                $this->table.'.created_by',
                $this->table.'.modified_by',
                'lv.portal_ticket_issue_level_id',
                'lv.issue_level_value',
                'tq.ticket_queue_id',
                'tq.queue_name',
                'tig.portal_ticket_issue_group_id',
                'tig.issue_group_name_vi as igname_vi',
                'tig.issue_group_name_en as igname_en'
            )
            ->first();
    }

    /**
     * Thêm vấn đề
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data);
    }

    /**
     * update issue
     *
     * @param arrray $data
     * @param int $portal_ticket_issue_id
     * @return mixed
    */
    public function updateIssue(array $data, $portal_ticket_issue_id)
    {
        return $this->where($this->primaryKey, $portal_ticket_issue_id)->update($data);
    }


}
