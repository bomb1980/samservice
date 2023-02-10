<?php

namespace App\Http\Livewire\Master\Troubletype;

use App\Models\OoapMasTroubletype;
use Livewire\Component;

class TroubletypeEditComponent extends Component
{
  public $troubletype_id, $name, $shortname, $status, $in_active, $remember_token, $create_by, $create_at;

  public function mount($dataTroubletype)
  {
    $this->troubletype_id = $dataTroubletype->id;
    $this->name = $dataTroubletype->name;
    $this->shotname = $dataTroubletype->shotname;
  }

  public function render()
  {
    return view('livewire.master.troubletype.troubletype-edit-component');
  }

  public function submit()
  {

    $this->validate([
      'name' => 'required',
    ], [
      'name.required' => 'กรุณากรอกชื่อประเภทความเดือดร้อน',
    ]);

    OoapMasTroubletype::where('id', '=', $this->troubletype_id)->update([
        'name' => $this->name,
        'shotname' => $this->shotname,
        'remember_token' => csrf_token(),
        'updated_by' => auth()->user()->emp_citizen_id,
        'updated_at' => now()
    ]);

    return redirect()->route('master.troubletype.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
  }

}
