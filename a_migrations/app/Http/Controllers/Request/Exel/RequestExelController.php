<?php

namespace App\Http\Controllers\Request\Exel;

use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;

use App\Models\OoapTblRequest;

use App\Exports\RequestedExelExport;

class RequestExelController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function export($arr)
    {
        $logs['route_name'] = 'request.exel.request2_3.index';
        $logs['submenu_name'] = 'จัดสรรงบประมาณ exel download';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        $arr = (explode("_",$arr));
        // return Excel::download(new RequestExelExport($arr), 'บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ.xlsx');

        $datas = OoapTblRequest::getExportExel($arr);

        $config = [
            'req_id' => ['label' => 'ลำดับที่'],
            'req_year' => ['label' => 'ปีที่'],
            'req_number' => ['label' => 'เลขที่คำขอ'],
            'name' => ['label' => 'ประเภทกิจกรรม'],
            'amphur_name' => ['label' => 'อำเภอ'],
            'tambon_name' => ['label' => 'ตำบล'],
            'req_moo' => ['label' => 'หมู่บ้าน'],
            'req_startmonth' => ['label' => 'ระยะเวลาดำเนินการ'],
            'req_numofday' => ['label' => 'จำนวนวัน'],
            'req_numofpeople' => ['label' => 'เป้าหมาย(คน)'],
            'req_amount' => ['label' => 'รวมค่าใช้จ่าย'],
            'status' => ['label' => 'สถานะใบคำขอ'],
        ];
        return Excel::download(new RequestedExelExport($datas, $config), 'บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ.xlsx');
    }
}
