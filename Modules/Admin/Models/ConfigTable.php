<?php


namespace Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class ConfigTable extends Model
{
    protected $table = 'config';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['id', 'name', 'key', 'value', 'type', 'created_at', 'updated_at'];

    /**
     * Lấy hết config
     * @return mixed
     */
    public function getAll()
    {
        return $this->select($this->fillable)->get();
    }

    public function edit(array $data, $id)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }
    public function updateByKey($key, $value)
    {
        return $this->where($this->table. '.key', $key)->update(['value' => $value]);
    }

    public function getItem($id)
    {
        $select = $this->select($this->fillable)
            ->where($this->table . '.id', $id);
        return $select->first();
    }
}
