<?php

namespace App\Http\Livewire\Activity\Operate\Population;

use App\Models\OoapMasAmphur;
use App\Models\OoapMasOcuupation;
use App\Models\OoapMasProvince;
use App\Models\OoapMasTambon;
use App\Models\OoapTblActivities;
use App\Models\OoapTblPopulation;
use Livewire\Component;

class AddComponent extends Component
{
    public $pop_role, $pop_nationalid, $check_thai_id, $pop_welfarecard, $pop_sname, $pop_firstname, $pop_lastname, $pop_gender = "ไม่ระบุ", $pop_age, $pop_birthday;
    public $pop_addressno, $pop_moo, $pop_soi, $pop_province, $pop_district, $pop_subdistrict, $pop_postcode, $pop_mobileno, $pop_ocuupation, $pop_education;
    public $pop_income, $act_id, $role, $type_role, $defective, $labor, $elderly;
    public $role_list = [], $pop_sname_list = [], $money_list = [];

    public $act_acttype; //Nakbin add


    public function mount($act_id, $act_number, $role)
    {
        $this->act_id = $act_id;
        $this->act_number = $act_number;

        //role 1=>วิทยากร 2=>ผู้เข้าร่วมกิจกรรม
        $this->role = $role;

        $this->role_list_1 = [1 => 'วิทยากรวิถีชุมชน', 2 => 'วิทยากรคุณวุฒิเฉพาะด้าน'];
        $this->role_list_2 = [1 => 'ผู้เข้าร่วม', 2 => 'ผู้นำชุมชน'];
        $this->pop_sname_list = [1 => 'นาย', 2 => 'นาง', 3 => 'นางสาว'];
        $this->education_list = [0 => 'ประถมศึกษาตอนต้น', 1 => 'ประถมศึกษาตอนปลาย', 2 => 'มัธยมศึกษาตอนต้น', 3 => 'มัธยมศึกษตอนปลาย', 4 => 'ประกาศนียบัตรวิชาชีพ (ปวช.)', 5 => 'ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส.)', 6 => 'ปริญญาตรี', 7 => 'ปริญญาโท', 8 => 'ปริญญาเอก'];
        $this->ocuupation_list = OoapMasOcuupation::where('in_active', false)->pluck('name', 'id');
        $this->money_list = [0 => 'น้อยกว่า 10000', 1 => '10000 - 15000', 2 => '15001 - 25000', 3 => '25001 - 35000', 4 => 'มากกว่า 35000'];

        $this->province_list = OoapMasProvince::where('in_active', false)->pluck('province_name', 'province_id');
        $act_list = OoapTblActivities::where('act_id', '=', $act_id)->where('in_active', false)->first();
        $this->pop_periodno = $act_list->act_periodno;
        $this->pop_div = $act_list->act_div;
        $this->pop_role = 2;

        $this->act_acttype = $act_list->act_acttype; //Nakbin add
    }

