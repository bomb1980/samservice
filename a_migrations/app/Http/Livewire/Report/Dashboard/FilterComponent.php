<?php

namespace App\Http\Livewire\Report\Dashboard;

use App\Models\OoapTblBudgetProjectplanPeriod;
use Livewire\Component;

class FilterComponent extends Component
{
    public $fiscalyear_code, $fiscalyear_list, $stdate, $endate, $startmonth, $endmonth;
    public function render()
    {
        $this->fiscalyear_list = OoapTblBudgetProjectplanPeriod::select('budgetyear')->groupBy('budgetyear')->where('in_active','=',false)->pluck('budgetyear','budgetyear');

        return view('livewire.report.dashboard.filter-component');
    }

    public function changeYear($val)
    {
        $this->fiscalyear_code = $val;
        $this->emit('setYear', $this->fiscalyear_code);
    }

    public function setArray()
    {
        $this->startmonth = montYearsToDate($this->stdate);
        $this->endmonth = montYearsToDate($this->endate);
        $this->emit('startmonth', $this->startmonth);
        $this->emit('endmonth', $this->endmonth);
    }
}
