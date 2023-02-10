<?php

namespace App\Http\Livewire\Manage\LocalMng;

use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblAllocate;
use App\Models\OoapMasDivision;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditComponent extends Component
{
    public $fiscalyear_code, $fiscalyear_list, $getFiscalyear;
    public $budget_period, $budget_manage, $budget_summanage, $balance, $budget_project, $budget_summanageproject, $budget_sumpaymentproject, $budget_transferamt, $balance_region;
    public $able_2_mng, $centerbudget_amt = 0, $regionbudget_amt = 0, $ostbudget_amt = 0;

    public function mount($fiscalyear_code)
    {
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)
            ->where('status', '=', 3)
            ->select('fiscalyear_code')->pluck('fiscalyear_code', 'fiscalyear_code');

        $this->fiscalyear_code = $fiscalyear_code;

        $mountFiscal = OoapTblFiscalyear::where('in_active','=',false)->where('fiscalyear_code','=',$fiscalyear_code)->first();

        $this->centerbudget_amt = $mountFiscal->centerbudget_amt;
        $this->regionbudget_amt = $mountFiscal->regionbudget_amt;
        $this->ostbudget_amt = $mountFiscal->ostbudget_amt;
    }

    public function render()
    {
        if ($this->fiscalyear_code) {
            $this->getFiscalyear = OoapTblFiscalyear::where('in_active', '=', false)
                ->where('fiscalyear_code', '=', $this->fiscalyear_code)->first();

            $getBudgetProjectplan = OoapTblBudgetProjectplanPeriod::where('in_active', '=', false)
                ->where('budgetyear', '=', $this->fiscalyear_code);

            $this->budget_manage = OoapTblFiscalyear::where('in_active', '=', false)
            ->where('fiscalyear_code', '=', $this->fiscalyear_code)->first();
            $this->budget_manage = $this->budget_manage->centerbudget_amt;

            $this->balance = (float) $this->budget_manage - (float) $this->budget_summanage;

            $this->budget_project = OoapTblFiscalyear::where('in_active', '=', false)
            ->where('fiscalyear_code', '=', $this->fiscalyear_code)->first();
            $this->budget_project = $this->budget_project->regionbudget_amt;

            $this->budget_summanageproject = clone $getBudgetProjectplan;
            $this->budget_summanageproject = $this->budget_summanageproject->select('budget_summanageproject')->sum('budget_summanageproject');

            $this->budget_sumpaymentproject = clone $getBudgetProjectplan;
            $this->budget_sumpaymentproject = $this->budget_sumpaymentproject->select('budget_summanageproject')->sum('budget_summanageproject');

            $this->balance_region = (float) $this->budget_project - ((float) $this->budget_summanageproject + (float) $this->budget_sumpaymentproject);

            $this->budget_period = $this->getFiscalyear->transfer_amt - $this->budget_manage - $this->budget_project + $this->budget_transferamt;

            $this->able_2_mng = $this->budget_period + $this->balance + $this->balance_region;

            if(!$this->centerbudget_amt) {
                $this->centerbudget_amt = 0;
            }
            if(!$this->regionbudget_amt) {
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
            }
            elseif ($this->centerbudget_amt + $this->regionbudget_amt > $this->able_2_mng) {
                $this->ostbudget_amt = 0;
                if ($this->centerbudget_amt && $this->regionbudget_amt) {
                    if ($this->centerbudget_amt > $this->regionbudget_amt) {
                        $this->centerbudget_amt = $this->able_2_mng - $this->regionbudget_amt;
                    }
                    else {
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

        return view('livewire.manage.local-mng.edit-component');
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
            'centerbudget_amt' => $this->centerbudget_amt,
            'regionbudget_amt' => $this->regionbudget_amt,
            'ostbudget_amt' => $this->ostbudget_amt,
            'updated_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now()
        ]);

        return redirect()->route('manage.local_mng.edit',['fiscalyear_code' => $this->fiscalyear_code])->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}
