<?php

namespace App\Http\Livewire\Activity\Assessment;

use App\Models\OoapTblReqmEmp;
use Livewire\Component;

class RecordAttendanceAddComponent extends Component
{
    public $reqform_id;
    public $resultReq;

    public function mount($reqform_id)
    {

        $this->reqform_id = $reqform_id;


        $this->resultReq = OoapTblReqmEmp::leftjoin('ooap_tbl_emps', 'ooap_tbl_reqm_emps.emps_id', 'ooap_tbl_emps.emps_id')
            ->where('ooap_tbl_reqm_emps.reqform_id', '=', $this->reqform_id)
            ->get();
    }


    public function render()
    {
        return view('livewire.activity.assessment.record-attendance-add-component');
    }
}
