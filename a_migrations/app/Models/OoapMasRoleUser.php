<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasRoleUser extends Model
{
    protected $table = 'ooap_mas_role_user';

    protected $primaryKey = 'role_user_id';

    protected $fillable = [
        'role_id', 'role_level_id', 'username', 'fname', 'lname', 'dept_id', 'costcenter', 'status', 'create_by', 'create_date', 'update_by', 'update_date'
    ];
}
