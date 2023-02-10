<?php

namespace App\Http\Livewire\Activity\ReadyConfirm;

use App\Models\OoapMasActtype;
use App\Models\OoapTblActivities;
use App\Models\OoapTblActivityFiles;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblReqform;
use App\Models\OoapTblRequest;
use App\Models\OoapTblRequestFiles;
use Livewire\Component;

class CopyReqComponent extends Component
{
    public $fiscalyear_list_modal, $acttype_list, $req_list, $req_id_check = [], $check_all, $year, $acttype_id, $search, $selectall, $act_periodno, $ref_number_list, $req_number, $req_clone = [], $act_number;
    public $file_array_old = [];
    // public $total_amt;

    public function mount()
    {
        $this->fiscalyear_list_modal = OoapTblRequest::where('in_active', '=', false)->where('status', '=', 3)->pluck('req_year', 'req_year');
        $this->acttype_list = OoapMasActtype::where('inactive', '=', false)->pluck('name', 'id');
        $this->req_list = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)->where('ooap_tbl_requests.status', '=', 3)
            ->where('req_div', '=', auth()->user()->division_id)
            ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
            ->leftjoin('ooap_mas_amphur', 'ooap_tbl_requests.req_district', 'ooap_mas_amphur.amphur_id')
            ->leftjoin('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict', 'ooap_mas_tambon.tambon_id')
            ->get()->toArray();
        // dd($this->req_list);
    }
    public function render()
    {
        if ($this->year && !$this->acttype_id && !$this->search && $this->search == '') {
            $this->req_list = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)->where('ooap_tbl_requests.status', '=', 3)->where('ooap_tbl_requests.req_year', '=', $this->year)
                ->where('req_div', '=', auth()->user()->division_id)
                ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
                ->leftjoin('ooap_mas_amphur', 'ooap_tbl_requests.req_district', 'ooap_mas_amphur.amphur_id')
                ->leftjoin('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict', 'ooap_mas_tambon.tambon_id')
                ->get()->toArray();
        } elseif (!$this->year && $this->acttype_id && !$this->search && $this->search == '') {
            $this->req_list = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)->where('ooap_tbl_requests.status', '=', 3)->where('ooap_tbl_requests.req_acttype', '=', $this->acttype_id)
                ->where('req_div', '=', auth()->user()->division_id)
                ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
                ->leftjoin('ooap_mas_amphur', 'ooap_tbl_requests.req_district', 'ooap_mas_amphur.amphur_id')
                ->leftjoin('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict', 'ooap_mas_tambon.tambon_id')
                ->get()->toArray();
        } elseif (!$this->year && !$this->acttype_id && $this->search) {
            $this->req_list = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)->where('ooap_tbl_requests.status', '=', 3)
                ->where('req_div', '=', auth()->user()->division_id)
                ->where('ooap_tbl_requests.req_year', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_number', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_district', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_subdistrict', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_moo', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_mas_acttype.name', 'like', '%' . trim($this->search) . '%')
                ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
                ->leftjoin('ooap_mas_amphur', 'ooap_tbl_requests.req_district', 'ooap_mas_amphur.amphur_id')
                ->leftjoin('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict', 'ooap_mas_tambon.tambon_id')
                ->get()->toArray();
        } elseif ($this->year && $this->acttype_id && !$this->search && $this->search == '') {
            $this->req_list = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)->where('ooap_tbl_requests.status', '=', 3)->where('ooap_tbl_requests.req_year', '=', $this->year)->where('ooap_tbl_requests.req_acttype', '=', $this->acttype_id)
                ->where('req_div', '=', auth()->user()->division_id)
                ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
                ->leftjoin('ooap_mas_amphur', 'ooap_tbl_requests.req_district', 'ooap_mas_amphur.amphur_id')
                ->leftjoin('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict', 'ooap_mas_tambon.tambon_id')
                ->get()->toArray();
        } elseif ($this->year && !$this->acttype_id && $this->search) {
            $this->req_list = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)->where('ooap_tbl_requests.status', '=', 3)->where('ooap_tbl_requests.req_year', '=', $this->year)
                ->where('req_div', '=', auth()->user()->division_id)
                ->where('ooap_tbl_requests.req_year', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_number', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_district', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_subdistrict', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_moo', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_mas_acttype.name', 'like', '%' . trim($this->search) . '%')
                ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
                ->leftjoin('ooap_mas_amphur', 'ooap_tbl_requests.req_district', 'ooap_mas_amphur.amphur_id')
                ->leftjoin('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict', 'ooap_mas_tambon.tambon_id')
                ->get()->toArray();
        } elseif (!$this->year && $this->acttype_id && $this->search) {
            $this->req_list = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)->where('ooap_tbl_requests.status', '=', 3)->where('ooap_tbl_requests.req_acttype', '=', $this->acttype_id)
                ->where('req_div', '=', auth()->user()->division_id)
                ->where('ooap_tbl_requests.req_year', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_number', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_district', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_subdistrict', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_moo', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_mas_acttype.name', 'like', '%' . trim($this->search) . '%')
                ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
                ->leftjoin('ooap_mas_amphur', 'ooap_tbl_requests.req_district', 'ooap_mas_amphur.amphur_id')
                ->leftjoin('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict', 'ooap_mas_tambon.tambon_id')
                ->get()->toArray();
        } elseif ($this->year && $this->acttype_id && $this->search) {
            $this->req_list = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)->where('ooap_tbl_requests.status', '=', 3)->where('ooap_tbl_requests.req_year', '=', $this->year)->where('ooap_tbl_requests.req_acttype', '=', $this->acttype_id)
                ->where('req_div', '=', auth()->user()->division_id)
                ->where('ooap_tbl_requests.req_year', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_number', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_district', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_subdistrict', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_tbl_requests.req_moo', 'like', '%' . trim($this->search) . '%')
                ->orWhere('ooap_mas_acttype.name', 'like', '%' . trim($this->search) . '%')
                ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
                ->leftjoin('ooap_mas_amphur', 'ooap_tbl_requests.req_district', 'ooap_mas_amphur.amphur_id')
                ->leftjoin('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict', 'ooap_mas_tambon.tambon_id')
                ->get()->toArray();
        } else {
            $this->req_list = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)->where('ooap_tbl_requests.status', '=', 3)
                ->where('req_div', '=', auth()->user()->division_id)
                ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
                ->leftjoin('ooap_mas_amphur', 'ooap_tbl_requests.req_district', 'ooap_mas_amphur.amphur_id')
                ->leftjoin('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict', 'ooap_mas_tambon.tambon_id')
                ->get()->toArray();
        }

        if ($this->year) {
            $act_number_success = OoapTblActivities::select('act_ref_number')->where('in_active', '=', false)->where('act_year', '=', $this->year)->get()->toArray() ?? [];
            $this->ref_number_list = OoapTblRequest::where('in_active', '=', false)
                ->whereNotIn('req_id', $act_number_success)
                ->where('req_div', '=', auth()->user()->division_id)
                ->where('status', '=', 3)
                ->where('req_year', '=', $this->year)->pluck('req_number', 'req_number');

            $this->req_list = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)->where('ooap_tbl_requests.status', '=', 3)
                ->where('req_div', '=', auth()->user()->division_id)
                ->whereNotIn('req_id', $act_number_success)
                ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
                ->leftjoin('ooap_mas_amphur', 'ooap_tbl_requests.req_district', 'ooap_mas_amphur.amphur_id')
                ->leftjoin('ooap_mas_tambon', 'ooap_tbl_requests.req_subdistrict', 'ooap_mas_tambon.tambon_id')
                ->get()->toArray();
        }

        $getId = OoapTblActivities::select('act_id')->where('in_active', '=', false)->where('act_year', '=', $this->year)->orderBy('act_id', 'DESC')->count() ?? 0;
        $this->act_number = "AT-" . substr($this->year, 2) . date("m") . "-" . sprintf('%04d', $getId + 1);

        return view('livewire.activity.ready-confirm.copy-req-component');
    }

    // public function allrow()
    // {
    //     foreach ($this->req_list as $key => $val) {
    //         $this->req_id_check[$key] = $this->selectall ? $val['req_id'] : 0;
    //     }
    // }

    public function setReq($val)
    {
        $this->act_number = $val;
    }

    public function setYear($val)
    {
        $this->year = $val;
    }

    public function setAct($val)
    {
        $this->acttype_id = $val;
    }

    public function search($val)
    {
        $this->search = $val;
    }

    public function cancel()
    {
        return redirect()->route('activity.ready_confirm.index');
    }

    public function addAct()
    {
        // $this->req_list = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)
        //     ->whereIn('ooap_tbl_requests.req_id', $this->req_id_check)
        //     ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
        //     ->get()->toArray();

        // foreach ($this->req_list as $key => $val) {

        //     $strDate = now();
        //     $getId = OoapTblActivities::select('act_id')->where('act_year', '=', date("Y", strtotime($strDate)) + 543)->orderBy('act_id', 'DESC')->count() ?? 1;
        //     // $getId = OoapTblActivities::select('act_id')->where('act_year', '=', $this->year)->orderBy('act_id', 'DESC')->get()->toArray();
        //     // dd($getId);
        //     // $getId = count($getId);
        //     // dd(sprintf('%04d', $getId + 1),$getId);
        //     $act_number = 'RF-' . substr(date("Y", strtotime($strDate)) + 543, 2, 2) . date("n", strtotime($strDate)) . '-' . sprintf('%04d', $getId + 1);
        //     // dd($act_number,$getId);

        //     // $this->act_periodno = OoapTblActivities::where('in_active', '=', false)->where('act_year', '=', date("Y", strtotime($strDate)) + 543)->get()->toArray();
        //     // dd($this->act_periodno);

        //     $req_copy = OoapTblActivities::create([
        //         'act_number' => $act_number,
        //         'act_year' => date("Y", strtotime($strDate)) + 543,
        //         'act_periodno' => 1,
        //         'act_acttype' => $this->req_list[$key]['req_acttype'],
        //         'act_province' => $this->req_list[$key]['req_province'],
        //         'act_district' => $this->req_list[$key]['req_district'],
        //         'act_subdistrict' => $this->req_list[$key]['req_subdistrict'],
        //         'act_moo' => $this->req_list[$key]['req_moo'],
        //         'act_commu' => $this->req_list[$key]['req_commu'],
        //         'act_leadname' => $this->req_list[$key]['req_leadname'],
        //         'act_position' => $this->req_list[$key]['req_position'],
        //         'act_leadinfo' => $this->req_list[$key]['req_leadinfo'],
        //         'act_rate' => $this->req_list[$key]['req_rate'],
        //         'act_troubletype' => $this->req_list[$key]['req_troubletype'],
        //         'act_peopleno' => $this->req_list[$key]['req_peopleno'],
        //         'act_buildtypeid' => $this->req_list[$key]['req_buildtypeid'],
        //         'act_buildname' => $this->req_list[$key]['req_buildname'],
        //         'act_latitude' => $this->req_list[$key]['req_latitude'],
        //         'act_longtitude' => $this->req_list[$key]['req_longtitude'],
        //         'act_measure' => $this->req_list[$key]['req_measure'],
        //         'act_metric' => $this->req_list[$key]['req_metric'],
        //         'act_width' => $this->req_list[$key]['req_width'],
        //         'act_length' => $this->req_list[$key]['req_length'],
        //         'act_height' => $this->req_list[$key]['req_height'],
        //         'act_unit' => $this->req_list[$key]['req_unit'],
        //         'act_course' => $this->req_list[$key]['req_course'],
        //         'act_coursegroup' => $this->req_list[$key]['req_coursegroup'],
        //         'act_coursesubgroup' => $this->req_list[$key]['req_coursesubgroup'],
        //         'act_shortname' => $this->req_list[$key]['req_shortname'],
        //         'act_desc' => $this->req_list[$key]['req_desc'],
        //         'act_remark' => $this->req_list[$key]['req_remark'],
        //         'act_numlecturer' => $this->req_list[$key]['req_numlecturer'],
        //         'act_foodrate' => $this->req_list[$key]['req_foodrate'],
        //         'act_amtfood' => $this->req_list[$key]['req_amtfood'],
        //         'act_amtlecturer' => $this->req_list[$key]['req_amtlecturer'],
        //         'act_materialrate' => $this->req_list[$key]['req_materialrate'],
        //         'act_materialamt' => $this->req_list[$key]['req_materialamt'],
        //         'act_otheramt' => $this->req_list[$key]['req_otheramt'],
        //         'act_hrperday' => $this->req_list[$key]['req_hrperday'],
        //         'act_sendappdate' => $this->req_list[$key]['req_sendappdate'],
        //         'act_approvedate' => $this->req_list[$key]['req_approvedate'],
        //         'act_approveby' => $this->req_list[$key]['req_approveby'],
        //         'act_approvenote' => $this->req_list[$key]['req_approvenote'],
        //         'act_startmonth' => $this->req_list[$key]['req_startmonth'],
        //         'act_endmonth' => $this->req_list[$key]['req_endmonth'],
        //         'act_numofday' => $this->req_list[$key]['req_numofday'],
        //         'act_numofpeople' => $this->req_list[$key]['req_numofpeople'],
        //         'act_amount' => $this->req_list[$key]['req_amount'],
        //         'status' => 1,
        //         'remember_token' => csrf_token(),
        //         'created_by' => auth()->user()->emp_citizen_id
        //     ]);
        // }
        $this->validate([
            'year' => 'required',
            'act_number' => 'required',
            'req_clone' => 'required',
        ], [
            'year.required' => 'กรุณาเลือก ปีงบประมาณ',
            'act_number.required' => 'กรุณาเลือก หมายเลขที่คำขออ้างอิง',
            'req_clone.required' => 'กรุณาเลือก คำขอที่ต้องการคัดลอก',
        ]);

        if ($this->req_clone) {
            $this->req_list = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)->where('req_id', '=', $this->req_clone)
                ->leftjoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
                ->first();
            $this->file_array_old = OoapTblRequestFiles::where('req_id', '=', $this->req_clone)->where('in_active', '=', false)->get()->toArray() ?? [];
            $strDate = now();

            $req_copy = OoapTblActivities::create([
                'act_number' => $this->act_number,
                'act_ref_number' => $this->req_list->req_id,
                'act_year' => $this->year,
                'act_periodno' => null,
                'act_div' => $this->req_list->req_div,
                'act_acttype' => $this->req_list->req_acttype,
                'act_province' => $this->req_list->req_province,
                'act_district' => $this->req_list->req_district,
                'act_subdistrict' => $this->req_list->req_subdistrict,
                'act_moo' => $this->req_list->req_moo,
                'act_commu' => $this->req_list->req_commu,
                'act_leadname' => $this->req_list->req_leadname,
                'act_position' => $this->req_list->req_position,
                'act_leadinfo' => $this->req_list->req_leadinfo,
                'act_rate' => $this->req_list->req_rate,
                'act_troubletype' => $this->req_list->req_troubletype,
                'act_peopleno' => $this->req_list->req_peopleno,
                'act_buildtypeid' => $this->req_list->req_buildtypeid,
                'act_buildname' => $this->req_list->req_buildname,
                'act_latitude' => $this->req_list->req_latitude,
                'act_longtitude' => $this->req_list->req_longtitude,
                'act_measure' => $this->req_list->req_measure,
                'act_metric' => $this->req_list->req_metric,
                'act_width' => $this->req_list->req_width,
                'act_length' => $this->req_list->req_length,
                'act_height' => $this->req_list->req_height,
                'act_unit' => $this->req_list->req_unit,
                'act_course' => $this->req_list->req_course,
                'act_coursegroup' => $this->req_list->req_coursegroup,
                'act_coursesubgroup' => $this->req_list->req_coursesubgroup,
                'act_shortname' => $this->req_list->req_shortname,
                'act_desc' => $this->req_list->req_desc,
                'act_remark' => $this->req_list->req_remark,
                'act_numlecturer' => $this->req_list->req_numlecturer,
                'act_foodrate' => $this->req_list->req_foodrate,
                'act_amtfood' => $this->req_list->req_amtfood,
                'act_amtlecturer' => $this->req_list->req_amtlecturer,
                'act_materialrate' => $this->req_list->req_materialrate,
                'act_materialamt' => $this->req_list->req_materialamt,
                'act_otheramt' => $this->req_list->req_otheramt,
                'act_hrperday' => $this->req_list->req_hrperday,
                'act_sendappdate' => $this->req_list->req_sendappdate,
                'act_approvedate' => $this->req_list->req_approvedate,
                'act_approveby' => $this->req_list->req_approveby,
                'act_approvenote' => $this->req_list->req_approvenote,
                'act_startmonth' => $this->req_list->req_startmonth,
                'act_endmonth' => $this->req_list->req_endmonth,
                'act_numofday' => $this->req_list->req_numofday,
                'act_numofpeople' => $this->req_list->req_numofpeople,
                'act_amount' => $this->req_list->req_amount,
                'status' => 1,
                'remember_token' => csrf_token(),
                'created_by' => auth()->user()->emp_citizen_id,
                'created_at' => now(),
            ]);

            if (!empty($this->file_array_old)) {
                $path_file = '/requests';
                foreach ($this->file_array_old as $file) {
                // dd($this->file_array_old);
                    // $file->store('/public' . $path_file);
                    OoapTblActivityFiles::create([
                        'files_ori' => $file['files_ori'],
                        'files_gen' => $file['files_gen'],
                        'files_path' => $file['files_path'],
                        'files_type' => $file['files_type'],
                        'files_size' => $file['files_size'],
                        'act_id' => $req_copy->act_id,

                        'created_by' => auth()->user()->emp_citizen_id,
                        'created_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('activity.ready_confirm.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}
