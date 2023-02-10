<?php

namespace App\Http\Livewire\Request\Consider;

use Livewire\Component;
use App\Models\OoapMasActtype;
use App\Models\OoapMasAmphur;
use App\Models\OoapMasBuildingtype;
use App\Models\OoapMasCourse;
use App\Models\OoapMasCoursegroup;
use App\Models\OoapMasCoursesubgroup;
use App\Models\OoapMasCoursetype;
use App\Models\OoapMasPatternarea;
use App\Models\OoapMasProvince;
use App\Models\OoapMasTambon;
use App\Models\OoapMasTroubletype;
use App\Models\OoapMasUnit;
use App\Models\OoapTblEmployee;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblNotification;
use App\Models\OoapTblReqapprovelog;
use App\Models\OoapTblRequestFiles;
use App\Models\OoapTblRequest;
use App\Models\UmMasDepartment;

class DetailComponent extends Component
{
    public $req_id;
    public $stdate, $endate, $date_list = [], $perioddays, $wages, $target_peoples;
    public $lat, $lng, $req_moo, $req_subdistrict, $tambon_list, $req_district, $amphur_list, $province_id, $province_list, $req_leadinfo, $req_commu, $req_leadname, $req_position;
    public $reqform_no, $panel = 1, $status;
    public $acttype_id, $req_year, $fiscalyear_list, $req_dept, $dept_list, $unit_id = 1, $unit_list, $acttye_list, $buildingtype_list, $buildingtype_id;
    public $req_shortname, $troubletype_id, $troubletype_list;
    public $patternarea_id = 0, $req_desc, $req_remark, $local_material, $people_benefit_qty;
    public $area_wide, $area_long, $area_high, $area_total;
    public $req_startmonth, $req_endmonth, $req_numofday, $req_numofpeople, $req_numlecturer, $job_wage_rate, $other_rate, $job_wage_amt, $other_amt, $req_amount;
    public $created_at, $req_buildname, $building_lat, $building_long, $req_approvenote;

    public $req_coursegroup, $coursegroup_list, $req_coursesubgroup, $coursesubgroup_list, $req_course, $course_list;
    public $req_foodrate, $req_amtfood, $course_trainer_rate, $course_trainer_amt, $req_materialrate, $course_material_amt;
    public $file_array = [], $files, $file_array_old, $coursetype_list, $req_coursetype, $show = false, $req_buildtypeid, $disbutton = true;

    public $created_by;

