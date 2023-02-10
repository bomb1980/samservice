<?php

namespace App\Http\Livewire\Master\SatisfactionSurvey;

use Livewire\Component;

use App\Models\OoapMasAssessmentTopic;
use App\Models\OoapMasActtype;
use App\Models\OoapMasAssessmentType;
use App\Models\OoapTblAssess;

class SatisfactionSurveyEdit extends Component
{

    public $assess_templateno_ini, $isCOPY = false;

    public $ASSESS_TEMPLATENO, $UPDATE_AT, $CREATED_BY, $CREATED_AT;

    public $Auto_ASSESS_HDR, $ASSESS_DESCRIPTION_R, $ph = "--เพิ่มกลุ่มคำถามใหม่--";

    public $Auto_ASSESS_HDR_list, $Auto_ASSESS_HDR_select2 = [];

    public $ASSESS_DESCRIPTION_O;

    public $ASSESS_DESCRIPTION_R_LIST = [], $ASSESS_DESCRIPTION_O_LIST = [];


    public $assessment_topics_id;
    public $acttype_id, $assessment_types_id;
    public $activity_types_list, $assessment_types_list;

    public function mount(){

        // dd($this->assessment_topics_id);
        $resultAss = OoapMasAssessmentTopic::where('assessment_topics_id',$this->assessment_topics_id)->first();
        $this->activity_types_id = $resultAss->activity_types_id;
        $this->assessment_types_id = $resultAss->assessment_types_id;

        $this->Auto_ASSESS_HDR_select2 = OoapTblAssess::select('assess_hdr')->where('in_active',false)->groupBy('assess_hdr')->pluck('assess_hdr', 'assess_hdr');


        $this->activity_types_list = OoapMasActtype::where('inactive', '=', false)->pluck('name', 'id');
        $this->assessment_types_list = OoapMasAssessmentType::where('in_active', '=', false)->pluck('assessment_types_name', 'assessment_types_id');

        if(str_contains($this->assess_templateno_ini, 'c')){
            $this->isCOPY = true;
            $this->assess_templateno_ini = str_replace("c","",$this->assess_templateno_ini);
        }

        $dataR = OoapTblAssess::where('in_active',0)->where('assessment_topics_id', '=', $this->assessment_topics_id)->where('assess_type', '=', "R")->get();
        foreach( $dataR as $key=>$val ){
            $this->Auto_ASSESS_HDR_list [] = $val->assess_hdr;
            $this->ASSESS_DESCRIPTION_R_LIST [] = $val->assess_description;
        }

        $datao = OoapTblAssess::where('in_active',0)->where('assessment_topics_id', '=', $this->assessment_topics_id)->where('assess_type', '=', "O")->get();
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
        $this->UPDATE_AT = now();
    }

    public function add_r(){//ASSESS_DESCRIPTION_R
        function in_obj($target_val, $obj){
            foreach($obj as $key=>$val){
                if($target_val == $val){
                    return true;
                }
            }
            return false;
        }
        if($this->ASSESS_DESCRIPTION_R != null && $this->Auto_ASSESS_HDR != null){

            if (!in_obj($this->Auto_ASSESS_HDR, $this->Auto_ASSESS_HDR_select2)){
                $this->Auto_ASSESS_HDR_select2[$this->Auto_ASSESS_HDR] = $this->Auto_ASSESS_HDR;
            }
            $this->ASSESS_DESCRIPTION_R_LIST [] = $this->ASSESS_DESCRIPTION_R;
            $this->ASSESS_DESCRIPTION_R = null;

            $this->Auto_ASSESS_HDR_list [] = $this->Auto_ASSESS_HDR;
            $this->Auto_ASSESS_HDR = null;

            $this->ph = "--เพิ่มกลุ่มคำถามใหม่--";
        }
        // dd($this->ASSESS_DESCRIPTION_R);
    }

    public function del_r($key){
        unset($this->Auto_ASSESS_HDR_select2[$this->Auto_ASSESS_HDR_list[$key]]);
        array_splice($this->ASSESS_DESCRIPTION_R_LIST, $key, 1);
        array_splice($this->Auto_ASSESS_HDR_list, $key, 1);
        // dd($this->ASSESS_DESCRIPTION_R);
    }

    public function add_o(){//ASSESS_DESCRIPTION_R
        if($this->ASSESS_DESCRIPTION_O != null){
            $this->ASSESS_DESCRIPTION_O_LIST [] = $this->ASSESS_DESCRIPTION_O;
            $this->ASSESS_DESCRIPTION_O = null;
        }
        // dd($this->ASSESS_DESCRIPTION_R);
    }
    public function del_o($key){
        array_splice($this->ASSESS_DESCRIPTION_O_LIST, $key, 1);
        // dd($this->ASSESS_DESCRIPTION_R);
    }

