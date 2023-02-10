<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OoapMasLecturerType extends Model
{
    protected $table = 'ooap_mas_lecturer_types';

    protected $primaryKey = 'lecturer_types_id';

    protected $fillable = [

        'lecturer_types_name',
        'view_data',
        'insert_data',
        'update_data',
        'delete_data',
        'status',
        'in_active',
        'remember_token',
        'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'
    ];
}
