<?php

namespace App\Http\Livewire\Activity\TranMng;

use App\Models\OoapMasDivision;
use App\Models\OoapTblActivities;
use App\Models\OoapTblAllocate;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblFiscalyear;
use App\Models\UmMasDepartment;
use Livewire\Component;

class AllocateComponent extends Component
{
    public $dept_list, $fiscalyear_list, $budgetyear, $division_id, $allocate_id, $period_list, $periodno;
    public $allocate_training, $allocate_urgent, $allocate_manage, $allocate_sum;

    public function mount($division_id)
    {
        // $this->allocate_id = $allocate_id;
        // $allocate_data = OoapTblAllocate::find($this->allocate_id);
        $this->division_id = $division_id;
        // $this->budgetyear = $budgetyear;

        $this->dept_list = OoapMasDivision::pluck('division_name', 'division_id');
        $this->fiscalyear_list = OoapTblBudgetProjectplanPeriod::where('in_active', '=', false)->pluck('budgetyear', 'budgetyear');

        $this->allocate_training = '';
        $this->allocate_urgent = '';
        $this->allocate_manage = '';
        $this->allocate_sum = 0;
    }

    public function render()
    {
        $this->period_list = OoapTblBudgetProjectplanPeriod::select('periodno')
        ->where('budgetyear','=',$this->budgetyear)
        ->where('in_active', '=', false)->groupBy('periodno')->pluck('periodno', 'periodno');

        if($this->allocate_training == '' && $this->allocate_urgent && $this->allocate_manage)
        {
            $this->allocate_sum = $this->allocate_manage + $this->allocate_urgent;
        }
        elseif($this->allocate_urgent == '' && $this->allocate_manage && $this->allocate_training)
        {
            $this->allocate_sum = $this->allocate_manage + $this->allocate_training;
        }
        elseif($this->allocate_manage == '' && $this->allocate_training && $this->allocate_urgent)
        {
            $this->allocate_sum = $this->allocate_urgent + $this->allocate_training;
        }
        elseif($this->allocate_training == '' && $this->allocate_urgent == '' && $this->allocate_manage)
        {
            $this->allocate_sum = $this->allocate_manage;
        }
        elseif($this->allocate_training == '' && $this->allocate_manage == '' && $this->allocate_urgent)
        {
            $this->allocate_sum = $this->allocate_urgent;
        }
        elseif($this->allocate_manage == '' && $this->allocate_urgent == '' && $this->allocate_training)
        {
            $this->allocate_sum = $this->allocate_training;
        }
        elseif($this->allocate_manage == '' && $this->allocate_urgent == '' && $this->allocate_training == '')
        {
            $this->allocate_sum = 0;
        }
        elseif($this->allocate_manage && $this->allocate_urgent && $this->allocate_training)
        {
            $this->allocate_sum = $this->allocate_manage + $this->allocate_training + $this->allocate_urgent;
        }

        return view('livewire.activity.tran-mng.allocate-component');
    }

    public function submit()
    {
        $this->validate([
            'budgetyear' => 'required',
            'periodno' => 'required',
            'allocate_urgent' => 'required',
            'allocate_training' => 'required',
            'allocate_manage' => 'required',
        ], [
                'budgetyear.required' => 'กรุณากรอกปีงบประมาณ',
                'periodno.required' => 'กรุณากรอกงวด',
                'allocate_urgent.required' => 'กรุณากรอกค่ากิจกรรมจ้างงาน',
                'allocate_training.required' => 'กรุณากรอกค่ากิจกรรมอบรม',
                'allocate_manage.required' => 'กรุณากรอกค่าบริหารโครงการ',
            ]);
        OoapTblAllocate::create([
            'budgetyear' => $this->budgetyear,
            'periodno' => $this->periodno,
            'division_id' => $this->division_id,
            'allocate_urgent' => $this->allocate_urgent,
            'allocate_training' => $this->allocate_training,
            'allocate_manage' => $this->allocate_manage,
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now(),
        ]);

        $this->emit('popup');
    }
    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('activity.tran_mng.index');
    }
}
