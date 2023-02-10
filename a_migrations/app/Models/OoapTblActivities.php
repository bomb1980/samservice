<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapTblActivities extends Model
{
    use HasFactory;

    //ooap_tbl_activities_model
    protected $table = 'ooap_tbl_activities';

    protected $primaryKey = 'act_id';

    protected $fillable = [

        'act_plan_adjust_status', 'act_ref_number', 'pop_income', 'people_checkin', 'act_year', 'act_subdistrict', 'act_number', 'act_acttype', 'act_coursegroup', 'templateno_count', 'templateno', 'act_shortname', 'people_all', 'people_not_checkin', 'act_periodno', 'act_dept', 'act_div', 'act_province',
        'act_district', 'act_moo', 'act_commu', 'act_leadname', 'act_position', 'act_leadinfo', 'act_startmonth', 'act_endmonth', 'act_numofday', 'act_numofpeople', 'act_rate', 'act_amount', 'act_desc', 'act_remark', 'act_troubletype', 'act_peopleno', 'act_buildtypeid', 'act_buildname', 'act_latitude',
        'act_longtitude', 'act_measure', 'act_metric', 'act_width', 'act_length', 'act_height', 'act_unit', 'act_course', 'act_coursesubgroup', 'act_numlecturer', 'act_foodrate', 'act_amtfood', 'act_amtlecturer', 'act_materialrate', 'act_materialamt', 'act_otheramt', 'act_hrperday', 'act_sendappdate',
        'act_approvedate', 'act_approveby', 'act_approvenote',

        'allocate_urgent', 'allocate_training', 'allocate_manage',

        'activity_name', 'activity_time_period_start', 'activity_time_period_end', 'collection_period_start', 'collection_period_end', 'allocation_period_start', 'allocation_period_end', 'plan_adjustment_period_start', 'plan_adjustment_period_end', 'activity_run_period_start', 'activity_run_period_end', 'collection_allocation_start', 'collection_allocation_end',
        'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at',

        'act_plan_adjust_status', 'act_coursetype', 'act_plan_adjust_status', 'act_ref_number', 'pop_income', 'people_checkin', 'act_year', 'act_subdistrict', 'act_number', 'act_acttype', 'act_coursegroup', 'templateno_count', 'templateno', 'act_shortname', 'people_all', 'people_not_checkin', 'act_periodno', 'act_dept', 'act_div', 'act_province', 'act_district', 'act_moo', 'act_commu', 'act_leadname', 'act_position', 'act_leadinfo', 'act_startmonth', 'act_endmonth', 'act_numofday', 'act_numofpeople', 'act_rate', 'act_amount', 'act_desc', 'act_remark', 'act_troubletype', 'act_peopleno', 'act_buildtypeid', 'act_buildname', 'act_latitude', 'act_longtitude', 'act_measure', 'act_metric', 'act_width', 'act_length', 'act_height', 'act_unit', 'act_course', 'act_coursesubgroup', 'act_numlecturer', 'act_foodrate', 'act_amtfood', 'act_amtlecturer', 'act_materialrate', 'act_materialamt', 'act_otheramt', 'act_hrperday', 'act_sendappdate', 'act_approvedate', 'act_approveby', 'act_approvenote', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    static function getReport9($year = NULL, $people_checkin = false)
    {
        self::UpdateTblActivities();



        $dd = OoapTblPopulation::selectraw('
            ooap_mas_tambon.province,
            ooap_mas_tambon.region,
            ooap_tbl_activities.act_year,
            ooap_mas_ocuupations.name,
            sum( ooap_tbl_populations.pop_income ) as total_pop_income,
            count( * ) as total_people_checkin,
            1 as t
        ')
            ->join('ooap_mas_ocuupations', 'ooap_tbl_populations.pop_ocuupation', '=', 'ooap_mas_ocuupations.id')
            ->join('ooap_tbl_activities', 'ooap_tbl_populations.pop_actnumber', '=', 'ooap_tbl_activities.act_number')
            ->join('ooap_mas_tambon', 'ooap_tbl_activities.act_subdistrict', '=', 'ooap_mas_tambon.tambon_id')

            ->whereraw( 'ooap_tbl_populations.pop_id IN ( SELECT pop_id FROM ooap_tbl_population_checkins where ooap_tbl_population_checkins.check_status IN ( 1, 2 ) )' );
            // ->get()->toArray();
            // dd( $dd );
            // SUM( ( CASE WHEN  THEN 1 ELSE 0 END ) ) as count_accept,
        if (!empty($year)) {

            // $dd = $dd->where('ooap_tbl_activities.act_year', '=', $year);
        }

        if ($people_checkin == true) {

            // $dd = $dd->where('ooap_tbl_activities.people_checkin', '>', 0);
        }

        return $dd
            ->groupby([
                'ooap_mas_ocuupations.name',
                'ooap_tbl_activities.act_year',
                'ooap_mas_tambon.province',
                'ooap_mas_tambon.region',

            ])
            ->orderby('ooap_tbl_activities.act_year', 'asc')
            ->orderby('ooap_mas_ocuupations.name', 'asc');
    }





    static function getReport($year = NULL, $people_checkin = false)
    {
        self::UpdateTblActivities();



        $dd = self::selectraw('
            ooap_mas_tambon.province,
            ooap_mas_tambon.region,
            ooap_tbl_activities.act_year,
            ooap_mas_coursegroup.name,
            COUNT( * ) as t,
            sum( ooap_tbl_activities.people_checkin ) as total_people_checkin,
            sum( ooap_tbl_activities.pop_income ) as total_pop_income

        ')
            ->join('ooap_mas_coursegroup', 'ooap_tbl_activities.act_coursegroup', '=', 'ooap_mas_coursegroup.id')
            ->join('ooap_mas_tambon', 'ooap_tbl_activities.act_subdistrict', '=', 'ooap_mas_tambon.tambon_id')
            ->where('ooap_tbl_activities.act_acttype', '=', 2);

        if (!empty($year)) {

            $dd = $dd->where('ooap_tbl_activities.act_year', '=', $year);
        }

        if ($people_checkin == true) {

            $dd = $dd->where('ooap_tbl_activities.people_checkin', '>', 0);
        }
        // dd('dsdsfsd');

        return $dd
            ->groupby([
                'ooap_mas_coursegroup.name',
                'ooap_tbl_activities.act_year',
                'ooap_mas_tambon.province',
                'ooap_mas_tambon.region',

            ])
            ->orderby('ooap_tbl_activities.act_year', 'asc')
            ->orderby('ooap_mas_coursegroup.name', 'asc');
    }





    static function UpdateTblActivities()
    {

        self::whereraw('1 = 1')->update([
            'people_checkin' => 0,
            'people_not_checkin' => 0,
            'people_all' => 0,
            'templateno_count' => 0,
            'pop_income' => 0,

        ]);


        $OoapTblPopulation = OoapTblPopulation::selectraw('
            ooap_tbl_populations.pop_actnumber,
            count( * ) as people_all
        ')
        ->where('in_active', false)
        ->groupby('ooap_tbl_populations.pop_actnumber')
        ->get();


        foreach ($OoapTblPopulation as $kd => $vd) {

            self::where('act_number', '=',  $vd->pop_actnumber)->update([
                'people_all' => $vd->people_all
            ]);
        }

        $OoapTblPopulationCheckin =  OoapTblPopulation::selectraw('

            ooap_tbl_populations.pop_actnumber,
            SUM( ( CASE WHEN ooap_tbl_populations.pop_id IN ( SELECT pop_id FROM ooap_tbl_population_checkins where ooap_tbl_population_checkins.check_status IN ( 1, 2 ) ) THEN 1 ELSE 0 END ) ) as count_accept,

            SUM( pop_income * ( CASE WHEN ooap_tbl_populations.pop_id IN ( SELECT pop_id FROM ooap_tbl_population_checkins where ooap_tbl_population_checkins.check_status IN ( 1, 2 ) ) THEN 1 ELSE 0 END ) ) as total_pop_income,

            SUM( 1 * ( CASE WHEN ooap_tbl_populations.pop_id IN ( SELECT pop_id FROM ooap_tbl_population_checkins where ooap_tbl_population_checkins.check_status NOT IN ( 1, 2 ) ) THEN 1 ELSE 0 END ) ) as count_denied

        ')
            ->groupby('ooap_tbl_populations.pop_actnumber')
            ->get();

        foreach ($OoapTblPopulationCheckin as $kd => $vd) {

            //ooap_tbl_activities
            self::where('act_number', '=',  $vd->pop_actnumber)->update([
                'people_checkin' => $vd->count_accept,
                'people_not_checkin' => $vd->count_denied,
                'pop_income' => $vd->total_pop_income,

            ]);
        }

        $OoapTblAssess = OoapTblAssess::selectraw('
            assess_templateno,
            COUNT( * ) as templateno_count
        ')->groupby('assess_templateno')->get();

        foreach ($OoapTblAssess as $ka => $vd) {
            self::where('templateno', '=',  $vd->assess_templateno)->update([
                'templateno_count' => $vd->templateno_count,
            ]);
        }
    }
}
