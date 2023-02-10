<?php

namespace App\Http\Livewire\Activity\ReadyConfirm;

use App\Models\OoapMasActtype;
use App\Models\OoapMasAmphur;
use App\Models\OoapMasBuildingtype;
use App\Models\OoapMasPatternarea;
use App\Models\OoapMasProvince;
use App\Models\OoapMasTambon;
use App\Models\OoapMasTroubletype;
use App\Models\OoapMasUnit;
use App\Models\OoapTblActapprovelog;
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

class HireAddComponent extends Component
{
    use WithFileUploads;
    public $stdate, $endate, $date_list = [];
    public $lat, $lng, $act_moo, $act_subdistrict, $tambon_list, $act_district, $amphur_list, $province_id, $province_list, $act_leadinfo, $act_commu, $act_leadname, $act_position;
    public $act_number, $panel = 1, $status, $acttype1;
    public $acttype_id, $act_year, $act_periodno, $fiscalyear_list, $act_dept, $dept_list, $act_unit, $unit_id, $unit_list, $acttye_list, $acttye_id, $buildingtype_list, $buildingtype_id;
    public $act_shortname, $act_troubletype, $troubletype_list;
    public $act_measure, $act_metric, $pattern_list, $act_width, $act_length, $act_height;
    public $patternarea_id, $act_desc, $act_remark, $act_peopleno, $act_buildtypeid;
    public $area_wide, $area_long, $area_high;
    public $act_startmonth, $act_endmonth, $act_numofday, $act_numofpeople, $act_numlecturer, $act_rate, $act_amount;
    public $created_at, $act_buildname, $building_lat, $building_long;

    // public $file_array = [], $files, $a = 1;
    public $file_array = [], $files, $file_array_old = [];
    public $circle1 = false,  $circle2 = false,  $circle3 = false,  $circle4 = false,  $circle5 = false;
    public $alert1 = false,  $alert2 = false,  $alert3 = false,  $alert4 = false,  $alert5 = false, $distext = true;
    public $emp_province_id,$province_disabled = false, $ref_number_list = [], $act_ref_number, $req_number;
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
            ->where('in_active', '=', false)
            ->get()->toArray() ?? [];

        $this->fiscalyear_list = OoapTblRequest::where('in_active', '=', false)
            ->whereIn('req_year', $fis_year)
            ->where('req_div', '=', auth()->user()->division_id)
            ->where('req_acttype', '=', 1)
            ->whereNotIn('status', [1,5])
            ->pluck('req_year', 'req_year as new');

        $this->act_year = $this->fiscalyear_list->first();
        $this->acttye_list = OoapMasActtype::pluck('name', 'id');
        $this->troubletype_list = OoapMasTroubletype::pluck('name', 'id');
        $this->province_list = OoapMasProvince::pluck('province_name', 'province_id');
        $emp_province_id = auth()->user()->province_id;
        if ($emp_province_id != null) {
            $this->province_id = $emp_province_id;
            $this->province_disabled = true;
        }
        $this->created_at = date("Y-m-d");
        $this->acttye_id = 1;
        $this->buildingtype_list = OoapMasBuildingtype::where('acttype_id', '=', 1)->where('in_active', false)->pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::pluck('name', 'patternarea_id as act_measure');
        $this->unit_list = OoapMasUnit::pluck('name', 'id as act_metric');

        $this->acttype1 = OoapMasActtype::where('inactive', '=', false)->where('id', '=', 1)->first();


        // $pull_template = OoapTblAssess::where('in_active', 0)->latest()->first();
        // if ($pull_template) {
        //     $this->templateno = $pull_template->assess_templateno;
        // } else {
        //     $this->templateno = null;
        // }

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

        $data = OoapTblActivities::create([
            'act_number' => $this->act_number,
            'act_year' => $this->act_year,
            'act_periodno' => $this->act_periodno,
            'act_dept' => $this->act_deptinput,
            'act_div' => $this->act_div,
            'act_acttype' => 1,
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
            'act_ref_number' => $this->act_ref_number,
            'act_amount' => $this->act_amount,
            'status' => 1,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now()
        ]);
        if ($status == 2) {
            OoapTblActivities::where('act_id', '=', $data->act_id)->update([
                'status' => 2
            ]);
        }

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
        OoapTblActapprovelog::create([
            'act_log_type' => 'APP',
            'act_ref_id' => $data->act_id,
            'act_log_date' => now(),
            'act_log_actions' => 'การยืนยันความพร้อมคำขอรับจัดสรรงบ',
            'act_log_details' => 'บันทึกความพร้อมคำขอรับจัดสรรงบ',
            'status' => 1,
        ]);
        if ($status == 2) {
            OoapTblActapprovelog::create([
                'act_log_type' => 'APP',
                'act_ref_id' => $data->act_id,
                'act_log_date' => now(),
                'act_log_actions' => 'การยืนยันความพร้อมคำขอรับจัดสรรงบ',
                'act_log_details' => 'ยืนยันความพร้อมคำขอรับจัดสรรงบ',
                'status' => 2,
            ]);
        }
        $logs['route_name'] = 'activity.ready_confirm.hire.create';
        $logs['submenu_name'] = 'บันทึกยืนยันความพร้อมคำขอการจัดสรรงบ (กิจกรรมจ้างงานเร่งด่วน)';
        $logs['log_type'] = 'create';
        createLogTrans( $logs );

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
        $st_date = montYearsToDate($this->stdate);
        $en_date = montYearsToDate($this->endate);

