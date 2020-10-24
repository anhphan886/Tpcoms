<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class LockOutTable extends Model
{
    use ListTableTrait;
    protected $table = 'admin_lock_out';
    protected $primaryKey = 'lock_out_id';
}
