<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SatisfactionformController extends Controller
{

    function __construct() {
        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        $logs['route_name'] = 'master.satisfactionform.index';
        $logs['submenu_name'] = 'บริหารแบบประเมินความพึงพอใจ';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        return view('master.satisfactionform.index');
    }

    public function create()
    {

        $logs['route_name'] = 'master.satisfactionform.index';
        $logs['submenu_name'] = 'บริหารแบบประเมินความพึงพอใจ';
        $logs['log_type'] = 'add';

        createLogTrans( $logs );
        return view('master.satisfactionform.create');
    }

    public function edit($satisfactionform_id)
    {

        $logs['route_name'] = 'master.satisfactionform.index';
        $logs['submenu_name'] = 'บริหารแบบประเมินความพึงพอใจ';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );
        return view('master.satisfactionform.edit', compact('satisfactionform_id'));
    }
}
