<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HistoryComponent extends Component
{
    public $columns;
    public $api;

    public function render()
    {
        return view('livewire.history-component');
    }
}
