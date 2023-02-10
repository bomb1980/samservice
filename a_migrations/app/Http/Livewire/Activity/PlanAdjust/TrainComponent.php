<?php

namespace App\Http\Livewire\Activity\PlanAdjust;

use App\Models\OoapMasActtype;
use App\Models\OoapMasAmphur;
use App\Models\OoapMasBuildingtype;
use App\Models\OoapMasCourse;
use App\Models\OoapMasCoursegroup;
use App\Models\OoapMasCoursesubgroup;
use App\Models\OoapMasCoursetype;
use App\Models\OoapMasDivision;
use App\Models\OoapMasPatternarea;
use App\Models\OoapMasProvince;
use App\Models\OoapMasTambon;
use App\Models\OoapMasTroubletype;
use App\Models\OoapMasUnit;
use App\Models\OoapTblActapprovelog;
use App\Models\OoapTblActivities;
use App\Models\OoapTblActivityFiles;
use App\Models\OoapTblAllocate;
use App\Models\OoapTblAssess;
use App\Models\OoapTblEmployee;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblPlanAdjust;
use App\Models\UmMasDepartment;
use DateTime;
use Livewire\Component;
use Livewire\WithFileUploads;

class TrainComponent extends Component
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

    public $file_array = [], $files, $a = 1;
    public $circle1 = false,  $circle2 = false,  $circle3 = false,  $circle4 = false,  $circle5 = false;
    public $alert1 = false,  $alert2 = false,  $alert3 = false,  $alert4 = false,  $alert5 = false, $distext = true;
    public $ch_1 = false, $ch_2 = false;
    public $emp_province_id, $province_disabled = false, $periodno_list = [], $ref_number_list  = [];
    public $act_ref_number, $act_buildtypeid, $act_coursetype, $coursetype_list = [], $file_array_old = [];

    public function latLng($latlng)
    {
        // dd($latlng);
        $this->building_lat = $latlng['lat'];
        $this->building_long = $latlng['lng'];
    }

    public function destroy_array($key)
    {
        unset($this->file_array[$key]);
        $this->file_array = array_values($this->file_array);
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

    public function destroy_old_array($key)
    {
        unset($this->file_array_old[$key]);
        $this->file_array_old = array_values($this->file_array_old);
    }

    function mount()
    {

        $fis_year = OoapTblFiscalyear::select('fiscalyear_code')
            ->where('in_active', '=', false)
            ->get()->toArray() ?? [];

        // dd($fis_year);

        $this->fiscalyear_list = OoapTblActivities::where('in_active', '=', false)
            ->whereIn('act_year', $fis_year)
            ->where('act_div', '=', auth()->user()->division_id)
            ->where('act_acttype', '=', 2)
            ->where('status', '=', 3)
            ->pluck('act_year', 'act_year as new');

        // $this->fiscalyear_list = OoapTblFiscalyear::where('req_status', 1)
        //     ->where('req_enddate', '>=', date("Y-m-d"))
        //     ->where('in_active', false)->pluck('fiscalyear_code', 'fiscalyear_code as new');
        $this->act_year = $this->fiscalyear_list->first();
        $this->acttye_list = OoapMasActtype::where('inactive', false)->pluck('name', 'id');
        $this->troubletype_list = OoapMasTroubletype::where('inactive', false)->pluck('name', 'id');
        $this->unit_list = OoapMasUnit::where('inactive', false)->pluck('name', 'id');
        $this->province_list = OoapMasProvince::where('in_active', false)->where('province_id', '!=', 1)->pluck('province_name', 'province_id');
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

        $this->course_list = OoapMasCourse::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->act_coursegroup)->where('coursesubgroup_id', '=', $this->act_coursesubgroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->acttype2 = OoapMasActtype::where('inactive', '=', false)->where('id', '=', 2)->first();
        $this->act_foodrate = sprintf('%0.2f', $this->acttype2->couse_lunch_maxrate);
        $this->course_trainer_rate = sprintf('%0.2f', $this->acttype2->couse_trainer_maxrate);
        $this->act_materialrate = sprintf('%0.2f', $this->acttype2->couse_material_maxrate);
        // $this->act_materialrate = sprintf('%0.2f', 0);

        $pull_template = OoapTblAssess::where('in_active', 0)->latest()->first();
        if ($pull_template) {
            $this->templateno = $pull_template->assess_templateno;
        } else {
            $this->templateno = null;
        }
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
            $this->act_acttype == null || $this->act_coursegroup == null ||  $this->act_shortname == null || $this->act_desc == null || $this->act_buildname == null || $this->act_buildtypeid == null
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

    public function changPanel($num)
    {
        $this->panel = $num;
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('activity.plan_adjust.index');
    }

    public function setArray()
    {
        $this->act_startmonth = new DateTime(montYearsToDate($this->stdate));
        $this->act_endmonth = new DateTime(montYearsToDate($this->endate));
    }

    public function calsum($name, $cal)
    {
        if ($name == 'act_foodrate') {
            if ($this->act_foodrate <= $this->acttype2->couse_lunch_maxrate) {
                $this->act_amtfood = sprintf('%0.2f', ($this->act_foodrate ? $this->act_foodrate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0));
            }
        }
        if ($name == 'course_trainer_rate') {
            if ($this->course_trainer_rate <= $this->acttype2->couse_trainer_maxrate) {
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_numlecturer ? $this->act_numlecturer : 0));
            }
        }
        if ($name == 'act_materialrate') {
            $this->course_material_amt = sprintf('%0.2f', ($this->act_materialrate ? $this->act_materialrate : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0));
        }
    }

    public function setnum($name, $num)
    {
        // dd($name);
        if ($num == null) {
            $num = 0;
        }
        if ($this->act_numlecturer && $this->act_numofpeople && $this->act_numofday) {
            if ($name == 'act_numofpeople') {
                $numofpeople = $num;
                $this->act_amtfood = sprintf('%0.2f', ($this->act_foodrate ? $this->act_foodrate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($numofpeople ? $numofpeople : 0));
                $this->course_material_amt = sprintf('%0.2f', ($this->act_materialrate ? $this->act_materialrate : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0));
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_numlecturer ? $this->act_numlecturer : 0));
                // dd($this->course_material_amt);

            }
            if ($name == 'act_numlecturer') {
                $numlecturer = $num;
                $this->act_amtfood = sprintf('%0.2f', ($this->act_foodrate ? $this->act_foodrate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0));
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * $numlecturer);
                $this->course_material_amt = sprintf('%0.2f', ($this->act_materialrate ? $this->act_materialrate : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0));
            }
            if ($name == 'act_numofday') {
                $numofday = $num;
                $this->act_amtfood = sprintf('%0.2f', ($this->act_foodrate ?: 0) * $numofday * ($this->act_numofpeople ?: 0));
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * $numofday * ($this->act_numlecturer ? $this->act_numlecturer : 0));
                $this->course_material_amt = sprintf('%0.2f', ($this->act_materialrate ? $this->act_materialrate : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0));
            }
        } else {
            $this->act_amtfood = 0;
            $this->course_material_amt = 0;
            $this->course_trainer_amt = 0;
        }
    }

    public function submit_prototype($status)
    {
        // dd('waiting db');

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

        $data = OoapTblActivities::where('act_id', '=', $this->act_ref_number)->update([
            // 'act_year' => $this->act_year,
            // 'act_dept' => $this->act_deptinput,
            // 'act_div' => $this->act_div,
            // 'act_acttype' => 2,
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
            // 'templateno' => $this->templateno,

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
            'act_amount' => $this->act_amount,
            'status' => 4,
            'updated_at' => now(),
            'updated_by' => auth()->user()->emp_citizen_id,
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
                    'act_id' => $this->act_ref_number,

                    'created_by' => auth()->user()->emp_citizen_id,
                    'created_at' => now(),
                ]);
            }
        }

        foreach ($this->file_array_old as $key => $file) {
            $search = OoapTblActivityFiles::where('in_active', '=', false)
                ->where('act_id', '=',  $this->file_array_old[$key]['act_id'])
                ->first();
            if ($search) {
                OoapTblActivityFiles::create([
                    'files_ori' => $search->files_ori,
                    'files_gen' => $search->files_gen,
                    'files_path' => $search->files_path,
                    'files_type' => $search->files_type,
                    'files_size' => $search->files_size,
                    'act_id' => $this->act_ref_number,

                    'created_by' => auth()->user()->emp_citizen_id,
                    'created_at' => now(),
                ]);
            }
        }

        $division = OoapTblEmployee::where('in_active', '=', false)->where('emp_citizen_id', '=', auth()->user()->emp_citizen_id)->select('division_id')->first();
        $division_name = OoapMasDivision::where('in_active', '=', false)->where('division_id', '=', $division->division_id)->first();
        $allocate_manage = OoapTblFiscalyear::where('in_active', '=', false)->where('fiscalyear_code', '=', 2565)->select('regionbudget_amt')->first();
        $act = OoapTblActivities::where('in_active', '=', false)
            ->where('status', '=', '4')
            ->where('act_year', '=', $this->act_year)
            ->where('act_div', '=', $division->division_id);

        $sum_urgent = clone $act;
        $sum_urgent = $sum_urgent->where('act_acttype', '=', 1)->select('act_amount')->sum('act_amount');
        $count_urgent = clone $act;
        $count_urgent = $count_urgent->where('act_acttype', '=', 1)->count();
        $sum_training = clone $act;
        $sum_training = $sum_training->where('act_acttype', '=', 2)->select('act_amount')->sum('act_amount');
        $count_training = clone $act;
        $count_training = $count_training->where('act_acttype', '=', 2)->count();

        OoapTblAllocate::where('budgetyear', '=', $this->act_year)->where('division_id', '=', $division->division_id)->update([
            'count_urgent' => $count_urgent,
            'count_training' => $count_training,
            'sum_urgent' => $sum_urgent,
            'sum_training' => $sum_training,
            'remember_token' => csrf_token(),
            'updated_at' => now(),
            'updated_by' => auth()->user()->emp_citizen_id,
        ]);

        // OoapTblAllocate::where()->create([
        //     'budgetyear' => $this->act_year,
        //     'periodno' => null,
        //     'division_id' => $division->division_id,
        //     'allocate_manage' => null,
        //     'division_name' => $division_name->division_name,
        //     'count_urgent' => $count_urgent,
        //     'count_training' => $count_training,
        //     'sum_urgent' => $sum_urgent,
        //     'sum_training' => $sum_training,
        //     'allocate_urgent' => null,
        //     'allocate_training' => null,
        //     'remember_token' => csrf_token(),
        //     'created_by' => auth()->user()->emp_citizen_id,
        //     'created_at' => now(),
        // ]);

        OoapTblActapprovelog::create([
            'act_log_type' => 'APP',
            'act_ref_id' => $this->act_ref_number,
            'act_log_date' => now(),
            'act_log_actions' => 'บันทึกข้อมูลปรับแผน/โครงการ',
            'act_log_details' => 'ส่งพิจารณาการปรับแผน',
            'status' => 4,
        ]);


        // if (!empty($this->file_array)) {
        //     $path_file = '/activities';
        //     foreach ($this->file_array as $file) {
        //         $file->store('/public' . $path_file);
        //         OoapTblActivityFiles::create([
        //             'files_ori' => $file->getClientOriginalName(),
        //             'files_gen' => $file->hashName(),
        //             'files_path' => $path_file,
        //             'files_type' => $file->getMimeType(),
        //             'files_size' => $file->getSize(),
        //             'act_id' => $data->act_id,

        //             'created_by' => auth()->user()->emp_citizen_id,
        //             'created_at' => now(),
        //         ]);
        //     }
        // }
        $logs['route_name'] = 'activity.ready_confirm.train.create';
        $logs['submenu_name'] = 'บันทึกยืนยันข้อมูลปรับแผน/โครงการ (กิจกรรมทักษะฝีมือแรงงาน)';
        $logs['log_type'] = 'create';
        createLogTrans($logs);

        $this->emit('popup', $this->act_number);
    }

    public function set_ref_request($val)
    {
        if ($val == null) {
            return 0;
        }
        $pullactivities = OoapTblActivities::where('in_active', '=', false)
            ->where('act_id', '=', $val)->first();

        $this->act_dept = $pullactivities->act_dept;
        $this->dept_list = UmMasDepartment::where('in_active', false)->pluck('dept_name_th', 'dept_id');
        $this->created_at = date($pullactivities->created_at);
        $this->act_year = $pullactivities->act_year;
        $this->act_periodno = $pullactivities->act_periodno;
        $this->act_buildtypeid = $pullactivities->act_buildtypeid;

        // $this->fiscalyear_list = OoapTblFiscalyear::where('req_status', 1)
        //     ->where('req_enddate', '>=', date("Y-m-d"))
        //     ->where('in_active', false)->pluck('fiscalyear_code', 'fiscalyear_code as new');

        $this->acttye_list = OoapMasActtype::where('inactive', false)->pluck('name', 'id');
        $this->troubletype_list = OoapMasTroubletype::where('inactive', false)->pluck('name', 'id');
        $this->unit_list = OoapMasUnit::where('inactive', false)->pluck('name', 'id');
        $this->province_list = OoapMasProvince::where('in_active', false)->pluck('province_name', 'province_id');
        $this->acttye_id = $pullactivities->act_acttype;
        $this->buildingtype_list = OoapMasBuildingtype::where('acttype_id', '=', 2)->where('in_active', false)->pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::where('in_active', false)->pluck('name', 'patternarea_id');

        $this->act_coursegroup = $pullactivities->act_coursegroup;
        $this->coursegroup_list = OoapMasCoursegroup::where('in_active', '=', false)
            ->where('acttype_id', '=', 2)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->act_coursesubgroup =  $pullactivities->act_coursesubgroup;
        $this->coursesubgroup_list = OoapMasCoursesubgroup::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->act_coursegroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->coursetype_list = OoapMasCoursetype::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->act_coursegroup)->where('coursesubgroup_id', '=', $this->act_coursesubgroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->act_course =  $pullactivities->act_course;
        $this->course_list = OoapMasCourse::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->act_coursegroup)->where('coursesubgroup_id', '=', $this->act_coursesubgroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->act_shortname = $pullactivities->act_shortname;
        $this->act_desc = $pullactivities->act_desc;
        $this->act_remark = $pullactivities->act_remark;
        $this->act_buildname = $pullactivities->act_buildname;
        $this->building_lat = $pullactivities->act_latitude;
        $this->building_long = $pullactivities->act_longtitude;
        $this->province_id = $pullactivities->act_province;
        $this->act_district = $pullactivities->act_district;
        $this->act_subdistrict = $pullactivities->act_subdistrict;
        $this->act_moo = $pullactivities->act_moo;
        $this->act_leadinfo = $pullactivities->act_leadinfo;
        $this->act_commu = $pullactivities->act_commu;
        $this->act_leadname = $pullactivities->act_leadname;
        $this->act_position = $pullactivities->act_position;
        $this->act_coursetype = $pullactivities->act_coursetype;

        $this->stdate = dateToMontYears($pullactivities->act_startmonth);
        $this->endate = dateToMontYears($pullactivities->act_endmonth);

        $this->act_startmonth = $pullactivities->act_startmonth;
        $this->act_endmonth = $pullactivities->act_endmonth;

        $this->act_numofday = $pullactivities->act_numofday;
        $this->act_numofpeople = $pullactivities->act_numofpeople;
        $this->act_numlecturer = $pullactivities->act_numlecturer;
        $this->countsum = $this->act_numofpeople + $this->act_numlecturer;
        $this->act_foodrate = sprintf('%0.2f', $pullactivities->act_foodrate);
        $this->course_trainer_rate = sprintf('%0.2f', $pullactivities->act_rate);
        $this->act_materialrate = sprintf('%0.2f', $pullactivities->act_materialrate);

        $this->other_amt = sprintf('%0.2f', $pullactivities->act_otheramt);
        // $this->status = $pullactivities->status;
        $this->act_approvenote = $pullactivities->act_approvenote;
        $this->course_trainer_amt = sprintf('%0.2f', $pullactivities->act_amtlecturer);
        $this->course_material_amt = sprintf('%0.2f', $pullactivities->act_materialamt);
        $this->act_amtfood = sprintf('%0.2f', $pullactivities->act_amtfood);

        $this->act_ref_number = $val;
        $this->file_array_old = OoapTblActivityFiles::where('act_id', '=', $val)->where('in_active', '=', false)->get()->toArray() ?? [];
    }


    public function render()
    {
        $this->emit('emits');

        if ($this->act_foodrate > $this->acttype2->couse_lunch_maxrate) {
            $this->act_foodrate = sprintf('%0.2f', $this->acttype2->couse_lunch_maxrate);
        }
        if ($this->course_trainer_rate > $this->acttype2->couse_trainer_maxrate) {
            $this->course_trainer_rate = sprintf('%0.2f', $this->acttype2->couse_trainer_maxrate);
        }

        if ($this->other_amt > 0) {
            $this->act_amount = sprintf('%0.2f', ($this->act_amtfood ? $this->act_amtfood : 0) + ($this->course_trainer_amt ? $this->course_trainer_amt : 0) + ($this->course_material_amt ? $this->course_material_amt : 0) + ($this->other_amt ? $this->other_amt : 0));
        } else {
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
        }
        if ($this->act_numlecturer && $this->act_numofpeople && $this->act_numofday) {
            $this->distext = false;
        } else {
            $this->distext = true;
        }

        $this->amphur_list = OoapMasAmphur::where('province_id', '=', $this->act_province)->where('in_active', false)->pluck('amphur_name', 'amphur_id');
        $this->tambon_list = OoapMasTambon::where('amphur_id', '=', $this->act_district)->where('in_active', false)->pluck('tambon_name', 'tambon_id');
        $this->act_dept = auth()->user()->division_name;
        $this->act_deptinput = auth()->user()->department_id;
        $this->act_div = auth()->user()->division_id;

        // $getId = OoapTblPlanAdjust::select('plan_id')->where('plan_year', '=', $this->act_year)->orderBy('plan_id', 'DESC')->count() ?? 1;
        // $this->act_number = "PA-" . substr($this->act_year, 2) . date("m") . "-" . sprintf('%04d', $getId + 1);

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

        if ($this->act_year > 0) {
            $this->ref_number_list = OoapTblActivities::where('in_active', '=', false)
                ->where('act_year', '=', $this->act_year)
                ->where('act_div', '=', auth()->user()->division_id)
                ->where('act_acttype', '=', 2)
                ->whereIn('status', [3])
                ->pluck('act_number', 'act_id');
        } else {
            $this->act_year = $this->fiscalyear_list->first();
        }

        return view('livewire.activity.plan-adjust.train-component');
    }
}
