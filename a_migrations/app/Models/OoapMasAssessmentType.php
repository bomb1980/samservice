<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasAssessmentType extends Model
{
    protected $table = 'ooap_mas_assessment_types';

    protected $primaryKey = 'assessment_types_id';

    protected $fillable = [
        'assessment_types_name',
        'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'deleted_at', 'created_at', 'updated_at'
    ];
}
