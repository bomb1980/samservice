<?php

namespace App\Http\Livewire\Manage\FiscalyearClose;

use App\Models\OoapTblFiscalyear;
use Livewire\Component;

class SaveComponent extends Component
{
    public $fiscalyear_list, $fiscalyear_code, $total_sum, $total_sum_labour, $total_sum_train, $req_amt, $budget_amt, $refund_amt, $centerbudget_amt, $regionbudget_amt,
        $total_budget_off, $parent_datas;

    public function render()
    {
        return view('livewire.manage.fiscalyearclose.save-component');
    }

    public function mount()
    {

        if(  $this->parent_datas ) {
            $this->parent_id = $this->parent_datas->id;

            if(  $this->parent_datas->refund_amt == 0 ) {

                $this->refund_amt = $this->parent_datas->total_transfer_amt - ($this->parent_datas->total_manage_payment_amt + $this->parent_datas->urgentpayment_amt + $this->parent_datas->trainingpayment_amt );
            }
            else {


                $this->refund_amt = $this->parent_datas->refund_amt;
            }
        }
        else {

            $this->parent_id = NULL;
            $this->refund_amt = 0;
        }
    }

    public function submit()
    {
        $datas = [
            'status' => 4,
            'refund_amt' => empty($this->refund_amt)? 0: $this->refund_amt,
            'updated_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now(),
        ];

        OoapTblFiscalyear::where('id', '=', $this->parent_datas->id)->update($datas);

        $this->emit('popup');
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect( route( 'manage.fiscalyear_cls.save', ['id'=>$this->parent_id ]) );
    }

}
