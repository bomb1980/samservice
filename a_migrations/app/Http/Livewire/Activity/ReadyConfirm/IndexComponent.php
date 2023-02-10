<?php

namespace App\Http\Livewire\Activity\ReadyConfirm;

// use App\Models\OoapTblBudgetProjectplanPeriod;

use App\Models\OoapMasDivision;
use App\Models\OoapTblActapprovelog;
use App\Models\OoapTblActivities;
use App\Models\OoapTblAllocate;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblEmployee;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblReqform;
use Livewire\Component;

class IndexComponent extends Component
{
    public $periods_list, $periods, $division_id;
    public $total_amt;
    public $budgetyear_list, $budgetyear, $periodno_list = [], $periodno;
    public $actyear_list, $act_year, $act_periodno, $txt_search;

    public $fiscalyear_list, $fiscalyear_code, $btn_submit = false;

    public function mount()
    {

        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code2');

        $this->periods_list = OoapTblActivities::select('act_periodno')->where('in_active', '=', false)->groupBy('act_periodno')
            ->pluck('act_periodno', 'act_periodno');

        $this->total_amt = OoapTblReqform::where('in_active', '=', false)->where('status', '=', 3)->where('fiscalyear_code', '=', 2565)->sum('total_amt');

        $this->division_id = auth()->user()->division_id;
    }

    public function render()
    {

        if ($this->fiscalyear_code) {

            $check = OoapTblActivities::where('act_year', $this->fiscalyear_code)->where('status', 1)->first();

            if ($check) {
                $this->btn_submit = true;
            }
        }

        $this->emit('emits');

        return view('livewire.activity.ready-confirm.index-component');
    }

    public function approve($act_id)
    {
        OoapTblActivities::where('act_id', '=', $act_id)->update([
                'status' => 2
        ]);
        $division = OoapTblEmployee::where('in_active', '=', false)->where('emp_citizen_id', '=', auth()->user()->emp_citizen_id)->select('division_id')->first();
        $division_name = OoapMasDivision::where('in_active', '=', false)->where('division_id', '=', $division->division_id)->first();
        $allocate_manage = OoapTblFiscalyear::where('in_active', '=', false)->where('fiscalyear_code', '=', 2565)->select('regionbudget_amt')->first();
        $act = OoapTblActivities::where('in_active', '=', false)
        ->where('act_id', '=', $act_id);

        $sum_urgent = clone $act;
        $sum_urgent = $sum_urgent->where('act_acttype', '=', 1)->select('act_amount')->sum('act_amount');
        $count_urgent = clone $act;
        $count_urgent = $count_urgent->where('act_acttype', '=', 1)->count();
        $sum_training = clone $act;
        $sum_training = $sum_training->where('act_acttype', '=', 2)->select('act_amount')->sum('act_amount');
        $count_training = clone $act;
        $count_training = $count_training->where('act_acttype', '=', 2)->count();

        OoapTblAllocate::create([
            'budgetyear' => $act->first()->act_year,
            'periodno' => null,
            'division_id' => $division->division_id,
            'allocate_manage' => null,
            'division_name' => $division_name->division_name,
            'count_urgent' => $count_urgent,
            'count_training' => $count_training,
            'sum_urgent' => $sum_urgent,
            'sum_training' => $sum_training,
            'allocate_urgent' => null,
            'allocate_training' => null,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now(),
        ]);
        OoapTblActapprovelog::create([
            'act_log_type' => 'APP',
            'act_ref_id' => $act_id,
            'act_log_date' => now(),
            'act_log_actions' => 'การยืนยันความพร้อมคำขอรับจัดสรรงบ',
            'act_log_details' => 'ยืนยันความพร้อมคำขอรับจัดสรรงบ',
            'status' => 2,
        ]);
        return redirect()->route('activity.ready_confirm.index')->with('successapprove', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function submit()
    {
        $this->validate([
            'fiscalyear_code' => 'required',
        ], [
            'fiscalyear_code.required' => 'กรุณาเลือกปีงบประมาณ',
        ]);

        OoapTblActivities::where('act_year', $this->fiscalyear_code)->where('status', '=', 1)->update([
                'status' => 2
        ]);

        $logs['route_name'] = 'activity.ready_confirm';
        $logs['submenu_name'] = 'บันทึกยืนยันความพร้อมคำขอการจัดสรรงบ(สรจ)';
        $logs['log_type'] = 'confirm';
        createLogTrans($logs);

        $division = OoapTblEmployee::where('in_active', '=', false)->where('emp_citizen_id', '=', auth()->user()->emp_citizen_id)->select('division_id')->first();
        $division_name = OoapMasDivision::where('in_active', '=', false)->where('division_id', '=', $division->division_id)->first();
        $allocate_manage = OoapTblFiscalyear::where('in_active', '=', false)->where('fiscalyear_code', '=', 2565)->select('regionbudget_amt')->first();
        $act = OoapTblActivities::where('in_active', '=', false)
            ->where('status', '=', '2')
            ->where('act_year', '=', $this->fiscalyear_code)
            ->where('act_div', '=', $division->division_id);

        $sum_urgent = clone $act;
        $sum_urgent = $sum_urgent->where('act_acttype', '=', 1)->select('act_amount')->sum('act_amount');
        $count_urgent = clone $act;
        $count_urgent = $count_urgent->where('act_acttype', '=', 1)->count();
        $sum_training = clone $act;
        $sum_training = $sum_training->where('act_acttype', '=', 2)->select('act_amount')->sum('act_amount');
        $count_training = clone $act;
        $count_training = $count_training->where('act_acttype', '=', 2)->count();

        OoapTblAllocate::create([
            'budgetyear' => $this->fiscalyear_code,
            'periodno' => null,
            'division_id' => $division->division_id,
            'allocate_manage' => null,
            'division_name' => $division_name->division_name,
            'count_urgent' => $count_urgent,
            'count_training' => $count_training,
            'sum_urgent' => $sum_urgent,
            'sum_training' => $sum_training,
            'allocate_urgent' => null,
            'allocate_training' => null,
            'remember_token' => csrf_token(),
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now(),
        ]);

        return redirect()->route('activity.ready_confirm.index')->with('successapprove', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}
