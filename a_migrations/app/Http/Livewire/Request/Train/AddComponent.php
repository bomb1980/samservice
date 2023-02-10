<?php

namespace App\Http\Livewire\Request\Train;

use App\Models\OoapLogTransModel;
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
use App\Models\OoapTblRequest;
use App\Models\OoapTblRequestFiles;
use DateTime;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddComponent extends Component
{
    use WithFileUploads;
    public $stdate, $endate, $date_list = [], $perioddays, $wages, $target_peoples;
    public $lat, $lng, $req_moo, $req_subdistrict, $tambon_list, $req_district, $amphur_list, $province_id, $province_list, $req_leadinfo, $req_commu, $req_leadname, $req_position;
    public $req_number, $panel = 1, $status = 1, $acttype2;
    public $acttype_id, $req_year, $fiscalyear_list, $req_dept, $dept_list, $unit_id = 1, $unit_list, $acttye_list, $acttye_id, $buildingtype_list, $buildingtype_id;
    public $req_shortname, $troubletype_id, $troubletype_list;
    public $patternarea_id = 0, $req_desc, $req_remark, $local_material, $people_benefit_qty, $req_id;
    public $area_wide, $area_long, $area_high, $area_total;
    public $req_startmonth, $req_endmonth, $req_numofday, $req_numofpeople, $req_numlecturer, $job_wage_rate, $other_rate, $job_wage_amt, $other_amt, $req_amount;
    public $created_at, $req_buildname, $building_lat, $building_long, $req_hrperday, $countsum;

    public $req_coursegroup, $coursegroup_list, $req_coursesubgroup, $coursesubgroup_list, $req_course, $course_list;
    public $req_foodrate, $req_amtfood, $course_trainer_rate, $course_trainer_amt, $req_materialrate, $course_material_amt;

    public $file_array = [], $files, $a = 1;
    public $circle1 = false,  $circle2 = false,  $circle3 = false,  $circle4 = false,  $circle5 = false;
    public $alert1 = false,  $alert2 = false,  $alert3 = false,  $alert4 = false,  $alert5 = false;
    public $emp_province_id, $province_disabled = false, $coursetype_list, $req_coursetype, $show = false, $req_buildtypeid;
    public $food_r, $trainer_r;

    public function mount()
    {
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', false)->orderby('fiscalyear_code', 'desc')->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code_new');
        $this->req_year = $this->fiscalyear_list->first();
        $this->acttye_list = OoapMasActtype::where('inactive', false)->pluck('name', 'id');
        $this->troubletype_list = OoapMasTroubletype::where('inactive', false)->pluck('name', 'id');
        $this->unit_list = OoapMasUnit::where('inactive', false)->pluck('name', 'id');
        $this->province_list = OoapMasProvince::where('in_active', false)->where('province_id', '!=', 1)->pluck('province_name', 'province_id');
        $emp_province_id = auth()->user()->province_id;
        if ($emp_province_id != null) {
            $this->province_id = $emp_province_id;
            $this->province_disabled = true;
        }
        $this->created_at = date("Y-m-d");
        $this->acttye_id = 2;
        $this->buildingtype_list = OoapMasBuildingtype::where('acttype_id', '=', 2)->where('in_active', false)->pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::where('in_active', false)->pluck('name', 'patternarea_id');

        $this->coursegroup_list = OoapMasCoursegroup::where('in_active', '=', false)
            ->where('acttype_id', '=', 2)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->coursesubgroup_list = OoapMasCoursesubgroup::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->req_coursegroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->course_list = OoapMasCourse::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->req_coursegroup)->where('coursesubgroup_id', '=', $this->req_coursesubgroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->coursetype_list = OoapMasCoursetype::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->req_coursegroup)->where('coursesubgroup_id', '=', $this->req_coursesubgroup)
            ->orderby('name', 'asc')->pluck('name', 'id');


        $this->acttype2 = OoapMasActtype::where('inactive', false)->where('id', '=', 2)->first();
        if ($this->acttype2) {
            $this->req_foodrate = sprintf('%0.2f', $this->acttype2->couse_lunch_maxrate);
            $this->course_trainer_rate = sprintf('%0.2f', $this->acttype2->couse_trainer_maxrate);
            $this->food_r = $this->acttype2->couse_lunch_maxrate;
            $this->trainer_r = $this->acttype2->couse_trainer_maxrate;
            $this->req_materialrate = sprintf('%0.2f', $this->acttype2->couse_material_maxrate);
        } else {
            $this->req_foodrate = sprintf('%0.2f', 240);
            $this->course_trainer_rate = sprintf('%0.2f', 600);
            $this->food_r =  sprintf('%0.2f', 240);
            $this->trainer_r = sprintf('%0.2f', 600);
            $this->req_materialrate = sprintf('%0.2f', 2000);
        }
        $this->other_amt = sprintf('%0.2f', 0);
    }

    public function latLng($latlng)
    {
        $this->building_lat = $latlng['lat'];
        $this->building_long = $latlng['lng'];
    }

    public function submit_file_array()
    {
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

    public function submit_prototype($status)
    {
        if ($this->req_year == null) {
            $this->alert1 = true;
        } else {
            $this->alert1 = false;
        }
        if ($this->req_coursegroup == null || $this->req_shortname == null || $this->req_buildtypeid == null || $this->req_desc == null || $this->req_buildname == null) {
            $this->alert2 = true;
        } else {
            $this->alert2 = false;
        }
        if ($this->province_id == null || $this->req_district == null || $this->req_subdistrict == null) {
            $this->alert3 = true;
        } else {
            $this->alert3 = false;
        }
        if ($this->stdate == null || $this->endate == null || $this->req_numofpeople == null || $this->req_numlecturer == null || $this->req_numofday == null || ((new DateTime(montYearsToDate($this->stdate))) > (new DateTime(montYearsToDate($this->endate))))) {
            $this->alert4 = true;
        } else {
            $this->alert4 = false;
        }

        $this->validate([
            'req_year' => 'required',
            'req_shortname' => 'required',
            'req_desc' => 'required',
            'req_buildname' => 'required',
            'req_coursegroup' => 'required',
            'req_numofpeople' => 'required',
            'req_numlecturer' => 'required',
            'req_numofday' => 'required',
            'province_id' => 'required',
            'req_district' => 'required',
            'req_subdistrict' => 'required',
            'req_buildtypeid' => 'required',
            'stdate' => 'required|date_format:m-Y|before_or_equal:endate',
            'endate' => 'required|date_format:m-Y|after_or_equal:stdate',
        ], [
            'req_buildtypeid.required' => 'กรุณาเลือก ประเภทสถานที่',
            'req_year.required' => 'กรุณาเลือก ปีงบประมาณ',
            'req_shortname.required' => 'กรุณากรอก ชื่อกิจกรรม',
            'req_desc.required' => 'กรุณากรอก รายละเอียดกิจกรรม',
            'req_buildname.required' => 'กรุณากรอก ชื่อสถานที่',
            'req_coursegroup.required' => 'กรุณาเลือก กลุ่มหลักสูตร',
            'req_numofpeople.required' => 'กรุณากรอก จำนวนคน',
            'req_numlecturer.required' => 'กรุณากรอก จำนวนวิทยากร',
            'req_numofday.required' => 'กรุณากรอก จำนวนวัน',
            'province_id.required' => 'กรุณากรอก จังหวัด',
            'req_district.required' => 'กรุณากรอก อำเภอ',
            'req_subdistrict.required' => 'กรุณากรอก ตำบล',
            'stdate.required' => 'กรุณากรอก เดือนที่เริ่ม',
            'stdate.before_or_equal' => 'เดือนที่เริ่ม ต้องน้อยกว่าหรือเท่ากับ เดือนที่สิ้นสุด',
            'endate.required' => 'กรุณากรอก เดือนที่สิ้นสุด',
            'endate.after_or_equal' => 'เดือนที่สิ้นสุด ต้องมากว่าหรือเท่ากับ เดือนที่เริ่ม',
        ]);

        $data = OoapTblRequest::create([
            'req_number' => $this->req_number,
            'req_year' => $this->req_year,
            'req_dept' => $this->req_deptinput,
            'req_div' => $this->req_div,
            'req_acttype' => 2,
            'req_coursegroup' => $this->req_coursegroup,
            'req_coursesubgroup' => $this->req_coursesubgroup,
            'req_course' => $this->req_course,
            'req_coursetype' => $this->req_coursetype,
            'req_shortname' => $this->req_shortname,
            'req_desc' => $this->req_desc,
            'req_remark' => $this->req_remark,
            'req_buildtypeid' => $this->req_buildtypeid,

            'req_commu' => $this->req_commu,
            'req_leadname' => $this->req_leadname,
            'req_position' => $this->req_position,
            'req_leadinfo' => $this->req_leadinfo,

            'req_buildname' => $this->req_buildname,
            'req_moo' => $this->req_moo,
            'req_subdistrict' => $this->req_subdistrict,
            'req_district' => $this->req_district,
            'req_province' => $this->province_id,
            'req_latitude' => $this->building_lat,
            'req_longtitude' => $this->building_long,
            'req_startmonth' => $this->req_startmonth,
            'req_endmonth' => $this->req_endmonth,
            'req_numofday' => $this->req_numofday,
            'req_numofpeople' => $this->req_numofpeople,
            'req_numlecturer' => $this->req_numlecturer,
            'req_foodrate' => str_replace(",", "", $this->req_foodrate),
            'req_rate' => str_replace(",", "", $this->course_trainer_rate),
            'req_materialrate' => str_replace(",", "", $this->req_materialrate),
            'req_hrperday' => 6,
            'req_amtfood' => $this->req_amtfood,
            'req_amtlecturer' => $this->course_trainer_amt,
            'req_materialamt' => $this->course_material_amt,
            'req_otheramt' => $this->other_amt,
            'req_amount' => $this->req_amount,
            'status' => 1,
            'remember_token' => csrf_token(),
            'updated_by' => auth()->user()->emp_citizen_id,
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now(),
        ]);
        if ($status == 2) {
            OoapTblRequest::where('req_id', '=', $data->req_id)->update([
                'status' => 2,
                'req_sendappdate' => now()
            ]);
        }
        if (!empty($this->file_array)) {
            $path_file = '/requests';
            foreach ($this->file_array as $file) {
                $file->store('/public' . $path_file);
                OoapTblRequestFiles::create([
                    'files_ori' => $file->getClientOriginalName(),
                    'files_gen' => $file->hashName(),
                    'files_path' => $path_file,
                    'files_type' => $file->getMimeType(),
                    'files_size' => $file->getSize(),
                    'req_id' => $data->req_id,

                    'created_by' => auth()->user()->emp_citizen_id,
                    'created_at' => now(),
                ]);
            }
        }

        OoapTblReqapprovelog::create([
            'log_type' => 'APP',
            'ref_id' => $data->req_id,
            'log_date' => now(),
            'log_actions' => 'การบันทึก/ยืนยันคำขอรับจัดสรรงบ',
            'log_details' => 'บันทึกคำขอรับจัดสรรงบ',
            'status' => 1,
        ]);
        if ($status == 2) {
            OoapTblReqapprovelog::create([
                'log_type' => 'APP',
                'ref_id' => $data->req_id,
                'log_date' => now(),
                'log_actions' => 'การบันทึก/ยืนยันคำขอรับจัดสรรงบ',
                'log_details' => 'ส่งพิจารณาคำขอรับจัดสรรงบ',
                'status' => 2,
            ]);

            OoapLogTransModel::create([
                // 'data_array' => json_encode($datas),
                'log_type' => 'create',
                'route_name' => 'request.train.create',
                'log_name' => 'บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ (กิจกรรมทักษะฝีมือแรงงาน)',
                'full_name' =>  auth()->user()->fname_th . ' ' . auth()->user()->lname_th,
                'submenu_id' => null,
                'log_date' => now(),
                'ip' => $_SERVER['REMOTE_ADDR'],
                'username' => auth()->user()->emp_citizen_id,
                'created_by' => auth()->user()->emp_citizen_id,
                'created_at' => now(),
            ]);

            $pull_emp_1 = OoapTblEmployee::where('emp_type', '=', 1)->where('in_active', '=', false)->get()->toArray();
            foreach ($pull_emp_1 as $key => $val) {
                if ($val['emp_type'] == 1) {
                    $notis = [
                        'noti_name' => 'คุณ '.auth()->user()->fname_th . ' ' . auth()->user()->lname_th.' ส่งเรื่องร้องขอ เลขที่ '. $data->req_number .' เข้ามาใหม่ กรุณาตรวจสอบ',
                        'noti_detail' => '',
                        'noti_to' => [$val['emp_citizen_id']],
                        'noti_link' => route('request.consider.detail', ['acttype_id' => 2, 'id' => $data->req_id]),
                    ];

                    OoapTblNotification::create_($notis);
                }
            }
        }

        $logs['route_name'] = 'request.train.create';
        $logs['submenu_name'] = 'บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ (กิจกรรมทักษะฝีมือแรงงาน)';
        $logs['log_type'] = 'create';
        createLogTrans($logs);

        $this->emit('popup', $this->req_number);
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('request.projects.index');
    }

    public function changPanel($num)
    {
        $this->panel = $num;
    }

    public function setArray()
    {
        $this->req_startmonth = new DateTime(montYearsToDate($this->stdate));
        $this->req_endmonth = new DateTime(montYearsToDate($this->endate));
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
        if ($this->req_year == null || $this->req_dept == null) {
            $this->circle1 = false;
        } else {
            $this->circle1 = true;
        }
    }

    public function validate_panel2()
    {
        if (
            $this->acttye_id == null || $this->req_coursegroup == null || $this->req_shortname == null || $this->req_desc == null || $this->req_buildname == null || $this->req_buildtypeid == null
        ) {
            $this->circle2 = false;
        } else {
            $this->circle2 = true;
        }
    }

    public function validate_panel3()
    {
        if (
            $this->province_id == null || $this->req_district == null || $this->req_subdistrict == null
        ) {
            $this->circle3 = false;
        } else {
            $this->circle3 = true;
        }
    }

    public function validate_panel4()
    {
        if (
            $this->stdate == null || $this->endate == null || $this->req_numofpeople == null || $this->req_numlecturer == null || $this->req_numofday == null || $this->req_foodrate == null ||
            $this->req_amtfood == null || $this->course_trainer_rate == null || $this->course_trainer_amt == null || $this->req_materialrate == null || $this->course_material_amt == null || ((new DateTime(montYearsToDate($this->stdate))) > (new DateTime(montYearsToDate($this->endate))))
        ) {
            $this->circle4 = false;
        } else {
            $this->circle4 = true;
        }
    }

    public function validate_panel5()
    {
        if (empty($this->file_array)) {
            $this->circle5 = false;
        } else {
            $this->circle5 = true;
        }
    }

    public function calsum($name, $cal)
    {
        if ($name == 'req_foodrate') {
            if ($this->req_foodrate <= $this->food_r) {
                $this->req_amtfood = sprintf('%0.2f', ($this->req_foodrate ? $this->req_foodrate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0));
            }
        }
        if ($name == 'course_trainer_rate') {
            if ($this->course_trainer_rate  <= $this->trainer_r) {
                // $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * ($this->req_numlecturer ? $this->req_numlecturer : 0) * 6);
                //ค่าวิทยากร new -> อัตราค่าวิทยากร * จน.วัน * จน.วิทยากร
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * ($this->req_numlecturer ? $this->req_numlecturer : 0));
            }
        }
        if ($name == 'req_materialrate') {
            $this->course_material_amt = sprintf('%0.2f', ($this->req_materialrate ? (int)str_replace(',', '', $cal) : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0));
        }
    }

    public function setnum($name, $num)
    {
        if ($num == null) {
            $num = 0;
        }
        if ($this->req_numlecturer && $this->req_numofpeople && $this->req_numofday) {
            $this->countsum = ($this->req_numofpeople ? $this->req_numofpeople : 0);
            if ($name == 'req_numofpeople') {
                $numofpeople = $num;
                $this->req_amtfood = sprintf('%0.2f', ($this->req_foodrate ? $this->req_foodrate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * ($numofpeople));
                // $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * ($this->req_numlecturer ? $this->req_numlecturer : 0) * 6);
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * ($this->req_numlecturer ? $this->req_numlecturer : 0));
                $this->course_material_amt = sprintf('%0.2f', ($this->req_materialrate ? (int)str_replace(',', '', $this->req_materialrate) : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0));
            }
            if ($name == 'req_numlecturer') {
                $numlecturer = $num;
                $this->req_amtfood = sprintf('%0.2f', ($this->req_foodrate ? $this->req_foodrate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0));
                // $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * $numlecturer) * 6;
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * $numlecturer);
                $this->course_material_amt = sprintf('%0.2f', ($this->req_materialrate ? (int)str_replace(',', '', $this->req_materialrate) : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0));
            }
            if ($name == 'req_numofday') {
                $numofday = $num;
                $this->req_amtfood = sprintf('%0.2f', ($this->req_foodrate ? $this->req_foodrate : 0) * ($numofday) * ($this->req_numofpeople ? $this->req_numofpeople : 0));
                // $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($numofday) * ($this->req_numlecturer ? $this->req_numlecturer : 0) * 6);
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($numofday) * ($this->req_numlecturer ? $this->req_numlecturer : 0));
                $this->course_material_amt = sprintf('%0.2f', ($this->req_materialrate ? (int)str_replace(',', '', $this->req_materialrate) : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0));
            }
        } else {
            $this->countsum = 0;
            $this->req_amtfood = 0;
            $this->course_material_amt = 0;
            $this->course_trainer_amt = 0;
        }
    }

    public function render()
    {
        $this->emit('emits');
        //check rate
        if ($this->req_foodrate > $this->food_r) {
            $this->req_foodrate = sprintf('%0.2f', $this->food_r);
        }
        if ($this->course_trainer_rate > $this->trainer_r) {
            $this->course_trainer_rate = sprintf('%0.2f', $this->trainer_r);
        }

        //amount
        if ($this->req_amtfood == null) {
            $this->req_amount = sprintf('%0.2f', ($this->course_trainer_amt ? $this->course_trainer_amt : 0) + ($this->course_material_amt ? $this->course_material_amt : 0));
        }
        if ($this->course_trainer_amt == null) {
            $this->req_amount = sprintf('%0.2f', ($this->req_amtfood ? $this->req_amtfood : 0) + ($this->course_material_amt ? $this->course_material_amt : 0));
        }
        if ($this->course_material_amt == null) {
            $this->req_amount = sprintf('%0.2f', ($this->req_amtfood ? $this->req_amtfood : 0) + ($this->course_trainer_amt ? $this->course_trainer_amt : 0));
        }
        if ($this->req_amtfood != null && $this->course_trainer_amt != null && $this->course_material_amt != null) {
            $this->req_amount = sprintf('%0.2f', ($this->req_amtfood ? $this->req_amtfood : 0) + ($this->course_trainer_amt ? $this->course_trainer_amt : 0) + ($this->course_material_amt ? $this->course_material_amt : 0));
        }

        $this->amphur_list = OoapMasAmphur::where('province_id', '=', $this->province_id)->where('in_active', false)->pluck('amphur_name', 'amphur_id');
        $this->tambon_list = OoapMasTambon::where('amphur_id', '=', $this->req_district)->where('in_active', false)->pluck('tambon_name', 'tambon_id');
        $OoapTblEmployee = OoapTblEmployee::where('emp_id', '=', auth()->user()->emp_id)->where('in_active', false)->first();
        $this->req_dept = $OoapTblEmployee->division_name;
        $this->req_deptinput = $OoapTblEmployee->department_id;
        $this->req_div = $OoapTblEmployee->division_id;

        $getId = OoapTblRequest::select('req_id')->where('req_year', '=', $this->req_year)->orderBy('req_id', 'DESC')->count() ?? 1;
        $this->req_number = "RF-" . substr($this->req_year, 2) . date("m") .  "-" . sprintf('%04d', $getId + 1);

        if ($this->panel == 2) {
            if ($this->req_coursegroup) {
                $this->coursesubgroup_list = OoapMasCoursesubgroup::where('in_active', '=', false)
                    ->where('coursegroup_id', '=', $this->req_coursegroup)->pluck('name', 'id');
                if (!empty($this->coursesubgroup_list->toArray())) {
                } else {
                    $this->req_coursesubgroup = null;
                    $this->req_course = null;
                    $this->req_coursetype = null;
                }
                if ($this->req_coursesubgroup) {
                    $this->coursetype_list = OoapMasCoursetype::where('in_active', '=', false)
                        ->where('coursegroup_id', '=', $this->req_coursegroup)->where('coursesubgroup_id', '=', $this->req_coursesubgroup)
                        ->orderby('name', 'asc')->pluck('name', 'id');
                    if (!empty($this->coursetype_list->toArray())) {
                    } else {
                        $this->req_coursetype = null;
                        $this->req_course = null;
                    }
                    if ($this->req_coursetype) {
                        $this->course_list = OoapMasCourse::where('in_active', '=', false)
                            ->where('coursegroup_id', '=', $this->req_coursegroup)
                            ->where('coursesubgroup_id', '=', $this->req_coursesubgroup)
                            ->where('coursetype_id', '=', $this->req_coursetype)
                            ->orderby('name', 'asc')->pluck('name', 'id');
                        if (!empty($this->course_list->toArray())) {
                        } else {
                            $this->req_course = null;
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

        return view('livewire.request.train.add-component');
    }
}
