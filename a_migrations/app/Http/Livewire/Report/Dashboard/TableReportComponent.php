<?php

namespace App\Http\Livewire\Report\Dashboard;

use App\Models\OoapTblBudgetProjectplanPeriod;
use Livewire\Component;

class TableReportComponent extends Component
{
    public $fiscalyear_code, $BudgetProjectplanPeriod, $startmonth, $endmonth;
    protected $listeners = ['setYear', 'startmonth', 'endmonth'];

    public function setYear($val)
    {
        $this->fiscalyear_code = $val;
    }

    public function startmonth($val)
    {
        $this->startmonth = $val;
    }

    public function endmonth($val)
    {
        $this->endmonth = $val;
    }

    public function render()
    {
        if ($this->fiscalyear_code) {
            $BudgetProjectplanPeriod = OoapTblBudgetProjectplanPeriod::where('ooap_tbl_budget_projectplan_periods.budgetyear', '=', $this->fiscalyear_code)
                ->where('ooap_tbl_budget_projectplan_periods.in_active', '=', false)
                ->orderBy('periodno')
                ->leftJoin('ooap_tbl_fybdpayment', 'ooap_tbl_budget_projectplan_periods.budget_id', 'ooap_tbl_fybdpayment.parent_id');
            if ($this->startmonth) {
                $BudgetProjectplanPeriod = $BudgetProjectplanPeriod->where('ooap_tbl_budget_projectplan_periods.startperioddate', '>=', $this->startmonth);
            }
            if ($this->endmonth) {
                $BudgetProjectplanPeriod = $BudgetProjectplanPeriod->where('ooap_tbl_budget_projectplan_periods.endperioddate', '<=', $this->endmonth);
            }
            $this->BudgetProjectplanPeriod = $BudgetProjectplanPeriod->get()->toArray();
        }

        return view('livewire.report.dashboard.table-report-component');
    }
}
