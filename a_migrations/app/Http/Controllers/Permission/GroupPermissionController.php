<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;

class GroupPermissionController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    public function index()
    {
        $logs['route_name'] = 'grouppermission.index';
        $logs['submenu_name'] = 'จัดการข้อมูลกลุ่มผู้ใช้';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        return view('grouppermission.create');
    }
}
