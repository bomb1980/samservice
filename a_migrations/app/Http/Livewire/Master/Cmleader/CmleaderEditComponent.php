<?php

namespace App\Http\Livewire\Master\Cmleader;

use App\Models\OoapMasCmleader;
use App\Models\OoapMasProvince;
use App\Models\OoapMasAmphur;
use App\Models\OoapMasTambon;
use Livewire\Component;

class CmleaderEditComponent extends Component
{
    public $province_id, $province_select;
    public $amphur_id, $amphur_select;
    public $tambon_id, $tambon_select;

    public $cmleader_id;
    public $cmleader_prefix, $cmleader_name, $cmleader_surname, $cmleaderjob_id, $moo, $cmleader_birthdate, $cmleader_tel, $cmleader_fax, $cmleader_mobile, $cmleader_email, $status, $in_active, $remember_token, $create_by, $create_at;

    public function mount($dataCmleader)
    {
        $this->province_id = OoapMasProvince::where('in_active', '=', 0)->orderby('province_name', 'asc')->first()->province_id;
        $this->province_select = OoapMasProvince::where('in_active', '=', 0)->pluck('province_name', 'province_id');

        $this->amphur_id = OoapMasAmphur::where('in_active', '=', 0)->orderby('amphur_name', 'asc')->first()->amphur_id;
        $this->amphur_select = OoapMasAmphur::where('in_active', '=', 0)->pluck('amphur_name', 'amphur_id');

        $this->courtambon_idsegroup_id = OoapMasTambon::where('in_active', '=', 0)->orderby('tambon_name', 'asc')->first()->tambon_id;
        $this->tambon_select = OoapMasTambon::where('in_active', '=', 0)->pluck('tambon_name', 'tambon_id');


        $this->cmleader_id = $dataCmleader->id;
        $this->cmleader_prefix = $dataCmleader->cmleader_prefix;
        $this->cmleader_name = $dataCmleader->cmleader_name;
        $this->cmleader_surname = $dataCmleader->cmleader_surname;
        $this->cmleader_birthdate = datetoview($dataCmleader->cmleader_birthdate);
        $this->moo = $dataCmleader->moo;

        $this->province_id = $dataCmleader->province_id;
        $this->amphur_id = $dataCmleader->amphur_id;
        $this->tambon_id = $dataCmleader->tambon_id;
        $this->people_descp = $dataCmleader->people_descp;
        $this->trainer_descp = $dataCmleader->trainer_descp;
        $this->cmleader_tel = $dataCmleader->cmleader_tel;
        $this->cmleader_fax = $dataCmleader->cmleader_fax;
        $this->cmleader_mobile = $dataCmleader->cmleader_mobile;
        $this->cmleader_email = $dataCmleader->cmleader_email;
    }

    public function submit()
    {
        $this->validate([
            'cmleader_prefix' => 'required',
            'cmleader_name' => 'required',
            'province_id' => 'required',
            'amphur_id' => 'required',
            'tambon_id' => 'required',
        ], [
            'cmleader_prefix.required' => 'กรุณากรอกคำนำหน้า',
            'cmleader_name.required' => 'กรุณากรอกชื่อ',
            'province_id.required' => 'กรุณาเลือกจังหวัด',
            'amphur_id.required' => 'กรุณาเลือกอำเภอ',
            'tambon_id.required' => 'กรุณาเลือกตำบล',
        ]);
        $checkResult = OoapMasCmleader::where('id', '=', $this->cmleader_id)->first();
        if ($checkResult) {
            OoapMasCmleader::where('id', '=', $this->cmleader_id)->update([
                'cmleader_prefix' => $this->cmleader_prefix,
                'cmleader_name' => $this->cmleader_name,
                'cmleader_surname' => $this->cmleader_surname,
                'cmleaderjob_id' => 1,
                'moo' => $this->moo,
                'province_id' => $this->province_id,
                'amphur_id' => $this->amphur_id,
                'tambon_id' => $this->tambon_id,
                'cmleader_birthdate' => datePickerThaiToDB($this->cmleader_birthdate),
                'cmleader_tel' => $this->cmleader_tel,
                'cmleader_fax' => $this->cmleader_fax,
                'cmleader_mobile' => $this->cmleader_mobile,
                'cmleader_email' => $this->cmleader_email,
                'updated_by' => auth()->user()->emp_citizen_id
            ]);
        }

        return redirect()->route('master.cmleader.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        // $this->emit('popup');
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('master.cmleader.index');
    }

    public function thisReset()
    {
        return redirect()->route('master.cmleader.index');
    }

    // public function changeDept($value)
    // {
    //     $this->dept_id = $value;
    // }

    public function changeProvince($value)
    {
        $this->province_id = $value;
    }

    public function changeAmphur($value)
    {
        $this->amphur_id = $value;
    }

    public function changeTambon($value)
    {
        $this->tambon_id = $value;
    }

    public function render()
    {
        return view('livewire.master.cmleader.cmleader-edit-component');
    }
}
