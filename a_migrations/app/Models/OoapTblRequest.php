<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//ooap_tbl_requests_model
class OoapTblRequest extends Model
{
    protected $table = 'ooap_tbl_requests';

    protected $primaryKey = 'req_id';

    protected $fillable = [
        'req_div', 'req_province', 'in_active', 'status', 'req_acttype', 'req_amount', 'req_number', 'req_year', 'req_dept', 'req_course', 'req_coursegroup', 'req_coursesubgroup', 'req_coursetype', 'req_shortname', 'req_desc', 'req_remark', 'req_troubletype', 'req_peopleno', 'req_moo', 'req_district', 'req_subdistrict', 'req_commu', 'req_leadname', 'req_position', 'req_leadinfo', 'req_buildtypeid', 'req_buildname', 'req_latitude', 'req_longtitude', 'req_measure', 'req_metric', 'req_width', 'req_length', 'req_height', 'req_unit', 'req_startmonth', 'req_endmonth', 'req_numofday', 'req_numofpeople', 'req_numlecturer', 'req_rate', 'req_foodrate', 'req_materialrate', 'req_otheramt', 'req_amtfood', 'req_amtlecturer', 'req_materialamt', 'req_hrperday', 'req_sendappdate', 'req_approvedate', 'req_approveby', 'req_approvenote', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    static function getAreas($emp_type = NULL, $template = NULL)
    {

        //'1=บันทึกแบบร่าง 2=รอพิจารณา 3=ผ่านการพิจารณา 4=ไม่ผ่านการพิจารณา 5=คำขอถูกส่งกลับ'
        $data = self::selectRaw('
            ooap_tbl_requests.status,
            ooap_tbl_requests.req_year,
            ooap_tbl_requests.req_acttype,
            ooap_mas_acttype.name as acttype_name,
            ooap_tbl_requests.req_div,
            ooap_mas_divisions.division_name,
            count( * ) as count_req,
            sum( ooap_tbl_requests.req_amount   ) as sum_amt
        ')
        ->join('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype','=', 'ooap_mas_acttype.id')
        ->join('ooap_mas_divisions', 'ooap_tbl_requests.req_div','=', 'ooap_mas_divisions.division_id')
        ->leftjoin('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict','=', 'ooap_mas_tambon.tambon_id')
        ->where([['ooap_tbl_requests.in_active', false]]);

        if (!empty($template)) {

            if( $template == 1 ) {

                $data = $data->whereIn('ooap_tbl_requests.status', [1, 2, 3, 4, 5]);
            }
            else {

                $data = $data->whereIn('ooap_tbl_requests.status', [2, 3, 4]);
            }

        }

        if (!empty($emp_type)) {

            if ($emp_type == 1) {

            } else {

                $data = $data->where('ooap_tbl_requests.req_province', '=', auth()->user()->province_id);
            }
        }

        return $data
            ->groupby('ooap_tbl_requests.status')
            ->groupby('ooap_tbl_requests.req_year')
            ->groupby('ooap_tbl_requests.req_acttype')
            ->groupby('ooap_mas_acttype.name')
            ->groupby('ooap_tbl_requests.req_div')
            ->groupby('ooap_mas_divisions.division_name')
            ->orderby('ooap_tbl_requests.req_year', 'desc');

    }

    static function getTbDatas($id = NULL, $emp_type = NULL, $req_acttype = NULL, $req_year = NULL, $status = NULL, $serachbox = NULL, $req_div = NULL)
    {
        $data = OoapTblRequest::selectraw("
            ooap_tbl_requests.*,
            ooap_mas_acttype.name,
            ooap_mas_tambon.tambon_name,
            ooap_mas_tambon.khet as amphur_name,
            ooap_tbl_requests.status as sort_status,
            ooap_mas_divisions.division_name,
            CASE
                WHEN ooap_tbl_requests.status = 1 THEN 'บันทึกแบบร่าง'
                WHEN ooap_tbl_requests.status = 2 THEN 'รอพิจารณา'
                WHEN ooap_tbl_requests.status = 3 THEN 'ผ่านการพิจารณา'
                WHEN ooap_tbl_requests.status = 4 THEN 'ไม่ผ่านการพิจารณา'
                ELSE 'ส่งคำขอกลับ'
            END as requests_status,
            CASE
                WHEN ooap_tbl_requests.status IN (5) THEN -1
                ELSE ooap_tbl_requests.status
            END as order_status
        ")
        ->join('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
        ->join('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict', 'ooap_mas_tambon.tambon_id')
        ->join('ooap_mas_divisions', 'ooap_tbl_requests.req_div', 'ooap_mas_divisions.division_id')
        ->where('ooap_tbl_requests.in_active', '=', false);

        $data = $data->where(function ($query) use ($serachbox) {

            if (!empty($serachbox)) {

                $s = str_replace(' ', '%', $serachbox);

                $query->where('ooap_tbl_requests.req_number', 'LIKE', '%' . $s . '%')
                    ->orWhere('ooap_mas_acttype.name', 'LIKE', '%' . $s . '%')
                    ->orWhere('ooap_mas_tambon.tambon_name', 'LIKE', '%' . $s . '%')
                    ->orWhere('ooap_mas_tambon.khet', 'LIKE', '%' . $s . '%');
            }
        });

        if (!empty($status)) {

            if ($status == 1) {

                $data = $data->wherein('ooap_tbl_requests.status', [1, 5]);
            } else {

                $data = $data->where('ooap_tbl_requests.status', '=', $status);
            }
        }
        if (!empty($req_div)) {
            $data = $data->where('ooap_tbl_requests.req_div', '=', $req_div);
        }

        if (!empty($emp_type)) {

            if ($emp_type == 2) {

                $data = $data->where('ooap_tbl_requests.req_province', '=', auth()->user()->province_id);
            }
        }

        if (!empty($id)) {

            $data = $data->where('ooap_tbl_requests.req_id', '=', $id);
        }

        if (!empty($req_acttype)) {

            $data = $data->where('ooap_tbl_requests.req_acttype', '=', $req_acttype);
        }

        if (!empty($req_year)) {

            $data = $data->where('ooap_tbl_requests.req_year', '=', str_replace( 'ปี', '', $req_year ) );
        }

        return $data;
    }


    static function getDatas()
    {
        return self::selectRaw('
            sum( ooap_tbl_requests.req_amount * ( CASE WHEN req_acttype = 1 THEN 1 ELSE 0 END ) ) as total_req_urgentamt,
            sum( ooap_tbl_requests.req_amount * ( CASE WHEN req_acttype = 2 THEN 1 ELSE 0 END ) ) as total_req_skillamt,
            sum( ooap_tbl_requests.req_amount * ( CASE WHEN req_acttype IN ( 1, 2 ) THEN 1 ELSE 0 END ) ) as total_req_sumreqamt,
            ooap_tbl_requests.req_year
        ')->where([['ooap_tbl_requests.status', '=', 3], ['ooap_tbl_requests.in_active', false]])
            ->groupby('ooap_tbl_requests.req_year');
    }

    static function getYearDatas($payment_group = NULL, $req_year = NULL)
    {
        $dd = self::selectraw("
            ooap_tbl_requests.req_year,
            ooap_tbl_requests.req_number,
            ooap_tbl_requests.req_id,
            ooap_tbl_requests.req_province,
            ooap_mas_province.province_name,
            ooap_tbl_requests.req_shortname,
            ooap_tbl_requests.req_amount
        ")
            ->join('ooap_tbl_fiscalyear', 'ooap_tbl_requests.req_year', '=', 'ooap_tbl_fiscalyear.fiscalyear_code')
            ->join('ooap_mas_province', 'ooap_tbl_requests.req_province', '=', 'ooap_mas_province.province_id');

        $dd = $dd->where('ooap_tbl_requests.in_active', '=', false);

        $dd = $dd->where('ooap_tbl_requests.status', '=', 3);

        if (!empty($req_year)) {

            $dd = $dd->where('ooap_tbl_requests.req_year', '=', $req_year);
        }

        if (!empty($payment_group)) {

            if ($payment_group == 1) {

                $dd = $dd->where('ooap_tbl_fiscalyear.centerbudget_amt', '>', 0);
            } else {

                if (auth()->user()->emp_type  == 2) {

                    $dd = $dd->where('ooap_tbl_requests.req_province', '=', auth()->user()->province_id);
                }

                $dd = $dd->where('ooap_tbl_fiscalyear.regionbudget_amt', '>', 0);
            }
        }

        return  $dd->orderby('ooap_tbl_requests.req_year', 'desc');
    }


    static function getExportExel($arr)
    {
        $data = OoapTblRequest::whereIn('req_id', $arr)
            ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
            ->leftjoin('ooap_mas_amphur', 'ooap_tbl_requests.req_district', 'ooap_mas_amphur.amphur_id')
            ->leftjoin('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict', 'ooap_mas_tambon.tambon_id')
            ->select(
                'ooap_tbl_requests.req_id',
                'ooap_tbl_requests.req_year',
                'ooap_tbl_requests.req_number',
                'ooap_mas_acttype.name',
                'ooap_mas_amphur.amphur_name',
                'ooap_mas_tambon.tambon_name',
                'ooap_tbl_requests.req_moo',
                'ooap_tbl_requests.req_startmonth',
                'ooap_tbl_requests.req_numofday',
                'ooap_tbl_requests.req_numofpeople',
                'ooap_tbl_requests.req_amount',
                'ooap_tbl_requests.status',
            )
            ->get();
        foreach ($data as $key => $val) {
            $data[$key]->req_id = $key + 1;
            $data[$key]->req_startmonth = formatDateThai($data[$key]->req_startmonth) ?? '-';
            $data[$key]->req_amount = number_format(($data[$key]->req_amount), 2);
            if ($val->status == 1) {
                $data[$key]->status = "บันทึกแบบร่าง";
            }
            if ($val->status == 2) {
                $data[$key]->status = "รอพิจารณา,";
            }
            if ($val->status == 3) {
                $data[$key]->status = "ผ่านการพิจารณา";
            }
            if ($val->status == 4) {
                $data[$key]->status = "ไม่ผ่านการพิจารณา";
            }
            if ($val->status == 5) {
                $data[$key]->status = "ส่งคำขอกลับ";
            }
        }
        return $data;
    }
}
