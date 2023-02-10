<?php

namespace App\Http\Controllers\Api\Request;

use App\Http\Controllers\Controller;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblReqform;
use App\Models\OoapTblRequest;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime;
use Yajra\DataTables\Facades\DataTables;


class ReqformController extends Controller
{
    public function getReqform(Request $request)
    {

        $data = OoapTblRequest::select(
            'ooap_tbl_requests.*',
            'ooap_mas_acttype.name',
            'ooap_mas_amphur.amphur_name',
            'ooap_mas_tambon.tambon_name',
        )
        ->where('ooap_tbl_requests.req_div',$request->division_id)//*** */
        ->leftjoin('ooap_mas_acttype','ooap_tbl_requests.req_acttype','ooap_mas_acttype.id')
        ->leftjoin('ooap_mas_amphur','ooap_tbl_requests.req_district','ooap_mas_amphur.amphur_id')
        ->leftjoin('ooap_mas_tambon','ooap_tbl_requests.req_subdistrict','ooap_mas_tambon.tambon_id')
        ->where('ooap_tbl_requests.in_active', '=', false);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($data) {
                $text="";
                if($data->status == 1 || $data->status == 5){
                    $text .= '<input type="checkbox" id="' . $data->req_id . '"value="'. $data->req_id .'" name="checkAll" class="checkSingle">';
                }
                else{
                    $text .= '<p>-</p>';
                }
                return $text;
            })
            ->addColumn('req_amount_format', function ($data) {
                $text = number_format(($data->req_amount),2);
                return $text;
            })
            ->addColumn('req_startmonth_format', function ($data) {
                $text = onlyMonthThai($data->req_startmonth) . ' - ' . onlyMonthThai($data->req_endmonth);
                return $text;
            })
            ->addColumn('status_confirm', function ($data) use ($request) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                    if($data->status == 1){
                        $button .= '<span class="text-primary">บันทึกแบบร่าง</span>';
                    }else if($data->status == 2){
                        $button .= '<span class="text-warning">รอพิจารณา</span>';
                    }else if($data->status == 3){
                        $button .= '<span class="text-success">ผ่านการพิจารณา</span>';
                    }else if($data->status == 4){
                        $button .= '<span class="text-ddanger">ไม่ผ่านการพิจารณา</span>';
                    }else if($data->status == 5){
                        $button .= '<span class="text-primary">ส่งคำขอกลับ</span>';
                    }
                $button .= '</div>';
                return $button;
            })
            ->addColumn('edit', function ($data) {
                $button = '';
                if($data->status == 1){


                    if( $data->req_enddate < now() ) {

                        $button = '';

                    }
                    else {


                    }
                    if($data->req_acttype == 1){
                        $button .= '<a href="/request/request2_1/' . $data->req_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                    }else{
                        $button .= '<a href="/request/request2_2/' . $data->req_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                    }
                }else{
                    if($data->req_acttype == 1){
                        $button .= '<a href="/request/request2_1/' . $data->req_id . '/edit"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    }else{
                        $button .= '<a href="/request/request2_2/' . $data->req_id . '/edit"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    }

                }
                return '<div class="icondemo vertical-align-middle p-2">'. $button .'</div>';

            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->req_id . ')" title="ลบ"></button>';

                $button .= '</div>';
                return $button;
            })
            ->rawColumns([
                'status_confirm',
                'edit',
                'checkbox',
                'del'
            ])
            ->make(true);
    }

    public function getReqform_seperate(Request $request){
        return OoapTblReqform::select('reqform_id')
            ->addSelect(['col1' => function ($data) use ($request) {
                $data->selectRaw('SUM(total_amt)')
                ->from('ooap_tbl_reqform')
                ->where('status','=', 1)
                ->where('fiscalyear_code','=', 2565)
                ->where('in_active','=', false);

                if($request->acttype_id){
                    $data = $data->where('ooap_tbl_reqform.acttype_id','=', $request->acttype_id);
                }

                if($request->dept_id){
                    $data = $data->where('ooap_tbl_reqform.dept_id','=', $request->dept_id);
                }

                if($request->fiscalyear_code){
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code','=', $request->fiscalyear_code);
                }

                $data = $data->groupBy('status');

            }])->addSelect(['col2' => function ($data) use ($request) {
                $data->selectRaw('count(*)')
                ->from('ooap_tbl_reqform')
                ->where('status','=', 1)
                ->where('in_active','=', false)
                ->groupBy('status');

                if($request->acttype_id){
                    $data = $data->where('ooap_tbl_reqform.acttype_id','=', $request->acttype_id);
                }

                if($request->dept_id){
                    $data = $data->where('ooap_tbl_reqform.dept_id','=', $request->dept_id);
                }

                if($request->fiscalyear_code){
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code','=', $request->fiscalyear_code);
                }

            }])
            ->addSelect(['col3' => function ($data) use ($request) {
                $data->selectRaw('SUM(total_amt)')
                ->from('ooap_tbl_reqform')
                ->where('status','=', 2)
                ->where('in_active','=', false)
                ->groupBy('status');

                if($request->acttype_id){
                    $data = $data->where('ooap_tbl_reqform.acttype_id','=', $request->acttype_id);
                }

                if($request->dept_id){
                    $data = $data->where('ooap_tbl_reqform.dept_id','=', $request->dept_id);
                }

                if($request->fiscalyear_code){
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code','=', $request->fiscalyear_code);
                }

            }])->addSelect(['col4' => function ($data) use ($request) {
                $data->selectRaw('count(*)')
                ->from('ooap_tbl_reqform')
                ->where('status','=', 2)
                ->where('in_active','=', false)
                ->groupBy('status');

                if($request->acttype_id){
                    $data = $data->where('ooap_tbl_reqform.acttype_id','=', $request->acttype_id);
                }

                if($request->dept_id){
                    $data = $data->where('ooap_tbl_reqform.dept_id','=', $request->dept_id);
                }

                if($request->fiscalyear_code){
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code','=', $request->fiscalyear_code);
                }

            }])
            ->addSelect(['col5' => function ($data) use ($request) {
                $data->selectRaw('SUM(total_amt)')
                ->from('ooap_tbl_reqform')
                ->where('status','=', 3)
                ->where('in_active','=', false)
                ->groupBy('status');

                if($request->acttype_id){
                    $data = $data->where('ooap_tbl_reqform.acttype_id','=', $request->acttype_id);
                }

                if($request->dept_id){
                    $data = $data->where('ooap_tbl_reqform.dept_id','=', $request->dept_id);
                }

                if($request->fiscalyear_code){
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code','=', $request->fiscalyear_code);
                }

            }])->addSelect(['col6' => function ($data) use ($request) {
                $data->selectRaw('count(*)')
                ->from('ooap_tbl_reqform')
                ->where('status','=', 3)
                ->where('in_active','=', false)
                ->groupBy('status');

                if($request->acttype_id){
                    $data = $data->where('ooap_tbl_reqform.acttype_id','=', $request->acttype_id);
                }

                if($request->dept_id){
                    $data = $data->where('ooap_tbl_reqform.dept_id','=', $request->dept_id);
                }

                if($request->fiscalyear_code){
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code','=', $request->fiscalyear_code);
                }

            }])
            ->addSelect(['col7' => function ($data) use ($request) {
                $data->selectRaw('SUM(total_amt)')
                ->from('ooap_tbl_reqform')
                ->where('status','=', 4)
                ->where('in_active','=', false)
                ->groupBy('status');

                if($request->acttype_id){
                    $data = $data->where('ooap_tbl_reqform.acttype_id','=', $request->acttype_id);
                }

                if($request->dept_id){
                    $data = $data->where('ooap_tbl_reqform.dept_id','=', $request->dept_id);
                }

                if($request->fiscalyear_code){
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code','=', $request->fiscalyear_code);
                }

            }])->addSelect(['col8' => function ($data) use ($request) {
                $data->selectRaw('count(*)')
                ->from('ooap_tbl_reqform')
                ->where('status','=', 4)
                ->where('in_active','=', false)
                ->groupBy('status');

                if($request->acttype_id){
                    $data = $data->where('ooap_tbl_reqform.acttype_id','=', $request->acttype_id);
                }

                if($request->dept_id){
                    $data = $data->where('ooap_tbl_reqform.dept_id','=', $request->dept_id);
                }

                if($request->fiscalyear_code){
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code','=', $request->fiscalyear_code);
                }

            }])
            ->addSelect(['col9' => function ($data) use ($request) {
                $data->selectRaw('SUM(total_amt)')
                ->from('ooap_tbl_reqform')
                ->where('status','=', 9)
                // ->where('fiscalyear_code', 2565)
                ->where('in_active','=', false)
                ->groupBy('status');

                if($request->acttype_id){
                    $data = $data->where('ooap_tbl_reqform.acttype_id','=', $request->acttype_id);
                }

                if($request->dept_id){
                    $data = $data->where('ooap_tbl_reqform.dept_id','=', $request->dept_id);
                }

                if($request->fiscalyear_code){
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code','=', $request->fiscalyear_code);
                }

            }])->addSelect(['col10' => function ($data) use ($request) {
                $data->selectRaw('count(*)')
                ->from('ooap_tbl_reqform')
                ->where('status','=', 9)
                // ->where('fiscalyear_code', 2565)
                ->where('in_active','=', false)
                ->groupBy('status');

                if($request->acttype_id){
                    $data = $data->where('ooap_tbl_reqform.acttype_id','=', $request->acttype_id);
                }

                if($request->dept_id){
                    $data = $data->where('ooap_tbl_reqform.dept_id','=', $request->dept_id);
                }

                if($request->fiscalyear_code){
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code','=', $request->fiscalyear_code);
                }

            }])
            ->addSelect(['col11' => function ($data) use ($request) {
                $data->selectRaw('SUM(total_amt)')
                ->from('ooap_tbl_reqform')
                ->whereIn('status', [1,2,3,4])
                // ->where('fiscalyear_code', 2565)
                ->where('in_active','=', false);

                if($request->acttype_id){
                    $data = $data->where('ooap_tbl_reqform.acttype_id','=', $request->acttype_id);
                }

                if($request->dept_id){
                    $data = $data->where('ooap_tbl_reqform.dept_id','=', $request->dept_id);
                }

                if($request->fiscalyear_code){
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code','=', $request->fiscalyear_code);
                }

            }])->addSelect(['col12' => function ($data) use ($request) {
                $data->selectRaw('count(*)')
                ->from('ooap_tbl_reqform')
                ->whereIn('status', [1,2,3,4])
                // ->where('fiscalyear_code', 2565)
                ->where('in_active','=', false);

                if($request->acttype_id){
                    $data = $data->where('ooap_tbl_reqform.acttype_id','=', $request->acttype_id);
                }

                if($request->dept_id){
                    $data = $data->where('ooap_tbl_reqform.dept_id','=', $request->dept_id);
                }

                if($request->fiscalyear_code){
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code','=', $request->fiscalyear_code);
                }

            }])
            ->first();
    }
    public function getReqformYearsNoti(Request $request)
    {
        // $fiscalyear_code = $request->fiscalyear_code ?? date("Y")+543;
        $fiscalyear_code = date("Y")+543;
        $st = OoapTblFiscalyear::select(['req_startdate'])->where('fiscalyear_code','=', $fiscalyear_code)->first()->req_startdate;
        $en = OoapTblFiscalyear::select(['req_enddate'])->where('fiscalyear_code','=', $fiscalyear_code)->first()->req_enddate;

        $date1=date_create($st);
        $date2=date_create($en);
        $now = new DateTime();

        $diff1=date_diff($date1,$date2);
        $diff_all = $diff1->format("%a") ?? 0;

        $diff2=date_diff($now,$date2);
        $diff_now = $diff2->format('%a') ?? 0;

        $per = ($diff_now/$diff_all)*100 ?? 0;

        if($per <= 15){
            $alert = '#dc3545';
        }else if($per <= 30){
            $alert = '#ffc107';
        }else{
            $alert = '#28a745';
        }

        return $arr = ['st' => datetoview($st), 'en' => datetoview($en), 'amount' => $diff_all, 'diff' => $diff_now, 'per' => $per, 'alert' => $alert];
    }
}
