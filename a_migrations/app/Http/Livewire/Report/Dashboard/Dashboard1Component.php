<?php

namespace App\Http\Livewire\Report\Dashboard;

use App\Models\OoapTblFiscalyear;
use App\Models\UmMasDepartment;
use Livewire\Component;

class Dashboard1Component extends Component
{
    public $dept_list, $fiscalyear_list;
    public $total_amt;

    public function mount()
    {
        // $this->dept_list = DB::connection('oracle_umts')->table('um_mas_department')->pluck("dept_name_th", "dept_id");
        $this->dept_list = UmMasDepartment::pluck('dept_name_th', 'dept_id');
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active','=', false)->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code2');

    }

    public function render()
    {
        return view('livewire.report.dashboard.dashboard1-component');
    }
}
