<?php

namespace App\Http\Livewire\Master\poptype;

use App\Models\OoapMaspoptype;
use Livewire\Component;

class poptypeAddComponent extends Component
{
  public $name, $shotname, $status, $in_active, $remember_token, $create_by, $create_at;

  public function submit()
  {
    $this->validate([
        'name' => 'required|unique:ooap_mas_poptype',
    ], [
      'name.required' => 'กรุณากรอกชื่อประเภทความเดือดร้อน',
      'name.unique' => 'มีประเภทความเดือดร้อนนี้แล้ว',
    ]);
    OoapMaspoptype::create([
      'name' => $this->name,
      'shotname' => $this->shotname,
      'remember_token' => csrf_token(),
      'created_by' => auth()->user()->emp_citizen_id
    ]);
    $this->emit('popup');
  }

  protected $listeners = ['redirect-to' => 'redirect_to'];

  public function redirect_to()
  {
    return redirect()->route('master.poptype.index');
  }

  public function thisReset()
  {
    return redirect()->route('master.poptype.index');
  }

  public function render()
  {
    return view('livewire.master.poptype.poptype-add-component');
  }
}
