<?php

namespace App\Http\Livewire\Master\SatisfactionSurvey;

use Livewire\Component;

use App\Models\OoapTblAssess;

class SatisfactionSurveyComponent extends Component
{
    public function del($assess_templateno){
        $OoapTblAssess = OoapTblAssess::where('assess_templateno', '=', $assess_templateno)->update(['in_active' => 1]);
        $this->emit('delc');
    }

    public function render()
    {
        return view('livewire.master.satisfaction-survey.satisfaction-survey-component');
    }
}
