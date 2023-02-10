<?php

namespace App\Http\Livewire\Activity\Operate;

use App\Models\OoapMasActtype;
use App\Models\OoapMasDivision;
use App\Models\OoapTblActivities;
use App\Models\OoapTblFiscalyear;
use Livewire\Component;

class OperateComponent extends Component
{
    public $resultAcc;
    public $fiscalyear_code, $fiscalyear_list;
    public $dept_id, $dept_list;
    public $acttype_id, $acttype_list;
    public $division_id;
    public $selectall = 0, $act_id_check;


    public function mount()
    {

        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code2');

        $this->division_id = auth()->user()->division_id;

        if (auth()->user()->province_id == null) {
            $this->dept_list = OoapMasDivision::whereNotNull('province_id')->pluck('division_name', 'division_id');
        } else {
            $this->dept_list = OoapMasDivision::where('division_id', '=', auth()->user()->division_id)->pluck('division_name', 'division_id');
            $this->dept_id = auth()->user()->division_id;
        }
        $this->acttype_list = OoapMasActtype::where('inactive', '=', false)->pluck('name', 'id');
    }

    public function render()
    {
        if ($this->selectall == 1) {
            $check_act = OoapTblActivities::where('in_active', '=', false)->where('status', '=', 3)->orWhere('status', '=', 4)->orWhere('status', '=', 5)->get()->toArray();

            foreach ($check_act as $key => $val) {
                $this->act_id_check[$key] = $this->selectall ? $val['act_id'] : 0;
            }
        } elseif ($this->selectall == 0) {
            $check_act = OoapTblActivities::where('in_active', '=', false)->where('status', '=', 3)->orWhere('status', '=', 4)->orWhere('status', '=', 5)->get()->toArray();

            foreach ($check_act as $key => $val) {
                $this->act_id_check[$key] = 0;
            }
        }

        $this->emit('emits');

        return view('livewire.activity.operate.operate-component');
    }

    public function actStart($act_id)
    {
        OoapTblActivities::where('act_id', '=', $act_id)->update([
            'status' => 5
        ]);
        return redirect()->route('operate.index')->with('act_start', 'บันทึกเริ่มกิจกรรมเรียบร้อย');
    }

    public function actEnd($act_id)
    {
        OoapTblActivities::where('act_id', '=', $act_id)->update([
            'status' => 6
        ]);
        return redirect()->route('operate.index')->with('act_end', 'บันทึกปิดกิจกรรมเรียบร้อย');
    }

    public function getCheckList($status, $act_id_list)
    {
        if(count($act_id_list)>0){

            if($status==5){
                OoapTblActivities::whereIn('act_id', $act_id_list)->where('status','!=',6)
                ->update([
                    'status' => $status,
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->emp_citizen_id
                ]);
                return redirect()->route('operate.index')->with('act_start', 'บันทึกเริ่มกิจกรรมเรียบร้อย');
            }else{

                $checkCount5 = OoapTblActivities::whereIn('act_id', $act_id_list)->where('status','=',5)->count();

                OoapTblActivities::whereIn('act_id', $act_id_list)->where('status','=',5)
                ->update([
                    'status' => $status,
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->emp_citizen_id
                ]);
                return redirect()->route('operate.index')->with('act_end', 'จำนวน '.$checkCount5.' รายการ');
            }
        }else{
            return redirect()->route('operate.index');
        }

    }
}
