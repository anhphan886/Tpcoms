<?php

namespace Modules\Vcloud\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleTaskTable extends Model
{
    protected $table = 'schedule_tasks';
    protected $primaryKey = 'id_task';
    protected $fillable = ['controller','function','params','customer_service_id',
    'run_at','created_at','is_operated','is_success','operate_log'];
    public $timestamps = false;
    public $control_list = [
        'ORGANIZATION' => '\\Modules\\Vcloud\\Api\\Organization\\OrgApi',
        'EDGENETWORK' => '\\Modules\\Vcloud\\Api\\EdgeNetwork\\EdgeNetworkApi',
        'VAPP' => '\\Modules\\Vcloud\\Api\\VApp\\VAppApi',
        'VDC' => '\\Modules\\Vcloud\\Api\\VDC\\VDCApi',
        'VCLOUD' => '\\Modules\\Vcloud\\Api\\Vcloud\\VcloudApi',
        'VM' => '\\Modules\\Vcloud\\Api\\VM\\VMApi'
    ];
    /**
     * Thêm schedule
     *
     * @param array $data
     * @return int
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }
    /**
     * edit schedule
     *
     * @param array $data
     * @return int
     */
    public function edit(array $data, $id)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }
    /**
     * get task not operated yet
     *
     * @param array $data
     * @return int
     */
    public function getNotOperated()
    {
        return $this->where($this->table.'.is_operated' , 0)->get()->toArray();
    }

    /**
     * get task not operated yet
     *
     * @param array $data
     * @return int
     */
    public function getFail()
    {
        return $this->where($this->table.'.is_success' , 0)->get()->toArray();
    }
    /**
     * get task not operated yet
     *
     * @param array $data
     * @return int
     */
    public function getFailAndNotOperate()
    {
        return $this->where($this->table.'.is_success' , 0)
        ->orWhere($this->table.'.is_operated' , 0)->get()->toArray();
    }
    /**
     * update log
     *
     * @param array $data
     * @return int
     */
    public function updateLog($log, $id)
    {
        $old = $this->where($this->primaryKey , $id)->first()->toArray();
        $oldLog = '';
        if(count($old) > 0){
            $oldLog = $old['operate_log'] ?? '';
        }
        //date("Y-m-d\_h:i:sa")
        $newLog = $oldLog .'\n'. date("Y-m-d\_h:i:sa") . ' - ' . $log;
        return $this->edit(['operate_log' =>  $newLog], $id);
    }
}
