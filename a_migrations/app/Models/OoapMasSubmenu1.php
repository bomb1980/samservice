<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasSubmenu1 extends Model
{
    protected $table = 'ooap_mas_submenu1';

    protected $primaryKey = 'submenu1_id';

    protected $fillable = [
        'submenu_id', 'submenu1_name', 'route_name', 'display_order', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public $timestamps = false;
}
