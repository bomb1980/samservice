<?php

namespace App\Http\Livewire\Activity\TranMng;

use App\Models\OoapMasDivision;
use App\Models\OoapTblActapprovelog;
use App\Models\OoapTblActivities;
use App\Models\OoapTblAllocate;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblFiscalyear;
use Livewire\Component;

class AllocateEditComponent extends Component
{
    public $dept_list, $fiscalyear_list, $budgetyear, $division_id, $allocate_id, $act_list, $act_id;
    public $allocate_training = 0, $allocate_urgent = 0, $allocate_manage = 0, $allocate_sum = 0;

    public function mount($allocate_id)
    {
        $this->allocate_id = $allocate_id;
        $allocate_data = OoapTblAllocate::find($this->allocate_id);
        $this->division_id = $allocate_data->division_id;
        $this->budgetyear = $allocate_data->budgetyear;

        $this->dept_list = OoapMasDivision::pluck('division_name', 'division_id');
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code');
        $this->act_list = OoapTblActivities::where('in_active', '=', false)->whereIn('status', [2,3,4])
            ->where('act_div', '=', $allocate_data->division_id)
            ->where('act_year', '=', $this->budgetyear)
            ->pluck('act_number', 'act_id');

        $this->allocate_training = '';
        $this->allocate_urgent = '';
        $this->allocate_manage = '';
    }
    public function render()
    {
        if ($this->allocate_training == '' && $this->allocate_urgent && $this->allocate_manage) {
            $this->allocate_sum = $this->allocate_manage + $this->allocate_urgent;
        } elseif ($this->allocate_urgent == '' && $this->allocate_manage && $this->allocate_training) {
            $this->allocate_sum = $this->allocate_manage + $this->allocate_training;
        } elseif ($this->allocate_manage == '' && $this->allocate_training && $this->allocate_urgent) {
            $this->allocate_sum = $this->allocate_urgent + $this->allocate_training;
        } elseif ($this->allocate_training == '' && $this->allocate_urgent == '' && $this->allocate_manage) {
            $this->allocate_sum = $this->allocate_manage;
        } elseif ($this->allocate_training == '' && $this->allocate_manage == '' && $this->allocate_urgent) {
            $this->allocate_sum = $this->allocate_urgent;
        } elseif ($this->allocate_manage == '' && $this->allocate_urgent == '' && $this->allocate_training) {
            $this->allocate_sum = $this->allocate_training;
        } elseif ($this->allocate_manage == '' && $this->allocate_urgent == '' && $this->allocate_training == '') {
            $this->allocate_sum = 0;
        } elseif ($this->allocate_manage && $this->allocate_urgent && $this->allocate_training) {
            $this->allocate_sum = $this->allocate_manage + $this->allocate_training + $this->allocate_urgent;
        }

        $this->emit('select2');

        return view('livewire.activity.tran-mng.allocate-edit-component');
    }

    public function setAct($val)
    {
        $this->act_id = $val;
        if ($this->act_id) {
            $act = OoapTblActivities::where('in_active', '=', false)->whereIn('status', [2,3,4])
                ->where('act_id', '=', $val)->first();
            $this->allocate_training = $act->allocate_training;
            $this->allocate_urgent = $act->allocate_urgent;
            $this->allocate_manage = $act->allocate_manage;
        } else {
            $this->allocate_training = '';
            $this->allocate_urgent = '';
            $this->allocate_manage = '';
        }

        $this->emit('select2');
    }

    public function submit()
    {
        $this->validate(
            [
                'budgetyear' => 'required',
                'act_id' => 'required',
                'allocate_urgent' => 'required',
                'allocate_training' => 'required',
                'allocate_manage' => 'required',
            ],
            [
                'budgetyear.required' => 'กรุณากรอกปีงบประมาณ',
                'act_id.required' => 'กรุณาเลือกหมายเลขคำขอ',
                'allocate_urgent.required' => 'กรุณากรอกค่ากิจกรรมจ้างงาน',
                'allocate_training.required' => 'กรุณากรอกค่ากิจกรรมอบรม',
                'allocate_manage.required' => 'กรุณากรอกค่าบริหารโครงการ',
            ]
        );

        OoapTblActivities::where('act_id', '=', $this->act_id)->update([
            'allocate_urgent' => $this->allocate_urgent,
            'allocate_training' => $this->allocate_training,
            'allocate_manage' => $this->allocate_manage,
            'status' => 3,
            'updated_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now(),
        ]);

        // $act = OoapTblActivities::where('in_active', '=', false)->where('status', '=', 3)->where('act_div', '=', $this->division_id)->where('act_year', '=', $this->budgetyear);
        // $allocate_urgent = clone $act;
        // $allocate_training = clone $act;
        // $allocate_manage = clone $act;

        $allocate_urgent = OoapTblActivities::where('in_active', '=', false)->where('status', '=', 3)->where('act_div', '=', $this->division_id)->where('act_year', '=', $this->budgetyear)->sum('allocate_urgent');
        $allocate_training = OoapTblActivities::where('in_active', '=', false)->where('status', '=', 3)->where('act_div', '=', $this->division_id)->where('act_year', '=', $this->budgetyear)->sum('allocate_training');
        $allocate_manage = OoapTblActivities::where('in_active', '=', false)->where('status', '=', 3)->where('act_div', '=', $this->division_id)->where('act_year', '=', $this->budgetyear)->sum('allocate_manage');

        OoapTblAllocate::where('id', '=', $this->allocate_id)->update([
            'budgetyear' => $this->budgetyear,
            'allocate_urgent' => $allocate_urgent,
            'allocate_training' => $allocate_training,
            'allocate_manage' => $allocate_manage,
            'updated_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now(),
        ]);

        // activity_log step
        OoapTblActapprovelog::create([
            'act_log_type' => 'APP',
            'act_ref_id' => $this->act_id,
            'act_log_date' => now(),
            'act_log_actions' => 'การจัดสรรโอนเงิน',
            'act_log_details' => 'ยืนยันการจัดสรรโอนเงิน',
            'status' => 3,
        ]);

        return redirect()->route('activity.tran_mng.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}
