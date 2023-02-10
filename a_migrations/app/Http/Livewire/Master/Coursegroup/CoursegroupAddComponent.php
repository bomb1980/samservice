<?php

namespace App\Http\Livewire\Master\Coursegroup;

use App\Models\OoapMasCoursegroup;
use App\Models\OoapMasActtype;
use Livewire\Component;

class CoursegroupAddComponent extends Component
{
    public $acttype_list, $acttype_id;
    public $code, $name, $shortname, $status, $in_active, $remember_token, $create_by, $create_at;

    public function mount()
    {

        $this->acttype_list = OoapMasActtype::where('inactive', '=', 0)->pluck('name', 'id');
    }

    public function render()
    {

        return view('livewire.master.coursegroup.coursegroup-add-component');
    }

    public function changeActtype($acttype_id)
    {
        if (!empty($acttype_id)) {
            $this->acttype_id = $acttype_id;
        }
    }

    public function submit()
    {

        $this->validate([
            'code' => 'required|digits:2|unique:ooap_mas_coursegroup,code',
            'name' => 'required|max:1000|unique:ooap_mas_coursegroup,name',
            'shortname' => 'required|max:200',
            'acttype_id' => 'required'
        ], [
            'code.required' => 'กรุณากรอกรหัสกลุ่มหลักสูตร',
            'code.digits' => 'กรุณากรอกรหัสกลุ่มหลักสูตรมีจำนวน 2 หลัก',
            'code.unique' => 'ชื่อรหัสกลุ่มหลักสูตร มีอยู่ในระบบแล้ว',
            'name.required' => 'กรุณากรอกชื่อกลุ่มหลักสูตร',
            'name.max' => 'ข้อมูลมีจำนวนตัวอักษรเกินกำหนด',
            'name.unique' => 'ชื่อกลุ่มหลักสูตร มีอยู่ในระบบแล้ว',
            'name.max' => 'ข้อมูลมีจำนวนตัวอักษรเกินกำหนด',
            'shortname.required' => 'กรุณากรอกชื่อย่อ',
            'acttype_id.required' => 'กรุณาเลือกประเภทกิจกรรม',
        ]);

        OoapMasCoursegroup::create([
            'code' => $this->code,
            'name' => $this->name,
            'shortname' => $this->shortname,
            'acttype_id' => $this->acttype_id,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id
        ]);

        return redirect()->route('master.coursegroup.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

}
