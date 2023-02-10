<?php

namespace App\Http\Livewire\Master\Coursesubgroup;

use App\Models\OoapMasCoursesubgroup;
use App\Models\OoapMasCoursegroup;
use App\Models\OoapMasActtype;
use Livewire\Component;

class CoursesubgroupAddComponent extends Component
{
  public $acttype_list, $acttype_id;
  public $coursegroup_list, $coursegroup_id;
  public $code, $name, $shortname, $status, $in_active, $remember_token, $create_by, $create_at;

  public function mount()
  {
    $this->acttype_list = OoapMasActtype::where('inactive', '=', 0)->pluck('name', 'id');
    $this->coursegroup_list = OoapMasCoursegroup::where('in_active', '=', false)->pluck('name', 'id');
  }

  public function render()
  {

    return view('livewire.master.coursesubgroup.coursesubgroup-add-component');
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
      'code' => 'required|digits:2|unique:ooap_mas_coursesubgroup,code',
      'name' => 'required|unique:ooap_mas_coursesubgroup,name',
      'shortname' => 'required',
      'acttype_id' => 'required',
      'coursegroup_id' => 'required'
    ], [
      'code.required' => 'กรุณาใส่รหัสกลุ่มสาขาอาชีพ',
      'code.digits' => 'กรุณากรอกรหัสกลุ่มสาขาอาชีพมีจำนวน 2 หลัก',
      'code.unique' => 'รหัสกลุ่มสาขาอาชีพ มีอยู่ในระบบแล้ว',
      'name.required' => 'กรุณากรอกชื่อกลุ่มสาขาอาชีพ',
      'name.unique' => 'ชื่อกลุ่มสาขาอาชีพ มีอยู่ในระบบแล้ว',
      'shortname.required' => 'กรุณากรอกชื่อย่อ',
      'acttype_id.required' => 'กรุณาเลือกประเภทกิจกรรม',
      'coursegroup_id.required' => 'กรุณาเลือกกลุ่มหลักสูตร',
    ]);

    OoapMasCoursesubgroup::create([
      'code' => $this->code,
      'name' => $this->name,
      'shortname' => $this->shortname,
      'acttype_id' => $this->acttype_id,
      'coursegroup_id' => $this->coursegroup_id,
      'remember_token' => csrf_token(),
      'created_by' => auth()->user()->emp_citizen_id
    ]);

    return redirect()->route('master.coursesubgroup.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
  }

}
