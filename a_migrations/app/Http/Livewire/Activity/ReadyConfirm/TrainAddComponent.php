<?php

namespace App\Http\Livewire\Activity\ReadyConfirm;

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
use App\Models\OoapTblActapprovelog;
use App\Models\OoapTblActivities;
use App\Models\OoapTblActivityFiles;
use App\Models\OoapTblAssess;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblEmployee;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblReqformFiles;
use App\Models\OoapTblRequest;
use App\Models\OoapTblRequestFiles;
use App\Models\UmMasDepartment;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

use function PHPUnit\Framework\isEmpty;

class TrainAddComponent extends Component
{
    use WithFileUploads;
    public $stdate, $endate, $date_list = [], $perioddays, $wages, $target_peoples;
    public $lat, $lng, $act_moo, $act_subdistrict, $tambon_list, $act_district, $amphur_list, $act_province, $province_list, $act_leadinfo, $act_commu, $act_leadname, $act_position;
    public $act_number, $panel = 1, $status = 1, $acttype2;
    public $acttype_id, $act_year, $fiscalyear_list, $act_dept, $dept_list, $unit_id = 1, $unit_list, $acttye_list, $act_acttype, $buildingtype_list, $buildingtype_id;
    public $act_shortname, $troubletype_id, $troubletype_list;
    public $patternarea_id = 0, $act_desc, $act_remark, $local_material, $people_benefit_qty;
    public $area_wide, $area_long, $area_high, $area_total;
    public $act_startmonth, $act_endmonth, $act_numofday, $act_numofpeople, $act_numlecturer, $job_wage_rate, $other_rate, $job_wage_amt, $other_amt, $act_amount;
    public $created_at, $act_buildname, $building_lat, $building_long, $act_hrperday, $act_periodno;

    public $act_coursegroup, $coursegroup_list, $act_coursesubgroup, $coursesubgroup_list, $act_course, $course_list;
    public $act_foodrate, $act_amtfood, $course_trainer_rate, $course_trainer_amt, $act_materialrate, $course_material_amt;

    public $file_array = [], $files, $a = 1, $file_array_old = [];
    public $circle1 = false,  $circle2 = false,  $circle3 = false,  $circle4 = false,  $circle5 = false;
    public $alert1 = false,  $alert2 = false,  $alert3 = false,  $alert4 = false,  $alert5 = false, $distext = true;
    public $ch_1 = false, $ch_2 = false, $show, $ref_number_list = [], $ref_number;
    public $emp_province_id, $province_disabled = false, $periodno_list = [], $act_buildtypeid, $act_coursetype, $act_ref_number;
    public $food_r, $trainer_r;

    public function latLng($latlng)
    {
        // dd($latlng);
        $this->building_lat = $latlng['lat'];
        $this->building_long = $latlng['lng'];
    }

    public function submit_file_array()
    {
        // dd($this->files);
        $this->validate([
            'files' => 'required',
        ], [
            'files.required' => 'กรุณาเลือกไฟล์',
        ]);
        array_push($this->file_array, $this->files);
        $this->files = null;
    }

    public function destroy_array($key)
    {
        unset($this->file_array[$key]);
        $this->file_array = array_values($this->file_array);
    }

    public function destroy_old_array($key)
    {
        unset($this->file_array_old[$key]);
        $this->file_array_old = array_values($this->file_array_old);
    }

