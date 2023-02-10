<?php

namespace App\Http\Livewire\Master\Coursetype;

use App\Models\OoapMasCoursegroup;
use App\Models\OoapMasCoursetype;
use App\Models\OoapMasCoursesubgroup;
use Livewire\Component;

class CoursetypeEditComponent extends Component
{
    public $coursegroup_list, $coursegroup_id, $dataCoursetype;
    public $coursesubgroup_list, $coursesubgroup_id;
    public $coursetype_id, $code, $name, $shortname, $status, $in_active, $remember_token, $create_by, $create_at;

    public function mount()
    {
        $this->coursetype_id = $this->dataCoursetype->id;
        $this->code = $this->dataCoursetype->code;
        $this->name = $this->dataCoursetype->name;
        $this->shortname = $this->dataCoursetype->shortname;
        $this->coursegroup_id = $this->dataCoursetype->coursegroup_id;
        $this->coursesubgroup_id = $this->dataCoursetype->coursesubgroup_id;

        $this->coursesubgroup_list = OoapMasCoursesubgroup::where('in_active', '=', false)->pluck('name', 'id');
        $this->coursegroup_list = OoapMasCoursegroup::where('in_active', '=', false)->pluck('name', 'id');
    }

    public function render()
    {

        return view('livewire.master.coursetype.coursetype-edit-component');
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
            'code' => 'required|digits:3|unique:ooap_mas_coursetype,code,' . $this->coursetype_id,
            'name' => 'required',
            'coursegroup_id' => 'required',
            'coursesubgroup_id' => 'required'
        ], [
            'code.required' => 'กรุณาใส่รหัสประเภทหลักสูตร',
            'code.digits' => 'กรุณากรอกรหัสประเภทหลักสูตรมีจำนวน 3 หลัก',
            'code.unique' => 'มีรหัสประเภทหลักสูตรนี้ อยู่ในระบบแล้ว',
            'name.required' => 'กรุณากรอกชื่อประเภทหลักสูตร',
            'coursegroup_id.required' => 'กรุณาเลือกกลุ่มหลักสูตร',
            'coursesubgroup_id.required' => 'กรุณาเลือกสาขาอาชีพ',
        ]);

        OoapMasCoursetype::where('id', '=', $this->coursetype_id)->update([

            'code' => $this->code,
            'name' => $this->name,
            'shortname' => $this->shortname,
            'coursegroup_id' => $this->coursegroup_id,
            'coursesubgroup_id' => $this->coursesubgroup_id,
            'remember_token' => csrf_token(),
            'updated_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now()
        ]);

        return redirect()->route('master.coursetype.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

}
