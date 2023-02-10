<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasRole extends Model
{

    protected $table = 'ooap_mas_role';

    protected $primaryKey = 'role_id';

    protected $fillable = [
        'role_level_id', 'role_name', 'role_name_th', 'status', 'in_active', 'create_by', 'create_date', 'update_by', 'update_date'
    ];
}
