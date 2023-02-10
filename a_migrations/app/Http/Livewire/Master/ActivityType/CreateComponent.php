<?php

namespace App\Http\Livewire\Master\ActivityType;

use App\Models\OoapMasActtype;
use Livewire\Component;

class CreateComponent extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.master.activity-type.create-component');
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|unique:ooap_mas_acttype,name',
        ], [
            'name.required' => 'กรุณากรอก ชื่อประเภทกิจกรรม',
            'name.unique' => 'ชื่อประเภทกิจกรรม อยู่ในระบบแล้ว',
        ]);

        OoapMasActtype::create([
            'name' => $this->name,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now(),
        ]);

        return redirect()->route('master.activitytype.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}
