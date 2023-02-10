<?php

namespace App\Http\Livewire\Manage\CenDepo;

use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFybdpayment;
use App\Models\UmMasDepartment;
use Livewire\Component;

class IndexComponent extends Component
{
    public $fiscalyear_list, $fiscalyear_code, $data, $data_top, $time_list, $time_list_code, $dept_code, $dept_list;
    public $service_pay, $disburse;

    public function mount()
    {
        $this->fiscalyear_code = date("Y") + 543;
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code2');
        $this->time_list = array('1', '2', '3', '4', '5');
        $this->dept_list = UmMasDepartment::pluck('dept_name_th', 'dept_id');
    }

    public function render()
    {
        $this->data = OoapTblFybdpayment::where('fiscalyear_code', '=', $this->fiscalyear_code)->get();
        $this->disburse = OoapTblFiscalyear::where('fiscalyear_code', '=', $this->fiscalyear_code)->first()->centerbudget_amt ?? 0;
        $this->service_pay = OoapTblFybdpayment::where('fiscalyear_code', '=', $this->fiscalyear_code)->sum('pay_amt') ?? 0;
        $this->emit('emits');
        return view('livewire.manage.cen-depo.index');
    }
}
