<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HistoryController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function history()
    {

        $this->params['columns'] = [
            ['name'=>'no', 'label'=>'ลำดับ'],
            ['name'=>'log_date', 'label'=>'วันที่ เวลา'],
            ['name'=>'full_name', 'label'=>'ชื่อ นามสกุล'],
            ['name'=>'ip', 'label'=>'IP'],
            ['name'=>'log_name', 'label'=>'การใช้งาน'],
        ];

        $this->params['title'] = 'ประวัติการใช้งาน';
        $this->params['api'] = 'api.history';


        return view('history', $this->params );
    }


}
