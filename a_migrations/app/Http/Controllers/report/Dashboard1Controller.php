<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;

class Dashboard1Controller extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        $logs['route_name'] = 'report.dashboard1.index';
        $logs['submenu_name'] = 'รายงานสรุป';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );
        return view('report.dashboard1.index');
    }
}
