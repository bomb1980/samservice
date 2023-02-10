<?php

namespace App\Http\Livewire\Activity\PlanAdjust;


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
use App\Models\OoapTblEmployee;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblRequest;
use App\Models\OoapTblRequestFiles;
use App\Models\OoapTblActivities;
use App\Models\OoapTblActivityFiles;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\UmMasDepartment;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class TrainEditComponent extends Component
{
    use WithFileUploads;
    public $act_id;
    public $stdate, $endate, $date_list = [], $perioddays, $wages, $target_peoples;
    public $lat, $lng, $act_moo, $act_subdistrict, $tambon_list, $act_district, $amphur_list, $province_id, $province_list, $act_leadinfo, $act_commu, $act_leadname, $act_position;
    public $act_number, $panel = 1, $status;
    public $acttype_id, $act_year, $fiscalyear_list, $act_dept, $dept_list, $unit_id = 1, $unit_list, $acttye_list, $acttye_id, $buildingtype_list, $buildingtype_id;
    public $act_shortname, $troubletype_id, $troubletype_list;
    public $patternarea_id = 0, $act_desc, $act_remark, $local_material, $people_benefit_qty;
    public $area_wide, $area_long, $area_high, $area_total;
    public $act_startmonth, $act_endmonth, $act_numofday, $act_numofpeople, $act_numlecturer, $job_wage_rate, $other_rate, $job_wage_amt, $other_amt, $act_amount;
    public $created_at, $act_buildname, $building_lat, $building_long, $act_hrperday, $act_periodno, $act_approvenote, $countsum;

    public $act_coursegroup, $coursegroup_list, $act_coursesubgroup, $coursesubgroup_list, $act_course, $course_list;
    public $act_foodrate, $act_amtfood, $course_trainer_rate, $course_trainer_amt, $act_materialrate, $course_material_amt;
    public $file_array = [], $files, $file_array_old;

    public $circle1 = false,  $circle2 = false,  $circle3 = false,  $circle4 = false,  $circle5 = false;
    public $alert1 = false,  $alert2 = false,  $alert3 = false,  $alert4 = false,  $alert5 = false;
    public $formdisabled = true;
    public $ch_1 = false, $ch_2 = false, $show;
    public $emp_province_id, $province_disabled = false, $act_coursetype, $coursetype_list, $act_buildtypeid;

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
        // dd($this->file_array);
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

    //กิจกรรมทักษะฝีมือแรงงาน
    public function mount($pullactivities)
    {
        // $this->saveButton = getCanEditTblRequests($pullactivities);

        $this->act_id = $pullactivities->act_id;

        $this->act_number = $pullactivities->act_number;
        $this->act_dept = $pullactivities->act_dept;
        // $this->dept_list = DB::connection('oracle_umts')->table('um_mas_department')->pluck("dept_name_th", "act_dept");
        $this->dept_list = UmMasDepartment::where('in_active', false)->pluck('dept_name_th', 'dept_id');
        $this->created_at = date($pullactivities->created_at);
        $this->act_year = $pullactivities->act_year;
        $this->act_periodno = $pullactivities->act_periodno;
        $this->act_buildtypeid = $pullactivities->act_buildtypeid;

        $keep = [];

        // $fdad = OoapTblFiscalyear::getDatas()->where('req_status', '=', 1)->where('req_enddate', '>', date("Y-m-d"))->get();

        // dd('d');

        // foreach ($fdad as $ka => $va) {

        //     $keep[$va->fiscalyear_code] = $va->fiscalyear_code;
        // }

        $this->fiscalyear_list = OoapTblFiscalyear::
        // where('req_status', 1)
            where('in_active', false)->pluck('fiscalyear_code', 'fiscalyear_code as new');

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
        $this->act_startmonth = $pullactivities->act_startmonth;
        $this->act_endmonth = $pullactivities->act_endmonth;
        $this->act_numofpeople = $pullactivities->act_numofpeople;
        $this->act_numlecturer = $pullactivities->act_numlecturer;
        $this->countsum = $this->act_numofpeople + $this->act_numlecturer;
        $this->act_foodrate = sprintf('%0.2f', $pullactivities->act_foodrate);
        $this->course_trainer_rate = sprintf('%0.2f', $pullactivities->act_rate);
        $this->act_materialrate = sprintf('%0.2f', $pullactivities->act_materialrate);

        $this->food_r = $pullactivities->act_foodrate;
        $this->trainer_r = $pullactivities->act_rate;
        $this->material_r = $pullactivities->act_materialrate;

        $this->other_amt = sprintf('%0.2f', $pullactivities->act_otheramt);
        $this->status = $pullactivities->status;
        $this->act_approvenote = $pullactivities->act_approvenote;
        $this->course_trainer_amt = sprintf('%0.2f', $pullactivities->act_amtlecturer);
        $this->course_material_amt = sprintf('%0.2f', $pullactivities->act_materialamt);
        $this->act_amtfood = sprintf('%0.2f', $pullactivities->act_amtfood);
        $this->act_hrperday = $pullactivities->act_hrperday;
        $this->act_plan_adjust_status = $pullactivities->act_plan_adjust_status;
        if ($this->status != 4) {
            $this->formdisabled = false;
            $emp_province_id = auth()->user()->province_id;
            if ($emp_province_id != null) {
                $this->province_disabled = true;
            }
        } else {
            $this->province_disabled = true;
        }

        $this->file_array_old = OoapTblActivityFiles::where('act_id', '=', $this->act_id)->where('in_active', '=', false)->get()->toArray() ?? [];
        // $this->periodno('', $this->fiscalyear_list[$this->act_year]);
    }

    public function submit_prototype($status)
    {
        if ($this->act_year == null || $this->act_dept == null) {
            $this->alert1 = true;
        } else {
            $this->alert1 = false;
        }
        if ($this->act_coursegroup == null || $this->act_shortname == null || $this->act_desc == null || $this->act_buildname == null || $this->act_buildtypeid == null) {
            $this->alert2 = true;
        } else {
            $this->alert2 = false;
        }
        if ($this->province_id == null || $this->act_district == null || $this->act_subdistrict == null) {
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
            // 'act_number' => 'required',
            'act_coursegroup' => 'required',
            'act_shortname' => 'required',
            'act_desc' => 'required',
            'act_buildname' => 'required',
            'act_numofpeople' => 'required',
            'act_numlecturer' => 'required',
            'act_numofday' => 'required',
            'province_id' => 'required',
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
            'act_coursegroup.required' => 'กรุณาเลือก กลุ่มหลักสูตร',
            'act_shortname.required' => 'กรุณากรอก ชื่อกิจกรรม',
            'act_desc.required' => 'กรุณากรอก รายละเอียดกิจกรรม',
            'act_buildname.required' => 'กรุณากรอก ชื่อสถานที่',
            'act_numofpeople.required' => 'กรุณากรอก จำนวนคน',
            'act_numlecturer.required' => 'กรุณากรอก จำนวนวิทยากร',
            'act_numofday.required' => 'กรุณากรอก จำนวนวัน',
            'province_id.required' => 'กรุณากรอก จังหวัด',
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

        OoapTblActivities::where('act_id', '=', $this->act_id)->update([
            'act_number' => $this->act_number,
            'act_year' => $this->act_year,
            // 'act_periodno' => $this->act_periodno,
            'act_coursegroup' => $this->act_coursegroup,
            'act_coursesubgroup' => $this->act_coursesubgroup,
            'act_course' => $this->act_course,
            'act_shortname' => $this->act_shortname,
            // 'troubletype_id' => 1, //suppose to be nullable
            'act_desc' => $this->act_desc,
            'act_remark' => $this->act_remark,
            'act_buildtypeid' => $this->act_buildtypeid,
            // 'local_material' => $this->local_material,
            // 'people_benefit_qty' => 1, //suppose to be nullable
            // 'patternarea_id' => 1, //suppose to be nullable
            // 'area_wide' => $this->area_wide,
            // 'area_long' => $this->area_long,
            // 'area_high' => $this->area_high,
            // 'area_total' => $this->area_total,

            'act_commu' => $this->act_commu,
            'act_leadname' => $this->act_leadname,
            'act_position' => $this->act_position,
            'act_leadinfo' => $this->act_leadinfo,
            'act_coursetype' => $this->act_coursetype,

            // 'buildingtype_id' => 1, //suppose to be nullable
            'act_buildname' => $this->act_buildname,
            'act_moo' => $this->act_moo,
            'act_subdistrict' => $this->act_subdistrict,
            'act_district' => $this->act_district,
            'act_province' => $this->province_id,
            'act_latitude' => $this->building_lat,
            'act_longtitude' => $this->building_long,
            // 'area_total' => $this->area_total,

            'act_startmonth' => $this->act_startmonth,
            'act_endmonth' => $this->act_endmonth,
            'act_numofday' => $this->act_numofday,
            'act_hrperday' => 6,
            'act_numofpeople' => $this->act_numofpeople,
            'act_numlecturer' => $this->act_numlecturer,
            'act_foodrate' => $this->act_foodrate,
            'act_rate' => $this->course_trainer_rate,
            'act_materialrate' => $this->act_materialrate,
            'act_approvenote' => $this->act_approvenote,
            // 'job_wage_amt' => $this->job_wage_amt,
            'act_amtfood' => $this->act_amtfood,
            'act_amtlecturer' => $this->course_trainer_amt,
            'act_materialamt' => $this->course_material_amt,
            'act_otheramt' => $this->other_amt,
            'act_amount' => $this->act_amount,
            'status' => 4,
            'updated_at' => now(),
            'updated_by' => auth()->user()->emp_citizen_id,
        ]);

        $array_left = array_column($this->file_array_old, 'files_id') ?? []; // ที่เหลือจากลบแล้ว

        OoapTblActivityFiles::where('act_id', '=', $this->act_id)->whereNotIn('files_id', $array_left)->update([ // ลบไฟล์ที่ไม่มีออก
            'in_active' => 1,
            'deleted_by' => auth()->user()->name,
            'deleted_at' => now()
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
                    'act_id' => $this->act_id,

                    'created_by' => auth()->user()->emp_citizen_id,
                    'created_at' => now(),
                ]);
            }
        }
        OoapTblActapprovelog::create([
            'act_log_type' => 'APP',
            'act_ref_id' => $this->act_ref_number,
            'act_log_date' => now(),
            'act_log_actions' => 'บันทึกข้อมูลปรับแผน/โครงการ',
            'act_log_details' => 'ส่งพิจารณาการปรับแผน',
            'status' => 4,
        ]);

        $logs['route_name'] = 'activity.ready_confirm.train.edit';
        $logs['submenu_name'] = 'บันทึกยืนยันความพร้อมคำขอการจัดสรรงบ (กิจกรรมทักษะฝีมือแรงงาน)';
        $logs['log_type'] = 'edit';
        createLogTrans($logs);

        $this->emit('popup');
    }


    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('activity.plan_adjust.index');
    }

    public function changPanel($num)
    {
        $this->panel = $num;
    }

    public function setArray()
    {

        $this->act_startmonth = new DateTime(montYearsToDate($this->stdate));
        $this->act_endmonth = new DateTime(montYearsToDate($this->endate));
        $interval = $this->act_startmonth->diff($this->act_endmonth);
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
        if ($this->act_year == null || $this->act_dept == null) {
            $this->circle1 = false;
        } else {
            $this->circle1 = true;
        }
    }

    public function validate_panel2()
    {
        if (
            $this->act_coursegroup == null || $this->act_shortname == null || $this->act_desc == null || $this->act_buildname == null || $this->act_buildtypeid == null
        ) {
            $this->circle2 = false;
        } else {
            $this->circle2 = true;
        }
    }

    public function validate_panel3()
    {
        if (
            $this->province_id == null || $this->act_district == null || $this->act_subdistrict == null
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
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_numlecturer ? $this->act_numlecturer : 0));
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

    public function render()
    {
        $this->emit('emits');
        if ($this->act_foodrate > $this->food_r) {
            $this->act_foodrate = sprintf('%0.2f', $this->food_r);
        }
        if ($this->course_trainer_rate > $this->trainer_r) {
            $this->course_trainer_rate = sprintf('%0.2f', $this->trainer_r);
        }
        // if ($this->act_materialrate > $this->material_r) {
        //     $this->act_materialrate = sprintf('%0.2f', $this->material_r);
        // }

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

        $this->amphur_list = OoapMasAmphur::where('province_id', '=', $this->province_id)->where('in_active', false)->pluck('amphur_name', 'amphur_id');
        $this->tambon_list = OoapMasTambon::where('amphur_id', '=', $this->act_district)->where('in_active', false)->pluck('tambon_name', 'tambon_id');
        $this->dept_list = UmMasDepartment::where('in_active', false)->pluck('dept_name_th', 'dept_id');
        $OoapTblEmployee = OoapTblEmployee::where('emp_id', '=', auth()->user()->emp_id)->where('in_active', false)->first();
        $this->act_dept = $OoapTblEmployee->division_name;
        $this->act_deptinput = $OoapTblEmployee->department_id;
        $this->act_div = $OoapTblEmployee->division_id;


        if ($this->panel == 2) {
            if ($this->act_coursegroup) {
                $this->ch_1 = false;
                $this->ch_2 = false;
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

        return view('livewire.activity.plan-adjust.train-edit-component');
    }
}
