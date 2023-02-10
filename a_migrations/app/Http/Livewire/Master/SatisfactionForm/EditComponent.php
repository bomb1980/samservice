<?php

namespace App\Http\Livewire\Master\SatisfactionForm;

use Livewire\Component;

class EditComponent extends Component
{
    public $satisfactionform_id;

    public function render()
    {
        return view('livewire.master.satisfaction-form.edit-component');
    }
}