    public function submit()
    {
        // dd($this->role);
        $roletodb = 1;
        if ($this->role == 1) {
            $this->validate([
                'type_role' => 'required',
                'pop_nationalid' => 'required',
                'pop_sname' => 'required',
                'pop_firstname' => 'required',
                'pop_lastname' => 'required',
                'pop_addressno' => 'required',
                'pop_province' => 'required',
                'pop_district' => 'required',
                'pop_subdistrict' => 'required',
                'pop_education' => 'required',
                'pop_birthday' => 'required',
                'pop_sname' => 'required',
            ], [
                'type_role.required' => 'กรุณาเลือก เลือกสถานะ',
                'pop_nationalid.required' => 'กรุณากรอก บัตรประจำตัวประชาชน',
                'pop_sname.required' => 'กรุณาเลือก คำนำหน้า',
                'pop_firstname.required' => 'กรุณากรอก ชื่อ',
                'pop_lastname.required' => 'กรุณากรอก นามสกุล',
                'pop_addressno.required' => 'กรุณากรอก จำนวนวัน',
                'pop_province.required' => 'กรุณาเลือก จังหวัด',
                'pop_district.required' => 'กรุณาเลือก อำเภอ',
                'pop_subdistrict.required' => 'กรุณาเลือก ตำบล',
                'pop_education.required' => 'กรุณาเลือก วุฒิการศึกษา',
                'pop_birthday.required' => 'กรุณาเลือก วัน/เดือน/ปีเกิด',
                'pop_sname.required' => 'กรุณาเลือก คำนำหน้า',
            ]);
        } else {
            $this->validate([
                'type_role' => 'required',
                'pop_nationalid' => 'required',
                'pop_sname' => 'required',
                'pop_firstname' => 'required',
                'pop_lastname' => 'required',
                'pop_addressno' => 'required',
                'pop_province' => 'required',
                'pop_district' => 'required',
                'pop_subdistrict' => 'required',
                'pop_ocuupation' => 'required',
                'pop_income' => 'required',
                'defective' => 'required',
                'labor' => 'required',
                'pop_birthday' => 'required',
            ], [
                'type_role.required' => 'กรุณาเลือก เลือกสถานะ',
                'pop_nationalid.required' => 'กรุณากรอก บัตรประจำตัวประชาชน',
                'pop_sname.required' => 'กรุณาเลือก คำนำหน้า',
                'pop_firstname.required' => 'กรุณากรอก ชื่อ',
                'pop_lastname.required' => 'กรุณากรอก นามสกุล',
                'pop_addressno.required' => 'กรุณากรอก จำนวนวัน',
                'pop_province.required' => 'กรุณาเลือก จังหวัด',
                'pop_district.required' => 'กรุณาเลือก อำเภอ',
                'pop_subdistrict.required' => 'กรุณาเลือก ตำบล',
                'pop_ocuupation.required' => 'กรุณาเลือก กลุ่มอาชีพหลัก',
                'pop_income.required' => 'กรุณากรอก รายได้ต่อเดือน',
                'defective.required' => 'กรุณาเลือก ท่านเป็นผู้พิการใช่หรือไม่',
                'labor.required' => 'กรุณาเลือก ท่านเป็นแรงงานนอกระบบใช่หรือไม่',
                'pop_birthday.required' => 'กรุณาเลือก วัน/เดือน/ปีเกิด',
            ]);
            if ($this->type_role == 1) {
                //ผู้เข้าร่วม
                $roletodb = 2;
            } else {
                //ผู้นำชุมชน
                $roletodb = 3;
            }
            $this->type_role = null;
        }
        OoapTblPopulation::create([
            'pop_actnumber' => $this->act_number,
            'pop_year' => date("Y") + 543,
            'pop_periodno' => $this->pop_periodno,
            'pop_div' => auth()->user()->division_id,
            'pop_role' => $roletodb,
            'pop_nationalid' => str_replace('-', '', $this->pop_nationalid),
            'pop_welfarecard' => $this->pop_welfarecard,
            'pop_title' => $this->pop_sname,
            'pop_firstname' => $this->pop_firstname,
            'pop_lastname' => $this->pop_lastname,
            'pop_gender' => $this->pop_gender,
            'pop_age' => getAge(DateToSqlExpSlash($this->pop_birthday)),
            'pop_birthday' => DateToSqlExpSlash($this->pop_birthday),
            'pop_addressno' => $this->pop_addressno,
            'pop_moo' => $this->pop_moo,
            'pop_soi' => $this->pop_soi,
            'pop_province' => $this->pop_province,
            'pop_district' => $this->pop_district,
            'pop_subdistrict' => $this->pop_subdistrict,
            'pop_education' => $this->pop_education,
            'pop_postcode' => $this->pop_postcode,
            'pop_mobileno' => str_replace('-', '', $this->pop_mobileno),
            'pop_ocuupation' => $this->pop_ocuupation,
            'pop_income' => $this->pop_income,
            'pop_elderly' => $this->elderly,
            'pop_labor' => $this->labor,
            'pop_defective' => $this->defective,
            'pop_typelecturer' => $this->type_role,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now(),

        ]);

        $this->emit('popup', 1);
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        // if ($this->act_acttype == 1) //Nakbin add
        // {
        //     return redirect()->route('activity.ready_confirm.hire.edit', ['id' => $this->act_id]);
        // } else {
        //     return redirect()->route('activity.ready_confirm.train.edit', ['id' => $this->act_id]);
        // }
        return redirect()->route('activity.participant.index');
    }

    public function callBack()
    {
        // if ($this->act_acttype == 1) //Nakbin add
        // {
        //     return redirect()->route('activity.ready_confirm.hire.edit', ['id' => $this->act_id]);
        // } else {
        //     return redirect()->route('activity.ready_confirm.train.edit', ['id' => $this->act_id]);
        // }
        return redirect()->route('activity.participant.index');
    }

