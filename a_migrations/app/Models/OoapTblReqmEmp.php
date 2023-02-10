<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapTblReqmEmp extends Model
{
    protected $table = 'ooap_tbl_reqm_emps';

    protected $primaryKey = 'id';

    protected $fillable = [

        'reqform_id', 'emps_id', 'emps_replace', 'status', 'join_date', 'created_at', 'updated_at'
    ];
}
