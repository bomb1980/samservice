<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapMasUserPer extends Model
{
    use HasFactory;
    protected $table = 'ooap_mas_user_per';

    protected $primaryKey = 'user_per_id';

    protected $fillable = [
        'user_id', 'submenu_id', 'view_data', 'insert_data', 'update_data', 'delete_data', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public $timestamps = false;


    static function getPermission($user_id)
    {

        return self::where('user_id',  $user_id);
    }
}