    public function cancel(){
        if($this->isCOPY){
            foreach( $this->ASSESS_DESCRIPTION_R_LIST as $key=>$val ){
                $OoapTblAssess = OoapTblAssess::create([
                    'assessment_topics_id' => $this->assessment_topics_id,
                    // 'assess_templateno' => $this->ASSESS_TEMPLATENO,
                    'assess_type' => "R",
                    'assess_hdr' => $this->Auto_ASSESS_HDR_list[$key],
                    'assess_description' => $val,

                    'created_by' => auth()->user()->emp_citizen_id,
                    'updated_by' => auth()->user()->emp_citizen_id,
                ]);
            }
            foreach( $this->ASSESS_DESCRIPTION_O_LIST as $key=>$val ){
                $OoapTblAssess = OoapTblAssess::create([
                    'assessment_topics_id' => $this->assessment_topics_id,
                    // 'assess_templateno' => $this->ASSESS_TEMPLATENO,
                    'assess_type' => "O",
                    'assess_description' => $val,

                    'created_by' => auth()->user()->emp_citizen_id,
                    'updated_by' => auth()->user()->emp_citizen_id,
                ]);
            }
            $OoapTblAssess = OoapTblAssess::where('assessment_topics_id','=',$this->assessment_topics_id)->update([
                'in_active' => 1
            ]);
        }
        return redirect()->to(route('master.form.index'));
    }
    public function submit(){
        $this->validate([
            'ASSESS_DESCRIPTION_R_LIST' => 'required',
            'ASSESS_DESCRIPTION_O_LIST' => 'required',
        ], [
            'ASSESS_DESCRIPTION_R_LIST.required' => 'จำเป็นต้องมีคำถามอย่างน้อย 1 ข้อ',
            'ASSESS_DESCRIPTION_O_LIST.required' => 'จำเป็นต้องมีคำถามอย่างน้อย 1 ข้อ',
        ]);

        if($this->isCOPY == false){
            $OoapTblAssess = OoapTblAssess::where('assessment_topics_id','=',$this->assessment_topics_id)->update([
                'in_active' => 1
            ]);

            foreach( $this->ASSESS_DESCRIPTION_R_LIST as $key=>$val ){
                $OoapTblAssess = OoapTblAssess::create([
                    'assessment_topics_id' => $this->assessment_topics_id,
                    // 'assess_templateno' => $this->ASSESS_TEMPLATENO,
                    'assess_type' => "R",
                    'assess_hdr' => $this->Auto_ASSESS_HDR_list[$key],
                    'assess_description' => $val,

                    'created_by' => $this->CREATED_BY,
                    'updated_by' => auth()->user()->emp_citizen_id,

                    'created_at' => $this->CREATED_AT,
                ]);
            }
            foreach( $this->ASSESS_DESCRIPTION_O_LIST as $key=>$val ){
                $OoapTblAssess = OoapTblAssess::create([
                    'assessment_topics_id' => $this->assessment_topics_id,
                    // 'assess_templateno' => $this->ASSESS_TEMPLATENO,
                    'assess_type' => "O",
                    'assess_description' => $val,

                    'created_by' => $this->CREATED_BY,
                    'updated_by' => auth()->user()->emp_citizen_id,

                    'created_at' => $this->CREATED_AT,
                ]);
            }
        }
        else{

            foreach( $this->ASSESS_DESCRIPTION_R_LIST as $key=>$val ){
                $OoapTblAssess = OoapTblAssess::create([
                    'assessment_topics_id' => $this->assessment_topics_id,
                    // 'assess_templateno' => $this->ASSESS_TEMPLATENO,
                    'assess_type' => "R",
                    'assess_hdr' => $this->Auto_ASSESS_HDR_list[$key],
                    'assess_description' => $val,

                    'created_by' => auth()->user()->emp_citizen_id,
                    'updated_by' => auth()->user()->emp_citizen_id,
                ]);
            }
            foreach( $this->ASSESS_DESCRIPTION_O_LIST as $key=>$val ){
                $OoapTblAssess = OoapTblAssess::create([
                    'assessment_topics_id' => $this->assessment_topics_id,
                    // 'assess_templateno' => $this->ASSESS_TEMPLATENO,
                    'assess_type' => "O",
                    'assess_description' => $val,

                    'created_by' => auth()->user()->emp_citizen_id,
                    'updated_by' => auth()->user()->emp_citizen_id,
                ]);
            }
        }
        return redirect()->to(route('master.form.index'))->with('create', 'succsess');
    }
    public function render()
    {
        return view('livewire.master.satisfaction-survey.satisfaction-survey-edit');
    }
}
