<?php

namespace App\Http\Livewire\Master\Lecturer;

use App\Models\OoapMasLecturer;
use App\Models\OoapMasLecturerType;
use App\Models\OoapMasProvince;
use Livewire\Component;

class LecturerEditComponent extends Component
{
    public $dataCenterMaster;
    public $province_id, $province_sel;
    public $lecturer_types_id, $lecturer_types_sel;
    public $lecturer_fname, $lecturer_lname, $lecturer_phone, $lecturer_address, $lecturer_nationalid, $check_thai_id = true;

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function mount($dataCenterMaster)
    {
        $this->lecturer_id = $dataCenterMaster->lecturer_id;
        $this->lecturer_fname = $dataCenterMaster->lecturer_fname;
        $this->lecturer_lname = $dataCenterMaster->lecturer_lname;
        $this->lecturer_phone = $dataCenterMaster->lecturer_phone;
        $this->lecturer_address = $dataCenterMaster->lecturer_address;
        $this->lecturer_nationalid = $dataCenterMaster->lecturer_nationalid;
        $this->province_id = $dataCenterMaster->province_id;
        $this->lecturer_types_id = $dataCenterMaster->lecturer_types_id;
        $this->lecturer_types_sel = OoapMasLecturerType::where('in_active', '=', false)
            ->pluck('lecturer_types_name', 'lecturer_types_id');

        $this->province_sel = OoapMasProvince::where('in_active', '=', false)
            ->pluck('province_name', 'province_id');
    }

    public function render()
    {
        $this->emit('emits');
        return view('livewire.master.lecturer.lecturer-edit-component');
    }

    public function submit()
    {

        $this->validate([
            'province_id' => 'required',
            'lecturer_types_id' => 'required',
            'lecturer_nationalid' => 'required',
            'lecturer_fname' => 'required',
        ], [
            'province_id.required' => 'กรุณาเลือก จังหวัด',
            'lecturer_types_id.required' => 'กรุณาเลือก ประเภท',
            'lecturer_fname.required' => 'กรุณากรอก ชื่อ',
            'lecturer_nationalid.required' => 'กรุณากรอก บัตรประจำตัวประชาชน',
        ]);

        OoapMasLecturer::where('lecturer_id', '=', $this->lecturer_id)->update([
            'lecturer_nationalid' => str_replace('-', '', $this->lecturer_nationalid),
            'lecturer_fname' => $this->lecturer_fname,
            'lecturer_lname' => $this->lecturer_lname,
            'lecturer_phone' => str_replace('-', '', $this->lecturer_phone),
            'lecturer_address' => $this->lecturer_address,
            'province_id' => $this->province_id,
            'lecturer_types_id' => $this->lecturer_types_id,
            'updated_by' => auth()->user()->emp_citizen_id
        ]);

        return redirect()->route('master.lecturer.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        $this->emit('popup');
    }

    public function redirect_to()
    {

        return redirect()->route('master.lecturer.index');
    }
}
