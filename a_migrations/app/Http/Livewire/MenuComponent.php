<?php

namespace App\Http\Livewire;

use Livewire\Component;
class MenuComponent extends Component
{
    public $activePage;
    public function render()
    {
        return view('livewire.menu-component');
    }
}
