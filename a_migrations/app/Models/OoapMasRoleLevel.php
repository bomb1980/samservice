<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasRoleLevel extends Model
{

    protected $table = 'ooap_mas_role_level';

    protected $primaryKey = 'role_level_id';

    protected $fillable = [
        'role_level_name', 'create_by', 'create_date', 'update_by', 'update_date'
    ];
}
