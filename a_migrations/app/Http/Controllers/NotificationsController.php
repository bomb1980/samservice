<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OoapTblEmployee;

class NotificationsController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function readNoti()
    {
        OoapTblEmployee::readNoti();

        return ['success'=>1];
    }

    public function notifications()
    {

        OoapTblEmployee::readNoti();

        $this->params['columns'] = [
            ['name'=>'no', 'label'=>'ลำดับ'],
            ['name'=>'sender', 'label'=>'ผู้ส่ง'],
            ['name'=>'noti_date', 'label'=>'วันที่ เวลา'],
            ['name'=>'noti_name', 'label'=>'เรือง'],
            ['name'=>'noti_detail', 'label'=>'รายละเอียด'],
        ];

        $this->params['title'] = 'การแจ้งเตือน';
        $this->params['api'] = 'api.notifications';

        return view('history', $this->params );
    }

}
