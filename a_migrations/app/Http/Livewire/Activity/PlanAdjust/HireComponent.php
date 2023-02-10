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
use App\Models\OoapTblAssess;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblActivityFiles;
use App\Models\OoapTblActivities;
use App\Models\OoapTblRequest;
use App\Models\OoapTblRequestFiles;
use App\Models\UmMasDepartment;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class HireComponent extends Component
{
    use WithFileUploads;
    public $stdate, $endate, $date_list = [];
    public $lat, $lng, $act_moo, $act_subdistrict, $tambon_list, $act_district, $amphur_list, $act_province, $province_id, $province_list, $act_leadinfo, $act_commu, $act_leadname, $act_position;
    public $act_number, $panel = 1, $status = 1, $acttype1;
    public $acttype_id, $act_year, $act_periodno, $fiscalyear_list, $act_dept, $dept_list, $act_unit, $unit_id, $unit_list, $acttye_list, $act_acttype, $acttye_id, $buildingtype_list, $buildingtype_id;
    public $act_shortname, $troubletype_id, $act_troubletype, $troubletype_list;
    public $act_measure, $act_metric, $pattern_list, $act_width, $act_length, $act_height;
    public $patternarea_id, $act_desc, $act_remark, $act_peopleno, $act_buildtypeid;
    public $area_wide, $area_long, $area_high;
    public $act_startmonth, $act_endmonth, $act_numofday, $act_numofpeople, $act_numlecturer, $act_rate, $act_amount;
    public $created_at, $act_buildname, $building_lat, $building_long;

    public $file_array = [], $files, $file_array_old = [];
    public $circle1 = false,  $circle2 = false,  $circle3 = false,  $circle4 = false,  $circle5 = false;
    public $alert1 = false,  $alert2 = false,  $alert3 = false,  $alert4 = false,  $alert5 = false, $distext = true;
    public $emp_province_id,$province_disabled = false, $ref_number_list = [], $act_ref_number;
    public $button_enables = false;

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


        $this->fiscalyear_list = OoapTblActivities::where('in_active', '=', false)
            ->whereIn('act_year', $fis_year)
            ->where('act_div', '=', auth()->user()->division_id)
            ->where('act_acttype', '=', 1)
            ->where('status', '=', 3)
            ->pluck('act_year', 'act_year as new');


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
        $this->act_acttype = 1;
        $this->buildingtype_list = OoapMasBuildingtype::pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::where('in_active', false)->pluck('name', 'patternarea_id');

        $this->acttype2 = OoapMasActtype::where('inactive', '=', false)->where('id', '=', 1)->first();

        // $pull_template = OoapTblAssess::where('in_active', 0)->latest()->first();
        // if ($pull_template) {
        //     $this->templateno = $pull_template->assess_templateno;
        // } else {
        //     $this->templateno = null;
        // }
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
        if ($this->acttye_id == null || $this->act_shortname == null || $this->act_desc == null || $this->act_buildname == null || $this->act_peopleno == null || $this->act_measure == null) {
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
        if ($this->stdate == null || $this->endate == null || $this->act_numofday == null || $this->act_numofpeople == null || $this->act_rate == null || ((new DateTime(montYearsToDate($this->stdate))) > (new DateTime(montYearsToDate($this->endate))))) {
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

    // public function calsum($name, $cal)
    // {
    //     if ($name == 'act_unit') {
    //         $numori = $this->act_width * $this->act_length * $this->act_height;
    //         if ($cal > $numori) {
    //             $this->act_unit = $this->act_width * $this->act_length * $this->act_height;
    //         } else {
    //             $this->act_unit = $cal;
    //         }
    //     }
    //     if ($name == 'act_amount') {
    //         $numori = $this->act_rate * $this->act_numofpeople * $this->act_numofday;
    //         if ($cal > $numori) {
    //             $this->act_amount = $this->act_rate * $this->act_numofpeople * $this->act_numofday;
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

    public function submit_prototype($status)
    {

        if ($this->act_year == null || $this->act_dept == null || $this->act_ref_number == null) {
            $this->alert1 = true;
        } else {
            $this->alert1 = false;
        }
        if ($this->acttye_id == null || $this->act_shortname == null || $this->act_desc == null || $this->act_buildtypeid == null || $this->act_buildname == null || $this->act_peopleno == null || $this->act_measure == null) {
            $this->alert2 = true;
        } else {
            $this->alert2 = false;
        }
        if ($this->province_id == null || $this->act_district == null || $this->act_subdistrict == null) {
            $this->alert3 = true;
        } else {
            $this->alert3 = false;
        }
        if ($this->stdate == null || $this->endate == null || ((new DateTime(montYearsToDate($this->stdate))) > (new DateTime(montYearsToDate($this->endate))))) {
            $this->alert4 = true;
        } else {
            $this->alert4 = false;
        }

        $this->validate([
            'act_year' => 'required',
            'act_ref_number' => 'required',

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

            'stdate' => 'required|date_format:m-Y|before_or_equal:endate',
            'endate' => 'required|date_format:m-Y|after_or_equal:stdate',
            'act_numofday' => 'required',
            'act_numofpeople' => 'required',
        ], [
            'act_year.required' => 'กรุณาเลือก ปีงบประมาณ',
            'act_ref_number.required' => 'กรุณาเลือก เลขที่คำขออ้างอิง',

            'act_shortname.required' => 'กรุณากรอก ชื่อกิจกรรม',
            'act_desc.required' => 'กรุณากรอก รายละเอียดกิจกรรม',
            'act_troubletype.required' => 'กรุณาเลือก ประเภทความเดือดร้อน',
            'act_peopleno.required' => 'กรุณากรอก จำนวนประชาชนในพื้นที่ ที่ได้รับประโยชน์',

            'act_buildtypeid.required' => 'กรุณาเลือก ประเภทสถานที่',
            'act_buildname.required' => 'กรุณากรอก ชื่อสถานที่',
            'act_measure.required' => 'กรุณาเลือก รูปแบบการวัดพื้นที่',

            'province_id.required' => 'กรุณาเลือก จังหวัด',
            'act_district.required' => 'กรุณาเลือก อำเภอ',
            'act_subdistrict.required' => 'กรุณาเลือก ตำบล',

            'stdate.required' => 'กรุณากรอก เดือนที่เริ่ม',
            'stdate.before_or_equal' => 'เดือนที่เริ่ม ต้องน้อยกว่าหรือเท่ากับ เดือนที่สิ้นสุด',
            'endate.required' => 'กรุณากรอก เดือนที่สิ้นสุด',
            'endate.after_or_equal' => 'เดือนที่สิ้นสุด ต้องมากว่าหรือเท่ากับ เดือนที่เริ่ม',
            'act_numofday.required' => 'กรุณากรอก จำนวนวันดำเนินการ',
            'act_numofpeople.required' => 'กรุณากรอก จำนวนคน',
            'act_rate.required' => 'กรุณากรอก อัตราค่าตอบแทนต่อคนต่อวัน',
        ]);

        $data = OoapTblActivities::where('act_id', '=', $this->act_ref_number)->update([
            'act_shortname' => $this->act_shortname,
            'act_desc' => $this->act_desc,
            'act_remark' => $this->act_remark,
            'act_troubletype' => $this->act_troubletype,
            'act_peopleno' => $this->act_peopleno,
            'act_buildtypeid' => $this->act_buildtypeid,

            'act_commu' => $this->act_commu,
            'act_leadname' => $this->act_leadname,
            'act_position' => $this->act_position,
            'act_leadinfo' => $this->act_leadinfo,

            'act_buildname' => $this->act_buildname,
            'act_moo' => $this->act_moo,
            'act_subdistrict' => $this->act_subdistrict,
            'act_district' => $this->act_district,
            'act_province' => $this->act_province,
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
        $this->troubletype_list = OoapMasTroubletype::where('inactive', false)->pluck('name', 'id');
        $this->acttye_list = OoapMasActtype::where('inactive', false)->pluck('name', 'id');
        $this->troubletype_list = OoapMasTroubletype::where('inactive', false)->pluck('name', 'id');
        $this->unit_list = OoapMasUnit::where('inactive', false)->pluck('name', 'id');
        $this->province_list = OoapMasProvince::where('in_active', false)->pluck('province_name', 'province_id');
        $this->acttye_id = $pullactivities->act_acttype;
        $this->buildingtype_list = OoapMasBuildingtype::where('acttype_id', '=', 1)->where('in_active', false)->pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::where('in_active', false)->pluck('name', 'patternarea_id');

        $this->act_shortname = $pullactivities->act_shortname;
        $this->act_desc = $pullactivities->act_desc;
        $this->act_remark = $pullactivities->act_remark;
        $this->act_peopleno = $pullactivities->act_peopleno;
        $this->act_troubletype = $pullactivities->act_troubletype;
        $this->act_buildtypeid = $pullactivities->act_buildtypeid;
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
        $this->act_measure = $pullactivities->act_measure;
        $this->act_metric = $pullactivities->act_metric;
        $this->act_width = $pullactivities->act_width;
        $this->act_length = $pullactivities->act_length;
        $this->act_height = $pullactivities->act_height;
        $this->stdate = dateToMontYears($pullactivities->act_startmonth);
        $this->endate = dateToMontYears($pullactivities->act_endmonth);
        $this->act_startmonth = $pullactivities->act_startmonth;
        $this->act_endmonth = $pullactivities->act_endmonth;
        $this->act_numofday = $pullactivities->act_numofday;
        $this->act_numofpeople = $pullactivities->act_numofpeople;
        $this->act_approvenote = $pullactivities->act_approvenote;
        $this->act_rate = $pullactivities->act_rate;
        $this->act_ref_number = $val;
        $this->file_array_old = OoapTblActivityFiles::where('act_id', '=', $val)->where('in_active', '=', false)->get()->toArray() ?? [];
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
                } else {
                    $this->act_unit = null;
                }
            } elseif ($this->act_measure == 3) {
                if ($this->act_width != null && $this->act_length != null ) {
                    $this->act_unit = ($this->act_width ? $this->act_width : 0) * ($this->act_length ? $this->act_length : 0);
                    $this->act_height = null;
                } else {
                    $this->act_unit = null;
                }
            }

            if ($this->act_numofpeople && $this->act_numofday && $this->act_rate) {
                 $this->distext = false;
            } else {
                 $this->distext = true;
            }

        $this->amphur_list = OoapMasAmphur::where('province_id', '=', $this->province_id)->pluck('amphur_name', 'amphur_id');
        $this->tambon_list = OoapMasTambon::where('amphur_id', '=', $this->act_district)->pluck('tambon_name', 'tambon_id');

        $this->amphur_list = OoapMasAmphur::where('province_id', '=', $this->act_province)->where('in_active', false)->pluck('amphur_name', 'amphur_id');
        $this->tambon_list = OoapMasTambon::where('amphur_id', '=', $this->act_district)->where('in_active', false)->pluck('tambon_name', 'tambon_id');
        $this->act_dept = auth()->user()->division_name;
        $this->act_deptinput = auth()->user()->department_id;
        $this->act_div = auth()->user()->division_id;

        $this->validate_panel1();
        $this->validate_panel2();
        $this->validate_panel3();
        $this->validate_panel4();
        $this->validate_panel5();

        if ($this->act_year > 0) {
            $act_number_success = OoapTblActivities::select('act_id')->where('in_active', '=', false)->where('act_year', '=', $this->act_year)->where('act_acttype', '=', 1)
                ->where('act_plan_adjust_status', '=', 1)
                ->get()->toArray() ?? [];
            $this->ref_number_list = OoapTblActivities::where('in_active', '=', false)
                ->whereNotIn('act_id', $act_number_success)
                ->where('act_year', '=', $this->act_year)
                ->where('act_div', '=', auth()->user()->division_id)
                ->where('act_acttype', '=', 1)
                ->where('status', '=', 3)
                ->pluck('act_number', 'act_id');
        } else {
            $this->act_year = $this->fiscalyear_list->first();
        }

        return view('livewire.activity.plan-adjust.hire-component');
    }
}
