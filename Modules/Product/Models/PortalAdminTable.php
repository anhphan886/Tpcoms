<?php


namespace Modules\Product\Models;


use Illuminate\Database\Eloquent\Model;

class PortalAdminTable extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';

    protected $fillable
        = [
            'id', 'full_name', 'email', 'password', 'remember_token',
            'is_admin', 'is_change_pass', 'is_actived', 'is_deleted',
            'created_at', 'updated_at', 'deleted_at', 'deleted_by'
        ];

    public function getOption()
    {
        $select = $this->select('id', 'email', 'full_name')
            ->where('is_deleted', 0)
            ->where('is_actived', 1)
            ->get();
        return $select;
    }
    public function getEmailById($id)
    {
        $select = $this->select('email', 'full_name')
            ->where($this->primaryKey, $id)
            ->first();
        return $select['email'];
    }

    /**
     * Get item
     * @param $id
     *
     * @return mixed
     */
    public function getItem($id)
    {
        $select = $this->select('email', 'full_name')
            ->where($this->primaryKey, $id)
            ->first();
        return $select;
    }

}
