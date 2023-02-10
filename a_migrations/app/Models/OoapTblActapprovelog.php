<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapTblActapprovelog extends Model
{
    protected $table = 'ooap_tbl_actapprovelogs';

    protected $primaryKey = 'act_applog_id';

    protected $fillable = [
        'act_log_type',
        'act_ref_id',
        'act_log_date',
        'act_log_actions',
        'act_log_details',
        'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];}
