<?php

namespace App\Http\Controllers\activity\operate\population;

use App\Http\Controllers\Controller;
use App\Models\OoapTblPopulation;

class PopulationController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function create($act_id, $act_number, $role)
    {
        $logs['route_name'] = 'population.create';
        $logs['submenu_name'] = 'บันทึกผู้เข้าร่วมกิจกรรม(สรจ)';
        $logs['log_type'] = 'create';
        createLogTrans($logs);

        return view('activity.operate.population.create', ['act_id' => $act_id, 'act_number' => $act_number, 'role' => $role]);
    }

    public function edit($act_id, $id)
    {
        $logs['route_name'] = 'population.edit';
        $logs['submenu_name'] = 'บันทึกผู้เข้าร่วมกิจกรรม(สรจ)';
        $logs['log_type'] = 'edit';
        createLogTrans($logs);

        $OoapTblPopulation = OoapTblPopulation::where('pop_id', $id)->first();
        if($OoapTblPopulation){
            return view('activity.operate.population.edit', ['act_id' => $act_id, 'pop_id' => $id]);
        }
        return redirect()->route('activity.participant.index');
    }

    public function create_lecturer($act_id)
    {
        $logs['route_name'] = 'population.create';
        $logs['submenu_name'] = 'บันทึกผู้เข้าร่วมกิจกรรม(สรจ)';
        $logs['log_type'] = 'create';
        createLogTrans($logs);

        return view('activity.operate.population.lecturer', ['act_id' => $act_id]);
    }
}
