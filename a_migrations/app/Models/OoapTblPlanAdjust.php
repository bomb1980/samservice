<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapTblPlanAdjust extends Model
{
    use HasFactory;
    protected $table = 'ooap_tbl_plan_adjusts';

    protected $primaryKey = 'plan_id';

    protected $fillable = [
        'plan_year',
        'plan_subdistrict',
        'plan_number',
        'plan_acttype',
        'plan_coursegroup',
        'plan_shortname',
        'plan_periodno',
        'plan_dept',
        'plan_div',
        'plan_province',
        'plan_district',
        'plan_moo',
        'plan_commu',
        'plan_leadname',
        'plan_position',
        'plan_leadinfo',
        'plan_startmonth',
        'plan_endmonth',
        'plan_numofday',
        'plan_numofpeople',
        'plan_rate',
        'plan_amount',
        'plan_desc',
        'plan_remark',
        'plan_troubletype', 'plan_peopleno', 'plan_buildtypeid', 'plan_buildname', 'plan_latitude', 'plan_longtitude',
        'plan_measure', 'plan_metric', 'plan_width', 'plan_length', 'plan_height', 'plan_unit', 'plan_course',
        'plan_coursesubgroup', 'plan_numlecturer', 'plan_foodrate', 'plan_amtfood', 'plan_amtlecturer',
        'plan_materialrate', 'plan_materialamt', 'plan_otheramt', 'plan_hrperday', 'plan_sendappdate',
        'plan_approvedate', 'plan_approveby', 'plan_approvenote',

        'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];
}
