<?php

namespace App\Http\Livewire\Master\AssessmentType;

use App\Models\OoapMasAssessmentType;
use Livewire\Component;

class EditComponent extends Component
{
    public $assessment_types_id, $assessment_types_name;

    public function mount()
    {
        $resultAss = OoapMasAssessmentType::where('assessment_types_id',$this->assessment_types_id)->first();
        $this->assessment_types_name = $resultAss->assessment_types_name;
    }

    public function render()
    {
        return view('livewire.master.assessment-type.edit-component');
    }

    public function submit()
    {
        $this->validate([
            'assessment_types_name' => 'required',
        ], [
            'assessment_types_name.required' => 'กรุณากรอกชื่อประเภทแบบประเมิน',
        ]);

        OoapMasAssessmentType::where('assessment_types_id',$this->assessment_types_id)->update([
            'assessment_types_name' => $this->assessment_types_name,
            'updated_at' => now(),
            'updated_by' => auth()->user()->emp_citizen_id
        ]);

        return redirect()->route('master.assessmenttype.index')->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
