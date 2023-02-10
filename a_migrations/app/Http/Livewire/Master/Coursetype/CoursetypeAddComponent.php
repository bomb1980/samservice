<?php

namespace App\Http\Livewire\Master\Coursetype;

use App\Models\OoapMasCoursegroup;
use App\Models\OoapMasCoursesubgroup;
use App\Models\OoapMasCoursetype;
use Livewire\Component;

class CoursetypeAddComponent extends Component
{
    public $coursegroup_list, $coursegroup_id;
    public $coursesubgroup_list, $coursesubgroup_id;
    public $code, $name, $shortname, $status, $in_active, $remember_token, $create_by, $create_at;

    public function mount()
    {

        $this->coursegroup_list = OoapMasCoursegroup::where('in_active', '=', false)->pluck('name', 'id');
        $this->coursesubgroup_list = OoapMasCoursesubgroup::where([['in_active', '=', false], ['coursegroup_id', '=', $this->coursegroup_id]])->pluck('name', 'id');
    }

    public function render()
    {

        return view('livewire.master.coursetype.coursetype-add-component');
    }

    public function changeCoursegroup($coursegroup_id)
    {

        if (!empty($coursegroup_id)) {
            $this->coursegroup_id = $coursegroup_id;
            $this->coursesubgroup_list = OoapMasCoursesubgroup::where([['in_active', '=', false], ['coursegroup_id', '=', $this->coursegroup_id]])->pluck('name', 'id');
        }
    }

    public function changeCourseSubgroup($coursesubgroup_id)
    {
        if (!empty($coursesubgroup_id)) {
            $this->coursesubgroup_id = $coursesubgroup_id;
        }
    }

    public function submit()
    {
        $this->validate([
            'code' => 'required|digits:3|unique:ooap_mas_coursetype,code',
            'name' => 'required|max:1000',
            'coursegroup_id' => 'required',
            'coursesubgroup_id' => 'required'
        ], [

            'code.required' => 'กรุณาใส่รหัสประเภทหลักสูตร',
            'code.digits' => 'กรุณากรอกรหัสประเภทหลักสูตรจำนวน 3 หลัก',
            'code.unique' => 'มีรหัสประเภทหลักสูตรนี้ อยู่ในระบบแล้ว',
            'name.required' => 'กรุณากรอกชื่อประเภทหลักสูตร',
            'name.max' => 'ข้อมูลมีจำนวนตัวอักษรเกินกำหนด',
            'coursegroup_id.required' => 'กรุณาเลือกกลุ่มหลักสูตร',
            'coursesubgroup_id.required' => 'กรุณาเลือกสาขาอาชีพ',
        ]);

        OoapMasCoursetype::create([
            'code' => $this->code,
            'name' => $this->name,
            'shortname' => $this->shortname,
            'coursegroup_id' => $this->coursegroup_id,
            'coursesubgroup_id' => $this->coursesubgroup_id,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id
        ]);

        return redirect()->route('master.coursetype.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

}
