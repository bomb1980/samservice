<?php

namespace App\Http\Livewire\Manage\LocalMng;

use App\Models\OoapTblFiscalyear;
use Livewire\Component;

class TranbackcenComponent extends Component
{
    public $fiscalyear_list;

    public function mount()
    {
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active','=', false)->pluck('fiscalyear_code', 'fiscalyear_code AS fiscalyear_code2');
    }

    public function submit()
    {
        $this->emit('popup');
        return redirect()->route('manage.local_mng.index');
    }
    // protected $listeners = ['redirect-to' => 'redirect_to'];

    // public function redirect_to()
    // {
    //     return redirect()->to('/manage/local_mng/index');
    // }

    public function render()
    {
        return view('livewire.manage.local-mng.tranbackcen-component');
    }
}
