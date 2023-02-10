<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapMasMenu extends Model
{
    use HasFactory;
    protected $table = 'ooap_mas_menu';

    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'menu_name', 'display_order', 'menu_icon', 'activepage_name', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public $timestamps = true;
}
