<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OoapTblAssesslog extends Model
{
    use HasFactory;

    //ooap_tbl_assesslogs_model
    protected $table = 'ooap_tbl_assesslogs';

    protected $primaryKey = 'assesslog_id';

    protected $fillable = [
        'assesslog_pop_id', 'assesslog_type', 'assesslog_score', 'assesslog_act_id', 'assesslog_refid', 'assesslog_description', 'assesslog_answers', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];


}