    public function mount($pullreqform)
    {
        // dd($this->status);
        $this->req_id = $pullreqform->req_id;
        $this->req_acttype = $pullreqform->req_acttype;
        $this->reqform_no = $pullreqform->reqform_no;
        $this->req_number = $pullreqform->req_number;

        $OoapTblEmployee = OoapTblEmployee::where('emp_id', '=', auth()->user()->emp_id)->first();
        $this->req_dept = $OoapTblEmployee->division_name;
        $this->req_deptinput = $OoapTblEmployee->department_id;
        $this->req_div = $OoapTblEmployee->division_id;

        $this->req_troubletype = $pullreqform->req_troubletype;
        $this->req_peopleno = $pullreqform->req_peopleno;
        $this->req_buildtypeid = $pullreqform->req_buildtypeid;
        $this->req_measure = $pullreqform->req_measure;
        $this->req_metric = $pullreqform->req_metric;
        $this->req_width = $pullreqform->req_width;
        $this->req_length = $pullreqform->req_length;
        $this->req_height = $pullreqform->req_height;
        $this->req_unit = $pullreqform->req_unit;
        $this->dept_list = UmMasDepartment::pluck('dept_name_th', 'dept_id');
        $this->created_at = date($pullreqform->created_at);
        $this->req_year = $pullreqform->req_year;
        $this->fiscalyear_list = OoapTblFiscalyear::pluck('fiscalyear_code', 'fiscalyear_code as new');
        $this->acttye_list = OoapMasActtype::pluck('name', 'id');
        $this->troubletype_list = OoapMasTroubletype::pluck('name', 'id');
        $this->unit_list = OoapMasUnit::pluck('name', 'id');
        $this->province_list = OoapMasProvince::pluck('province_name', 'province_id');
        $this->buildingtype_list = OoapMasBuildingtype::pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::pluck('name', 'patternarea_id');
        $this->req_buildtypeid = $pullreqform->req_buildtypeid;

        $this->req_coursegroup = $pullreqform->req_coursegroup;
        $this->req_coursetype =  $pullreqform->req_coursetype;
        $this->coursegroup_list = OoapMasCoursegroup::where('in_active', '=', false)
            ->where('acttype_id', '=', 2)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->req_coursesubgroup =  $pullreqform->req_coursesubgroup;
        $this->coursesubgroup_list = OoapMasCoursesubgroup::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->req_coursegroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->coursetype_list = OoapMasCoursetype::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->req_coursegroup)->where('coursesubgroup_id', '=', $this->req_coursesubgroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->req_course =  $pullreqform->req_course;
        $this->course_list = OoapMasCourse::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->req_coursegroup)->where('coursesubgroup_id', '=', $this->req_coursesubgroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->req_shortname = $pullreqform->req_shortname;
        $this->req_desc = $pullreqform->req_desc;
        $this->req_remark = $pullreqform->req_remark;
        $this->req_buildname = $pullreqform->req_buildname;
        $this->building_lat = $pullreqform->req_latitude;
        $this->building_long = $pullreqform->req_longtitude;
        $this->province_id = $pullreqform->req_province;
        $this->req_district = $pullreqform->req_district;
        $this->req_subdistrict = $pullreqform->req_subdistrict;
        $this->req_moo = $pullreqform->req_moo;
        $this->req_leadinfo = $pullreqform->req_leadinfo;
        $this->req_commu = $pullreqform->req_commu;
        $this->req_leadname = $pullreqform->req_leadname;
        $this->req_position = $pullreqform->req_position;

        $this->stdate = dateToMontYears($pullreqform->req_startmonth);
        $this->endate = dateToMontYears($pullreqform->req_endmonth);
        $this->req_startmonth = $pullreqform->req_startmonth;
        $this->req_endmonth = $pullreqform->req_endmonth;

        $this->req_numofday = $pullreqform->req_numofday;
        $this->req_startmonth = $pullreqform->req_startmonth;
        $this->req_endmonth = $pullreqform->req_endmonth;
        $this->req_numofpeople = $pullreqform->req_numofpeople;
        $this->req_numlecturer = $pullreqform->req_numlecturer;
        $this->req_foodrate = $pullreqform->req_foodrate;
        $this->course_trainer_rate = $pullreqform->req_rate;
        $this->req_materialrate = $pullreqform->req_materialrate;
        $this->other_amt = $pullreqform->req_otheramt;
        $this->req_amtfood = $pullreqform->req_amtfood;
        $this->course_trainer_amt = $pullreqform->req_amtlecturer;
        $this->course_material_amt = $pullreqform->req_materialamt;
        $this->req_amount = $pullreqform->req_amount;
        $this->status = $pullreqform->status;
        $this->created_by = $pullreqform->created_by;
        $this->req_approvenote = $pullreqform->req_approvenote;
        $this->req_hrperday = $pullreqform->req_hrperday;

        $this->amphur_list = OoapMasAmphur::where('province_id', '=', $this->province_id)->pluck('amphur_name', 'amphur_id');
        $this->tambon_list = OoapMasTambon::where('amphur_id', '=', $this->req_district)->pluck('tambon_name', 'tambon_id');
        $this->dept_list = UmMasDepartment::pluck('dept_name_th', 'dept_id');

        if ($this->status == 1 || $this->status == 5) {
            $this->formdisabled = false;
        }

        if($this->status >= 3){
            $this->disbutton = false;
        }

        $this->file_array_old = OoapTblRequestFiles::where('req_id', '=', $this->req_id)->where('in_active', '=', false)->get()->toArray() ?? [];
    }

