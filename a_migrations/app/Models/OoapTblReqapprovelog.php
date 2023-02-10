<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapTblReqapprovelog extends Model
{
    protected $table = 'ooap_tbl_reqapprovelogs';

    protected $primaryKey = 'applog_id';

    protected $fillable = [
        'log_type',
        'ref_id',
        'log_date',
        'log_actions',
        'log_details',
        'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];
}
