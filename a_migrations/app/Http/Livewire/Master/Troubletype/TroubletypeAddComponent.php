<?php

namespace App\Http\Livewire\Master\Troubletype;

use App\Models\OoapMasTroubletype;
use Livewire\Component;

class TroubletypeAddComponent extends Component
{
    public $name, $shotname, $status, $in_active, $remember_token, $create_by, $create_at;

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.master.troubletype.troubletype-add-component');
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|unique:ooap_mas_troubletype',
        ], [
            'name.required' => 'กรุณากรอกชื่อประเภทความเดือดร้อน',
            'name.unique' => 'มีประเภทความเดือดร้อนนี้แล้ว',
        ]);
        OoapMasTroubletype::create([
            'name' => $this->name,
            'shotname' => $this->shotname,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id
        ]);

        return redirect()->route('master.troubletype.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

}
