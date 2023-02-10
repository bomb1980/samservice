<?php

namespace App\Http\Livewire\Master\SatisfactionSurvey;

use Livewire\Component;


use App\Models\OoapMasAssessmentTopic;
use App\Models\OoapMasActtype;
use App\Models\OoapMasAssessmentType;
use App\Models\OoapTblAssess;

class SatisfactionSurveyCreate extends Component
{

    public $ASSESS_TEMPLATENO, $CREATE_AT;

    public $Auto_ASSESS_HDR, $ASSESS_DESCRIPTION_R, $ph = "--เพิ่มกลุ่มคำถามใหม่--";

    public $Auto_ASSESS_HDR_list, $Auto_ASSESS_HDR_select2 = [];

    public $ASSESS_DESCRIPTION_O;

    public $ASSESS_DESCRIPTION_R_LIST = [], $ASSESS_DESCRIPTION_O_LIST = [];


    public $acttype_id, $assessment_types_id;
    public $activity_types_list, $assessment_types_list;

    public function mount(){
        $this->ASSESS_TEMPLATENO = date("ymd-His");
        $this->CREATE_AT = (explode(" ",(explode("T",now()))[0]))[0];
        $this->Auto_ASSESS_HDR_select2 = OoapTblAssess::select('assess_hdr')->where('in_active',false)->groupBy('assess_hdr')->pluck('assess_hdr', 'assess_hdr');

        $this->activity_types_list = OoapMasActtype::where('inactive', '=', false)->pluck('name', 'id');
        $this->assessment_types_list = OoapMasAssessmentType::where('in_active', '=', false)->pluck('assessment_types_name', 'assessment_types_id');

    }

    public function changeAssessmentType($assessment_types_id)
    {

        if (!empty($assessment_types_id)) {
            $this->assessment_types_id = $assessment_types_id;
        }
    }

    public function changeActivityType($acttype_id)
    {

        if (!empty($acttype_id)) {
            $this->acttype_id = $acttype_id;
        }
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

    public function set($name, $val){
        $this->$name = $val;
    }

    public function cancel(){
        return redirect()->to(route('master.form.index'));
    }

    public function submit(){

        $this->validate([
            'acttype_id' => 'required',
            'assessment_types_id' => 'required',
            'ASSESS_DESCRIPTION_R_LIST' => 'required',
            'ASSESS_DESCRIPTION_O_LIST' => 'required',
        ], [
            'acttype_id.required' => 'กรุณาเลือก ประเภทกิจกรรม',
            'assessment_types_id.required' => 'กรุณาเลือก ประเภทแบบประเมิน',
            'ASSESS_DESCRIPTION_R_LIST.required' => 'จำเป็นต้องมีคำถามอย่างน้อย 1 ข้อ',
            'ASSESS_DESCRIPTION_O_LIST.required' => 'จำเป็นต้องมีคำถามอย่างน้อย 1 ข้อ',
        ]);

        $AssessmentTopic = OoapMasAssessmentTopic::create([
            'acttype_id' => $this->acttype_id,
            'assessment_types_id' => $this->assessment_types_id,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id
        ]);

        foreach( $this->ASSESS_DESCRIPTION_R_LIST as $key=>$val ){
            OoapTblAssess::create([
                'assess_templateno' => $this->ASSESS_TEMPLATENO,
                'assessment_topics_id' => $AssessmentTopic->assessment_topics_id ?? null,
                'assess_type' => "R",
                'assess_hdr' => $this->Auto_ASSESS_HDR_list[$key],
                'assess_description' => $val,

                'created_by' => auth()->user()->emp_citizen_id,
                'updated_by' => auth()->user()->emp_citizen_id,
            ]);
        }
        foreach( $this->ASSESS_DESCRIPTION_O_LIST as $key=>$val ){
            OoapTblAssess::create([
                'assess_templateno' => $this->ASSESS_TEMPLATENO,
                'assessment_topics_id' => $AssessmentTopic->assessment_topics_id ?? null,
                'assess_type' => "O",
                'assess_description' => $val,

                'created_by' => auth()->user()->emp_citizen_id,
                'updated_by' => auth()->user()->emp_citizen_id,
            ]);
        }
        return redirect()->to(route('master.form.index'))->with('create', 'succsess');
    }

    public function render()
    {
        $this->emit('emits');
        return view('livewire.master.satisfaction-survey.satisfaction-survey-create');
    }
}
