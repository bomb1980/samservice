<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//ooap_tbl_populations_model

class OoapTblPopulation extends Model
{
    use HasFactory;
    protected $table = 'ooap_tbl_populations';

    protected $primaryKey = 'pop_id';

    protected $fillable = [
        'pop_typelecturer', 'pop_elderly', 'pop_labor', 'pop_defective','pop_actnumber', 'pop_subdistrict', 'pop_province', 'total_score', 'total_avg', 'pop_year', 'pop_periodno', 'pop_div', 'pop_role', 'pop_nationalid', 'pop_welfarecard', 'pop_title', 'pop_firstname', 'pop_lastname', 'pop_gender', 'pop_age', 'pop_addressno', 'pop_moo', 'pop_soi', 'pop_district', 'pop_education', 'pop_postcode', 'pop_mobileno', 'pop_ocuupation', 'pop_income', 'pop_birthday', 'pop_assessflag', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];


    static function updateTblPopulations()
    {

        // ooap_tbl_populations
        self::whereraw('1=1')->update([
            'total_score' => 0,
            'total_avg' => 0,
            'remember_token' => csrf_token(),
            'updated_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now(),
        ]);


        $dd = OoapTblAssesslog::selectraw('
            ooap_tbl_activities.templateno_count,
            ooap_tbl_assesslogs.assesslog_pop_id,
            SUM( ooap_tbl_assesslogs.assesslog_score ) as total_score
        ')
        ->leftjoin('ooap_tbl_populations', 'ooap_tbl_assesslogs.assesslog_pop_id', '=', 'ooap_tbl_populations.pop_id')
        ->leftjoin('ooap_tbl_activities', 'ooap_tbl_activities.act_number', '=', 'ooap_tbl_populations.pop_actnumber')

        ->where( 'ooap_tbl_activities.templateno_count', '>', 0 )

        ->groupby('ooap_tbl_assesslogs.assesslog_pop_id')
        ->groupby('ooap_tbl_activities.templateno_count')
        // ->havingraw(' SUM( ooap_tbl_assesslogs.assesslog_score ) > 0')
        ->get();

        foreach ($dd as $kd => $vd) {

            $total_score =  empty($vd->total_score) ? 0 : $vd->total_score;

            //ooap_tbl_populations
            self::where('pop_id', '=', $vd->assesslog_pop_id)->update([
                'total_score' => $total_score,
                'total_avg' => ($total_score / $vd->templateno_count ),
                'remember_token' => csrf_token(),
                'updated_by' => auth()->user()->emp_citizen_id,
                'updated_at' => now(),
            ]);
        }
    }

    static function getReport1($region_select = NULL, $province_select = NULL, $updateData = false )
    {

        if( $updateData == true ) {

            OoapTblActivities::UpdateTblActivities();

            self::updateTblPopulations();
        }

        // ooap_tbl_populations
        $dd = self::selectraw('
            ooap_mas_tambon.region,
            ooap_mas_tambon.province,
            ooap_tbl_activities.act_id,
            ooap_tbl_activities.act_number,
            ooap_tbl_activities.act_shortname,
            ooap_tbl_activities.people_checkin,
            SUM( (
                CASE WHEN
                    ooap_tbl_populations.pop_id IN ( SELECT assesslog_pop_id FROM ooap_tbl_assesslogs  )
                THEN 1
                ELSE 0
                END ) ) as people_answer,
            SUM( ooap_tbl_populations.total_avg ) as total_score

        ')
        ->leftjoin('ooap_tbl_activities', 'ooap_tbl_populations.pop_actnumber', '=', 'ooap_tbl_activities.act_number')
        ->leftjoin('ooap_mas_tambon', 'ooap_tbl_activities.act_subdistrict', '=', 'ooap_mas_tambon.tambon_id');

        if (!empty($region_select)) {
            $dd = $dd->where('ooap_mas_tambon.region', '=',  $region_select);
        }

        if (!empty($province_select)) {
            $dd = $dd->where('ooap_mas_tambon.province', '=',  $province_select);
        }

        $dd = $dd->whereraw('ooap_tbl_populations.pop_id IN ( SELECT pop_id FROM ooap_tbl_population_checkins where ooap_tbl_population_checkins.check_status IN ( 1, 2 ) )');
        // $dd = $dd->where('ooap_tbl_activities.people_checkin', '>', 0);

        return $dd
            ->groupby('ooap_mas_tambon.region')
            ->groupby('ooap_mas_tambon.province')
            ->groupby('ooap_tbl_activities.act_id')
            ->groupby('ooap_tbl_activities.act_number')
            ->groupby('ooap_tbl_activities.act_shortname')
            ->groupby('ooap_tbl_activities.people_checkin')
            ->orderby('ooap_mas_tambon.region', 'asc')
            ->orderby('ooap_mas_tambon.province', 'asc')
            ->orderby('ooap_tbl_activities.act_shortname', 'asc')
            ->get();
    }


    static function getReport2($region_select = NULL, $province_select = NULL, $updateData = false )
    {
        if( $updateData == true ) {


            OoapTblActivities::UpdateTblActivities();

            self::updateTblPopulations();
        }

        //ooap_tbl_populations
        $dd = OoapTblActivities::selectraw('
            ooap_tbl_activities.act_id,
            ooap_tbl_activities.act_numofday,
            ooap_tbl_activities.act_shortname,
            ooap_tbl_activities.people_checkin,
            ooap_tbl_activities.act_number,
            ooap_tbl_activities.act_amount,
            ooap_mas_tambon.region,
            ooap_mas_tambon.province,
            COUNT( * ) as t
        ')
        ->leftjoin('ooap_mas_tambon', 'ooap_tbl_activities.act_subdistrict', '=', 'ooap_mas_tambon.tambon_id');

        // dd($dd);

        if (!empty($region_select)) {
            $dd = $dd->where('ooap_mas_tambon.region', '=',  $region_select);
        }

        if (!empty($province_select)) {
            $dd = $dd->where('ooap_mas_tambon.province', '=',  $province_select);
        }

        $dd = $dd->groupby('ooap_tbl_activities.act_shortname')
            ->groupby('ooap_tbl_activities.act_amount')
            ->groupby('ooap_tbl_activities.act_numofday')
            ->groupby('ooap_tbl_activities.people_checkin')
            ->groupby('ooap_tbl_activities.act_id')
            ->groupby('ooap_tbl_activities.act_number')
            ->groupby('ooap_mas_tambon.province')
            ->groupby('ooap_mas_tambon.region')
            ->orderby('ooap_mas_tambon.region', 'asc')
            ->orderby('ooap_mas_tambon.province', 'asc')
            ->orderby('ooap_tbl_activities.act_shortname', 'asc')->get();
        return $dd;
    }
}
