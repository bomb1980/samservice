<?php

namespace App\Http\Livewire\Activity\Participant;

use App\Models\OoapMasActtype;
use App\Models\OoapMasAmphur;
use App\Models\OoapMasDivision;
use App\Models\OoapMasOcuupation;
use App\Models\OoapMasProvince;
use App\Models\OoapMasTambon;
use App\Models\OoapTblActivities;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblPopulation;
use App\Models\OoapTblReqform;
use App\Models\OoapTblReqmEmp;
use App\Models\OoapTblRequest;
use App\Models\UmMasDepartment;
use Livewire\Component;

class ParticipantComponent extends Component
{

    public $resultPop = [];
    public $fiscalyear_code, $fiscalyear_list;
    public $dept_id, $dept_list;
    public $acttype_id, $acttype_list;
    public $reqform_id = 0, $reqform_no_list = [];
    public $total_amt, $resultForm;
    public $ocuupation_list = [], $c_status = false;

    public function mount()
    {

        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code2');
        if(auth()->user()->province_id == null){
            $this->dept_list = OoapMasDivision::whereNotNull('province_id')->pluck('division_name', 'division_id');
        }else{
            $this->dept_list = OoapMasDivision::where('division_id', '=', auth()->user()->division_id)->pluck('division_name', 'division_id');
        }

        $this->acttype_list = OoapMasActtype::where('inactive', '=', false)->pluck('name', 'id');
        $this->ocuupation_list = OoapMasOcuupation::where('in_active', false)->pluck('name', 'id');
    }

    public function render()
    {
        $this->emit('emits');
        if (!empty($this->fiscalyear_code) && !empty($this->dept_id) && !empty($this->acttype_id)) {

            $resultForm = OoapTblActivities::select('ooap_tbl_activities.act_id', 'ooap_tbl_activities.act_number');
            $resultForm = $resultForm->where('ooap_tbl_activities.in_active', '=', false);
            $resultForm = $resultForm->where('ooap_tbl_activities.act_year', '=', $this->fiscalyear_code);
            $resultForm = $resultForm->where('ooap_tbl_activities.act_div', '=', $this->dept_id);
            $resultForm = $resultForm->where('ooap_tbl_activities.act_acttype', '=', $this->acttype_id);
            // $resultForm = $resultForm->where('ooap_tbl_activities.status', '=', 3);
            // if($resultForm->where('ooap_tbl_activities.status', '=', 3)->first()){
            //     $this->c_status = true;
            // }
            // dd('t');

            $this->reqform_no_list = $resultForm->pluck('ooap_tbl_activities.act_number', 'ooap_tbl_activities.act_id');
            if ($this->reqform_id) {
                if (!isset($this->reqform_no_list[$this->reqform_id])) {
                    $this->reqform_id = 0;
                }
            }
        }

        if ($this->reqform_id > 0) {
            $pullresult = OoapTblActivities::where('in_active', '=', false)
                ->where('act_acttype', '=', $this->acttype_id)
                ->where('act_id', '=', $this->reqform_id)
                ->where('status', '>=', 3)
                ->first();
            if ($pullresult) {
                $this->c_status = true;
            } else {
                $this->c_status = false;
            }

            $this->resultPop = OoapTblPopulation::select(
                'ooap_tbl_populations.*',
                'ooap_mas_tambon.tambon_name',
                'ooap_mas_amphur.amphur_name',
                'ooap_mas_province.province_name'
            )
                ->leftjoin('ooap_mas_tambon', 'ooap_tbl_populations.pop_subdistrict', 'ooap_mas_tambon.tambon_id')
                ->leftjoin('ooap_mas_amphur', 'ooap_mas_amphur.amphur_id', 'ooap_tbl_populations.pop_district')
                ->leftjoin('ooap_mas_province', 'ooap_mas_province.province_id', 'ooap_tbl_populations.pop_province')
                ->where('ooap_tbl_populations.in_active', '=', 0)->where('ooap_tbl_populations.pop_actnumber', '=', $this->reqform_no_list[$this->reqform_id])
                ->where('ooap_tbl_populations.pop_role', '!=', 1)
                ->orderby('ooap_tbl_populations.pop_role', 'desc')
                ->get();
        }

        return view('livewire.activity.participant.participant-component');
    }
}
