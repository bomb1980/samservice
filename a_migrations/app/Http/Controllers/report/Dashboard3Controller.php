<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use App\Models\OoapMasSubmenu;
use Illuminate\Http\Request;

class Dashboard3Controller extends Controller
{

    public function __construct( Request $request )
    {
        if (!empty($request->route()->getName()))
            $this->OoapMasSubmenu = OoapMasSubmenu::getData($request->route()->getName())->first();

        $this->middleware('auth');
    }

    public function index()
    {
        return view('report.dashboard3.index');
    }

    public function report8()
    {
        $this->params['title'] = $this->OoapMasSubmenu->submenu_name;

        return view('report.report8', $this->params);
    }

    public function report9()
    {
        $this->params['title'] = $this->OoapMasSubmenu->submenu_name;

        return view('report.report9', $this->params);
    }

    public function report1()
    {
        $logs['route_name'] = 'report1';
        $logs['submenu_name'] = 'รายงานประมวลผลความพึงพอใจ';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );
        $this->params['title'] =  $this->OoapMasSubmenu->submenu_name;

        $this->params['datas'] = NULL;

        return view('report.report1', $this->params);
    }

    public function report7()
    {
        $logs['route_name'] = 'report7';
        $logs['submenu_name'] = 'report';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );
        $this->params['title'] = $this->OoapMasSubmenu->submenu_name;

        return view('report.report7', $this->params);
    }


    public function repoer6()
    {
        $logs['route_name'] = 'report6';
        $logs['submenu_name'] = 'report';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );
        $this->params['title'] = $this->OoapMasSubmenu->submenu_name;

        return view('report.dashboard6.index', $this->params);
    }

    public function report3()
    {
        $logs['route_name'] = 'report3';
        $logs['submenu_name'] = 'รายงานสรุป';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );
        return view('report.dashboard1.index');
    }

    public function report2()
    {
        $logs['route_name'] = 'report2';
        $logs['submenu_name'] = 'รายงานรูปภาพกิจกรรม';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );
        $this->params['title'] =  $this->OoapMasSubmenu->submenu_name;

        $this->params['datas'] = NULL;

        return view('report.report2', $this->params);
    }

    public function repoer4()
    {
        $logs['route_name'] = 'report4';
        $logs['submenu_name'] = 'report4';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );
        return view('report.dashboard4.index');
    }

    public function repoer5()
    {
        $logs['route_name'] = 'report5';
        $logs['submenu_name'] = 'report5';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );
        return view('report.dashboard5.index');
    }
}
