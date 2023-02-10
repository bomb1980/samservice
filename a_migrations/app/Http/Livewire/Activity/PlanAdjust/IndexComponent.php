<?php

namespace App\Http\Livewire\Activity\PlanAdjust;

use App\Models\OoapMasActtype;
use App\Models\OoapMasDivision;
use App\Models\OoapTblActImages;
use App\Models\OoapTblActivities;
use App\Models\OoapTblAllocate;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblReqform;
use App\Models\OoapTblRequest;
use App\Models\UmMasDepartment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IndexComponent extends Component
{
    public $dept_list, $fiscalyear_list, $acttype_list = [], $acttype, $dept;
    public $total_amt, $total_amt_arr, $installment, $fiscalyear_code, $txt_search, $totle_amt_all;
    public $resultActivities, $train, $urgent;

    public function mount()
    {
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code2');

        if (auth()->user()->emp_type == 1) {
            $this->dept_list = OoapMasDivision::whereNotNull('province_id')->pluck('division_name', 'division_id');
        } else {
            $this->dept_list = OoapMasDivision::where('division_id', '=', auth()->user()->division_id)->pluck('division_name', 'division_id');
            $this->dept = auth()->user()->division_id;
        }

        $this->acttype_list = OoapMasActtype::pluck('name', 'id');
    }

    public function render()
    {
        $this->total_amt = OoapTblActivities::where('in_active', '=', false)->where('status', '=', 4)
        ->where('act_year', '=', $this->fiscalyear_code)
        ->where('act_div', '=', $this->dept)
        ->sum('act_amount');

        $this->train = OoapTblAllocate::where('in_active', '=', false)->where('budgetyear', '=', $this->fiscalyear_code)
        ->where('division_id', '=', $this->dept)->sum('allocate_training');
        $this->urgent = OoapTblAllocate::where('in_active', '=', false)->where('budgetyear', '=', $this->fiscalyear_code)
        ->where('division_id', '=', $this->dept)->sum('allocate_urgent');
        $this->total_amt_all = $this->train + $this-> urgent;
        if ($this->acttype) {
            if($this->acttype == 1){
                $this->total_amt_all = $this-> urgent;
            }else{
                $this->total_amt_all = $this-> train;
            }
        }

        $resultActivities = OoapTblActivities::select(
            'ooap_tbl_activities.act_id',
            'ooap_mas_tambon.tambon_name',
            'ooap_mas_amphur.amphur_name',
            'ooap_tbl_activities.act_number',
            'ooap_tbl_activities.act_year',
            'ooap_tbl_activities.act_periodno',
            'ooap_tbl_activities.act_acttype',
            'ooap_tbl_activities.act_div',
            'ooap_tbl_activities.act_acttype',
            'ooap_mas_acttype.name',
            'ooap_tbl_activities.act_district',
            'ooap_tbl_activities.act_subdistrict',
            'ooap_tbl_activities.act_moo',
            'ooap_tbl_activities.act_startmonth',
            'ooap_tbl_activities.act_endmonth',
            'ooap_tbl_activities.act_numofday',
            'ooap_tbl_activities.act_numofpeople',
            'ooap_tbl_activities.act_amount',
            'ooap_tbl_activities.status',
            'ooap_tbl_activities.act_plan_adjust_status',
            'ooap_tbl_activities.act_shortname',
            'ooap_mas_divisions.division_name'
        )
            ->leftjoin('ooap_mas_acttype', 'ooap_tbl_activities.act_acttype', 'ooap_mas_acttype.id')
            ->leftjoin('ooap_mas_tambon', 'ooap_tbl_activities.act_subdistrict', 'ooap_mas_tambon.tambon_id')
            ->leftjoin('ooap_mas_amphur', 'ooap_tbl_activities.act_district', 'ooap_mas_amphur.amphur_id')
            ->leftjoin('ooap_mas_divisions', 'ooap_tbl_activities.act_div', 'ooap_mas_divisions.division_id')

            ->where('ooap_tbl_activities.in_active', '=', false)
            ->whereIn('ooap_tbl_activities.status', [4]);

        if ($this->fiscalyear_code) {
            $resultActivities = $resultActivities->where('ooap_tbl_activities.act_year', '=', $this->fiscalyear_code);
        }

        if ((auth()->user()->emp_type) == 2) {
            $resultActivities = $resultActivities->where('ooap_tbl_activities.act_div', '=', auth()->user()->division_id);
        }

        if ($this->acttype) {
            $resultActivities = $resultActivities->where('ooap_tbl_activities.act_acttype', '=', $this->acttype);
        }

        if ($this->txt_search) {
            $resultActivities = $resultActivities->where('ooap_tbl_activities.act_number', 'LIKE', '%' . $this->txt_search . '%')
                ->orWhere('ooap_mas_acttype.name', 'LIKE', '%' . $this->txt_search . '%')
                ->orWhere('ooap_mas_amphur.amphur_name', 'LIKE', '%' . $this->txt_search . '%')
                ->orWhere('ooap_mas_tambon.tambon_name', 'LIKE', '%' . $this->txt_search . '%')
                ->orWhere('ooap_tbl_activities.act_moo', 'LIKE', '%' . $this->txt_search . '%');
        }


        $this->resultActivities = $resultActivities->get();

        $this->emit('emits');
        return view('livewire.activity.plan-adjust.index-component');
    }

    public function submit_cancel($id)
    {
        OoapTblActivities::where('act_id', '=', $id)->update([
            'status' => 1,
            'updated_at' => now(),
            'updated_by' => auth()->user()->emp_citizen_id,
        ]);
        $this->emit('popup2');
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('activity.plan_adjust.index');
    }

    // public function searchData()
    // {
    //     $this->emit('emits');
    // }
}