    public function getDataLinkgate()
    {
        $data = callLinkgate(str_replace('-', '', $this->pop_nationalid), auth()->user()->emp_citizen_id);
        $data_home = callLinkgateHome(str_replace('-', '', $this->pop_nationalid), auth()->user()->emp_citizen_id);

        // $data_home = '{
        // "houseID": 24060408671,
        // "houseNo": "171/31",
        // "houseType": 1,
        // "houseTypeDesc": "บ้าน",
        // "villageNo": 6,
        // "alleyWayCode": 0,
        // "alleyWayDesc": null,
        // "alleyCode": 0,
        // "alleyDesc": null,
        // "roadCode": 0,
        // "roadDesc": null,
        // "subdistrictCode": 7,
        // "subdistrictDesc": "หนองแหน",
        // "districtCode": 6,
        // "districtDesc": "พนมสารคาม",
        // "provinceCode": 24,
        // "provinceDesc": "ฉะเชิงเทรา",
        // "rcodeCode": "2406",
        // "rcodeDesc": "อำเภอพนมสารคาม",
        // "dateOfTerminate": 0
        // }';

        // $data_home = json_decode($data_home);

        if ($data) {
            $subdistrictCode = sprintf("%02d", (int)$data_home['subdistrictCode']);
            $districtCode = sprintf("%02d", (int)$data_home['districtCode']);
            $provinceCode = sprintf("%02d", (int)$data_home['provinceCode']);
            $rcodeCode = (string)$provinceCode . (string)$districtCode . (string)$subdistrictCode . '00';
            $pull = OoapMasTambon::select([
                'province_id', 'amphur_id', 'tambon_id', 'postcode'
            ])
                ->where('tambon_code', '=', $rcodeCode)
                ->where('in_active', '=', false)->first();

            $province = OoapMasProvince::where('province_id', $pull->province_id)->first()->province_id ?? null;
            $district = OoapMasAmphur::where('amphur_id', $pull->amphur_id)->first()->amphur_id ?? null;
            $subdistrict = OoapMasTamBon::where('tambon_id', $pull->tambon_id)->first()->tambon_id ?? null;
            // $subdistricts_postcode = OoapMasTamBon::where('tambon_name', $data_home['subdistrictDesc'])->first()->subdistricts_postcode ?? null;

            if ($data['titleName'] == 'นาย') {
                $titleName = 1;
            } else if ($data['titleName'] == 'นาง') {
                $titleName = 2;
            } else {
                $titleName = 3;
            }
            $this->pop_sname = $titleName;
            $this->pop_firstname = $data['firstName'];
            $this->pop_lastname = $data['lastName'];
            $this->pop_gender = $data['genderCode'] == 2 ? 'หญิง' : 'ชาย';
            $this->pop_province = $province;
            $this->pop_district = $district;
            $this->pop_postcode = $pull->postcode;
            $this->pop_subdistrict = $subdistrict;
            $this->pop_addressno = $data_home['houseNo'] == 0 ? null : $data_home['houseNo'];
            $this->pop_moo = $data_home['villageNo'] == 0 ? null : $data_home['villageNo'];
            $this->pop_soi = $data_home['alleyDesc'] = null ? '' : $data_home['alleyDesc'];
            $d = substr($data['dateOfBirth'], 6, 2);
            $m = substr($data['dateOfBirth'], 4, 2);
            $y = substr($data['dateOfBirth'], 0, 4);
            $this->pop_birthday = $d . '/' . $m . '/' . $y;
        } else {
            $this->emit('popup', 2);
        }
    }

    public function render()
    {
        $this->emit('emits');
        if ($this->pop_sname == 1) {
            $this->pop_gender = "ชาย";
        } else if ($this->pop_sname == 2 || $this->pop_sname == 3) {
            $this->pop_gender = "หญิง";
        } else {
            $this->pop_gender = "ไม่ระบุ";
        }

        if (substr($this->pop_birthday, 2, 1) == '/') {
            if (getAge(DateToSqlExpSlash($this->pop_birthday)) > 60) {
                $this->elderly = 1;
            } else {
                $this->elderly = 2;
            }
        }
        $this->province_list = OoapMasProvince::where('in_active', false)->pluck('province_name', 'province_id');
        $this->amphur_list = OoapMasAmphur::where('province_id', '=', $this->pop_province)->where('in_active', false)->pluck('amphur_name', 'amphur_id');
        $this->subdistrict_list = OoapMasTambon::where('amphur_id', '=', $this->pop_district)->where('in_active', false)->pluck('tambon_name', 'tambon_id');
        if ($this->pop_subdistrict) {
            $this->pop_postcode = OoapMasTambon::where('tambon_id', '=', $this->pop_subdistrict)->first('postcode')->postcode ?? null;
        }

        return view('livewire.activity.operate.population.add-component');
    }
}
