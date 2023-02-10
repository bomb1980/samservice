<?php

namespace App\Http\Livewire\Activity\ActivityImage;

use Livewire\Component;

class AddComponent extends Component
{
    public $items = [], $types = ['ก่อนกิจกรรม' => 'ก่อนกิจกรรม', 'ระหว่างกิจกรรม' => 'ระหว่างกิจกรรม', 'หลังกิจกรรม' => 'หลังกิจกรรม'], $type, $date, $amount;

    public function render()
    {
        return view('livewire.activity.activity-image.add-component');
    }

    function addItem()
    {
        $this->items[] = [
            'type' => $this->type,
            'date' => $this->date,
            'amount' => 1
        ];

        $this->reset(['type', 'date']);
        $this->emit('add_item');
    }

    public function submit()
    {
        $this->emit('save_success');
    }

    public function redirectTo()
    {
        return redirect()->route('activity.activity_image.index');
    }
}
