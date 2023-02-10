<?php

namespace App\Http\Livewire\Manage\Installment;

use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFybdperiod;
use Livewire\Component;

class InstallmentAddComponent extends Component
{
  public $fiscalyear_select, $fiscalyear_code, $databudget_list, $startdate, $enddate, $period_no, $budget_amt, $period_rate, $period_amt;
  public $left_per, $left_amt;

  public function mount()
  {
    $this->fiscalyear_code = $_REQUEST['fiscalyear_code'] ?? null;
    $this->period_no = OoapTblFybdperiod::where('fiscalyear_code', '=', $this->fiscalyear_code)->count() + 1;

    $this->budget_amt = OoapTblFiscalyear::select('budget_amt')->where('fiscalyear_code', '=', $this->fiscalyear_code)->first()->budget_amt ?? 0;

    $this->left_amt = $this->budget_amt - (OoapTblFybdperiod::where('fiscalyear_code', '=', $this->fiscalyear_code)->sum('period_amt') ?? 0);

    $this->left_per = $this->budget_amt === 0 ? 0 : ($this->left_amt / $this->budget_amt) * 100;
  }

  public function submit()
  {
    // dd($this);
    $this->validate([
      'fiscalyear_code' => 'required',
      'period_no' => 'required',
      'startdate' => 'required',
      'enddate' => 'required',
      'period_rate' => 'required',
      'period_amt' => 'numeric|max:' . $this->left_amt,
    ], [
      'fiscalyear_code.required' => 'กรุณาเลือก ปีงบประมาณ',
      'period_no.required' => 'กรุณากรอก งวดที่',
      'startdate.required' => 'กรุณากรอก ช่วงเวลาเริ่มต้น',
      'enddate.required' => 'กรุณากรอก ช่วงเวลาสิ้นสุด',
      'period_rate.required' => 'กรุณากรอก สัดส่วน',
      'period_amt.required' => 'กรุณากรอก จำนวนเงิน',
      'period_amt.max' => 'กรุณากรอก จำนวนเงินไม่เกิน ' . $this->left_amt,
    ]);
    // dd();
    $OoapTblFybdperiod = OoapTblFybdperiod::create([
      'fiscalyear_code' => $this->fiscalyear_code,
      'period_no' => $this->period_no,
      'startdate' => montYearsToDate($this->startdate),
      'enddate' => montYearsToDate($this->enddate),
      'period_month' => 1,
      'period_rate' => $this->period_rate,
      'period_amt' => $this->period_amt,
      'created_at' => now(),
      'created_by' => auth()->user()->emp_citizen_id,
    ]);
    $this->emit('popup');
  }

  protected $listeners = ['redirect-to' => 'redirect_to'];

  public function redirect_to()
  {
    return redirect()->route('manage.installment.index');
  }

  public function render()
  {
    $this->databudget_list = OoapTblFiscalyear::select('budget_amt')->where('fiscalyear_code', '=', $this->fiscalyear_code)->first()->budget_amt ?? 0;

    $this->fiscalyear_select = OoapTblFiscalyear::where('in_active', '=', false)->get()->pluck('fiscalyear_code', 'fiscalyear_code');

    $this->period_rate = $this->databudget_list === 0 ? 0 : number_format(($this->period_amt / $this->databudget_list) * 100, 2);

    return view('livewire.manage.installment.installment-add-component');
  }
}
