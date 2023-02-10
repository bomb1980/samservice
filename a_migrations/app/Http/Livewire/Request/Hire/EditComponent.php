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
use App\Models\OoapTblReqapprovelog;
use App\Models\OoapTblRequestFiles;
use App\Models\OoapTblRequest;
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
    public $reqform_no, $panel = 1, $status;
    public $acttype_id, $req_year, $fiscalyear_list, $req_dept, $dept_list, $unit_list, $acttye_list, $acttye_id, $buildingtype_list, $buildingtype_id;
    public $req_shortname, $req_troubletype, $troubletype_id, $troubletype_list;
    public $req_measure, $req_metric, $pattern_list, $req_width, $req_length, $req_height, $req_unit;
    public $patternarea_id, $req_desc, $req_remark, $local_material, $req_peopleno, $req_buildtypeid;
    public $area_wide, $area_long, $area_high, $area_total;
    public $req_startmonth, $req_endmonth, $req_numofday, $req_numofpeople, $req_rate, $req_amount;
    public $created_at, $req_buildname, $building_lat, $building_long, $req_approvenote;

    public $file_array = [], $files, $file_array_old;

    public $circle1 = false,  $circle2 = false,  $circle3 = false,  $circle4 = false,  $circle5 = false;
    public $alert1 = false,  $alert2 = false,  $alert3 = false,  $alert4 = false,  $alert5 = false;
    public $formdisabled = true;
    public $emp_province_id,$province_disabled = false, $view;
    public $button_enables = false;

    public function render()
    {
        $this->emit('emits');
            if ($this->req_numofday !== null && $this->req_numofpeople !== null && $this->req_rate !== null) {
                $this->req_amount = ($this->req_numofday ? $this->req_numofday : 0) * ($this->req_numofpeople ? $this->req_numofpeople : 0) * ($this->req_rate ? $this->req_rate : 0);
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
                }
            } elseif ($this->req_measure == 3) {
                if ($this->req_width != null && $this->req_length != null ) {
                    $this->req_unit = ($this->req_width ? $this->req_width : 0) * ($this->req_length ? $this->req_length : 0);
                }
            }


            if ($this->req_numofpeople && $this->req_numofday && $this->req_rate) {
                 $this->distext = false;
            } else {
                 $this->distext = true;
            }

        $this->amphur_list = OoapMasAmphur::where('province_id', '=', $this->province_id)->pluck('amphur_name', 'amphur_id');
        $this->tambon_list = OoapMasTambon::where('amphur_id', '=', $this->req_district)->pluck('tambon_name', 'tambon_id');
        $OoapTblEmployee = OoapTblEmployee::where('division_id', '=', $this->req_div)->where('in_active', false)->first();
        $this->req_dept = $OoapTblEmployee->division_name;
        // $this->req_deptinput = $OoapTblEmployee->department_id;
        // $this->req_div = $OoapTblEmployee->division_id;

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

        return view('livewire.request.hire.edit-component');
    }

    //กิจกรรมจ้างงานเร่งด่วน
    public function mount($pullrequest)
    {
        $this->req_id = $pullrequest->req_id;
        $this->req_number = $pullrequest->req_number;
        $this->req_dept = $pullrequest->req_dept;
        $this->req_div = $pullrequest->req_div;
        $this->dept_list = UmMasDepartment::pluck('dept_name_th', 'dept_id');
        $this->created_at = date($pullrequest->created_at);

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

        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', false)->orderby('fiscalyear_code','desc')->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code_new');
        $this->troubletype_list = OoapMasTroubletype::pluck('name', 'id');
        $this->province_list = OoapMasProvince::pluck('province_name', 'province_id');
        $this->acttye_id = $pullrequest->req_acttype;
        $this->buildingtype_list = OoapMasBuildingtype::pluck('name', 'buildingtype_id');
        $this->patternarea_list = OoapMasPatternarea::pluck('name', 'patternarea_id as req_measure');
        $this->unit_list = OoapMasUnit::pluck('name', 'id as req_metric');

        $this->req_year = $pullrequest->req_year;
        $this->acttye_list = OoapMasActtype::pluck('name', 'id');
        $this->req_shortname = $pullrequest->req_shortname;
        $this->req_desc = $pullrequest->req_desc;
        $this->req_remark = $pullrequest->req_remark;
        $this->req_troubletype = $pullrequest->req_troubletype;
        $this->req_peopleno = $pullrequest->req_peopleno;
        $this->req_buildtypeid = $pullrequest->req_buildtypeid;
        $this->req_buildname = $pullrequest->req_buildname;
        $this->building_lat = $pullrequest->req_latitude;
        $this->building_long = $pullrequest->req_longtitude;
        $this->req_measure = $pullrequest->req_measure;
        $this->req_metric = $pullrequest->req_metric;
        $this->req_width = $pullrequest->req_width;
        $this->req_length = $pullrequest->req_length;
        $this->req_height = $pullrequest->req_height;
        $this->province_id = $pullrequest->req_province;
        $this->req_district = $pullrequest->req_district;
        $this->req_subdistrict = $pullrequest->req_subdistrict;
        $this->req_moo = $pullrequest->req_moo;
        $this->req_leadinfo = $pullrequest->req_leadinfo;
        $this->req_commu = $pullrequest->req_commu;
        $this->req_leadname = $pullrequest->req_leadname;
        $this->req_position = $pullrequest->req_position;

        $this->stdate = dateToMontYears($pullrequest->req_startmonth);
        $this->endate = dateToMontYears($pullrequest->req_endmonth);
        $this->req_startmonth = $pullrequest->req_startmonth;
        $this->req_endmonth = $pullrequest->req_endmonth;

        $this->req_numofday = $pullrequest->req_numofday;
        $this->req_numofpeople = $pullrequest->req_numofpeople;
        $this->req_rate = $pullrequest->req_rate;

        $this->status = $pullrequest->status;
        $this->req_approvenote = $pullrequest->req_approvenote;
        if ($this->status == 1 ||$this->status == 2 || $this->status == 5) {
            $this->formdisabled = false;
            $this->view = null;
            $emp_province_id = auth()->user()->province_id;
            if ($emp_province_id != null) {
                $this->province_disabled = true;
            }
        } else {
            $this->province_disabled = true;
            $this->view = 'disabled';
        }
        // if( OoapTblFiscalyearReqPeriod::canRequest() == 'close' || auth()->user()->emp_type == 1) {
        //     $this->formdisabled = true;
        //     $this->province_disabled = true;
        //     $this->view = 'disabled';
        // }
        $this->file_array_old = OoapTblRequestFiles::where('req_id', '=', $this->req_id)->where('in_active', '=', false)->get()->toArray() ?? [];
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

    public function destroy_old_array($key)
    {
        unset($this->file_array_old[$key]);
        $this->file_array_old = array_values($this->file_array_old);
    }

    public function submit_cancel()
    {
        OoapTblRequest::where('req_id', '=', $this->req_id)->update([
            'status' => 9,
            'updated_at' => now(),
            'updated_by' => auth()->user()->emp_citizen_id,
        ]);
        // dd($this);
        $this->emit('popup');
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
            OoapTblRequest::where('req_id', '=', $this->req_id)->update([
                'req_number' => $this->req_number,
                'req_year' => $this->req_year,
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
                'req_approvenote' => $this->req_approvenote,
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
        if($status == 2){
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
                'route_name' => 'request.hire.edit',
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
                        'noti_link' => route('request.consider.detail', ['acttype_id' => 1, 'id' => $this->req_id]),
                    ];

                    OoapTblNotification::create_($notis);
                }
            }
        }

        $logs['route_name'] = 'request.hire.edit';
        $logs['submenu_name'] = 'บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ (กิจกรรมจ้างงานเร่งด่วน)';
        $logs['log_type'] = 'edit';
        createLogTrans( $logs );

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
        $st_date = montYearsToDate($this->stdate);
        $en_date = montYearsToDate($this->endate);

        $this->req_startmonth = new DateTime(montYearsToDate($this->stdate));
        $this->req_endmonth = new DateTime(montYearsToDate($this->endate));
        $interval = $this->req_startmonth->diff($this->req_endmonth);
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
            $this->acttye_id == null || $this->req_shortname == null || $this->req_desc == null || $this->req_peopleno == null || $this->req_buildtypeid == null || $this->req_buildname == null || $this->req_measure == null) {
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
            $this->stdate == null || $this->endate == null || $this->req_numofpeople == null || $this->req_numofday == null || ((new DateTime(montYearsToDate($this->stdate))) > (new DateTime(montYearsToDate($this->endate))))
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
    //             $this->req_amount = number_format($this->req_rate * $this->req_numofpeople * $this->req_numofday,2);
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
}
