<?php

namespace App\Http\Livewire\Activity\TranMng;

use App\Models\OoapTblFiscalyear;
use App\Models\UmMasDepartment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ManageComponent extends Component
{
    public $dept_list, $fiscalyear_list;

    public function mount()
    {
        // $this->dept_list = DB::connection('oracle_umts')->table('um_mas_department')->pluck("dept_name_th", "dept_id");
        $this->dept_list = UmMasDepartment::pluck('dept_name_th', 'dept_id');
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active','=', false)->pluck('fiscalyear_code', 'fiscalyear_code AS fiscalyear_code2');
    }

    public function submit()
    {
        $this->emit('popup');
    }
    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('activity.tran_mng.index');

    }

    public function render()
    {
        return view('livewire.activity.tran-mng.manage-component');
    }
}
