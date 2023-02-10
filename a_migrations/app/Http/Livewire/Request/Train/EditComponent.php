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
use App\Models\OoapTblFiscalyearReqPeriod;
use App\Models\OoapTblNotification;
use App\Models\OoapTblReqapprovelog;
use App\Models\OoapTblRequest;
use App\Models\OoapTblRequestFiles;
use App\Models\UmMasDepartment;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditComponent extends Component
{
    use WithFileUploads;
    public $req_id;
    public $stdate, $endate, $date_list = [], $perioddays, $wages, $target_peoples;
    public $lat, $lng, $req_moo, $req_subdistrict, $tambon_list, $req_district, $amphur_list, $province_id, $province_list, $req_leadinfo, $req_commu, $req_leadname, $req_position;
    public $panel = 1, $status;
    public $acttype_id, $req_year, $fiscalyear_list, $req_dept, $dept_list, $unit_id = 1, $unit_list, $acttye_list, $acttye_id, $buildingtype_list, $buildingtype_id;
    public $req_shortname, $troubletype_id, $troubletype_list;
    public $patternarea_id = 0, $req_desc, $req_remark, $local_material, $people_benefit_qty;
    public $area_wide, $area_long, $area_high, $area_total;
    public $req_startmonth, $req_endmonth, $req_numofday, $req_numofpeople, $req_numlecturer, $job_wage_rate, $other_rate, $job_wage_amt, $other_amt, $req_amount;
    public $created_at, $req_buildname, $building_lat, $building_long, $req_approvenote, $countsum;

    public $req_coursegroup, $coursegroup_list, $req_coursesubgroup, $coursesubgroup_list, $req_course, $course_list;
    public $req_foodrate, $req_amtfood, $course_trainer_rate, $course_trainer_amt, $req_materialrate, $course_material_amt;
    public $file_array = [], $files, $file_array_old;

    public $circle1 = false,  $circle2 = false,  $circle3 = false,  $circle4 = false,  $circle5 = false;
    public $alert1 = false,  $alert2 = false,  $alert3 = false,  $alert4 = false,  $alert5 = false;
    public $formdisabled = true;
    public $emp_province_id, $province_disabled = false, $view, $coursetype_list, $req_coursetype, $show = false, $req_buildtypeid;
    public $dateshow1, $dateshow2, $countnumstatus;
    public $food_r, $trainer_r;

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

    public function destroy_old_array($key)
    {
        unset($this->file_array_old[$key]);
        $this->file_array_old = array_values($this->file_array_old);
    }

    //กิจกรรมทักษะฝีมือแรงงาน
    public function mount($pullreqform)
    {
        $this->req_id = $pullreqform->req_id;
        $this->req_number = $pullreqform->req_number;
        $this->req_dept = $pullreqform->req_dept;
        $this->req_div = $pullreqform->req_div;
        $this->dept_list = UmMasDepartment::where('in_active', false)->pluck('dept_name_th', 'dept_id');
        $this->created_at = date($pullreqform->created_at);
        $this->req_year = $pullreqform->req_year;

        $this->dateshow1 = OoapTblReqapprovelog::where('in_active', '=', false)->where('ref_id', '=', $this->req_id)->where('status', '=', 1)->latest()->first();
        $this->dateshow2 = OoapTblReqapprovelog::where('in_active', '=', false)->where('ref_id', '=', $this->req_id)->where('status', '=', 2)->latest()->first();
        $this->dateshow3 = OoapTblReqapprovelog::where('in_active', '=', false)->where('ref_id', '=', $this->req_id)->whereIn('status', [3, 4, 5])->latest()->first();
        $this->countnumstatus = OoapTblReqapprovelog::where('in_active', '=', false)->where('ref_id', '=', $this->req_id)->where('status', '=', 5)->count();

        if ($this->dateshow1) {
            $this->dateshow1 = formatDateThai($this->dateshow1->created_at);
        }

        if ($this->dateshow2) {
            $this->dateshow2 = formatDateThai($this->dateshow2->created_at);
        }

        if ($this->dateshow3) {
            $this->dateshow3 = formatDateThai($this->dateshow3->created_at);
        }

        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', false)->orderby('fiscalyear_code', 'desc')->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code_new');
        $this->acttye_list = OoapMasActtype::where('inactive', false)->pluck('name', 'id');
        $this->troubletype_list = OoapMasTroubletype::where('inactive', false)->pluck('name', 'id');
        $this->unit_list = OoapMasUnit::where('inactive', false)->pluck('name', 'id');
        $this->province_list = OoapMasProvince::where('in_active', false)->where('province_id', '!=', 1)->pluck('province_name', 'province_id');
        $this->acttye_id = $pullreqform->req_acttype;
        $this->buildingtype_list = OoapMasBuildingtype::where('acttype_id', '=', 2)->where('in_active', false)->pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::where('in_active', false)->pluck('name', 'patternarea_id');

        $this->req_coursegroup = $pullreqform->req_coursegroup;
        $this->coursegroup_list = OoapMasCoursegroup::where('in_active', '=', false)
            ->where('acttype_id', '=', 2)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->req_coursesubgroup =  $pullreqform->req_coursesubgroup;
        $this->req_coursetype =  $pullreqform->req_coursetype;
        $this->coursesubgroup_list = OoapMasCoursesubgroup::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->req_coursegroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->coursetype_list = OoapMasCoursetype::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->req_coursegroup)->where('coursesubgroup_id', '=', $this->req_coursesubgroup)
            ->orderby('name', 'asc')->pluck('name', 'id');

        $this->req_course =  $pullreqform->req_course;
        $this->course_list = OoapMasCourse::where('in_active', '=', false)
            ->where('coursegroup_id', '=', $this->req_coursegroup)->where('coursesubgroup_id', '=', $this->req_coursesubgroup)->where('coursetype_id', '=', $this->req_coursetype)
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
        $this->countsum = $this->req_numofpeople;
        $this->req_foodrate = sprintf('%0.2f', $pullreqform->req_foodrate);
        $this->course_trainer_rate = sprintf('%0.2f', $pullreqform->req_rate);
        $this->req_materialrate = sprintf('%0.2f', $pullreqform->req_materialrate);
        $this->req_buildtypeid = $pullreqform->req_buildtypeid;

        $this->other_amt = sprintf('%0.2f', $pullreqform->req_otheramt);
        $this->status = $pullreqform->status;
        $this->req_approvenote = $pullreqform->req_approvenote;
        $this->course_trainer_amt = sprintf('%0.2f', $pullreqform->req_amtlecturer);
        $this->course_material_amt = sprintf('%0.2f', $pullreqform->req_materialamt);
        $this->req_amtfood = sprintf('%0.2f', $pullreqform->req_amtfood);
        $this->req_hrperday = $pullreqform->req_hrperday;
        if ($this->status == 1 || $this->status == 5) {
            $this->formdisabled = false;
            $this->view = null;
            if (auth()->user()->emp_type != 1) {
                $this->province_disabled = true;
            }
        } else {
            $this->province_disabled = true;
            $this->view = 'disabled';
        }
        $this->file_array_old = OoapTblRequestFiles::where('req_id', '=', $this->req_id)->where('in_active', '=', false)->get()->toArray() ?? [];
        $this->acttype2 = OoapMasActtype::where('inactive', false)->where('id', '=', 2)->first();
        if ($this->acttype2) {
            $this->food_r = $this->acttype2->couse_lunch_maxrate;
            $this->trainer_r = $this->acttype2->couse_trainer_maxrate;
        } else {
            $this->food_r =  sprintf('%0.2f', 240);
            $this->trainer_r = sprintf('%0.2f', 600);
        }
    }

    public function submit_prototype($status)
    {
        if ($this->req_year == null) {
            $this->alert1 = true;
        } else {
            $this->alert1 = false;
        }
        if ($this->req_coursegroup == null || $this->req_shortname == null || $this->req_desc == null || $this->req_buildname == null || $this->req_buildtypeid == null) {
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

        OoapTblRequest::where('req_id', '=', $this->req_id)->update([
            'req_number' => $this->req_number,
            'req_year' => $this->req_year,
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
            'req_hrperday' => 6,
            'req_numofpeople' => $this->req_numofpeople,
            'req_numlecturer' => $this->req_numlecturer,
            'req_foodrate' => str_replace(",", "", $this->req_foodrate),
            'req_rate' => str_replace(",", "", $this->course_trainer_rate),
            'req_materialrate' => str_replace(",", "", $this->req_materialrate),
            'req_approvenote' => $this->req_approvenote,
            'req_amtfood' => $this->req_amtfood,
            'req_amtlecturer' => $this->course_trainer_amt,
            'req_materialamt' => $this->course_material_amt,
            'req_otheramt' => $this->other_amt,
            'req_amount' => $this->req_amount,
            'updated_at' => now(),
            'updated_by' => auth()->user()->emp_citizen_id,
        ]);
        if ($status == 2) {
            OoapTblRequest::where('req_id', '=', $this->req_id)->update([
                'status' => 2
            ]);
        }

        $array_left = array_column($this->file_array_old, 'files_id') ?? []; // ที่เหลือจากลบแล้ว

        OoapTblRequestFiles::where('req_id', '=', $this->req_id)->whereNotIn('files_id', $array_left)->update([ // ลบไฟล์ที่ไม่มีออก
            'in_active' => 1,
            'deleted_by' => auth()->user()->name,
            'deleted_at' => now()
        ]);

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
                    'req_id' => $this->req_id,

                    'created_by' => auth()->user()->emp_citizen_id,
                    'created_at' => now(),
                ]);
            }
        }

        OoapTblReqapprovelog::create([
            'log_type' => 'APP',
            'ref_id' => $this->req_id,
            'log_date' => now(),
            'log_actions' => 'การบันทึก/ยืนยันคำขอรับจัดสรรงบ',
            'log_details' => 'บันทึกคำขอรับจัดสรรงบ',
            'status' => 1,
        ]);
        if ($status == 2) {
            OoapTblReqapprovelog::create([
                'log_type' => 'APP',
                'ref_id' => $this->req_id,
                'log_date' => now(),
                'log_actions' => 'การบันทึก/ยืนยันคำขอรับจัดสรรงบ',
                'log_details' => 'ส่งพิจารณาคำขอรับจัดสรรงบ',
                'status' => 2,
            ]);

            OoapLogTransModel::create([
                // 'data_array' => json_encode($datas),
                'log_type' => 'edit',
                'route_name' => 'request.train.edit',
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
                        'noti_name' => 'คุณ '.auth()->user()->fname_th . ' ' . auth()->user()->lname_th.' ส่งเรื่องร้องขอ เลขที่ '. $this->req_number .' เข้ามาใหม่ กรุณาตรวจสอบ',
                        'noti_detail' => '',
                        'noti_to' => [$val['emp_citizen_id']],
                        'noti_link' => route('request.consider.detail', ['acttype_id' => 2, 'id' => $this->req_id]),
                    ];

                    OoapTblNotification::create_($notis);
                }
            }
        }

        $logs['route_name'] = 'request.train.edit';
        $logs['submenu_name'] = 'บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ (กิจกรรมทักษะฝีมือแรงงาน)';
        $logs['log_type'] = 'edit';
        createLogTrans($logs);

        $this->emit('popup');
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
        if (empty($this->file_array) && empty($this->file_array_old)) {
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
            $this->countsum = $this->req_numofpeople;
            if ($name == 'req_numofpeople') {
                $numofpeople = $num;
                $this->req_amtfood = sprintf('%0.2f', ($this->req_foodrate ? $this->req_foodrate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * ($numofpeople));
                $this->course_material_amt = sprintf('%0.2f', ($this->req_materialrate ? (int)str_replace(',', '', $this->req_materialrate) : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0));
                // $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * ($this->req_numlecturer ? $this->req_numlecturer : 0) * 6);
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * ($this->req_numlecturer ? $this->req_numlecturer : 0));
            }
            if ($name == 'req_numlecturer') {
                $numlecturer = $num;
                $this->req_amtfood = sprintf('%0.2f', ($this->req_foodrate ? $this->reqreq_foodrate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0));
                // $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * $numlecturer) * 6;
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * ($this->req_numofday ? $this->req_numofday : 0) * $numlecturer);
                $this->course_material_amt = sprintf('%0.2f', ($this->req_materialrate ? (int)str_replace(',', '', $this->req_materialrate) : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0));
            }
            if ($name == 'req_numofday') {
                $numofday = $num;
                $this->req_amtfood = sprintf('%0.2f', ($this->req_foodrate ? $this->req_foodrate : 0) * $numofday * ($this->req_numofpeople ? $this->req_numofpeople : 0));
                // $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * $numofday * ($this->req_numlecturer ? $this->req_numlecturer : 0) * 6);
                $this->course_trainer_amt = sprintf('%0.2f', ($this->course_trainer_rate ? $this->course_trainer_rate : 0) * $numofday * ($this->req_numlecturer ? $this->req_numlecturer : 0));
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
        $this->dept_list = UmMasDepartment::where('in_active', false)->pluck('dept_name_th', 'dept_id');
        $OoapTblEmployee = OoapTblEmployee::where('division_id', '=', $this->req_div)->where('in_active', false)->first();
        $this->req_dept = $OoapTblEmployee->division_name;
        // $this->req_deptinput = $OoapTblEmployee->department_id;
        // $this->req_div = $OoapTblEmployee->division_id;


        if ($this->panel == 2) {
            if ($this->req_coursegroup) {
                $this->coursesubgroup_list = OoapMasCoursesubgroup::where('in_active', '=', false)
                    ->where('coursegroup_id', '=', $this->req_coursegroup)->pluck('name', 'id');
                if (!empty($this->coursesubgroup_list->toArray())) {
                } else {
                    $this->req_coursesubgroup = null;
                    $this->req_course = null;
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
        return view('livewire.request.train.edit-component');
    }
}
