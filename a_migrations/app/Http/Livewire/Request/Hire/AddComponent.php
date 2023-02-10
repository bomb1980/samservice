<?php

namespace App\Http\Livewire\Request\Hire;

use App\Models\OoapLogTransModel;
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
use App\Models\OoapTblNotification;
use App\Models\OoapTblRequest;
use App\Models\OoapTblRequestFiles;
use App\Models\OoapTblReqapprovelog;
use DateTime;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddComponent extends Component
{
    use WithFileUploads;
    public $stdate, $endate, $date_list = [];
    public $lat, $lng, $req_moo, $req_subdistrict, $tambon_list, $req_district, $amphur_list, $province_id, $province_list, $req_leadinfo, $req_commu, $req_leadname, $req_position;
    public $req_number, $panel = 1, $status, $acttype1;
    public $acttype_id, $req_year, $fiscalyear_list, $req_dept, $dept_list, $unit_id, $unit_list, $acttye_list, $acttye_id, $buildingtype_list, $buildingtype_id;
    public $req_shortname, $req_troubletype, $troubletype_list;
    public $req_measure, $req_metric, $pattern_list, $req_width, $req_length, $req_height, $req_unit;
    public $patternarea_id, $req_desc, $req_remark, $local_material, $req_peopleno, $req_buildtypeid;
    public $area_wide, $area_long, $area_high, $area_total;
    public $req_startmonth, $req_endmonth, $req_numofday, $req_numofpeople, $req_numlecturer, $req_rate, $req_amount;
    public $created_at, $req_buildname, $building_lat, $building_long;

    public $file_array = [], $files;
    public $circle1 = false,  $circle2 = false,  $circle3 = false,  $circle4 = false,  $circle5 = false;
    public $alert1 = false,  $alert2 = false,  $alert3 = false,  $alert4 = false,  $alert5 = false, $distext = true;
    public $emp_province_id,$province_disabled = false;
    public $button_enables = false;


    public function mount()
    {
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', false)->orderby('fiscalyear_code','desc')->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code_new');
        $this->req_year=$this->fiscalyear_list->first();
        $this->acttye_list = OoapMasActtype::pluck('name', 'id');
        $this->troubletype_list = OoapMasTroubletype::pluck('name', 'id');
        $this->province_list = OoapMasProvince::where('province_id','!=',1)->pluck('province_name', 'province_id');
        $emp_province_id = auth()->user()->province_id;
        if ($emp_province_id != null) {
            $this->province_id = $emp_province_id;
            $this->province_disabled = true;
        }
        $this->created_at = date("Y-m-d");
        $this->acttye_id = 1;
        $this->buildingtype_list = OoapMasBuildingtype::pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::pluck('name', 'patternarea_id as req_measure');
        $this->unit_list = OoapMasUnit::pluck('name', 'id as req_metric');

        $this->acttype1 = OoapMasActtype::where('inactive', '=', false)->where('id', '=', 1)->first();
        $this->req_rate = $this->acttype1->job_wage_maxrate;

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
        if ($this->req_year == null || $this->req_dept == null) {
            $this->alert1 = true;
        } else {
            $this->alert1 = false;
        }
        if ($this->req_shortname == null || $this->req_desc == null || $this->req_troubletype == null || $this->req_peopleno == null || $this->req_buildtypeid == null || $this->req_buildname == null || $this->req_measure == null) {
            $this->alert2 = true;
        } else {
            $this->alert2 = false;
        }
        if ($this->province_id == null || $this->req_district == null || $this->req_subdistrict == null) {
            $this->alert3 = true;
        } else {
            $this->alert3 = false;
        }
        if ($this->stdate == null || $this->endate == null || $this->req_numofday == null || $this->req_numofpeople == null || $this->req_rate == null || ((new DateTime(montYearsToDate($this->stdate))) > (new DateTime(montYearsToDate($this->endate))))) {
            $this->alert4 = true;
        } else {
            $this->alert4 = false;
        }

        $this->validate([
            'req_year' => 'required',

            'req_shortname' => 'required',
            'req_desc' => 'required',
            'req_troubletype' => 'required',
            'req_peopleno' => 'required',
            'req_buildtypeid' => 'required',
            'req_buildname' => 'required',
            'req_measure' => 'required',

            'province_id' => 'required',
            'req_district' => 'required',
            'req_subdistrict' => 'required',

            'stdate' => 'required|date_format:m-Y|before_or_equal:endate',
            'endate' => 'required|date_format:m-Y|after_or_equal:stdate',

            'req_numofday' => 'required',
            'req_numofpeople' => 'required',
            'req_rate' => 'required',
        ], [
            'req_year.required' => 'กรุณาเลือก ปีงบประมาณ',

            'req_shortname.required' => 'กรุณากรอก ชื่อกิจกรรม',
            'req_desc.required' => 'กรุณากรอก รายละเอียดกิจกรรม',
            'req_troubletype.required' => 'กรุณาเลือก ประเภทความเดือดร้อน',
            'req_peopleno.required' => 'กรุณากรอก จำนวนประชาชนในพื้นที่ ที่ได้รับประโยชน์',

            'req_buildtypeid.required' => 'กรุณาเลือก ประเภทสถานที่',
            'req_buildname.required' => 'กรุณากรอก ชื่อสถานที่',
            'req_measure.required' => 'กรุณาเลือก รูปแบบการวัดพื้นที่',

            'province_id.required' => 'กรุณากรอก จังหวัด',
            'req_district.required' => 'กรุณากรอก อำเภอ',
            'req_subdistrict.required' => 'กรุณากรอก ตำบล',

            'stdate.required' => 'กรุณากรอก เดือนที่เริ่ม',
            'stdate.before_or_equal' => 'เดือนที่เริ่ม ต้องน้อยกว่าหรือเท่ากับ เดือนที่สิ้นสุด',
            'endate.required' => 'กรุณากรอก เดือนที่สิ้นสุด',
            'endate.after_or_equal' => 'เดือนที่สิ้นสุด ต้องมากว่าหรือเท่ากับ เดือนที่เริ่ม',
            'req_numofday.required' => 'กรุณากรอก จำนวนวันดำเนินการ',
            'req_numofpeople.required' => 'กรุณากรอก จำนวนคน',
            'req_rate.required' => 'กรุณากรอก อัตราค่าตอบแทนต่อคนต่อวัน',
        ]);

        $data = OoapTblRequest::create([
            'req_number' => $this->req_number,
            'req_year' => $this->req_year,
            'req_dept' => $this->req_deptinput,
            'req_div' => $this->req_div,
            'req_acttype' => 1,
            'req_shortname' => $this->req_shortname,
            'req_desc' => $this->req_desc,
            'req_remark' => $this->req_remark,
            'req_troubletype' => $this->req_troubletype,
            'req_peopleno' => $this->req_peopleno,
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
            'req_measure' => $this->req_measure,
            'req_metric' => $this->req_metric,
            'req_width' => $this->req_width,
            'req_length' => $this->req_length,
            'req_height' => $this->req_height,
            'req_unit' => $this->req_unit,
            'req_startmonth' => $this->req_startmonth,
            'req_endmonth' => $this->req_endmonth,
            'req_numofday' => $this->req_numofday,
            'req_numofpeople' => $this->req_numofpeople,
            'req_rate' => $this->req_rate,
            'req_amount' => $this->req_amount,
            'status' => 1,
            'remember_token' => csrf_token(),
            'updated_by' => auth()->user()->emp_citizen_id,
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now(),
        ]);
        if ($status == 2) {
            OoapTblRequest::where('req_id', '=', $data->req_id)->update([
                'status' => 2
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
        if($status == 2){
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
                'route_name' => 'request.hire.create',
                'log_name' => 'บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ (กิจกรรมจ้างงานเร่งด่วน)',
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
                        'noti_link' => route('request.consider.detail', ['acttype_id' => 1, 'id' => $data->req_id]),
                    ];

                    OoapTblNotification::create_($notis);
                }
            }
        }

        $logs['route_name'] = 'request.hire.create';
        $logs['submenu_name'] = 'บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ (กิจกรรมจ้างงานเร่งด่วน)';
        $logs['log_type'] = 'create';
        createLogTrans( $logs );

        $this->emit('popup', $this->req_number);
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->to('/request/project');
    }

    public function changPanel($num)
    {
        $this->panel = $num;
    }

    public function setArray()
    {
        $st_date = montYearsToDate($this->stdate);
        $en_date = montYearsToDate($this->endate);

        $this->req_startmonth = new DateTime(montYearsToDate($this->stdate));
        $this->req_endmonth = new DateTime(montYearsToDate($this->endate));
    }

    public function setValue($name, $val)
    {
        dd($name, $val);
        $this->$name = $val;
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
            $this->acttye_id == null || $this->req_shortname == null || $this->req_desc == null || $this->req_buildtypeid == null || $this->req_buildname == null || $this->req_peopleno == null || $this->req_measure == null
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
            $this->stdate == null || $this->endate == null || $this->req_numofday == null || $this->req_numofpeople == null || $this->req_rate == null || ((new DateTime(montYearsToDate($this->stdate))) > (new DateTime(montYearsToDate($this->endate))))
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

    // public function calsum($name, $cal)
    // {
    //     if ($name == 'req_unit') {
    //         $numori = $this->req_width * $this->req_length * $this->req_height;
    //         if ($cal > $numori) {
    //             $this->req_unit = $this->req_width * $this->req_length * $this->req_height;
    //         } else {
    //             $this->req_unit = $cal;
    //         }
    //     }
    //     if ($name == 'req_amount') {
    //         $numori = $this->req_rate * $this->req_numofpeople * $this->req_numofday;
    //         if ($cal > $numori) {
    //             $this->req_amount = $this->req_rate * $this->req_numofpeople * $this->req_numofday;
    //         } else {
    //             $this->req_amount = $cal;
    //         }
    //     }
    // }

    public function setnum($name, $num)
    {
        if($num == null){
            $num = 0;
        }
        if ($this->req_numofpeople && $this->req_numofday && $this->req_rate) {
            if ($name == 'req_numofpeople') {
                $numofpeople = $num;
                $this->req_amount = ($this->req_numofday ? $this->req_numofday : 0) * ($this->req_rate ? $this->req_rate : 0) * $numofpeople;
            }
            if ($name == 'req_numofday') {
                $numofday = $num;
                $this->req_amount = ($this->req_rate ? $this->req_rate : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0) * $numofday;
            }
            if ($name == 'req_rate') {
                $numofrate = $num;
                $this->req_amount = ($this->req_rate ? $this->req_rate : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0) * $numofrate;
            }
        }else{
            $this->req_amount = 0;
        }
    }

    public function render()
    {
        $this->emit('emits');
            if ($this->req_numofday != null && $this->req_numofpeople != null && $this->req_rate != null) {
                $this->req_amount = ($this->req_numofday ? $this->req_numofday : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0) * ($this->req_rate ? $this->req_rate : 0);
            }

            if ($this->req_numofpeople && $this->req_numofday && $this->req_rate) {
                $this->distext = false;
           } else {
                $this->distext = true;
           }
           if ($this->req_measure == 1) {
            $this->req_metric = null;
            $this->req_width = null;
            $this->req_length = null;
            $this->req_height = null;
            $this->req_unit = null;
           } elseif ($this->req_measure == 2) {
            if ($this->req_width != null && $this->req_length != null && $this->req_height != null) {
                $this->req_unit = ($this->req_width ? $this->req_width : 0) * ($this->req_length ? $this->req_length : 0) * ($this->req_height ? $this->req_height : 0);
            } else {
                $this->req_unit = null;
            }
        } elseif ($this->req_measure == 3) {
            if ($this->req_width != null && $this->req_length != null ) {
                $this->req_unit = ($this->req_width ? $this->req_width : 0) * ($this->req_length ? $this->req_length : 0);
                $this->req_height = null;
            } else {
                $this->req_unit = null;
            }
        }

        $this->amphur_list = OoapMasAmphur::where('province_id', '=', $this->province_id)->pluck('amphur_name', 'amphur_id');
        $this->tambon_list = OoapMasTambon::where('amphur_id', '=', $this->req_district)->pluck('tambon_name', 'tambon_id');
        $this->req_dept = auth()->user()->division_name;
        $this->req_deptinput = auth()->user()->department_id;
        $this->req_div = auth()->user()->division_id;


        $getId = OoapTblRequest::select('req_id')->where('in_active', '=', false)->where('req_year', '=', $this->req_year)->count() ?? 0;
        $this->req_number = "RF-" . substr($this->req_year, 2) . date("m") .  "-" . sprintf('%04d', $getId + 1);

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

        return view('livewire.request.hire.add-component');
    }
}
