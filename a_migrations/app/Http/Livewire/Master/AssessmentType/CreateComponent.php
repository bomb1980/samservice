<?php

namespace App\Http\Livewire\Master\AssessmentType;

use App\Models\OoapMasAssessmentType;
use Livewire\Component;

class CreateComponent extends Component
{
    public $assessment_types_name;

    public function render()
    {
        return view('livewire.master.assessment-type.create-component');
    }

    public function submit()
    {
        $this->validate([
            'assessment_types_name' => 'required',
        ], [
            'assessment_types_name.required' => 'กรุณากรอกชื่อประเภทแบบประเมิน',
        ]);

        OoapMasAssessmentType::create([
            'assessment_types_name' => $this->assessment_types_name,
            'created_at' => now(),
            'created_by' => auth()->user()->emp_citizen_id
        ]);

        return redirect()->route('master.assessmenttype.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}
