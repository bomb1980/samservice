<?php

namespace App\Http\Livewire\Activity\JoinActivity;

use Livewire\Component;

class JoinActivityAddComponent extends Component
{
    public $type_id, $type_select;
    protected $listeners = ['redirect-to' => 'redirect_to'];
    public function mount()
    {
        $this->type_select = array('มา', 'ขาด', 'ทดแทน');
    }
    public function render()
    {
        return view('livewire.activity.join-activity.join-activity-add-component');
    }
    public function submit()
    {
        $this->emit('popup');
    }
    public function redirect_to()
    {
        return redirect()->route('activity.join_activity.index');
    }
}
