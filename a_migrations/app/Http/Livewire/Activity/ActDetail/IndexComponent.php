<?php

namespace App\Http\Livewire\Activity\ActDetail;

use App\Models\OoapMasDivision;
use App\Models\OoapTblActivities;
use App\Models\OoapTblFiscalyear;
use App\Models\UmMasDepartment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IndexComponent extends Component
{
    public $dept_list, $fiscalyear_list, $fiscalyear_code, $resultact;

    public function mount()
    {

        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code2');

    }

    public function render()
    {

        if ($this->fiscalyear_code) {

            $resultact = OoapTblActivities::where('ooap_tbl_activities.in_active', '=', false);

            $resultact = $resultact->where('ooap_tbl_activities.act_year', '=', $this->fiscalyear_code);

            if(auth()->user()->province_id){
                $resultact = $resultact->where('ooap_tbl_activities.act_div', '=', auth()->user()->division_id);
            }

            $resultact = $resultact->orderby('created_at', 'desc');
            $this->resultact = $resultact->get();
        }

        $this->emit('emits');

        return view('livewire.activity.act-detail.index-component');
    }

}
