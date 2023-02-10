<?php

namespace App\Http\Livewire\Activity\PlanAdjust;

use App\Models\OoapMasActtype;
use App\Models\OoapMasAmphur;
use App\Models\OoapMasBuildingtype;
use App\Models\OoapMasPatternarea;
use App\Models\OoapMasProvince;
use App\Models\OoapMasTambon;
use App\Models\OoapMasTroubletype;
use App\Models\OoapMasUnit;
use App\Models\OoapTblEmployee;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblActivities;
use App\Models\OoapTblActivityFiles;
use App\Models\UmMasDepartment;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class HireEditComponent extends Component
{
    use WithFileUploads;
    public $act_id;
    public $stdate, $endate, $date_list = [], $perioddays, $wages, $target_peoples;
    public $lat, $lng, $act_moo, $act_subdistrict, $tambon_list, $act_district, $amphur_list, $province_id, $province_list, $act_leadinfo, $act_commu, $act_leadname, $act_position;
    public $act_number, $panel = 1, $status;
    public $acttype_id, $act_year, $fiscalyear_list, $act_dept, $dept_list, $unit_id = 1, $unit_list, $act_unit, $acttye_list, $acttye_id, $buildingtype_list, $buildingtype_id;
    public $act_shortname, $troubletype_id, $troubletype_list, $act_troubletype;
    public $patternarea_id, $act_desc, $act_remark;

    public $act_startmonth, $act_endmonth, $act_numofday, $act_numofpeople, $act_peopleno, $act_numlecturer, $act_rate, $act_amount;
    public $created_at, $act_buildname, $building_lat, $building_long, $act_hrperday, $act_periodno, $act_approvenote, $countsum;
    public $file_array = [], $files, $file_array_old;
    public $circle1 = false,  $circle2 = false,  $circle3 = false,  $circle4 = false,  $circle5 = false;
    public $alert1 = false,  $alert2 = false,  $alert3 = false,  $alert4 = false,  $alert5 = false;
    public $formdisabled = true;
    public $emp_province_id, $province_disabled = false, $act_coursetype, $coursetype_list, $act_buildtypeid;
    public $act_measure, $act_metric, $pattern_list, $act_width, $act_length, $act_height;
    public $button_enables = false;

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

    public function mount($pullactivities)
    {

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


        $this->fiscalyear_list = OoapTblFiscalyear::

            where('in_active', false)->pluck('fiscalyear_code', 'fiscalyear_code as new');

        $this->acttye_list = OoapMasActtype::where('inactive', false)->pluck('name', 'id');
        $this->troubletype_list = OoapMasTroubletype::where('inactive', false)->pluck('name', 'id');
        $this->unit_list = OoapMasUnit::where('inactive', false)->pluck('name', 'id');
        $this->province_list = OoapMasProvince::where('in_active', false)->pluck('province_name', 'province_id');
        $this->acttye_id = $pullactivities->act_acttype;
        $this->buildingtype_list = OoapMasBuildingtype::where('acttype_id', '=', 1)->where('in_active', false)->pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::where('in_active', false)->pluck('name', 'patternarea_id');

        $this->act_year = $pullactivities->act_year;
        $this->act_shortname = $pullactivities->act_shortname;
        $this->act_desc = $pullactivities->act_desc;
        $this->act_remark = $pullactivities->act_remark;
        $this->act_buildtypeid = $pullactivities->act_buildtypeid;
        $this->act_buildtypeid = $pullactivities->act_buildtypeid;
        $this->act_buildname = $pullactivities->act_buildname;
        $this->building_lat = $pullactivities->act_latitude;
        $this->building_long = $pullactivities->act_longtitude;
        $this->act_measure = $pullactivities->act_measure;
        $this->act_metric = $pullactivities->act_metric;
        $this->act_width = $pullactivities->act_width;
        $this->act_length = $pullactivities->act_length;
        $this->act_height = $pullactivities->act_height;
        $this->province_id = $pullactivities->act_province;
        $this->act_district = $pullactivities->act_district;
        $this->act_subdistrict = $pullactivities->act_subdistrict;
        $this->act_moo = $pullactivities->act_moo;
        $this->act_leadinfo = $pullactivities->act_leadinfo;
        $this->act_commu = $pullactivities->act_commu;
        $this->act_leadname = $pullactivities->act_leadname;
        $this->act_position = $pullactivities->act_position;

        $this->act_troubletype = $pullactivities->act_troubletype;
        $this->act_peopleno = $pullactivities->act_peopleno;

        $this->stdate = dateToMontYears($pullactivities->act_startmonth);
        $this->endate = dateToMontYears($pullactivities->act_endmonth);
        $this->act_startmonth = $pullactivities->act_startmonth;
        $this->act_endmonth = $pullactivities->act_endmonth;
        $this->act_numofday = $pullactivities->act_numofday;
        $this->act_numofpeople = $pullactivities->act_numofpeople;
        $this->act_rate = $pullactivities->act_rate;

        $this->status = $pullactivities->status;
        $this->act_approvenote = $pullactivities->act_approvenote;
        $this->act_plan_adjust_status = $pullactivities->act_plan_adjust_status;
        if ($this->act_plan_adjust_status == 1) {
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
        if ($this->act_shortname == null || $this->act_desc == null || $this->act_buildtypeid == null || $this->act_buildname == null || $this->act_peopleno == null || $this->act_measure == null) {
            $this->alert2 = true;
        } else {
            $this->alert2 = false;
        }
        if ($this->province_id == null || $this->act_district == null || $this->act_subdistrict == null) {
            $this->alert3 = true;
        } else {
            $this->alert3 = false;
        }
        if ($this->stdate == null || $this->endate == null || $this->act_numofpeople == null  || $this->act_numofday == null || $this->act_rate == null || ((new DateTime(montYearsToDate($this->stdate))) > (new DateTime(montYearsToDate($this->endate))))) {
            $this->alert4 = true;
        } else {
            $this->alert4 = false;
        }

        $this->validate([
            'act_year' => 'required',
            // 'act_periodno' => 'required',

            'act_shortname' => 'required',
            'act_desc' => 'required',
            'act_troubletype' => 'required',
            'act_peopleno' => 'required',
            'act_buildtypeid' => 'required',
            'act_buildname' => 'required',
            'act_measure' => 'required',

            'province_id' => 'required',
            'act_district' => 'required',
            'act_subdistrict' => 'required',
            // 'act_leadname' => 'required',
            // 'act_position' => 'required',
            // 'act_leadinfo' => 'required',

            'stdate' => 'required|date_format:m-Y|before_or_equal:endate',
            'endate' => 'required|date_format:m-Y|after_or_equal:stdate',
            'act_numofday' => 'required',
            'act_numofpeople' => 'required',
            'act_rate' => 'required',
        ], [
            'act_year.required' => 'กรุณาเลือก ปีงบประมาณ',
            // 'act_periodno.required' => 'กรุณากรอก จำนวนงวดที่',

            'act_shortname.required' => 'กรุณากรอก ชื่อกิจกรรม',
            'act_desc.required' => 'กรุณากรอก รายละเอียดกิจกรรม',
            'act_troubletype.required' => 'กรุณาเลือก ประเภทความเดือดร้อน',
            'act_peopleno.required' => 'กรุณากรอก จำนวนประชาชนในพื้นที่ ที่ได้รับประโยชน์',

            'act_buildtypeid.required' => 'กรุณาเลือก สถานที่ดำเนินการ',
            'act_buildname.required' => 'กรุณากรอก ชื่อสถานที่',
            'act_measure.required' => 'กรุณาเลือก รูปแบบการวัดพื้นที่',

            'province_id.required' => 'กรุณาเลือก จังหวัด',
            'act_district.required' => 'กรุณาเลือก อำเภอ',
            'act_subdistrict.required' => 'กรุณาเลือก ตำบล',
            // 'act_leadname.required' => 'กรุณากรอก ชื่อผู้นำชุมชน',
            // 'act_position.required' => 'กรุณากรอก ตำแหน่งผู้นำชุมชน',
            // 'act_leadinfo.required' => 'กรุณากรอก ข้อมูลผู้นำชุมชน',

            'stdate.required' => 'กรุณากรอก เดือนที่เริ่ม',
            'stdate.before_or_equal' => 'เดือนที่เริ่ม ต้องน้อยกว่าหรือเท่ากับ เดือนที่สิ้นสุด',
            'endate.required' => 'กรุณากรอก เดือนที่สิ้นสุด',
            'endate.after_or_equal' => 'เดือนที่สิ้นสุด ต้องมากว่าหรือเท่ากับ เดือนที่เริ่ม',
            'act_numofday.required' => 'กรุณากรอก จำนวนวันดำเนินการ',
            'act_numofpeople.required' => 'กรุณากรอก จำนวนคน',
            'act_rate.required' => 'กรุณากรอก อัตราค่าตอบแทนต่อคนต่อวัน',
        ]);

        OoapTblActivities::where('act_id', '=', $this->act_id)->update([








 // 'act_number' => $this->act_number,

 // 'act_periodno' => $this->act_periodno,


            'act_year' => $this->act_year,
            'act_shortname' => $this->act_shortname,
            'act_desc' => $this->act_desc,
            'act_remark' => $this->act_remark,
            'act_troubletype' => $this->act_troubletype,
            'act_peopleno' => $this->act_peopleno,
            'act_buildtypeid' => $this->act_buildtypeid,
            'act_buildname' => $this->act_buildname,
            'act_commu' => $this->act_commu,
            'act_leadname' => $this->act_leadname,
            'act_position' => $this->act_position,
            'act_leadinfo' => $this->act_leadinfo,


            'act_moo' => $this->act_moo,
            'act_subdistrict' => $this->act_subdistrict,
            'act_district' => $this->act_district,
            'act_province' => $this->province_id,
            'act_latitude' => $this->building_lat,
            'act_longtitude' => $this->building_long,
            'act_measure' => $this->act_measure,
            'act_metric' => $this->act_metric,
            'act_width' => $this->act_width,
            'act_length' => $this->act_length,
            'act_height' => $this->act_height,
            'act_unit' => $this->act_unit,
            'act_startmonth' => $this->act_startmonth,
            'act_endmonth' => $this->act_endmonth,
            'act_numofday' => $this->act_numofday,
            'act_numofpeople' => $this->act_numofpeople,
            'act_rate' => $this->act_rate,
            'act_amount' => $this->act_amount,
            'act_approvenote' => $this->act_approvenote,
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

    public function validate_panel1()
    {
        if ($this->act_year == null || $this->act_dept == null || $this->act_number == null) {
            $this->circle1 = false;
        } else {
            $this->circle1 = true;
        }
    }

    public function validate_panel2()
    {
        if ($this->acttye_id == null || $this->act_shortname == null || $this->act_desc == null || $this->act_buildtypeid == null || $this->act_buildname == null || $this->act_peopleno == null || $this->act_measure == null) {
            $this->circle2 = false;
        } else {
            $this->circle2 = true;
        }
    }

    public function validate_panel3()
    {
        if ($this->province_id == null || $this->act_district == null || $this->act_subdistrict == null) {
            $this->circle3 = false;
        } else {
            $this->circle3 = true;
        }
    }

    public function validate_panel4()
    {
        if ($this->stdate == null || $this->endate == null || $this->act_numofpeople == null || $this->act_numofday == null || $this->act_rate == null || ((new DateTime(montYearsToDate($this->stdate))) > (new DateTime(montYearsToDate($this->endate))))) {
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

    // public function calsum($name, $cal)
    // {
    //     if ($name == 'act_unit') {
    //         if ($this->act_measure == 2) {
    //             $numori = ($this->act_width ? $this->act_width : 0) * ($this->act_length ? $this->act_length : 0) * ($this->act_height ? $this->act_height : 0);
    //             if ($cal > $numori) {
    //                 $this->act_unit = ($this->act_width ? $this->act_width : 0) * ($this->act_length ? $this->act_length : 0) * ($this->act_height ? $this->act_height : 0);
    //             } else {
    //                 $this->act_unit = $cal;
    //             }
    //         }
    //         } elseif ($this->act_measure == 3) {
    //             $numori = ($this->act_width ? $this->act_width : 0) * ($this->act_length ? $this->act_length : 0);
    //             if ($cal > $numori) {
    //                 $this->act_unit = ($this->act_width ? $this->act_width : 0) * ($this->act_length ? $this->act_length : 0);
    //             } else {
    //                 $this->act_unit = $cal;
    //         }
    //     }

    //     if ($name == 'act_amount') {
    //         $numori = ($this->act_rate ? $this->act_rate : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0) * ($this->act_numofday ? $this->act_numofday : 0);
    //         if ($cal > $numori) {
    //             $this->act_amount = ($this->act_rate ? $this->act_rate : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0) * ($this->act_numofday ? $this->act_numofday : 0);
    //         } else {
    //             $this->act_amount = $cal;
    //         }
    //     }
    // }

    public function setnum($name, $num)
    {
        if($num == null){
            $num = 0;
        }
        if ($this->act_numofpeople && $this->act_numofday && $this->act_rate) {
            if ($name == 'act_numofpeople') {
                $numofpeople = $num;
                $this->act_amount = ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_rate ? $this->act_rate : 0) * ($numofpeople);
            }
            if ($name == 'act_numofday') {
                $numofday = $num;
                $this->act_amount = ($this->act_rate ? $this->act_rate : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0) * ($numofday);
            }
            if ($name == 'act_rate') {
                $numofrate = $num;
                $this->act_amount = ($this->act_rate ? $this->act_rate : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0) * ($numofrate);
            }
        }else{
            $this->act_amount = 0;
        }
    }

    public function render()
    {
        $this->emit('emits');
        if ($this->act_numofday != null && $this->act_numofpeople != null && $this->act_rate != null) {
            $this->act_amount = ($this->act_numofday ? $this->act_numofday : 0) * ($this->act_numofpeople ? $this->act_numofpeople : 0) * ($this->act_rate ? $this->act_rate : 0);
        }

        if ($this->act_measure == 1) {
            $this->act_metric = null;
            $this->act_width = null;
            $this->act_length = null;
            $this->act_height = null;
            $this->act_unit = null;
        } elseif ($this->act_measure == 2) {
            if ($this->act_width != null && $this->act_length != null && $this->act_height != null) {
                $this->act_unit = ($this->act_width ? $this->act_width : 0) * ($this->act_length ? $this->act_length : 0) * ($this->act_height ? $this->act_height : 0);
            }
        } elseif ($this->act_measure == 3) {
            if ($this->act_width != null && $this->act_length != null ) {
                $this->act_unit = ($this->act_width ? $this->act_width : 0) * ($this->act_length ? $this->act_length : 0);
            }
        }

        if ($this->act_numofpeople && $this->act_numofday && $this->act_rate) {
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
        return view('livewire.activity.plan-adjust.hire-edit-component');
    }
}
