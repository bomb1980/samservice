<?php

namespace App\Http\Livewire\Activity\Operate\Population;

use App\Models\OoapMasAmphur;
use App\Models\OoapMasOcuupation;
use App\Models\OoapMasProvince;
use App\Models\OoapMasTambon;
use App\Models\OoapTblActivities;
use App\Models\OoapTblPopulation;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class EditComponent extends Component
{
    public $pop_role, $pop_nationalid, $check_thai_id = true, $pop_welfarecard, $pop_sname, $pop_firstname, $pop_lastname, $pop_gender, $pop_age;
    public $pop_addressno, $pop_moo, $pop_soi, $pop_province, $pop_district, $pop_subdistrict, $pop_postcode, $pop_mobileno, $pop_ocuupation, $pop_education;
    public $pop_income, $act_id, $pop_id, $pop_birthday, $role, $type_role, $defective, $labor, $elderly;
    public $role_list = [], $pop_sname_list = [], $money_list = [];

    public $act_acttype; //Nakbin add

    public function mount($act_id, $pop_id)
    {
        $this->act_id = $act_id;
        $this->pop_id = $pop_id;
        $this->role_list_1 = [0 => 'วิทยากรวิถีชุมชน', 1 => 'วิทยากรคุณวุฒิเฉพาะด้าน'];
        $this->pop_sname_list = [1 => 'นาย', 2 => 'นาง', 3 => 'นางสาว'];
        $this->education_list = [0 => 'ประถมศึกษาตอนต้น', 1 => 'ประถมศึกษาตอนปลาย', 2 => 'มัธยมศึกษาตอนต้น', 3 => 'มัธยมศึกษตอนปลาย', 4 => 'ประกาศนียบัตรวิชาชีพ (ปวช.)', 5 => 'ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส.)', 6 => 'ปริญญาตรี', 7 => 'ปริญญาโท', 8 => 'ปริญญาเอก'];
        $this->ocuupation_list = OoapMasOcuupation::where('in_active', false)->pluck('name', 'id');
        $this->money_list = [0 => 'น้อยกว่า 10000', 1 => '10000 - 15000', 2 => '15001 - 25000', 3 => '25001 - 35000', 4 => 'มากกว่า 35000'];

        $this->province_list = OoapMasProvince::where('in_active', false)->pluck('province_name', 'province_id');
        $act_list = OoapTblActivities::where('act_id', '=', $act_id)->where('in_active', false)->first();
        $this->pop_periodno = $act_list->act_periodno;
        $this->pop_div = $act_list->act_div;
        $this->pop_periodno = $act_list->act_periodno;
        $this->act_acttype = $act_list->act_acttype; //Nakbin add

        $OoapTblPopulation = OoapTblPopulation::where('pop_id', '=', $pop_id)->first();
        $this->pop_role = $OoapTblPopulation->pop_role;
        $this->pop_nationalid = $OoapTblPopulation->pop_nationalid;
        $this->pop_welfarecard = $OoapTblPopulation->pop_welfarecard;
        $this->pop_sname = $OoapTblPopulation->pop_title;
        $this->pop_firstname = $OoapTblPopulation->pop_firstname;
        $this->pop_lastname = $OoapTblPopulation->pop_lastname;
        $this->pop_age = $OoapTblPopulation->pop_age;
        $this->pop_addressno = $OoapTblPopulation->pop_addressno;
        $this->pop_moo = $OoapTblPopulation->pop_moo;
        $this->pop_soi = $OoapTblPopulation->pop_soi;
        $this->pop_province = $OoapTblPopulation->pop_province;
        $this->pop_district = $OoapTblPopulation->pop_district;
        $this->pop_subdistrict = $OoapTblPopulation->pop_subdistrict;
        $this->pop_postcode = $OoapTblPopulation->pop_postcode;
        $this->pop_mobileno = $OoapTblPopulation->pop_mobileno;
        $this->pop_education = $OoapTblPopulation->pop_education;
        $this->pop_ocuupation = $OoapTblPopulation->pop_ocuupation;
        $this->pop_income = $OoapTblPopulation->pop_income;
        $this->pop_gender = $OoapTblPopulation->pop_gender;
        $this->defective = $OoapTblPopulation->pop_defective;
        $this->labor = $OoapTblPopulation->pop_labor;
        $this->elderly = $OoapTblPopulation->pop_elderly;
        $this->type_role = $OoapTblPopulation->pop_typelecturer;
        $this->pop_birthday = datetoview($OoapTblPopulation->pop_birthday);
    }

    public function submit()
    {
        if ($this->pop_role == 1) {
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
            ]);
        } else {
            $this->validate([
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
            ], [
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
            ]);
        }

        OoapTblPopulation::where('pop_id', '=', $this->pop_id)->update([
            'pop_role' => $this->pop_role,
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
            'pop_typelecturer' => $this->type_role,
            'remember_token' => csrf_token(),
            'updated_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now(),

        ]);
        $this->emit('popup');
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        Redirect::back();
        // if ($this->act_acttype == 1) //Nakbin add
        // {
        //     return redirect()->route('activity.ready_confirm.hire.edit', ['id' => $this->act_id]);
        // } else {
        //     return redirect()->route('activity.ready_confirm.train.edit', ['id' => $this->act_id]);
        // }
    }

    public function callBack()
    {
        Redirect::back();
        // if ($this->act_acttype == 1) //Nakbin add
        // {
        //     return redirect()->route('activity.ready_confirm.hire.edit', ['id' => $this->act_id]);
        // } else {
        //     return redirect()->route('activity.ready_confirm.train.edit', ['id' => $this->act_id]);
        // }
    }

    public function render()
    {
        $this->emit('emits');
        if (getAge(DateToSqlExpSlash($this->pop_birthday)) > 60) {
            $this->elderly = 1;
        } else {
            $this->elderly = 2;
        }
        $this->amphur_list = OoapMasAmphur::where('province_id', '=', $this->pop_province)->where('in_active', false)->pluck('amphur_name', 'amphur_id');
        $this->subdistrict_list = OoapMasTambon::where('amphur_id', '=', $this->pop_district)->where('in_active', false)->pluck('tambon_name', 'tambon_id');
        if ($this->pop_subdistrict) {
            $this->pop_postcode = OoapMasTambon::where('tambon_id', '=', $this->pop_subdistrict)->first('postcode')->postcode ?? null;
        }
        return view('livewire.activity.operate.population.edit-component');
    }
}
