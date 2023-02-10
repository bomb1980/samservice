<?php

namespace App\Http\Livewire\Master\AssessmentTopic;

use App\Models\OoapMasAssessmentTopic;
use Livewire\Component;

class AddComponent extends Component
{

    protected $listeners = ['redirect-to' => 'redirect_to'];
    public $assessment_topics_name;

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.master.assessment-topic.add-component');
    }

    public function submit()
    {


        $this->validate([
            'assessment_topics_name' => 'required',
        ], [
            'assessment_topics_name.required' => 'กรุณากรอก ข้อมูลหัวข้อประเมิน',
        ]);


        OoapMasAssessmentTopic::create([
            'assessment_topics_name' => $this->assessment_topics_name,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id
        ]);


        $this->emit('save_success');
    }

    public function redirectTo()
    {
        return redirect()->route('master.assessment_topic.index');
    }
}
