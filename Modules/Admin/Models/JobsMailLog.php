<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Modules\Core\Models\MailCore;

class JobsMailLog extends MailCore
{
    public $timestamps = false;
    protected  $table = 'jobs_email_log';
    protected $primaryKey = 'jobs_email_id';
    protected $fillable = [
        'jobs_email_id',
        'obj_id',
        'template_type',
        'template_path',
        'email_type',
        'email_subject',
        'email_from',
        'email_to',
        'email_cc',
        'email_body',
        'email_params',
        'email_attach',
        'created_at',
        'is_sent',
        'date_sent',
    ];

    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    public function sent($jobs_email_id, $date_send = null)
    {
        if($date_send==null){
            $date_send = Carbon::now();
        }
        return $this->where($this->primaryKey, $jobs_email_id)->update([
            'is_sent' => 1,
            'date_send' => $date_send
        ]);
    }

    public function getDetailByID($jobs_email_id)
    {
        return $this->select($this->fillable)
            ->where($this->table.'.jobs_email_id', $jobs_email_id);
    }
}
