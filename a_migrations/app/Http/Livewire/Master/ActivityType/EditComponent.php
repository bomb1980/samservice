<?php

namespace App\Http\Livewire\Master\ActivityType;

use App\Models\OoapMasActtype;
use Livewire\Component;

class EditComponent extends Component
{
    public $activity_types_id, $name;

    public function mount()
    {

        $activityType = OoapMasActtype::find($this->activity_types_id);
        $this->activity_types_id = $activityType->id;
        $this->name = $activityType->name;
    }

    public function render()
    {
        return view('livewire.master.activity-type.edit-component');
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|digits:3|unique:ooap_mas_acttype,name,' . $this->activity_types_id,
        ], [
            'name.required' => 'กรุณากรอก ชื่อประเภทกิจกรรม',
            'name.unique' => 'ชื่อประเภทกิจกรรม อยู่ในระบบแล้ว',
        ]);

        OoapMasActtype::where('id', '=', $this->activity_types_id)->update([
            'name' => $this->name,
            'remember_token' => csrf_token(),
            'update_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now()
        ]);

        return redirect()->route('master.activitytype.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}