        $this->act_startmonth = new DateTime(montYearsToDate($this->stdate));
        $this->act_endmonth = new DateTime(montYearsToDate($this->endate));
    }

    public function setValue($name, $val)
    {
        dd($name, $val);
        $this->$name = $val;
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

    public function set_ref_request($val)
    {
        if ($val == null) {
            return 0;
        }
        $pullrequest = OoapTblRequest::where('in_active', '=', false)
            ->where('req_id', '=', $val)->first();
        $this->act_dept = $pullrequest->req_dept;

        $this->dept_list = UmMasDepartment::where('in_active', false)->pluck('dept_name_th', 'dept_id');
        $this->created_at = date($pullrequest->created_at);
        $this->act_year = $pullrequest->req_year;
        $this->troubletype_list = OoapMasTroubletype::where('inactive', false)->pluck('name', 'id');
        $this->unit_list = OoapMasUnit::where('inactive', false)->pluck('name', 'id');
        $this->province_list = OoapMasProvince::where('in_active', false)->pluck('province_name', 'province_id');
        $this->act_acttype = $pullrequest->req_acttype;
        $this->buildingtype_list = OoapMasBuildingtype::where('acttype_id', '=', 1)->where('in_active', false)->pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::where('in_active', false)->pluck('name', 'patternarea_id');

        $this->req_number = $pullrequest->req_number;
        $this->act_shortname = $pullrequest->req_shortname;
        $this->act_desc = $pullrequest->req_desc;
        $this->act_remark = $pullrequest->req_remark;
        $this->act_peopleno = $pullrequest->req_peopleno;
        $this->act_troubletype = $pullrequest->req_troubletype;
        $this->act_buildtypeid = $pullrequest->req_buildtypeid;
        $this->act_measure = $pullrequest->req_measure;
        $this->act_metric = $pullrequest->req_metric;
        $this->act_width = $pullrequest->req_width;
        $this->act_length = $pullrequest->req_length;
        $this->act_height = $pullrequest->req_height;

        $this->act_buildname = $pullrequest->req_buildname;
        $this->building_lat = $pullrequest->req_latitude;
        $this->building_long = $pullrequest->req_longtitude;
        $this->province_id = $pullrequest->req_province;
        $this->act_district = $pullrequest->req_district;
        $this->act_subdistrict = $pullrequest->req_subdistrict;
        $this->act_moo = $pullrequest->req_moo;
        $this->act_leadinfo = $pullrequest->req_leadinfo;
        $this->act_commu = $pullrequest->req_commu;
        $this->act_leadname = $pullrequest->req_leadname;
        $this->act_position = $pullrequest->req_position;

        $this->stdate = dateToMontYears($pullrequest->req_startmonth);
        $this->endate = dateToMontYears($pullrequest->req_endmonth);

        $this->act_numofday = $pullrequest->req_numofday;
        $this->act_startmonth = $pullrequest->req_startmonth;
        $this->act_endmonth = $pullrequest->req_endmonth;
        $this->act_numofpeople = $pullrequest->req_numofpeople;
        $this->act_rate = $pullrequest->req_rate;

        $this->act_approvenote = $pullrequest->req_approvenote;

        $this->act_ref_number = $val;
        $this->file_array_old = OoapTblRequestFiles::where('req_id', '=', $val)->where('in_active', '=', false)->get()->toArray() ?? [];

    }

    public function render()
    {
        $this->emit('emits');
        // $this->job_wage_amt = $this->job_wage_rate * $this->act_numofday * $this->act_numofpeople ?? 0;
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

        $this->act_dept = auth()->user()->division_name;
        $this->act_deptinput = auth()->user()->department_id;
        $this->act_div = auth()->user()->division_id;
        $emp_province_id = auth()->user()->province_id;
        if ($emp_province_id != null) {
            $this->province_id = $emp_province_id;
            $this->province_disabled = true;
        }

        $getId = OoapTblActivities::select('act_id')->where('act_year', '=', $this->act_year)->count() ?? 0;
        $this->act_number = "AT-" . substr($this->act_year, 2) . date("m") . "-" . sprintf('%04d', $getId + 1);
          // $this->act_number = "RF-" . substr($this->act_year, 2) . date("m") . "-" . sprintf('%04d', $getId + 1);
        $this->validate_panel1();
        $this->validate_panel2();
        $this->validate_panel3();
        $this->validate_panel4();
        $this->validate_panel5();

        if ($this->circle1 == true && $this->circle2 == true && $this->circle3 == true && $this->circle4 == true) {
            $this->button_enables = true;
        } else {
            $this->button_enables = false;
        }
        if ($this->act_year > 0) {
            $act_number_success = OoapTblActivities::select('act_ref_number')->where('in_active', '=', false)->where('act_year', '=', $this->act_year)->where('act_acttype', '=', 1)->get()->toArray() ?? [];
            $this->ref_number_list = OoapTblRequest::where('in_active', '=', false)
                ->whereNotIn('req_id', $act_number_success)
                ->where('req_year', '=', $this->act_year)
                ->where('req_div', '=', auth()->user()->division_id)
                ->where('req_acttype', '=', 1)
                ->where('status', '=', 3)
                ->pluck('req_number', 'req_id');
        } else {
            $this->act_year = $this->fiscalyear_list->first();
        }
        return view('livewire.activity.ready-confirm.hire-add-component');
    }
}
