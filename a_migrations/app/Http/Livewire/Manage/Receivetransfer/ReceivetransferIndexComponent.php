<?php

namespace App\Http\Livewire\Manage\Receivetransfer;

use App\Models\OoapTblFybdtransfer;
use Livewire\Component;

class ReceivetransferIndexComponent extends Component
{
    public $fiscalyear_list, $fiscalyear_code, $fybdperiod_list, $fybdperiod_id, $transfer_date, $transfer_amt, $transfer_desp;

    public $columns;
    public $delete_budget_id;

    public function render()
    {
        return view('livewire.manage.receivetransfer.receivetransfer-component');
    }

    public function submit($formData)
    {

        // dd($formData);

        foreach ($formData as $kd => $va) {

            if (!is_numeric($va))
                continue;
            $keep[] = $va;

        }

        // dd($keep);



        foreach( OoapTblFybdtransfer::wherein('id', $keep)->get() as $ka => $va )  {

// dd('ddds');
            // $va->update(['in_active'=> 1]);

            OoapTblFybdtransfer::where('id', $va->id)->delete();
            // $va->delete();
        }



        // dd($dfdf);
    }

    public function mount()
    {

        //  $fiscalyear_code = date("Y")+543;
        $this->fiscalyear_code = date("Y") + 543;

        $this->fiscalyear_list = [];

        foreach (OoapTblFybdtransfer::getDatas($id = NULL, $fiscalyear_code = NULL, true)->get() as $ka => $va) {

            $this->fiscalyear_list[$va->fiscalyear_code] = $va->fiscalyear_code;
        }
    }


}
