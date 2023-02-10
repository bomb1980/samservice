<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OoapTblEmp extends Model
{

    protected $table = 'ooap_tbl_emps';

    protected $primaryKey = 'emps_id';

    protected $fillable = [
        'identification_id',
        'customer_fname',
        'customer_lname',
        'sex',
        'dateofbirth',
        'status_id',
        'address_number',
        'address_moo',
        'address_tumbol',
        'address_amphur',
        'address_province',
        'mobile',
        'occupation_text',
        'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];
}
