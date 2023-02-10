<?php

namespace App\Http\Controllers\Manage\local_mng;

use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Http\Controllers\Controller;

class LocalMngController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    public function index()
    {
        $logs['route_name'] = 'manage.local_mng.index';
        $logs['submenu_name'] = 'จัดสรรงบประมาณ';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );
        return view('manage.local_mng.index');
    }
    public function edit($fiscalyear_code)
    {
        $logs['route_name'] = 'manage.local_mng.index';
        $logs['submenu_name'] = 'จัดสรรงบประมาณ';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );
        // $data = OoapTblBudgetProjectplanPeriod::where('budget_id', '=', $project_plan_id)->first();
        return view('manage.local_mng.edit', ["fiscalyear_code" => $fiscalyear_code]);
    }

    public function tranback()
    {
        return view('manage.local_mng.tranbackcen');
    }
}
