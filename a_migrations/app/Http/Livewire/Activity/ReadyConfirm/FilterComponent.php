<?php

namespace App\Http\Livewire\Activity\ReadyConfirm;

use Livewire\Component;
use App\Models\OoapTblActivities;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblReqform;

class FilterComponent extends Component
{
    public $budgetyear_list,$budgetyear,$periodno_list=[],$periodno;
    public $actyear_list, $act_year, $periods_list, $act_periodno;
    public $total_amt, $txt_search;

    public function mount()
    {
        // $this->actyear_list = OoapTblActivities::select('act_year')->where('in_active', '=', false)->groupBy('act_year')->pluck('act_year', 'act_year');
        $this->actyear_list = OoapTblFiscalyear::select('fiscalyear_code')->where('in_active', '=', false)->groupBy('fiscalyear_code')->pluck('fiscalyear_code', 'fiscalyear_code');
    }

    public function render()
    {
        return view('livewire.activity.ready-confirm.filter-component');
    }

    public function changeYear($year)
    {
        $this->act_year = $year;
        $this->periodno_list = OoapTblActivities::select('act_periodno')->where('act_year', '=', $this->act_year)->groupBy('act_periodno')->pluck('act_periodno', 'act_periodno');
        // dd($this->periodno_list);
    }

    public function searchData()
    {
        $this->emit('setValue', $this->act_year, $this->act_periodno, $this->txt_search);
    }
}
