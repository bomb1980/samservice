<?php

namespace App\Http\Livewire\Master\SatisfactionSurvey;

use Livewire\Component;

use App\Models\OoapTblAssess;

class SatisfactionSurveyView extends Component
{
    public $assess_templateno_ini, $isCOPY = false;

    public $ASSESS_TEMPLATENO, $UPDATE_AT, $CREATED_BY, $CREATED_AT;

    public $Auto_ASSESS_HDR, $ASSESS_DESCRIPTION_R;

    public $Auto_ASSESS_HDR_list = [];

    public $ASSESS_DESCRIPTION_O;

    public $ASSESS_DESCRIPTION_R_LIST = [], $ASSESS_DESCRIPTION_O_LIST = [];
    public function mount(){
        if(str_contains($this->assess_templateno_ini, 'c')){
            $this->isCOPY = true;
            $this->assess_templateno_ini = str_replace("c","",$this->assess_templateno_ini);
        }

        $dataR = OoapTblAssess::where('in_active',0)->where('assess_templateno', '=', $this->assess_templateno_ini)->where('assess_type', '=', "R")->get();
        foreach( $dataR as $key=>$val ){
            $this->Auto_ASSESS_HDR_list [] = $val->assess_hdr;
            $this->ASSESS_DESCRIPTION_R_LIST [] = $val->assess_description;
        }

        $datao = OoapTblAssess::where('in_active',0)->where('assess_templateno', '=', $this->assess_templateno_ini)->where('assess_type', '=', "O")->get();
        foreach( $datao as $key=>$val ){
            $this->ASSESS_DESCRIPTION_O_LIST [] = $val->assess_description;
        }

        if($this->isCOPY == false){
            $this->ASSESS_TEMPLATENO = $this->assess_templateno_ini;
            $this->CREATED_BY = $datao[0]->created_by;
            $this->CREATED_AT = $datao[0]->created_at;
        }
        else{
            $this->ASSESS_TEMPLATENO = date("ymd-His");
            $this->CREATED_BY = null;
            $this->CREATED_AT = null;
        }
        $this->UPDATE_AT = $datao[0]->created_at;
    }

    public function cancel()
    {
        return redirect()->to(route('master.form.index'));
    }

    public function render()
    {
        return view('livewire.master.satisfaction-survey.satisfaction-survey-view');
    }
}
