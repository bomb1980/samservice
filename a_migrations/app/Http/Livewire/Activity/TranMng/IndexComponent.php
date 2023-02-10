<?php

namespace App\Http\Livewire\Activity\TranMng;

use App\Models\OoapMasDivision;
use App\Models\OoapTblActivities;
use App\Models\OoapTblAllocate;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblFiscalyear;
use App\Models\UmMasDepartment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IndexComponent extends Component
{
    public $dept_list, $fiscalyear_list, $fiscalyear_code, $txt_search, $local_budget, $project_cost, $total_allocate, $transfer_amt = 0, $transfer_amt_wait = 0;

    public function mount()
    {
        $this->dept_list = UmMasDepartment::pluck('dept_name_th', 'dept_id');
    }

    public function render()
    {
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code AS fiscalyear_code2');

        return view('livewire.activity.tran-mng.index-component');
    }

    public function setYear($val)
    {
        $this->fiscalyear_code = $val;
        if ($this->fiscalyear_code) {
            $this->local_budget = OoapTblFiscalyear::where('in_active','=',false)->where('fiscalyear_code','=',$this->fiscalyear_code)->first();
            $this->local_budget = $this->local_budget->regionbudget_amt;

            $allocate = OoapTblAllocate::where('in_active','=',false)->where('budgetyear','=',$this->fiscalyear_code);
            $project_urgent_cost = clone $allocate;
            $project_urgent_cost = $project_urgent_cost->sum('sum_urgent');
            $project_training_cost = clone $allocate;
            $project_training_cost = $project_training_cost->sum('sum_training');
            $this->project_cost = $project_urgent_cost + $project_training_cost;

            $allocate_manage = clone $allocate;
            $allocate_manage = $allocate_manage->sum('allocate_manage');
            $allocate_urgent = clone $allocate;
            $allocate_urgent = $allocate_urgent->sum('allocate_urgent');
            $allocate_training = clone $allocate;
            $allocate_training = $allocate_training->sum('allocate_training');
            $this->total_allocate = $allocate_urgent + $allocate_training + $allocate_manage;
        } else {
            $this->local_budget = '';
            $this->project_cost = '';
            $this->total_allocate = '';
        }
    }
}
