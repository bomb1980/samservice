<?php

namespace App\Http\Livewire\Report\Dashboard;

use App\Models\OoapTblBudgetProjectplanPeriod;
use Livewire\Component;

class InstallmentComponent extends Component
{
    public $installment = [], $budget = [], $withdraw = [], $startmonth, $endmonth;
    public $fiscalyear_code;
    protected $listeners = ['setYear', 'startmonth', 'endmonth'];

    public function mount()
    {

    }

    public function render()
    {
        if($this->fiscalyear_code)
        {
            $this->installment = [];
            $this->budget = [];
            $this->withdraw = [];

            $BudgetProjectplanPeriod = OoapTblBudgetProjectplanPeriod::where('ooap_tbl_budget_projectplan_periods.budgetyear','=',$this->fiscalyear_code)
            ->where('ooap_tbl_budget_projectplan_periods.in_active','=',false)
            ->orderBy('periodno')
            ->leftJoin('ooap_tbl_fybdpayment','ooap_tbl_budget_projectplan_periods.budget_id','ooap_tbl_fybdpayment.parent_id');
            if ($this->startmonth) {
                $BudgetProjectplanPeriod = $BudgetProjectplanPeriod->where('ooap_tbl_budget_projectplan_periods.startperioddate', '>=', $this->startmonth);
            }
            if ($this->endmonth) {
                $BudgetProjectplanPeriod = $BudgetProjectplanPeriod->where('ooap_tbl_budget_projectplan_periods.endperioddate', '<=', $this->endmonth);
            }
            $BudgetProjectplanPeriod = $BudgetProjectplanPeriod->get()->toArray();
            // dd($BudgetProjectplanPeriod);

            foreach($BudgetProjectplanPeriod as $key => $val)
            {
                $this->installment[$key] = 'งวดที่'.' '.$val['periodno'];
                $this->budget[$key] = (int) $val['budgetperiod'] + $val['budgetbalance'];
                $this->withdraw[$key] = (int) $val['pay_amt'];
            }

            $this->emit('installment',[
                'installment' => $this->installment,
                'budget' => $this->budget,
                'withdraw' => $this->withdraw
            ]);
        }

        return view('livewire.report.dashboard.installment-component');
    }

    public function setYear($val)
    {
        $this->fiscalyear_code = $val;

        $this->emit('installment',[
            'installment' => $this->installment,
            'budget' => $this->budget,
            'withdraw' => $this->withdraw
        ]);
    }

    public function startmonth($val)
    {
        $this->startmonth = $val;

        $this->emit('installment',[
            'installment' => $this->installment,
            'budget' => $this->budget,
            'withdraw' => $this->withdraw
        ]);
    }

    public function endmonth($val)
    {
        $this->endmonth = $val;

        $this->emit('installment',[
            'installment' => $this->installment,
            'budget' => $this->budget,
            'withdraw' => $this->withdraw
        ]);
    }
}
