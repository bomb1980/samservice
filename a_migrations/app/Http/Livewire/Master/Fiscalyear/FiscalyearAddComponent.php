<?php

namespace App\Http\Livewire\Master\Fiscalyear;

use App\Models\OoapTblFiscalyear;
use Livewire\Component;

class FiscalyearAddComponent extends Component
{
  public $fiscalyear_code, $startdate, $enddate, $req_status = 0, $req_startdate, $req_enddate, $status, $in_active, $remember_token, $create_by, $create_at;


  public function render()
  {
    return view('livewire.master.fiscalyear.fiscalyear-add-component');
  }

  public function submit()
  {
    $this->validate([
      'fiscalyear_code' => 'required|numeric|min:4|unique:ooap_tbl_fiscalyear,fiscalyear_code'
    ], [
      'fiscalyear_code.required' => 'กรุณากรอกปีงบประมาณ',
      'fiscalyear_code.numeric' => 'กรุณากรอกตัวเลขเท่านั้น',
      'fiscalyear_code.min' => 'กรุณากรอกปีพ.ศ.ให้ครบ 4 ตัวอักษร',
      'fiscalyear_code.unique' => 'ปีงบประมาณ อยู่ในระบบแล้ว',
    ]);

    OoapTblFiscalyear::create([
      'fiscalyear_code' => $this->fiscalyear_code,
      'req_status' => 1,
      'req_startdate' => datePickerThaiToDB($this->req_startdate),
      'req_enddate' => datePickerThaiToDB($this->req_enddate),
      'remember_token' => csrf_token(),
      'created_by' => auth()->user()->emp_citizen_id
    ]);

    return redirect()->route('master.fiscalyear.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
  }

}
