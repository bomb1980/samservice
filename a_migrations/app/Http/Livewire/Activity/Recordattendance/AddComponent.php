<?php

namespace App\Http\Livewire\Activity\Recordattendance;

use App\Models\OoapTblActivities;
use Livewire\Component;

class AddComponent extends Component
{
    public $act_id, $resultActivities;
    public $act_year, $act_number, $activity_name;
    public $activity_time_period_start, $activity_time_period_end, $collection_period_start, $collection_period_end, $plan_adjustment_period_start, $plan_adjustment_period_end, $activity_run_period_start, $activity_run_period_end, $collection_allocation_start, $collection_allocation_end;

    public function mount()
    {

        $resultActivities = OoapTblActivities::where('act_id', $this->act_id)->first();

        $this->act_year = $resultActivities->act_year ?? null;
        $this->act_number = $resultActivities->act_number ?? null;
        $this->activity_name = $resultActivities->activity_name ?? null;

        $this->activity_time_period_start = datetoview($resultActivities->activity_time_period_start) ?? null;
        $this->activity_time_period_end = datetoview($resultActivities->activity_time_period_end) ?? null;
        $this->collection_allocation_start = datetoview($resultActivities->collection_allocation_start) ?? null;
        $this->collection_allocation_end = datetoview($resultActivities->collection_allocation_end) ?? null;
        $this->collection_period_start = datetoview($resultActivities->collection_period_start) ?? null;
        $this->collection_period_end = datetoview($resultActivities->collection_period_end) ?? null;
        $this->plan_adjustment_period_start = datetoview($resultActivities->plan_adjustment_period_start) ?? null;
        $this->plan_adjustment_period_end = datetoview($resultActivities->plan_adjustment_period_end) ?? null;
        $this->activity_run_period_start = datetoview($resultActivities->activity_run_period_start) ?? null;
        $this->activity_run_period_end = datetoview($resultActivities->activity_run_period_end) ?? null;
    }

    public function render()
    {
        return view('livewire.activity.recordattendance.add-component');
    }

    public function submit()
    {
        $this->validate([
            'activity_name' => 'required|max:400',
        ], [
            'activity_name.required' => 'กรุณากรอกชื่อกิจกรรม',
            'activity_name.max' => 'ชื่อกิจกรรมมีข้อความเกินกำหนด',
        ]);

        OoapTblActivities::where('act_id', $this->act_id)->update([
            'activity_name' => $this->activity_name,
            'activity_time_period_start' => datePickerThaiToDB($this->activity_time_period_start) ?? null,
            'activity_time_period_end' => datePickerThaiToDB($this->activity_time_period_end) ?? null,
            'collection_allocation_start' => datePickerThaiToDB($this->collection_allocation_start) ?? null,
            'collection_allocation_end' => datePickerThaiToDB($this->collection_allocation_end) ?? null,
            'collection_period_start' => datePickerThaiToDB($this->collection_period_start) ?? null,
            'collection_period_end' => datePickerThaiToDB($this->collection_period_end) ?? null,
            'plan_adjustment_period_start' => datePickerThaiToDB($this->plan_adjustment_period_start) ?? null,
            'plan_adjustment_period_end' => datePickerThaiToDB($this->plan_adjustment_period_end) ?? null,
            'activity_run_period_start' => datePickerThaiToDB($this->activity_run_period_start) ?? null,
            'activity_run_period_end' => datePickerThaiToDB($this->activity_run_period_end) ?? null,
            'updated_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now()

        ]);

        return redirect()->route('activity.recordattendance.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}
