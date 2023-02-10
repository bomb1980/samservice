<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Models\OoapTblEmployee;

class PermissionController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function create()
    {

        $logs['route_name'] = 'permission.create';
        $logs['submenu_name'] = 'เพิ่มกำหนดสิทธิ์การเข้าใช้งานระบบ';
        $logs['log_type'] = 'add';

        createLogTrans($logs);


        $this->params['dataRoleUser'] = NULL;
        $this->params['title'] = 'เพิ่มสิทธิ์การใช้งาน';

        // dd( $dataRoleUser );
        return view('permission.create', $this->params);


        // $dataRoleUser = NULL;
        // return view('permission.edit', ['dataRoleUser' => $dataRoleUser]);

    }

    public function edit($id)
    {
        $logs['route_name'] = route('permission.edit', ['id' => $id]);
        $logs['submenu_name'] = 'แก้ไขกำหนดสิทธิ์การเข้าใช้งานระบบ';
        $logs['log_type'] = 'edit';

        createLogTrans($logs);

        $logs = array(
            'log_type' => 'permission',
            'log_name' => 'แก้ไข กำหนดสิทธิ์การเข้าใช้งานระบบ',
            'data_array' => $id,
        );

        // log_save($logs);

        $dataRoleUser = OoapTblEmployee::find($id);


        $this->params['dataRoleUser'] = $dataRoleUser;
        $this->params['title'] = 'แก้ไขสิทธิ์การใช้งาน';

        // dd( $dataRoleUser );
        return view('permission.edit', $this->params);
    }

    function test($act_id, $p_id)
    {


        $url = route('activity.operate.assessment_form', ['act_id' => $act_id, 'p_id' => $p_id]);
        return view('activity.operate.assessment_form.qrcode', ['url' => $url]);
    }

    public function index()
    {
        $logs['route_name'] = 'permission.index';
        $logs['submenu_name'] = 'กำหนดสิทธิ์การเข้าใช้งานระบบ';
        $logs['log_type'] = 'view';

        createLogTrans($logs);

        $logs = array(
            'log_type' => 'permission',
            'log_name' => 'เข้าเมนู กำหนดสิทธิ์การเข้าใช้งานระบบ',
        );



        $this->params['columns'] = [
            ['name' => 'DT_RowIndex', 'label' => 'ลำดับ'],
            // ['name' => 'emp_citizen_id', 'label' => 'ยูสเซอร์'],
            ['name' => 'name_user', 'label' => 'ชื่อ-นามสกุล'],
            ['name' => 'division_name', 'label' => 'สำนัก/ศูนย์/กอง'],
            ['name' => 'dept_name_th', 'label' => 'กลุ่มงาน'],
            ['name' => 'posit_name_th', 'label' => 'ตำแหน่ง/ระดับ'],
            ['name' => 'role_name_th', 'label' => 'สิทธิ์การใช้งาน'],
            ['name' => 'edit', 'label' => 'แก้ไข'],
            ['name' => 'delete', 'label' => 'ลบ'],
        ];

        return view('permission.index', $this->params);
    }
}
