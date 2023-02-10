<?php

namespace App\Http\Livewire\Master\Buildingtype;

use App\Models\OoapMasBuildingtype;
use App\Models\OoapMasActtype;
use Livewire\Component;

class BuildingtypeAddComponent extends Component
{
  public $name, $shortname, $status, $in_active, $remember_token, $create_by, $create_at;
  public $acttype_list, $acttype_id;

  public function mount()
  {

    $this->acttype_list = OoapMasActtype::where('inactive', '=', 0)->pluck('name', 'id');
  }

  public function render()
  {

    return view('livewire.master.buildingtype.buildingtype-add-component');
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
      'name' => 'required',
      'shortname' => 'required',
      'acttype_id' => 'required'
    ], [
      'name.required' => 'กรุณากรอกชื่อประเภทสถานที่',
      'shortname.required' => 'กรุณากรอกชื่อย่อ',
      'acttype_id.required' => 'กรุณาเลือกประเภทกิจกรรม'
    ]);

    OoapMasBuildingtype::create([
      'name' => $this->name,
      'shortname' => $this->shortname,
      'acttype_id' => $this->acttype_id,
      'remember_token' => csrf_token(),
      'created_by' => auth()->user()->emp_citizen_id
    ]);

    return redirect()->route('master.buildingtype.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
  }

}
