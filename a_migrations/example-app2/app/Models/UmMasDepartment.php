<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmMasDepartment extends Model
{

    protected $table = 'um_mas_department';

    protected $primaryKey = 'dept_id';

    protected $fillable = [
        'dept_code', 'dept_name_th', 'dept_short_name', 'address', 'district', 'aumpur', 'province', 'postcode', 'phone', 'email', 'branch_type_id', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at', 'dept_code', 'dept_name_th', 'dept_short_name', 'address', 'district', 'province', 'postcode', 'phone', 'email', 'branch_type_id', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];
}
