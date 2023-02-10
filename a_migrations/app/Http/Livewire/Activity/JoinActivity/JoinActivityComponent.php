<?php

namespace App\Http\Livewire\Activity\JoinActivity;

use Livewire\Component;

class JoinActivityComponent extends Component
{
    public $years_select, $years, $division_select, $division, $project_type_select, $project_type, $project_select, $project;
    public function mount()
    {
        $this->years_select = [];
        $this->division_select = [];
        $this->project_type_select = [];
        $this->project_select = [];
    }
    public function render()
    {
        return view('livewire.activity.join-activity.join-activity-component');
    }
}
