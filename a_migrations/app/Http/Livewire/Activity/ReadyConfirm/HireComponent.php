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
use App\Models\OoapTblEmployee;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblActivityFiles;
use App\Models\OoapTblActivities;

use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class HireComponent extends Component
{
    use WithFileUploads;
    public $stdate, $endate, $date_list = [], $perioddays, $wages, $target_peoples;
    public $lat, $lng, $act_moo, $act_subdistrict, $tambon_list, $act_district, $amphur_list, $province_id, $province_list, $act_leadinfo, $act_commu, $act_leadname, $act_position;
    public $act_number, $panel = 1, $status = 1, $acttype1;
    public $acttype_id, $act_year, $act_periodno, $fiscalyear_list, $act_dept, $dept_list, $act_unit, $unit_id = 1, $unit_list, $acttye_list, $acttye_id, $buildingtype_list, $buildingtype_id;
    public $act_shortname, $act_troubletype, $troubletype_list;
    public $act_measure, $act_metric, $pattern_list, $act_width, $act_length, $act_height;
    public $patternarea_id = 0, $act_desc, $act_remark, $local_material, $act_peopleno, $act_buildtypeid;
    public $area_wide, $area_long, $area_high, $area_total;
    public $act_startmonth, $act_endmonth, $act_numofday, $act_numofpeople, $act_numlecturer, $act_rate, $act_amount;
    public $created_at, $act_buildname, $building_lat, $building_long;

    public $file_array = [], $files, $a = 1;
    public $circle1 = false,  $circle2 = false,  $circle3 = false,  $circle4 = false,  $circle5 = false;
    public $alert1 = false,  $alert2 = false,  $alert3 = false,  $alert4 = false,  $alert5 = false, $distext = true;


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

    public function mount()
    {
        // $this->dept_list = DB::connection('oracle_umts')->table('um_mas_department')->pluck("dept_name_th", "act_dept");
        // $this->dept_list = UmMasDepartment::pluck('dept_name_th', 'act_dept');
        $this->fiscalyear_list = OoapTblFiscalyear::pluck('fiscalyear_code', 'fiscalyear_code as new');
        $this->acttye_list = OoapMasActtype::pluck('name', 'id');
        $this->troubletype_list = OoapMasTroubletype::pluck('name', 'id');
        $this->province_list = OoapMasProvince::pluck('province_name', 'province_id');
        $this->created_at = date("Y-m-d");
        $this->acttye_id = 1;
        $this->buildingtype_list = OoapMasBuildingtype::pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::pluck('name', 'patternarea_id as act_measure');
        $this->unit_list = OoapMasUnit::pluck('name', 'id as act_metric');

        $this->acttype1 = OoapMasActtype::where('inactive', '=', false)->where('id', '=', 1)->first();
        $this->act_rate = $this->acttype1->job_wage_maxrate;

    }

    public function submit_prototype($status)
    {
        // dd($this->act_dept);
        // $this->emit('popup',$this->act_number);

        if ($this->act_year == null || $this->act_dept == null) {
            $this->alert1 = true;
        } else {
            $this->alert1 = false;
        }
        if ($this->act_shortname == null || $this->act_troubletype == null) {
            $this->alert2 = true;
        } else {
            $this->alert2 = false;
        }
        if ($this->act_numofpeople == null || $this->act_numofday == null || $this->act_rate == null) {
            $this->alert4 = true;
        } else {
            $this->alert4 = false;
        }

        $this->validate([
            'act_year' => 'required',
            // 'act_coursegroup' => 'required',
            'act_numofpeople' => 'required',
            // 'act_numlecturer' => 'required',
            'act_numofday' => 'required',
            // 'act_hrperday' => 'required',
        ], [
            'act_year.required' => 'กรุณาเลือก ปีงบประมาณ',
            // 'act_coursegroup.required' => 'กรุณาเลือก กลุ่มหลักสูตร',
            'act_numofpeople.required' => 'กรุณากรอก จำนวนคน',
            // 'act_numlecturer.required' => 'กรุณากรอก จำนวนวิทยากร',
            'act_numofday.required' => 'กรุณากรอก จำนวนวัน',
            // 'act_hrperday.required' => 'กรุณากรอก จำนวนชั้วโมง/วัน',
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
        if ($this->act_year == null || $this->act_periodno == null) {
            $this->circle1 = false;
        } else {
            $this->circle1 = true;
        }
    }

    public function validate_panel2()
    {
        if (
            $this->acttye_id == null ||
            $this->act_shortname == null || $this->act_desc == null || $this->act_remark == null || $this->act_buildname == null || $this->building_lat == null || $this->building_long == null
        ) {
            $this->circle2 = false;
        } else {
            $this->circle2 = true;
        }
    }

    public function validate_panel3()
    {
        if (
            $this->province_id == null || $this->act_district == null || $this->act_subdistrict == null || $this->act_moo == null ||
            $this->act_commu == null || $this->act_leadname == null || $this->act_position == null || $this->act_leadinfo == null
        ) {
            $this->circle3 = false;
        } else {
            $this->circle3 = true;
        }
    }

    public function validate_panel4()
    {
        if (
            $this->stdate == null || $this->endate == null || $this->act_numofday == null || $this->act_numofpeople == null || $this->act_rate == null
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
        if ($name == 'act_unit') {
            $numori = $this->act_width * $this->act_length * $this->act_height;
            if ($cal > $numori) {
                $this->act_unit = $this->act_width * $this->act_length * $this->act_height;
            } else {
                $this->act_unit = $cal;
            }
        }
        if ($name == 'act_amount') {
            $numori = $this->act_rate * $this->act_numofpeople * $this->act_numofday;
            if ($cal > $numori) {
                $this->act_amount = $this->act_rate * $this->act_numofpeople * $this->act_numofday;
            } else {
                $this->act_amount = $cal;
            }
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
                $this->act_amount = $this->act_numofday * $this->act_rate * $numofpeople;
            }
            if ($name == 'act_numofday') {
                $numofday = $num;
                $this->act_amount = $this->act_rate * $this->act_numofpeople * $numofday;
            }
            if ($name == 'act_rate') {
                $numofrate = $num;
                $this->act_amount = $this->act_rate * $this->act_numofpeople * $numofrate;
            }
        }else{
            $this->act_amount = 0;
        }
    }

    public function render()
    {
        $this->emit('emits');
        // $this->job_wage_amt = $this->job_wage_rate * $this->act_numofday * $this->act_numofpeople ?? 0;
            if ($this->act_numofday != null && $this->act_numofpeople != null && $this->act_rate != null) {
                $this->act_amount = $this->act_numofday * $this->act_numofpeople * $this->act_rate;
            }

            if ($this->act_measure == 2) {
                if ($this->act_width != null && $this->act_length != null && $this->act_height != null) {
                    $this->act_unit = $this->act_width * $this->act_length * $this->act_height;
                }
            } elseif ($this->act_measure == 3) {
                if ($this->act_width != null && $this->act_length != null ) {
                    $this->act_unit = $this->act_width * $this->act_length;
                }
            }

            if ($this->act_numofpeople && $this->act_numofday && $this->act_rate) {
                 $this->distext = false;
            } else {
                 $this->distext = true;
            }

        $this->amphur_list = OoapMasAmphur::where('province_id', '=', $this->province_id)->pluck('amphur_name', 'amphur_id');
        $this->tambon_list = OoapMasTambon::where('amphur_id', '=', $this->act_district)->pluck('tambon_name', 'tambon_id');
        $OoapTblEmployee = OoapTblEmployee::where('emp_id', '=', auth()->user()->emp_id)->first();
        $this->act_dept = $OoapTblEmployee->division_name;
        $this->act_deptinput = $OoapTblEmployee->department_id;
        $this->act_div = $OoapTblEmployee->division_id;

        $getId = OoapTblActivities::select('act_id')->where('act_year', '=', $this->act_year)->orderBy('act_id', 'DESC')->count() ?? 1;
        $this->act_number = "AT-" . substr($this->act_year, 2) . "-" . sprintf('%04d', $getId + 1);

        $this->validate_panel1();
        $this->validate_panel2();
        $this->validate_panel3();
        $this->validate_panel4();
        $this->validate_panel5();
        return view('livewire.activity.ready-confirm.hire-component');
    }
}
