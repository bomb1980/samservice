<?php

namespace App\Http\Livewire\Manage\LocalMng;

use App\Models\OoapTblAllocate;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFybdtransfer;
use Livewire\Component;

class ReindexComponent extends Component
{
    public $fiscalyear_code, $fiscalyear_list, $getFiscalyear;
    public $budget_period, $budget_manage, $budget_summanage, $balance, $budget_project, $budget_summanageproject, $budget_sumpaymentproject, $budget_transferamt, $balance_region, $transfer_amt;
    public $able_2_mng, $centerbudget_amt = 0, $regionbudget_amt = 0, $ostbudget_amt = 0;

    public function mount()
    {
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)
            ->where('status', '=', 3)
            ->select('fiscalyear_code')->pluck('fiscalyear_code', 'fiscalyear_code');

        $fiscalyear_check = OoapTblFiscalyear::where('in_active', '=', false)
            ->where('status', '=', 3)->get();

        if ($fiscalyear_check != '') {
            $this->fiscalyear_code = OoapTblFiscalyear::where('in_active', '=', false)->where('status', '=', 3)->first();
            $this->fiscalyear_code = $this->fiscalyear_code->fiscalyear_code ?? null;

            $this->transfer_amt = OoapTblFybdtransfer::where('in_active', '=', false)->where('fiscalyear_code', '=', $this->fiscalyear_code)->select('transfer_amt')->sum('transfer_amt');

            $this->centerbudget_amt = OoapTblFiscalyear::select('centerbudget_amt')->where('in_active', '=', false)->where('fiscalyear_code', '=', $this->fiscalyear_code)->first();
            $this->centerbudget_amt = $this->centerbudget_amt->centerbudget_amt ?? null;
            $this->regionbudget_amt = OoapTblFiscalyear::select('regionbudget_amt')->where('in_active', '=', false)->where('fiscalyear_code', '=', $this->fiscalyear_code)->first();
            $this->regionbudget_amt = $this->regionbudget_amt->regionbudget_amt ?? null;
            $this->ostbudget_amt = OoapTblFiscalyear::select('ostbudget_amt')->where('in_active', '=', false)->where('fiscalyear_code', '=', $this->fiscalyear_code)->first();
            $this->ostbudget_amt = $this->ostbudget_amt->ostbudget_amt ?? null;
            // dd($this->regionbudget_amt);
        }
    }

    public function render()
    {
        if ($this->fiscalyear_code) {
            $this->getFiscalyear = OoapTblFiscalyear::where('in_active','=', false)
                ->where('status', '=', 3)
                ->where('fiscalyear_code', '=', $this->fiscalyear_code)->first();

            $allocate = OoapTblAllocate::where('in_active','=',false)->where('budgetyear', '=', $this->fiscalyear_code);

            $this->budget_manage = OoapTblFiscalyear::where('in_active', '=', false)
                ->where('fiscalyear_code', '=', $this->fiscalyear_code)->first();
            $this->budget_manage = $this->budget_manage->centerbudget_amt;

            $this->balance = (float) $this->budget_manage - (float) $this->getFiscalyear->sub_manage_payment_amt1;

            $this->budget_project = OoapTblFiscalyear::where('in_active', '=', false)
                ->where('fiscalyear_code', '=', $this->fiscalyear_code)->first();
            $this->budget_project = $this->budget_project->regionbudget_amt;

            $this->budget_summanageproject = clone $allocate;
            $this->budget_summanageproject = $this->budget_summanageproject->sum('allocate_manage');

            $allocate_urgent = clone $allocate;
            $allocate_urgent = $allocate_urgent->sum('allocate_urgent');
            $allocate_training = clone $allocate;
            $allocate_training = $allocate_training->sum('allocate_training');
            $this->budget_sumpaymentproject = $allocate_urgent + $allocate_training;

            $this->balance_region = (float) $this->budget_project - ((float) $this->budget_summanageproject + (float) $this->budget_sumpaymentproject);

            $this->budget_period = $this->transfer_amt - $this->budget_manage - $this->budget_project + $this->budget_transferamt;

            $this->able_2_mng = $this->budget_period + $this->balance + $this->balance_region;

            if (!$this->centerbudget_amt) {
                $this->centerbudget_amt = 0;
            }
            if (!$this->regionbudget_amt) {
                $this->regionbudget_amt = 0;
            }

            if ($this->centerbudget_amt + $this->regionbudget_amt <= $this->able_2_mng) {
                if ($this->centerbudget_amt && $this->regionbudget_amt) {
                    $this->ostbudget_amt = $this->able_2_mng - $this->centerbudget_amt - $this->regionbudget_amt;
                } elseif (!$this->centerbudget_amt && $this->regionbudget_amt) {
                    $this->ostbudget_amt = $this->able_2_mng - $this->regionbudget_amt;
                } elseif ($this->centerbudget_amt && !$this->regionbudget_amt) {
                    $this->ostbudget_amt = $this->able_2_mng - $this->centerbudget_amt;
                } elseif (!$this->centerbudget_amt && !$this->regionbudget_amt) {
                    $this->ostbudget_amt = $this->able_2_mng;
                }
            } elseif ($this->centerbudget_amt + $this->regionbudget_amt > $this->able_2_mng) {
                $this->ostbudget_amt = 0;
                if ($this->centerbudget_amt && $this->regionbudget_amt) {
                    if ($this->centerbudget_amt > $this->regionbudget_amt) {
                        $this->centerbudget_amt = $this->able_2_mng - $this->regionbudget_amt;
                    } else {
                        $this->regionbudget_amt = $this->able_2_mng - $this->centerbudget_amt;
                    }
                } elseif (!$this->centerbudget_amt && $this->regionbudget_amt) {
                    $this->regionbudget_amt = $this->able_2_mng;
                } elseif ($this->centerbudget_amt && !$this->regionbudget_amt) {
                    $this->centerbudget_amt = $this->able_2_mng;
                }
            }
        }

        $this->emit('select2');

        return view('livewire.manage.local-mng.reindex-component');
    }

    public function setYearValue($val)
    {
        $this->fiscalyear_code = $val;
        if ($this->fiscalyear_code) {
            $this->centerbudget_amt = OoapTblFiscalyear::select('centerbudget_amt')->where('in_active', '=', false)->where('fiscalyear_code', '=', $val)->first();
            $this->centerbudget_amt = $this->centerbudget_amt->centerbudget_amt;
            $this->regionbudget_amt = OoapTblFiscalyear::select('regionbudget_amt')->where('in_active', '=', false)->where('fiscalyear_code', '=', $val)->first();
            $this->regionbudget_amt = $this->regionbudget_amt->regionbudget_amt;
            $this->ostbudget_amt = OoapTblFiscalyear::select('ostbudget_amt')->where('in_active', '=', false)->where('fiscalyear_code', '=', $val)->first();
            $this->ostbudget_amt = $this->ostbudget_amt->ostbudget_amt;
        }
    }

    public function submit()
    {
        $this->validate([
            'centerbudget_amt' => 'required',
            'regionbudget_amt' => 'required',
        ], [
                'centerbudget_amt.required' => 'กรุณากรอก ยอดจัดสรรส่วนกลาง',
                'regionbudget_amt.required' => 'กรุณากรอก ยอดจัดสรรส่วนภูมิภาค',
            ]);

        OoapTblFiscalyear::where('fiscalyear_code', '=', $this->fiscalyear_code)->update([
            'transfer_amt' => $this->transfer_amt,
            'centerbudget_amt' => $this->centerbudget_amt,
            'regionbudget_amt' => $this->regionbudget_amt,
            'ostbudget_amt' => $this->ostbudget_amt,
            'updated_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now()
        ]);

        return redirect()->route('manage.local_mng.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        // return redirect()->route('manage.local_mng.edit', ['fiscalyear_code' => $this->fiscalyear_code])->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}
