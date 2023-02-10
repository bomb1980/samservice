<?php

namespace App\Http\Livewire\Master\SatisfactionForm;

use App\Models\OoapMasAssessmentTopic;
use App\Models\OoapMasActtype;
use App\Models\OoapMasAssessmentType;
use App\Models\OoapTblAssess;
use Livewire\Component;

class CreateComponent extends Component
{
    public $assessment_topics_name, $descriptions;
    public $activity_types_id, $assessment_types_id;
    public $activity_types_list, $assessment_types_list;
    public $question_arr1 = [], $question_arr2 = [];
    public $assess_type = [], $assess_hdr = [];

    public function mount()
    {
        $this->activity_types_list = OoapMasActtype::where('inactive', '=', false)->pluck('name', 'id');
        $this->assessment_types_list = OoapMasAssessmentType::where('in_active', '=', false)->pluck('assessment_types_name', 'assessment_types_id');
    }
    public function render()
    {
        $this->emit('select2');

        return view('livewire.master.satisfaction-form.create-component');
    }

    public function changeAssessmentType($assessment_types_id)
    {

        if (!empty($assessment_types_id)) {
            $this->assessment_types_id = $assessment_types_id;
        }
    }

    public function changeActivityType($activity_types_id)
    {

        if (!empty($activity_types_id)) {
            $this->activity_types_id = $activity_types_id;
        }
    }

    public function add1()
    {
        $this->question_arr1[count($this->question_arr1) + 1] = null;
    }

    public function remove1($i)
    {
        unset($this->question_arr1[$i]);
        $this->question_arr1 = array_values($this->question_arr1);
        unset($this->assess_type[$i]);
        $this->assess_type = array_values($this->assess_type);
    }

    public function add2()
    {
        $this->question_arr2[count($this->question_arr2) + 1] = null;
    }

    public function remove2($i)
    {
        unset($this->question_arr2[$i]);
        $this->question_arr2 = array_values($this->question_arr2);
        unset($this->assess_hdr[$i]);
        $this->assess_hdr = array_values($this->assess_hdr);
    }

    public function submit()
    {

        $this->validate([
            'activity_types_id' => 'required',
            'assessment_types_id' => 'required',
        ], [
            'activity_types_id.required' => 'กรุณาเลือก ประเภทกิจกรรม',
            'assessment_types_id.required' => 'กรุณาเลือก ประเภทแบบประเมิน',
        ]);

        $AssessmentTopic = OoapMasAssessmentTopic::create([
            'assessment_topics_name' => $this->assessment_topics_name,
            'activity_types_id' => $this->activity_types_id,
            'assessment_types_id' => $this->assessment_types_id,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id
        ]);

        if ($this->question_arr1 >= $this->question_arr2) {
            foreach ($this->question_arr1 as $key => $val) {
                OoapTblAssess::create([
                    'assessment_topics_id' => $AssessmentTopic->assessment_topics_id,
                    'assess_type' => $this->assess_type[$key],
                    // 'assess_hdr' => $this->assess_hdr[$key],
                    'remember_token' => csrf_token(),
                    'created_by' => auth()->user()->emp_citizen_id
                ]);
            }
        }
        // else {
        //     foreach ($this->question_arr2 as $key => $val) {
        //         OoapTblAssess::create([
        //             'assessment_topics_id' => $AssessmentTopic->assessment_topics_id,
        //             'assess_type' => $this->assess_type[$key],
        //             'assess_hdr' => $this->assess_hdr[$key],
        //             'remember_token' => csrf_token(),
        //             'created_by' => auth()->user()->emp_citizen_id
        //         ]);
        //     }
        // }

        return redirect()->route('master.satisfactionform.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        // $this->emit('save_success');
    }
}
