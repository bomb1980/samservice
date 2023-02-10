<?php

namespace App\Exports;

use App\Models\OoapTblRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequestExelExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $arr;

    function __construct($arr) {
            $this->arr = $arr;
    }

    public function collection()
    {
        $data = OoapTblRequest::whereIn('req_id', $this->arr)
        ->leftjoin('ooap_mas_acttype','ooap_tbl_requests.req_acttype','ooap_mas_acttype.id')
        ->leftjoin('ooap_mas_amphur','ooap_tbl_requests.req_district','ooap_mas_amphur.amphur_id')
        ->leftjoin('ooap_mas_tambon','ooap_tbl_requests.req_subdistrict','ooap_mas_tambon.tambon_id')
        ->select(
            'ooap_tbl_requests.req_id',
            'ooap_tbl_requests.req_year',
            'ooap_tbl_requests.req_number',
            'ooap_mas_acttype.name',
            'ooap_mas_amphur.amphur_name',
            'ooap_mas_tambon.tambon_name',
            'ooap_tbl_requests.req_moo',
            'ooap_tbl_requests.req_startmonth',
            'ooap_tbl_requests.req_numofday',
            'ooap_tbl_requests.req_numofpeople',
            'ooap_tbl_requests.req_amount',
            'ooap_tbl_requests.status',
        )
        ->get();
        foreach($data as $key=>$val){
            $data[$key]->req_id = $key+1;
            $data[$key]->req_startmonth = formatDateThai($data[$key]->req_startmonth) ?? '-';
            $data[$key]->req_amount = number_format(($data[$key]->req_amount),2);
            if($val->status == 1){
                $data[$key]->status = "บันทึกแบบร่าง";
            }
            if($val->status == 2){
                $data[$key]->status = "รอพิจารณา,";
            }
            if($val->status == 3){
                $data[$key]->status = "ผ่านการพิจารณา";
            }
            if($val->status == 4){
                $data[$key]->status = "ไม่ผ่านการพิจารณา";
            }
            if($val->status == 5){
                $data[$key]->status = "ส่งคำขอกลับ";
            }
        }
        return $data;
    }

    public function headings(): array
    {
        return ["ลำดับที่", "ปีที่", "เลขที่คำขอ", "ประเภทกิจกรรม","อำเภอ", "ตำบล", "หมู่บ้าน", "ระยะเวลาดำเนินการ", "จำนวนวัน", "เป้าหมาย(คน)","รวมค่าใช้จ่าย", "สถานะใบคำขอ"];
    }
}
