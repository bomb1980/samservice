<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OoapMasLecturer extends Model
{
    protected $table = 'ooap_mas_lecturers';

    protected $primaryKey = 'lecturer_id';

    protected $fillable = [

        'lecturer_nationalid',
        'lecturer_fname',
        'lecturer_lname',
        'lecturer_phone',
        'lecturer_address',
        'province_id',
        'lecturer_types_id',
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
