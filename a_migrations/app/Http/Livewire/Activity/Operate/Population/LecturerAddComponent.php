<?php

namespace App\Http\Livewire\Activity\Operate\Population;

use App\Models\OoapMasActtype;
use App\Models\OoapMasLecturer;
use App\Models\OoapTblActivities;
use App\Models\OoapTblPopulation;
use Livewire\Component;

use function PHPUnit\Framework\isEmpty;

class LecturerAddComponent extends Component
{
    public $act_id, $acttype_list, $acttype_id, $act_number, $actform_no_list, $select_values_list = [];

    public function mount($act_id)
    {
        $this->act_id = $act_id;
        $data = OoapTblActivities::where('in_active', '=', false)->where('act_id', '=', $this->act_id)->first();
        if ($data) {
            $this->acttype_list = OoapMasActtype::where('inactive', '=', false)->pluck('name', 'id');
            $this->acttype_id = $data->act_acttype;
            $this->act_number = $data->act_number;
            $this->act_periodno = $data->act_periodno;
        }
    }

    public function submit()
    {
        // dd($this->select_values_list);
        $data = OoapTblPopulation::where('pop_actnumber', '=', $this->act_number)->where('pop_role', '=', 1);
        // if (isEmpty($this->select_values_list)) {
        $data->where('in_active', false)->update([
            'in_active' => 1,
            'updated_by' => auth()->user()->emp_citizen_id,
            'updated_at' => now(),
        ]);
        // }
        // $check = 0;

        foreach ($this->select_values_list as $key => $value) {
            // $check = 0;
            $datalecturer = OoapMasLecturer::where('in_active', false)->where('lecturer_id', '=', $key)->first();
            if ($datalecturer) {
                if ($this->select_values_list[$key] != null) {
                    $check = OoapTblPopulation::where('pop_actnumber', '=', $this->act_number)->where('pop_role', '=', 1)->where('pop_nationalid', '=', $datalecturer->lecturer_nationalid)->first();
                    if ($check) {
                        // dd('ki');
                        $check->update([
                            'in_active' => 0,
                            'updated_by' => auth()->user()->emp_citizen_id,
                            'updated_at' => now(),
                        ]);
                    } else {
                        // dd('ta');
                        $datainsert = OoapTblPopulation::insert([
                            'pop_actnumber' => $this->act_number,
                            'pop_year' => date("Y") + 543,
                            'pop_periodno' => $this->act_periodno,
                            'pop_div' => auth()->user()->division_id,
                            'pop_role' => 1,
                            'pop_nationalid' => $datalecturer->lecturer_nationalid,
                            'pop_firstname' => $datalecturer->lecturer_fname,
                            'pop_lastname' => $datalecturer->lecturer_lname,
                            'pop_province' => $datalecturer->province_id,
                            'pop_mobileno' => $datalecturer->lecturer_phone,
                            'pop_typelecturer' => $datalecturer->lecturer_types_id,
                            'remember_token' => csrf_token(),
                            'created_by' => auth()->user()->emp_citizen_id,
                            'created_at' => now(),
                        ]);
                    }
                }
            }
        }
        return redirect()->route('population.create_lecturer', ['act_id' => $this->act_id])->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        $this->emit('popup');
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('population.create_lecturer', ['act_id' => $this->act_id]);
    }

    public function render()
    {
        $this->emit('emits');
        return view('livewire.activity.operate.population.lecturer-add-component');
    }
}