    public function submitapprove($status)
    {
        if ($status == 3) {
            OoapTblRequest::where('req_id', '=', $this->req_id)->update([
                //'req_approvenote' => $this->req_approvenote,
                'status' => $status,
                'req_approvedate' => now(),
                'req_approveby' => auth()->user()->emp_citizen_id,
                'updated_at' => now(),
                'updated_by' => auth()->user()->emp_citizen_id,
            ]);

            if ($this->req_acttype == 1) {
                $notis = [
                    'noti_name' => 'เลขที่ร้องขอ ' . $this->req_number . ' ผ่านการพิจารณา',
                    'noti_detail' => '',
                    'noti_to' => [$this->created_by],
                    // 'noti_to' => ['all'],
                    // 'noti_to' => [],
                    'noti_link' => route('request.hire.edit', ['id' => $this->req_id]),
                ];
            } else {
                $notis = [
                    'noti_name' => 'เลขที่ร้องขอ ' . $this->req_number . ' ผ่านการพิจารณา',
                    'noti_detail' => '',
                    'noti_to' => [$this->created_by],
                    // 'noti_to' => ['all'],
                    // 'noti_to' => [],
                    'noti_link' => route('request.train.edit', ['id' => $this->req_id]),
                ];
            }

            OoapTblNotification::create_($notis);
        }
        if ($status == 4) {

            $this->validate([
                'req_approvenote' => 'required',
            ], [
                'req_approvenote.required' => 'โปรดระบุเหตุผล',
            ]);

            OoapTblRequest::where('req_id', '=', $this->req_id)->update([
                'req_approvenote' => $this->req_approvenote,
                'status' => $status,
                'updated_at' => now(),
                // 'updated_by' => auth()->user()->emp_citizen_id,
            ]);

            if ($this->req_acttype == 1) {
                $notis = [
                    'noti_name' => 'เลขที่ร้องขอ ' . $this->req_number . ' ไม่ผ่านการพิจารณา',
                    'noti_detail' => '',
                    'noti_to' => [$this->created_by],
                    // 'noti_to' => ['all'],
                    // 'noti_to' => [],
                    'noti_link' => route('request.hire.edit', ['id' => $this->req_id]),
                ];
            } else {
                $notis = [
                    'noti_name' => 'เลขที่ร้องขอ ' . $this->req_number . ' ไม่ผ่านการพิจารณา',
                    'noti_detail' => '',
                    'noti_to' => [$this->created_by],
                    // 'noti_to' => ['all'],
                    // 'noti_to' => [],
                    'noti_link' => route('request.train.edit', ['id' => $this->req_id]),
                ];
            }

            OoapTblNotification::create_($notis);
        }
        if ($status == 5) {

            $this->validate([
                'req_approvenote' => 'required',
            ], [
                'req_approvenote.required' => 'โปรดระบุเหตุผล',
            ]);

            OoapTblRequest::where('req_id', '=', $this->req_id)->update([
                'req_approvenote' => $this->req_approvenote,
                'status' => $status,
                'updated_at' => now(),
                // 'updated_by' => auth()->user()->emp_citizen_id,
            ]);


            if ($this->req_acttype == 1) {
                $notis = [
                    'noti_name' => 'เลขที่ร้องขอ ' . $this->req_number . ' ส่งคำขอกลับให้แก้ไข',
                    'noti_detail' => '',
                    'noti_to' => [$this->created_by],
                    // 'noti_to' => ['all'],
                    // 'noti_to' => [],
                    'noti_link' => route('request.hire.edit', ['id' => $this->req_id]),
                ];
            } else {
                $notis = [
                    'noti_name' => 'เลขที่ร้องขอ ' . $this->req_number . ' ส่งคำขอกลับให้แก้ไข',
                    'noti_detail' => '',
                    'noti_to' => [$this->created_by],
                    // 'noti_to' => ['all'],
                    // 'noti_to' => [],
                    'noti_link' => route('request.train.edit', ['id' => $this->req_id]),
                ];
            }

            OoapTblNotification::create_($notis);
        }
        OoapTblReqapprovelog::create([
            'log_type' => 'APP',
            'ref_id' => $this->req_id,
            'log_date' => now(),
            'log_actions' => 'การยืนยันคำขอจัดสรรงบ',
            'log_details' => $this->req_approvenote,
            'status' => $status,
        ]);

        $this->emit('popup');
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('request.consider.index');
    }

    public function render()
    {
        $this->emit('emits');
        return view('livewire.request.consider.detail-component');
    }
}
