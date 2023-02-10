<?php

namespace App\Http\Livewire\Manage\CenDepo;

use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFybdpayment;
use Livewire\Component;

class EditComponent extends Component
{
  public $den_id, $fiscalyear_list, $fiscalyear_code, $pay_name, $pay_date, $pay_desp, $pay_amt;

  public function mount()
  {
    $data = OoapTblFybdpayment::where('id', '=', $this->den_id)->first();
    $this->fiscalyear_code = $data->fiscalyear_code;
    $this->pay_name = $data->pay_name;
    $this->pay_date = datetoview($data->pay_date);
    $this->pay_amt = $data->pay_amt;
    $this->pay_desp = $data->pay_desp;
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

    OoapTblFybdpayment::where('id', '=', $this->den_id)->update([
      'fiscalyear_code' => $this->fiscalyear_code,
      'pay_name' => $this->pay_name,
      'pay_date' => datePickerThaiToDB($this->pay_date),
      'pay_desp' => $this->pay_desp,
      'pay_amt' => $this->pay_amt,
      'remember_token' => csrf_token(),
      'updated_by' => auth()->user()->emp_citizen_id,
      'updated_at' => now(),
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
    return view('livewire.manage.cen-depo.edit-component');
  }
}
