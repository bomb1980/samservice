<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasUnit extends Model
{
    protected $table = 'ooap_mas_unit';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'shotname', 'status', 'inactive', 'remember_token', 'create_by', 'update_by', 'delete_by', 'create_date', 'upadate_date', 'delete_date', 'created_at', 'updated_at', 'name', 'shotname', 'status', 'inactive', 'remember_token', 'create_by', 'update_by', 'delete_by', 'create_date', 'upadate_date', 'delete_date'
    ];
}
