<?php

namespace App\Http\Livewire\Manage\Installment;

use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFybdperiod;
use Livewire\Component;

class InstallmentComponent extends Component
{
    public $fiscalyear_select, $fiscalyear_search, $data_list=[], $databudget_list=[], $dataperiod_list=[], $budget_amt, $sum_period_amt;

    public function mount()
    {
        $this->fiscalyear_search = date("Y")+543;
    }

    public function setVal($name, $val)
    {
        $this->$name = $val;
    }

    public function gotoUrl()
    {
        return redirect()->route('manage.installment.create', ['fiscalyear_code' => $this->fiscalyear_search]);
    }

    public function render()
    {
        $this->data_list=OoapTblFybdperiod::select('id','fiscalyear_code','period_no','startdate','enddate','period_rate','period_amt')
        ->where('in_active','=',false)
        ->where('fiscalyear_code','=',$this->fiscalyear_search)
        ->orderBy('period_no')
        ->get();
        $this->databudget_list=OoapTblFiscalyear::select('budget_amt')
        ->where('fiscalyear_code','=',$this->fiscalyear_search)
        ->first();
        $this->budget_amt = $this->databudget_list->budget_amt ?? 0;
        $this->dataperiod_list=OoapTblFybdperiod::selectRaw('sum(period_amt) as sum_period_amt')
        ->where('in_active','=',false)
        ->where('fiscalyear_code','=',$this->fiscalyear_search)
        ->groupBy('fiscalyear_code')
        ->first();
        $this->sum_period_amt = $this->dataperiod_list->sum_period_amt ?? 0;

        $this->fiscalyear_select=OoapTblFiscalyear::where('in_active','=', false)->get()->pluck('fiscalyear_code','fiscalyear_code');

        $this->emit('emits');

        return view('livewire.manage.installment.installment-component');
    }
}
