<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//ooap_tbl_assess_model
class OoapTblAssess extends Model
{
    protected $table = 'ooap_tbl_assess';

    protected $primaryKey = 'assess_id';

    protected $fillable = [

        'assess_templateno',
        'assessment_topics_id',
        'assess_type',
        'assess_hdr',
        'assess_description',
        'assess_group',

        'status',
        'in_active',
        'remember_token',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
