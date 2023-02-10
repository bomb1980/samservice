<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\OoapTblRequest;

class RequestConsiderController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }


    public function index()
    {

        if (1) {
            $logs['route_name'] = 'request.consider.index';
            $logs['submenu_name'] = 'บันทึกผลการพิจารณาคำขอรับการจัดสรรงบประมาณ';
            $logs['log_type'] = 'view';

            createLogTrans($logs);
            $this->params['columns'] = [
                ['name' => 'DT_RowIndex', 'label' => 'ลำดับ'],
                ['name' => 'req_year', 'label' => 'ปีที่'],
                ['name' => 'req_number', 'label' => 'เลขที่คำขอ'],
                ['name' => 'name', 'label' => 'ประเภทกิจกรรม'],
                ['name' => 'division_name', 'label' => 'หน่วยงาน'],
                ['name' => 'amphur_name', 'label' => 'อำเภอ'],
                ['name' => 'tambon_name', 'label' => 'ตำบล'],
                ['name' => 'req_moo', 'label' => 'หมู่'],
                ['name' => 'req_startmonth_format', 'label' => 'ระยะเวลาดำเนินการ'],
                ['name' => 'req_numofday', 'label' => 'จำนวนวัน'],
                ['name' => 'req_numofpeople', 'label' => 'เป้าหมาย(คน)'],
                ['name' => 'req_amount_format', 'label' => 'รวมค่าใช้จ่าย'],
                ['name' => 'status_confirm', 'label' => 'สถานะใบคำขอ'],
                ['name' => 'edit', 'label' => ''],
            ];

            $this->params['api'] = 'api.request.consider.list';
            $this->params['show_status'] = [2, 3, 4, 5];
            $this->params['template'] = 2;


            return view('request.projects.index', $this->params);
        }


        $logs['route_name'] = 'request.consider.index';
        $logs['submenu_name'] = 'บันทึกผลการพิจารณาคำขอรับการจัดสรรงบประมาณ';
        $logs['log_type'] = 'view';

        createLogTrans($logs);

        return view('request.consider.index');
    }



    public function detail($acttype_id, $id)
    {

        $OoapTblReqform = OoapTblRequest::where('req_id', $id)->first();
        if ($OoapTblReqform) {
            $pullreqform = OoapTblRequest::find($id);

            $logs['route_name'] = route('request.consider.detail', ['acttype_id' => $acttype_id, 'id' => $id]);
            $logs['submenu_name'] = 'ดูลายละเอียดบันทึกผลการพิจารณาคำขอรับการจัดสรรงบประมาณ';
            $logs['log_type'] = 'view';

            createLogTrans($logs);
            return view('request.consider.detail', ['acttype_id' => $acttype_id, 'pullreqform' => $pullreqform]);
        } else {
            return redirect()->route('request.consider.index');
        }
    }
}
