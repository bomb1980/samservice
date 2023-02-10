<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//ooap_mas_role_per_model
class OoapMasRolePer extends Model
{

    protected $table = 'ooap_mas_role_per';

    protected $primaryKey = 'role_per_id';

    protected $fillable = [
       'role_id', 'submenu_id', 'view_data', 'insert_data', 'update_data', 'delete_data', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];


    static function getPermission($role_id)
    {

        return self::where('role_id', $role_id);
    }
}
