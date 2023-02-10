<?php

namespace App\Http\Livewire\Master\Ownertype;

use App\Models\OoapMasCourseOwnertype;
use Livewire\Component;

class OwnertypeAddComponent extends Component
{
  public $name, $shortname, $status, $in_active, $remember_token, $create_by, $create_at;

  public function render()
  {
    return view('livewire.master.ownertype.ownertype-add-component');
  }

  public function submit()
  {
    $this->validate([
      'name' => 'required|unique:ooap_mas_course_ownertype',
      'shortname' => 'required'
    ], [
      'name.required' => 'กรุณากรอกชื่อแหล่งที่มาของหลักสูตร',
      'name.unique' => 'มีชื่อแหล่งที่มาของหลักสูตรนี้แล้ว',
      'shortname.required' => 'กรุณากรอกชื่อย่อ',
    ]);
    OoapMasCourseOwnertype::create([
      'name' => $this->name,
      'shortname' => $this->shortname,
      'remember_token' => csrf_token(),
      'created_by' => auth()->user()->emp_citizen_id
    ]);

    return redirect()->route('master.ownertype.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');

  }


}
