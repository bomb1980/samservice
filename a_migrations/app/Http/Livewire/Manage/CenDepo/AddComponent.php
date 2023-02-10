<?php

namespace App\Http\Livewire\Manage\CenDepo;

use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFybdpayment;
use Livewire\Component;

class AddComponent extends Component
{
    public $fiscalyear_list, $fiscalyear_code, $pay_name, $pay_date, $pay_desp, $pay_amt;

    public function mount()
    {
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code AS fiscalyear_code2');
    }

    public function submit()
    {
        $this->validate([
            'fiscalyear_code' => 'required',
            'pay_name' => 'required',
            'pay_date' => 'required',
            'pay_amt' => 'required',
        ], [
            'fiscalyear_code.required' => 'กรุณากรอก ปีงบประมาณ',
            'pay_name.required' => 'กรุณากรอก รายการ',
            'pay_date.required' => 'กรุณากรอก วันที่เบิก',
            'pay_amt.required' => 'กรุณากรอก จำนวนเงิน',
        ]);

        OoapTblFybdpayment::create([
            'fiscalyear_code' => $this->fiscalyear_code,
            'pay_name' => $this->pay_name,
            'pay_date' => datePickerThaiToDB($this->pay_date),
            'pay_desp' => $this->pay_desp,
            'pay_amt' => $this->pay_amt,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now(),
        ]);

        $this->emit('popup');
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('manage.center');
    }

    public function render()
    {
        return view('livewire.manage.cen-depo.add-component');
    }
}
