<?php

namespace App\Http\Livewire\Master\Buildingtype;

use App\Models\OoapMasBuildingtype;
use App\Models\OoapMasActtype;
use Livewire\Component;

class BuildingtypeEditComponent extends Component
{
    public $buildingtype_id, $name, $shortname, $status, $in_active, $remember_token, $create_by, $create_at;
    public $acttype_list, $acttype_id;

    public function mount($dataBuildingtype)
    {
        $this->acttype_list = OoapMasActtype::where('inactive', '=', 0)->pluck('name', 'id');
        $this->buildingtype_id = $dataBuildingtype->buildingtype_id;
        $this->name = $dataBuildingtype->name;
        $this->shortname = $dataBuildingtype->shortname;
        $this->acttype_id = $dataBuildingtype->acttype_id;
    }

    public function render()
    {

        return view('livewire.master.buildingtype.buildingtype-edit-component');
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
            'acttype_id' => 'required',
        ], [
            'name.required' => 'กรุณากรอกชื่อสถานที่ดำเนินการ',
            'shortname.required' => 'กรุณากรอกชื่อย่อ',
            'acttype_id.required' => 'กรุณาเลือกประเภทกิจกรรม',
        ]);

        $checkResult = OoapMasBuildingtype::where('buildingtype_id', '=', $this->buildingtype_id)->first();

        if ($checkResult) {
            OoapMasBuildingtype::where('buildingtype_id', '=', $this->buildingtype_id)->update([
                'acttype_id' => $this->acttype_id,
                'name' => $this->name,
                'shortname' => $this->shortname,
                'updated_by' => auth()->user()->emp_citizen_id
            ]);
        }

        return redirect()->route('master.buildingtype.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}