    public function mount()
    {
        $fis_year = OoapTblFiscalyear::select('fiscalyear_code')
            // ->where('req_status', 1)
            ->where('in_active', '=', false)
            ->get()->toArray() ?? [];

        $this->fiscalyear_list = OoapTblRequest::where('in_active', '=', false)
            ->whereIn('req_year', $fis_year)
            ->where('req_div', '=', auth()->user()->division_id)
            ->where('req_acttype', '=', 2)
            ->whereNotIn('status', [1, 5])
            ->pluck('req_year', 'req_year as new');

        $this->act_year = $this->fiscalyear_list->first();
        $this->acttye_list = OoapMasActtype::where('inactive', false)->pluck('name', 'id');
        $this->troubletype_list = OoapMasTroubletype::where('inactive', false)->pluck('name', 'id');
        $this->unit_list = OoapMasUnit::where('inactive', false)->pluck('name', 'id');
        $this->province_list = OoapMasProvince::where('in_active', false)->pluck('province_name', 'province_id');
        $emp_province_id = auth()->user()->province_id;
        if ($emp_province_id != null) {
            $this->act_province = $emp_province_id;
            $this->province_disabled = true;
        }
        $this->created_at = date("Y-m-d");
        $this->act_acttype = 2;
        $this->other_amt = sprintf('%0.2f', 0);
        $this->buildingtype_list = OoapMasBuildingtype::where('acttype_id', '=', 2)->where('in_active', false)->pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::where('in_active', false)->pluck('name', 'patternarea_id');

        $this->coursegroup_list = OoapMasCoursegroup::where('in_active', '=', false)
            ->where('acttype_id', '=', 2)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->coursesubgroup_list = OoapMasCoursesubgroup::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->act_coursegroup)
            ->orderby('name', 'asc')->pluck('name', 'id');
        $this->coursetype_list = OoapMasCoursetype::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->act_coursegroup)->where('coursesubgroup_id', '=', $this->act_coursesubgroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->course_list = OoapMasCourse::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->act_coursegroup)->where('coursesubgroup_id', '=', $this->act_coursesubgroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->acttype2 = OoapMasActtype::where('inactive', '=', false)->where('id', '=', 2)->first();
        if ($this->acttype2) {
            $this->act_foodrate = sprintf('%0.2f', $this->acttype2->couse_lunch_maxrate);
            $this->course_trainer_rate = sprintf('%0.2f', $this->acttype2->couse_trainer_maxrate);
            $this->food_r = $this->acttype2->couse_lunch_maxrate;
            $this->trainer_r = $this->acttype2->couse_trainer_maxrate;
            $this->act_materialrate = sprintf('%0.2f', $this->acttype2->couse_material_maxrate);
        } else {
            $this->act_foodrate = sprintf('%0.2f', 240);
            $this->course_trainer_rate = sprintf('%0.2f', 600);
            $this->food_r =  sprintf('%0.2f', 240);
            $this->trainer_r = sprintf('%0.2f', 600);
            $this->act_materialrate = sprintf('%0.2f', 2000);
        }

        $pull_template = OoapTblAssess::where('in_active', 0)->latest()->first();
        if ($pull_template) {
            $this->templateno = $pull_template->assess_templateno;
        } else {
            $this->templateno = null;
        }
    }

    public function submit_prototype($status)
    {
        if ($this->act_year == null || $this->act_dept == null || $this->act_ref_number == null) {
            $this->alert1 = true;
        } else {
            $this->alert1 = false;
        }
        if ($this->act_coursegroup == null || $this->act_shortname == null || $this->act_desc == null || $this->act_buildname == null || $this->act_buildtypeid == null) {
            $this->alert2 = true;
        } else {
            $this->alert2 = false;
        }
        if ($this->act_province == null || $this->act_district == null || $this->act_subdistrict == null) {
            $this->alert3 = true;
        } else {
            $this->alert3 = false;
        }
        if ($this->act_numofpeople == null || $this->act_numlecturer == null || $this->act_numofday == null || ((new DateTime(montYearsToDate($this->stdate))) > (new DateTime(montYearsToDate($this->endate))))) {
            $this->alert4 = true;
        } else {
            $this->alert4 = false;
        }

        $this->validate([
            'act_year' => 'required',
            // 'act_periodno' => 'required',
            'act_coursegroup' => 'required',
            'act_shortname' => 'required',
            'act_desc' => 'required',
            'act_buildname' => 'required',
            'act_numofpeople' => 'required',
            'act_numlecturer' => 'required',
            'act_numofday' => 'required',
            'act_province' => 'required',
            'act_district' => 'required',
            'act_subdistrict' => 'required',
            'act_buildtypeid' => 'required',
            // 'act_position' => 'required',
            // 'act_leadname' => 'required',
            // 'act_leadinfo' => 'required',
            'stdate' => 'required|date_format:m-Y|before_or_equal:endate',
            'endate' => 'required|date_format:m-Y|after_or_equal:stdate',
        ], [
            'act_buildtypeid.required' => 'กรุณาเลือก ประเภทหลักสูตร',
            'act_year.required' => 'กรุณาเลือก ปีงบประมาณ',
            // 'act_periodno.required' => 'กรุณากรอก จำนวนงวดที่',
            'act_coursegroup.required' => 'กรุณาเลือก กลุ่มหลักสูตร',
            'act_shortname.required' => 'กรุณากรอก ชื่อกิจกรรม',
            'act_desc.required' => 'กรุณากรอก รายละเอียดกิจกรรม',
            'act_buildname.required' => 'กรุณากรอก ชื่อสถานที่',
            'act_numofpeople.required' => 'กรุณากรอก จำนวนคน',
            'act_numlecturer.required' => 'กรุณากรอก จำนวนวิทยากร',
            'act_numofday.required' => 'กรุณากรอก จำนวนวัน',
            'act_province.required' => 'กรุณากรอก จังหวัด',
            'act_district.required' => 'กรุณากรอก อำเภอ',
            'act_subdistrict.required' => 'กรุณากรอก ตำบล',
            // 'act_position.required' => 'กรุณากรอก ตำแหน่งผู้นำชุมชน',
            // 'act_leadname.required' => 'กรุณากรอก ชื่อผู้นำชุมชน',
            // 'act_leadinfo.required' => 'กรุณากรอก ข้อมูลผู้นำชุมชน',
            'stdate.required' => 'กรุณากรอก เดือนที่เริ่ม',
            'stdate.before_or_equal' => 'เดือนที่เริ่ม ต้องน้อยกว่าหรือเท่ากับ เดือนที่สิ้นสุด',
            'endate.required' => 'กรุณากรอก เดือนที่สิ้นสุด',
            'endate.after_or_equal' => 'เดือนที่สิ้นสุด ต้องมากว่าหรือเท่ากับ เดือนที่เริ่ม',
        ]);

        $data = OoapTblActivities::create([
            'act_number' => $this->act_number,
            'act_year' => $this->act_year,
            'act_dept' => $this->act_deptinput,
            'act_div' => $this->act_div,
            // 'act_periodno' => $this->act_periodno,
            'act_acttype' => 2,
            'act_coursegroup' => $this->act_coursegroup,
            'act_coursesubgroup' => $this->act_coursesubgroup,
            'act_course' => $this->act_course,
            'act_shortname' => $this->act_shortname,
            'act_desc' => $this->act_desc,
            'act_remark' => $this->act_remark,
            'act_buildtypeid' => $this->act_buildtypeid,

            'act_commu' => $this->act_commu,
            'act_leadname' => $this->act_leadname,
            'act_position' => $this->act_position,
            'act_leadinfo' => $this->act_leadinfo,
            'templateno' => $this->templateno,
            'act_coursetype' => $this->act_coursetype,

            'act_buildname' => $this->act_buildname,
            'act_moo' => $this->act_moo,
            'act_subdistrict' => $this->act_subdistrict,
            'act_district' => $this->act_district,
            'act_province' => $this->act_province,
            'act_latitude' => $this->building_lat,
            'act_longtitude' => $this->building_long,
            'act_startmonth' => $this->act_startmonth,
            'act_endmonth' => $this->act_endmonth,
            'act_numofday' => $this->act_numofday,
            'act_hrperday' => 6,
            'act_numofpeople' => $this->act_numofpeople,
            'act_numlecturer' => $this->act_numlecturer,
            'act_foodrate' => $this->act_foodrate,
            'act_rate' => $this->course_trainer_rate,
            'act_materialrate' => $this->act_materialrate,
            'act_amtfood' => $this->act_amtfood,
            'act_amtlecturer' => $this->course_trainer_amt,
            'act_materialamt' => $this->course_material_amt,
            'act_otheramt' => $this->other_amt,
            'act_ref_number' => $this->act_ref_number,
            'act_amount' => $this->act_amount,
            'status' => 1,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now(),
        ]);

        if (!empty($this->file_array)) {
            $path_file = '/activities';
            foreach ($this->file_array as $file) {
                $file->store('/public' . $path_file);
                OoapTblActivityFiles::create([
                    'files_ori' => $file->getClientOriginalName(),
                    'files_gen' => $file->hashName(),
                    'files_path' => $path_file,
                    'files_type' => $file->getMimeType(),
                    'files_size' => $file->getSize(),
                    'act_id' => $data->act_id,

                    'created_by' => auth()->user()->emp_citizen_id,
                    'created_at' => now(),
                ]);
            }
        }

        foreach ($this->file_array_old as $key => $file) {
            $search = OoapTblRequestFiles::where('in_active', '=', false)
                ->where('req_id', '=',  $this->file_array_old[$key]['req_id'])
                ->first();
            if ($search) {
                OoapTblActivityFiles::create([
                    'files_ori' => $search->files_ori,
                    'files_gen' => $search->files_gen,
                    'files_path' => $search->files_path,
                    'files_type' => $search->files_type,
                    'files_size' => $search->files_size,
                    'act_id' => $data->act_id,

                    'created_by' => auth()->user()->emp_citizen_id,
                    'created_at' => now(),
                ]);
            }
        }
        // log step
        OoapTblActapprovelog::create([
            'act_log_type' => 'APP',
            'act_ref_id' => $data->act_id,
            'act_log_date' => now(),
            'act_log_actions' => 'การยืนยันความพร้อมคำขอรับจัดสรรงบ',
            'act_log_details' => 'บันทึกความพร้อมคำขอรับจัดสรรงบ',
            'status' => 1,
        ]);

        $logs['route_name'] = 'activity.ready_confirm.train.create';
        $logs['submenu_name'] = 'บันทึกยืนยันความพร้อมคำขอการจัดสรรงบ (กิจกรรมทักษะฝีมือแรงงาน)';
        $logs['log_type'] = 'create';
        createLogTrans($logs);

        $this->emit('popup', $this->act_number);
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('activity.ready_confirm.index');
    }

    public function changPanel($num)
    {
        $this->panel = $num;
    }

    public function setArray()
    {
        $this->act_startmonth = new DateTime(montYearsToDate($this->stdate));
        $this->act_endmonth = new DateTime(montYearsToDate($this->endate));
    }

    public function setValue($name, $val)
    {
        dd($name, $val);
        $this->$name = $val;
    }

    public function back($num_panel)
    {
        $this->panel = $num_panel - 1;
    }

    public function next($num_panel)
    {
        $this->panel = $num_panel + 1;
    }

    public function validate_panel1()
    {
        if ($this->act_year == null || $this->act_dept == null || $this->act_ref_number == null) {
            $this->circle1 = false;
        } else {
            $this->circle1 = true;
        }
    }

    public function validate_panel2()
    {
        if (
            $this->act_coursegroup == null ||  $this->act_shortname == null || $this->act_desc == null || $this->act_buildname == null || $this->act_buildtypeid == null
        ) {
            $this->circle2 = false;
        } else {
            $this->circle2 = true;
        }
    }

    public function validate_panel3()
    {
        if (
            $this->act_province == null || $this->act_district == null || $this->act_subdistrict == null
        ) {
            $this->circle3 = false;
        } else {
            $this->circle3 = true;
        }
    }

    public function validate_panel4()
    {
        if (
            $this->stdate == null || $this->endate == null || $this->act_numofpeople == null || $this->act_numlecturer == null || $this->act_numofday == null || $this->act_foodrate == null ||
            $this->act_amtfood == null || $this->course_trainer_rate == null || $this->course_trainer_amt == null || $this->act_materialrate == null || $this->course_material_amt == null
            || ((new DateTime(montYearsToDate($this->stdate))) > (new DateTime(montYearsToDate($this->endate))))
        ) {
            $this->circle4 = false;
        } else {
            $this->circle4 = true;
        }
    }

    public function validate_panel5()
    {
        if (empty($this->file_array) && empty($this->file_array_old)) {
            $this->circle5 = false;
        } else {
            $this->circle5 = true;
        }
    }

    public function calsum($name, $cal)
    {
        if ($name == 'act_foodrate') {
            if ($this->act_foodrate <= $this->food_r) {
                $this->act_amtfood = sprintf('%0.2f', ($this->act_foodrate ? $this->act_foodrate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0));
            }
        }
        if ($name == 'course_trainer_rate') {
            if ($this->course_trainer_rate <= $this->trainer_r) {
                // $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_numlecturer ? $this->act_numlecturer : 0) * 6);
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_numlecturer ? $this->act_numlecturer : 0));
            }
        }
        if ($name == 'act_materialrate') {
            $this->course_material_amt = sprintf('%0.2f', ($this->act_materialrate ? $this->act_materialrate : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0));
        }
    }

    public function setnum($name, $num)
    {
        if ($num == null) {
            $num = 0;
        }
        if ($this->act_numlecturer && $this->act_numofpeople && $this->act_numofday) {
            if ($name == 'act_numofpeople') {
                $numofpeople = $num;
                $this->act_amtfood = sprintf('%0.2f', ($this->act_foodrate ? $this->act_foodrate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($numofpeople ? $numofpeople : 0));
                $this->course_material_amt = sprintf('%0.2f', ($this->act_materialrate ? $this->act_materialrate : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0));
                // $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_numlecturer ? $this->act_numlecturer : 0) * 6);
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_numlecturer ? $this->act_numlecturer : 0));
                // dd($this->course_material_amt);

            }
            if ($name == 'act_numlecturer') {
                $numlecturer = $num;
                $this->act_amtfood = sprintf('%0.2f', ($this->act_foodrate ? $this->act_foodrate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0));
                // $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * $numlecturer * 6);
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * $numlecturer);
                $this->course_material_amt = sprintf('%0.2f', ($this->act_materialrate ? $this->act_materialrate : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0));
            }
            if ($name == 'act_numofday') {
                $numofday = $num;
                $this->act_amtfood = sprintf('%0.2f', ($this->act_foodrate ?: 0) * $numofday * ($this->act_numofpeople ?: 0));
                // $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * $numofday * ($this->act_numlecturer ? $this->act_numlecturer : 0) * 6);
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * $numofday * ($this->act_numlecturer ? $this->act_numlecturer : 0));
                $this->course_material_amt = sprintf('%0.2f', ($this->act_materialrate ? $this->act_materialrate : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0));
            }
        } else {
            $this->act_amtfood = 0;
            $this->course_material_amt = 0;
            $this->course_trainer_amt = 0;
        }
    }

    public function set_ref_request($val)
    {
        if ($val == null) {
            return 0;
        }
        $pullreqform = OoapTblRequest::where('in_active', '=', false)
            ->where('req_id', '=', $val)->first();

        $this->ref_number = $pullreqform->req_number;
        $this->act_dept = $pullreqform->req_dept;

        $this->dept_list = UmMasDepartment::where('in_active', false)->pluck('dept_name_th', 'dept_id');
        $this->created_at = date($pullreqform->created_at);
        $this->act_year = $pullreqform->req_year;
        $this->troubletype_list = OoapMasTroubletype::where('inactive', false)->pluck('name', 'id');
        $this->unit_list = OoapMasUnit::where('inactive', false)->pluck('name', 'id');
        $this->province_list = OoapMasProvince::where('in_active', false)->pluck('province_name', 'province_id');
        $this->act_acttype = $pullreqform->req_acttype;
        $this->buildingtype_list = OoapMasBuildingtype::where('acttype_id', '=', 2)->where('in_active', false)->pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::where('in_active', false)->pluck('name', 'patternarea_id');

        $this->act_coursegroup = $pullreqform->req_coursegroup;
        $this->coursegroup_list = OoapMasCoursegroup::where('in_active', '=', false)
            ->where('acttype_id', '=', 2)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->act_coursesubgroup =  $pullreqform->req_coursesubgroup;
        $this->act_coursetype =  $pullreqform->req_coursetype;
        $this->coursesubgroup_list = OoapMasCoursesubgroup::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->act_coursegroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->coursetype_list = OoapMasCoursetype::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->act_coursegroup)->where('coursesubgroup_id', '=', $this->act_coursesubgroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->act_course =  $pullreqform->req_course;
        $this->course_list = OoapMasCourse::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->act_coursegroup)->where('coursesubgroup_id', '=', $this->act_coursesubgroup)->where('coursetype_id', '=', $this->act_coursetype)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->act_shortname = $pullreqform->req_shortname;
        $this->act_desc = $pullreqform->req_desc;
        $this->act_remark = $pullreqform->req_remark;
        $this->act_buildname = $pullreqform->req_buildname;
        $this->building_lat = $pullreqform->req_latitude;
        $this->building_long = $pullreqform->req_longtitude;
        $this->province_id = $pullreqform->req_province;
        $this->act_district = $pullreqform->req_district;
        $this->act_subdistrict = $pullreqform->req_subdistrict;
        $this->act_moo = $pullreqform->req_moo;
        $this->act_leadinfo = $pullreqform->req_leadinfo;
        $this->act_commu = $pullreqform->req_commu;
        $this->act_leadname = $pullreqform->req_leadname;
        $this->act_position = $pullreqform->req_position;

        $this->stdate = dateToMontYears($pullreqform->req_startmonth);
        $this->endate = dateToMontYears($pullreqform->req_endmonth);

        $this->act_numofday = $pullreqform->req_numofday;
        $this->act_startmonth = $pullreqform->req_startmonth;
        $this->act_endmonth = $pullreqform->req_endmonth;
        $this->act_numofpeople = $pullreqform->req_numofpeople;
        $this->act_numlecturer = $pullreqform->req_numlecturer;
        $this->countsum = $this->act_numofpeople;
        $this->act_foodrate = sprintf('%0.2f', $pullreqform->req_foodrate);
        $this->course_trainer_rate = sprintf('%0.2f', $pullreqform->req_rate);
        $this->act_materialrate = sprintf('%0.2f', $pullreqform->req_materialrate);
        $this->act_buildtypeid = $pullreqform->req_buildtypeid;

        $this->other_amt = sprintf('%0.2f', $pullreqform->req_otheramt);
        $this->act_approvenote = $pullreqform->req_approvenote;
        $this->course_trainer_amt = sprintf('%0.2f', $pullreqform->req_amtlecturer);
        $this->course_material_amt = sprintf('%0.2f', $pullreqform->req_materialamt);
        $this->act_amtfood = sprintf('%0.2f', $pullreqform->req_amtfood);
        $this->act_ref_number = $val;
        $this->file_array_old = OoapTblRequestFiles::where('req_id', '=', $val)->where('in_active', '=', false)->get()->toArray() ?? [];
    }

    public function render()
    {
        $this->emit('emits');
        //check rate
        if ($this->act_foodrate > $this->food_r) {
            $this->act_foodrate = sprintf('%0.2f', $this->food_r);
        }
        if ($this->course_trainer_rate > $this->trainer_r) {
            $this->course_trainer_rate = sprintf('%0.2f', $this->trainer_r);
        }

        //amount
        if ($this->act_amtfood == null) {
            $this->act_amount = sprintf('%0.2f', ($this->course_trainer_amt ? $this->course_trainer_amt : 0) + ($this->course_material_amt ? $this->course_material_amt : 0));
        }
        if ($this->course_trainer_amt == null) {
            $this->act_amount = sprintf('%0.2f', ($this->act_amtfood ? $this->act_amtfood : 0) + ($this->course_material_amt ? $this->course_material_amt : 0));
        }
        if ($this->course_material_amt == null) {
            $this->act_amount = sprintf('%0.2f', ($this->act_amtfood ? $this->act_amtfood : 0) + ($this->course_trainer_amt ? $this->course_trainer_amt : 0));
        }
        if ($this->act_amtfood != null && $this->course_trainer_amt != null && $this->course_material_amt != null) {
            $this->act_amount = sprintf('%0.2f', ($this->act_amtfood ? $this->act_amtfood : 0) + ($this->course_trainer_amt ? $this->course_trainer_amt : 0) + ($this->course_material_amt ? $this->course_material_amt : 0));
        }

        $this->amphur_list = OoapMasAmphur::where('province_id', '=', $this->act_province)->where('in_active', false)->pluck('amphur_name', 'amphur_id');
        $this->tambon_list = OoapMasTambon::where('amphur_id', '=', $this->act_district)->where('in_active', false)->pluck('tambon_name', 'tambon_id');
        $this->act_dept = auth()->user()->division_name;
        $this->act_deptinput = auth()->user()->department_id;
        $this->act_div = auth()->user()->division_id;

        $getId = OoapTblActivities::select('act_id')->where('act_year', '=', $this->act_year)->where('in_active', '=', false)->orderBy('act_id', 'DESC')->count() ?? 0;
        $this->act_number = "AT-" . substr($this->act_year, 2) . date("m") . "-" . sprintf('%04d', $getId + 1);

        if ($this->panel == 2) {
            if ($this->act_coursegroup) {
                $this->coursesubgroup_list = OoapMasCoursesubgroup::where('in_active', '=', false)
                    ->where('coursegroup_id', '=', $this->act_coursegroup)->pluck('name', 'id');
                if (!empty($this->coursesubgroup_list->toArray())) {
                    // $this->ch_1 = true;
                } else {
                    $this->act_coursesubgroup = null;
                    $this->act_course = null;
                    $this->act_coursetype = null;
                }
                if ($this->act_coursesubgroup) {
                    $this->coursetype_list = OoapMasCoursetype::where('in_active', '=', false)
                        ->where('coursegroup_id', '=', $this->act_coursegroup)->where('coursesubgroup_id', '=', $this->act_coursesubgroup)
                        ->orderby('name', 'asc')->pluck('name', 'id');
                    if (!empty($this->coursetype_list->toArray())) {
                        // $this->ch_2 = true;
                    } else {
                        $this->act_coursetype = null;
                        $this->act_course = null;
                    }
                    if ($this->act_coursetype) {
                        $this->course_list = OoapMasCourse::where('in_active', '=', false)
                            ->where('coursegroup_id', '=', $this->act_coursegroup)
                            ->where('coursesubgroup_id', '=', $this->act_coursesubgroup)
                            ->where('coursetype_id', '=', $this->act_coursetype)
                            ->orderby('name', 'asc')->pluck('name', 'id');
                        if (!empty($this->course_list->toArray())) {
                            // $this->ch_2 = true;
                        } else {
                            $this->act_course = null;
                        }
                    }
                }
            }
        }

        $this->validate_panel1();
        $this->validate_panel2();
        $this->validate_panel3();
        $this->validate_panel4();
        $this->validate_panel5();

        if ($this->circle1 && $this->circle2 && $this->circle3 && $this->circle4) {
            $this->show = true;
        } else {
            $this->show = false;
        }

        if ($this->act_year > 0) {
            $act_number_success = OoapTblActivities::select('act_ref_number')->where('in_active', '=', false)->where('act_year', '=', $this->act_year)->where('act_acttype', '=', 2)->get()->toArray() ?? [];
            $this->ref_number_list = OoapTblRequest::where('in_active', '=', false)
                ->whereNotIn('req_id', $act_number_success)
                ->where('req_year', '=', $this->act_year)
                ->where('req_div', '=', auth()->user()->division_id)
                ->where('req_acttype', '=', 2)
                ->where('status', '=', 3)
                ->pluck('req_number', 'req_id');
        } else {
            $this->act_year = $this->fiscalyear_list->first();
        }

        return view('livewire.activity.ready-confirm.train-add-component');
    }
}
