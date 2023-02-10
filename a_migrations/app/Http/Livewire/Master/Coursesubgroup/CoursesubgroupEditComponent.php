<?php

namespace App\Http\Livewire\Master\Coursesubgroup;

use App\Models\OoapMasCoursesubgroup;
use App\Models\OoapMasCoursegroup;
use App\Models\OoapMasActtype;
use Livewire\Component;

class CoursesubgroupEditComponent extends Component
{
    public $acttype_list, $acttype_id, $dataCoursesubgroup;
    public $coursegroup_list, $coursegroup_id;
    public $coursesubgroup_id, $code, $name, $shortname, $status, $in_active, $remember_token, $create_by, $create_at;

    public function mount()
    {
        $this->acttype_list = OoapMasActtype::where('inactive', '=', 0)->pluck('name', 'id');
        $this->coursegroup_list = OoapMasCoursegroup::where('in_active', '=', false)->pluck('name', 'id');

        $this->coursesubgroup_id = $this->dataCoursesubgroup->id;
        $this->code = $this->dataCoursesubgroup->code;
        $this->name = $this->dataCoursesubgroup->name;
        $this->shortname = $this->dataCoursesubgroup->shortname;
        $this->acttype_id = $this->dataCoursesubgroup->acttype_id;
        $this->coursegroup_id = $this->dataCoursesubgroup->coursegroup_id;
    }

    public function render()
    {

        return view('livewire.master.coursesubgroup.coursesubgroup-edit-component');
    }

    public function changeActtype($acttype_id)
    {
        if (!empty($acttype_id)) {
            $this->acttype_id = $acttype_id;
        }
    }

    public function changeCoursegroup($coursegroup_id)
    {
        if (!empty($coursegroup_id)) {
            $this->coursegroup_id = $coursegroup_id;
        }
    }

    public function submit()
    {

        $this->validate([
            'code' => 'required|digits:2|unique:ooap_mas_coursesubgroup,code,' . $this->coursesubgroup_id,
            'name' => 'required|unique:ooap_mas_coursesubgroup,name,' . $this->coursesubgroup_id,
            'shortname' => 'required',
            'acttype_id' => 'required',
            'coursegroup_id' => 'required'
          ], [
            'code.required' => 'กรุณาใส่รหัสกลุ่มสาขาอาชีพ',
            'code.digits' => 'กรุณากรอกรหัสกลุ่่มสาขาอาชีพมีจำนวน 2 หลัก',
            'code.unique' => 'รหัสกลุ่มสาขาอาชีพ อยู่ในระบบแล้ว',
            'name.required' => 'กรุณากรอกชื่อกลุ่มสาขาอาชีพ',
            'name.unique' => 'ชื่อกลุ่มสาขาอาชีพ อยู่ในระบบแล้ว',
            'shortname.required' => 'กรุณากรอกชื่อย่อ',
            'acttype_id.required' => 'กรุณาเลือกประเภทกิจกรรม',
            'coursegroup_id.required' => 'กรุณาเลือกกลุ่มหลักสูตร',
          ]);

        OoapMasCoursesubgroup::where('id', '=', $this->coursesubgroup_id)->update([
            'code' => $this->code,
            'name' => $this->name,
            'shortname' => $this->shortname,
            'acttype_id' => $this->acttype_id,
            'coursegroup_id' => $this->coursegroup_id,
            'remember_token' => csrf_token(),
            'updated_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now()
        ]);

        return redirect()->route('master.coursesubgroup.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}
