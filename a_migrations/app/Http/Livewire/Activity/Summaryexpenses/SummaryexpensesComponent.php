<?php

namespace App\Http\Livewire\Activity\Summaryexpenses;

use App\Models\OoapTblFiscalyear;
use App\Models\OoapMasActtype;
use App\Models\OoapTblFybdpayment;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\UmMasDepartment;
use Livewire\Component;

class SummaryexpensesComponent extends Component
{
    public $budgetyear_list,$budgetyear,$periodno_list=[],$periodno;
    public $fiscalyear_list, $fiscalyear_code, $data, $data_top, $time_list, $time_list_code, $dept_code, $dept_list, $acttype_list, $acttype_id;
    public $service_pay, $disburse;

    public function mount()
    {
        // $this->fiscalyear_code = date("Y") + 543;
        $this->budgetyear_list = OoapTblBudgetProjectplanPeriod::where('in_active', '=', 0)->select('budgetyear')->groupBy('budgetyear')->pluck('budgetyear','budgetyear');
        // $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code2');
        // $this->time_list = array('1', '2', '3', '4', '5');
        $this->acttype_list = OoapMasActtype::where('inactive', '=', false)->pluck('name', 'id as acttype_id');
        // $this->dept_list = UmMasDepartment::pluck('dept_name_th', 'dept_id');

    }

    public function setVal($name, $val){
        $this->$name = $val;

        if($this->budgetyear != null && $this->periodno != null){
            $this->emit("emits");
        }
        else{
            $this->emit("emp");
        }
    }

    public function render()
    {
        // $this->emit('emits');
        // $this->coursesubgroup_list = OoapMasCoursesubgroup::where([['in_active', '=', false], ['coursegroup_id', '=', $this->coursegroup_id]])->pluck('name', 'id');
        // $this->data = OoapTblFybdpayment::where('fiscalyear_code', '=', $this->fiscalyear_code)->get();

        // $this->disburse = OoapTblFiscalyear::where('fiscalyear_code', '=', $this->fiscalyear_code)->first()->centerbudget_amt ?? 0;
        // $this->service_pay = OoapTblFybdpayment::where('fiscalyear_code', '=', $this->fiscalyear_code)->sum('pay_amt') ?? 0;
        $this->periodno_list = OoapTblBudgetProjectplanPeriod::where('budgetyear', '=', $this->budgetyear)->select('periodno')->groupBy('periodno')->pluck('periodno', 'periodno');

        return view('livewire.activity.summaryexpenses.summaryexpenses-component');
    }
}
