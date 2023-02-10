<?php

namespace App\Http\Livewire\Master\AssessmentTopic;

use App\Models\OoapMasActivityType;
use App\Models\OoapMasAssessmentType;
use App\Models\OoapMasAssessmentTopic;

use Livewire\Component;

class AssessmentTopicAddComponent extends Component
{

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public $assessment_topics_name, $descriptions;

    public $acttype_id, $acttype_list, $population_type_id, $population_type_list, $desc;

    public $activity_types_id, $assessment_types_id;
    public $activity_types_list, $assessment_types_list;

    public function mount()
    {

        $this->activity_types_list = OoapMasActivityType::where('in_active','=',false)->pluck('activity_types_name','activity_types_id');
        $this->assessment_types_list = OoapMasAssessmentType::where('in_active','=',false)->pluck('assessment_types_name','assessment_types_id');

    }

    public function render()
    {
        $this->emit('select2');

        return view('livewire.master.assessment-topic.assessment-topic-add-component');
    }

    public function submit()
    {


        $this->validate([
            'assessment_topics_name' => 'required',
            'activity_types_id' => 'required',
            'assessment_types_id' => 'required',
        ], [
            'assessment_topics_name.required' => 'กรุณากรอก หัวข้อแบบประเมิน',
            'activity_types_id.required' => 'กรุณาเลือก ประเภทกิจกรรม',
            'assessment_types_id.required' => 'กรุณาเลือก ประเภทแบบประเมิน',
        ]);


        OoapMasAssessmentTopic::create([
            'assessment_topics_name' => $this->assessment_topics_name,
            'activity_types_id' => $this->activity_types_id,
            'assessment_types_id' => $this->assessment_types_id,
            'descriptions' => $this->descriptions,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id
        ]);


        return redirect()->route('master.assessment_topic.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        // $this->emit('save_success');
    }

    public function redirectTo()
    {
        return redirect()->route('master.assessment_topic.index');
    }
}
