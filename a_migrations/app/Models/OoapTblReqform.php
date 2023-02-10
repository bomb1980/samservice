<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapTblReqform extends Model
{
    protected $table = 'ooap_tbl_reqform';

    protected $primaryKey = 'reqform_id';

    protected $fillable = [
        'reqform_id', 'fiscalyear_code', 'total_amt', 'status', 'reqform_no', 'dept_id', 'acttype_id', 'coursegroup_id', 'coursesubgroup_id', 'course_id', 'actname', 'actdetail', 'actremark', 'troubletype_id', 'people_benefit_qty', 'local_material', 'moo', 'province_id', 'amphur_id', 'tambon_id', 'cmname', 'cmleader_name', 'cmleader_desp', 'cmleader_position', 'buildingtype_id', 'building_name', 'building_lat', 'building_long', 'patternarea_id', 'area_wide', 'area_long', 'area_high', 'area_total', 'unit_id', 'plan_startdate', 'plan_enddate', 'day_qty', 'people_qty', 'trainer_qty', 'job_wage_rate', 'couse_lunch_rate', 'couse_trainer_rate', 'couse_material_rate', 'other_rate', 'job_wage_amt', 'couse_lunch_amt', 'couse_trainer_amt', 'couse_material_amt', 'other_amt', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $dates = [
        'plan_startdate',
        'plan_enddate',
        'created_at',
        'updated_at',
        'deleted_at',
        'plan_startdate',
        'plan_enddate',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
