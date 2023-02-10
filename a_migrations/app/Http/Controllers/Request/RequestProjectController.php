<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;

use App\Models\OoapTblRequest;

class RequestProjectController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        $logs['route_name'] = 'request.projects.index';
        $logs['submenu_name'] = 'บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ';
        $logs['log_type'] = 'view';

        createLogTrans($logs);

        $this->params['columns'] = [
            ['name'=>'checkbox', 'label'=>'<input type="checkbox" name="checkedAll" id="checkedAll" />'],
            ['name'=>'DT_RowIndex', 'label'=>'ลำดับ'],
            ['name'=>'req_year', 'label'=>'ปีที่'],
            ['name'=>'req_number', 'label'=>'เลขที่คำขอ'],
            ['name'=>'name', 'label'=>'ประเภทกิจกรรม'],
            ['name'=>'division_name', 'label'=>'หน่วยงาน'],
            ['name'=>'amphur_name', 'label'=>'อำเภอ'],
            ['name'=>'tambon_name', 'label'=>'ตำบล'],
            ['name'=>'req_moo', 'label'=>'หมู่'],
            ['name'=>'req_startmonth_format', 'label'=>'ระยะเวลาดำเนินการ'],
            ['name'=>'req_numofday', 'label'=>'จำนวนวัน'],
            ['name'=>'req_numofpeople', 'label'=>'เป้าหมาย(คน)'],
            ['name'=>'req_amount_format', 'label'=>'รวมค่าใช้จ่าย'],
            ['name'=>'status_confirm', 'label'=>'สถานะใบคำขอ'],
            ['name'=>'edit', 'label'=>''],
            ['name'=>'del', 'label'=>''],
        ];

        $this->params['api'] = 'api.request.projects.list';
        $this->params['show_status'] = [1,2,3,4,5];
        $this->params['template'] = 1;

        return view('request.projects.index', $this->params );
    }

    public function destroy($id)
    {

        $datas = [
            'req_id' => $id,
            'in_active' => true,
            'req_sendappdate' => now()
        ];
        $data = OoapTblRequest::where('in_active', '=', false)->where('req_id', $id)->update($datas);

        $logs['route_name'] = 'request.projects.destroy';
        $logs['submenu_name'] = 'บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ';
        $logs['log_type'] = 'delete';

        createLogTrans($logs, $datas);

        return redirect()->back()->with('message_delete1', 'ดำเนินการ ลบข้อมูล เรียบร้อย');
    }
}
