<?php

namespace App\Http\Livewire\Master\Fiscalyear;

use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFiscalyearReqPeriod;
use Illuminate\Http\Request;

use Livewire\Component;

class FiscalyearEditComponent extends Component
{

    public $fiscalyear_id, $resultFiscal;
    public $dataCenterMaster, $fiscalyear_code, $startdate, $enddate, $req_status, $req_startdate, $req_enddate, $fiscalyear_code_old;

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function mount()
    {
        $resultFiscal = OoapTblFiscalyear::where('id', $this->fiscalyear_id)->first();
        $this->fiscalyear_code = $resultFiscal->fiscalyear_code ?? null;
        $this->req_startdate = datetoview($resultFiscal->req_startdate) ?? null;
        $this->req_enddate = datetoview($resultFiscal->req_enddate) ?? null;
    }

    public function render()
    {

        return view('livewire.master.fiscalyear.fiscalyear-edit-component');
    }

    public function submit()
    {
        $this->validate([
            'fiscalyear_code' => 'required|numeric|min:4|unique:ooap_tbl_fiscalyear,fiscalyear_code,' . $this->fiscalyear_id,
        ], [
            'fiscalyear_code.required' => 'กรุณากรอกปีงบประมาณ',
            'fiscalyear_code.numeric' => 'กรุณากรอกตัวเลขเท่านั้น',
            'fiscalyear_code.min' => 'กรุณากรอกปีพ.ศ.ให้ครบ 4 ตัวอักษร',
            'fiscalyear_code.unique' => 'ปีงบประมาณ อยู่ในระบบแล้ว',
        ]);

        OoapTblFiscalyear::where('id', '=', $this->fiscalyear_id)->update([
            'fiscalyear_code' => $this->fiscalyear_code,
            'req_startdate' => datePickerThaiToDB($this->req_startdate),
            'req_enddate' => datePickerThaiToDB($this->req_enddate),
            'remember_token' => csrf_token(),
            'updated_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now()
        ]);

        return redirect()->route('master.fiscalyear.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}
