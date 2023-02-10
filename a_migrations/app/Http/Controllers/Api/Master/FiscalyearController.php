<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapLogTransModel;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFybdtransfer;
use App\Models\OoapTblReqform;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FiscalyearController extends Controller
{

    public function getFiscalyear(Request $request)
    {

        $data = OoapTblFiscalyear::getDatas($id = NULL, $fiscalyear_code = NULL, $payment_group = NULL );

        $this->no = 0;
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('total_transfer_amt', function ($data) {

                return number_format( $data->transfer_amt, 2);
            })
            ->addColumn('refund_amt', function ($data) {
                return number_format( $data->refund_amt , 2);
            })
            ->addColumn('sum_transfer_amt', function ($data) {

                $result_transfer_amt = OoapTblFybdtransfer::select('transfer_amt')
                    ->where('fiscalyear_code', '=', $data->fiscalyear_code)
                    ->sum('transfer_amt');

                return number_format($result_transfer_amt, 2);
            })
            ->addColumn('stil_amt', function ($data) {
                return number_format($data->total_transfer_amt - ($data->total_manage_payment_amt + $data->urgentpayment_amt + $data->trainingpayment_amt), 2);
            })
            ->addColumn('regionbudget_balance', function ($data) {
                return number_format($data->regionbudget_amt - $data->sub_manage_payment_amt2, 2);
            })
            ->addColumn('regionbudget_amt', function ($data) {
                return number_format( $data->regionbudget_amt, 2);
            })
            ->addColumn('centerbudget_amt', function ($data) {
                $text = number_format($data->centerbudget_amt, 2);
                return $text;
            })
            ->addColumn('budget_amt', function ($data) {
                return number_format($data->budget_amt, 2);
            })
            ->addColumn('del', function ($data) use ($request) {

                return '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->id . ')" title="ลบ"></button>
                <form action="' . route('master.fiscalyear.destroy', ['id' => $data->id]) . '" id="delete_form' . $data->id . '" method="post"> <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
            })
            ->addColumn('buttons', function ($data) {


                // if (!empty($data->refund_amt))
                //     return NULL;
                if ($data->status == 4) {

                    $button = '<a href="' . route('manage.fiscalyear_cls.save', ['id' => $data->id]) . '" class="btn btn-pure" >ปิดงบ</a>';
                } else {

                    $button = '<a href="' . route('manage.fiscalyear_cls.save', ['id' => $data->id]) . '" class="btn btn-pure" >บันทึกปิดงบ</a>';
                }

                return $button;
            })
            ->addColumn('no', function ($data) {
                return ++$this->no;
            })
            ->addColumn('regionperiod_amt', function ($data) {
                return number_format($data->regionperiod_amt, 2);
            })
            ->addColumn('regionpay_amt', function ($data) {
                return number_format($data->regionpay_amt, 2);
            })

            ->addColumn('sum_pay_amt', function ($data) {
                return number_format($data->centerpayment_amt, 2);
                // return 123456789;
            })
            ->addColumn('centerbudget_balance', function ($data) {
                $text = number_format(($data->centerbudget_amt) - ($data->centerpayment_amt), 2);
                return $text;
            })
            ->addColumn('fiscalyear_code', function ($data) {
                $text = $data->fiscalyear_code;
                return $text;
            })
            ->addColumn('sum_total_amt', function ($data) {


                return  number_format($data->req_sumreqamt, 2);
            })
            ->addColumn('req_amt', function ($data) {
                $text = number_format($data->req_amt, 2);
                return $text;
            })
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href="fiscalyear/' . $data->id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['id', 'fiscalyear_code', 'sum_period_amt','total_transfer_amt', 'edit', 'del', 'buttons'])
            ->make(true);
    }



    public function history(Request $request)
    {

        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $draw = $request->get('draw');
        // dd($start);
        $datas = OoapLogTransModel::getDatas();

        $totalRecords = $datas->count();


        $datas = $datas->skip($start)->take($rowperpage)->orderby('created_at', 'DESC')->get();


        $i = $start;
        foreach ($datas as $kd => $vd) {

            $vd->log_date = datetimeToThaiDatetime($vd->log_date);

            $vd->no = ++$i;
        }

        return array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" =>  $datas,
        );
    }


    public function rec(Request $request)
    {
        $data = OoapTblFiscalyear::getDatas()->where('req_sumreqamt', '>', 0);

        $this->no = 0;
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('no', function ($data) {

                return ++$this->no;
            })
            ->addColumn('edit', function ($data) {

                return '<div class="icondemo vertical-align-middle p-2"><a href="' . route('request.sum_list.save', ['id' => $data->id]) . '"> บันทึกงบ</a></div>';

            })
            ->addColumn('status', function ($data) {
                return  getFiscalyearStatus($data->status);
            })
            ->addColumn('req_urgentamt', function ($data) {
                return number_format($data->req_urgentamt, 2);
            })
            ->addColumn('req_skillamt', function ($data) {
                return number_format($data->req_skillamt, 2);
            })
            ->addColumn('req_sumreqamt', function ($data) {
                return number_format($data->req_sumreqamt, 2);
            })
            ->addColumn('regionperiod_amt', function ($data) {
                return number_format($data->regionperiod_amt, 2);
            })
            ->addColumn('regionpay_amt', function ($data) {
                return number_format($data->regionpay_amt, 2);
            })
            ->addColumn('regionbudget_balance', function ($data) {
                return number_format($data->regionperiod_amt - $data->regionpay_amt, 2);
            })
            ->addColumn('sum_pay_amt', function ($data) {
                return number_format($data->centerpayment_amt, 2);
            })
            ->addColumn('refund_amt', function ($data) {
                return  number_format(($data->refund_amt), 2);
            })
            ->addColumn('fiscalyear_code', function ($data) {
                return $data->fiscalyear_code;
            })
            ->addColumn('sum_total_amt', function ($data) {

                $result_total_amt = OoapTblReqform::select('total_amt')
                    ->where('fiscalyear_code', '=', $data->fiscalyear_code)
                    ->where('status', '=', 3)
                    ->sum('total_amt');

                return  number_format($result_total_amt, 2);
            })
            ->addColumn('req_amt', function ($data) {
                $text = number_format($data->req_amt, 2);
                return $text;
            })
            ->addColumn('budget_amt', function ($data) {
                $text = number_format($data->total_transfer_amt, 2);
                return $text;
            })
            ->addColumn('sum_transfer_amt', function ($data) {

                $result_transfer_amt = OoapTblFybdtransfer::select('transfer_amt')
                    ->where('fiscalyear_code', '=', $data->fiscalyear_code)
                    ->sum('transfer_amt');

                return number_format($result_transfer_amt, 2);
            })
            ->addColumn('centerbudget_amt', function ($data) {
                $text = number_format($data->centerbudget_amt, 2);
                return $text;
            })


            ->addColumn('regionbudget_amt', function ($data) {
                $text = number_format($data->regionbudget_amt, 2);
                return $text;
            })

            ->addColumn('req_enddate', function ($data) {
                $text = formatDateThai($data->req_enddate);
                return $text;
            })

            ->addColumn('del', function ($data) use ($request) {
                $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->id . ')" title="ลบ"></button>';
                $button .= '<form action="/master/fiscalyear/' . $data->id . '" id="delete_form' . $data->id . '" method="post">
                    <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                return $button;
            })
            // ->rawColumns(['startdate_view','enddate_view','edit', 'del'])
            ->rawColumns(['id', 'fiscalyear_code', 'sum_period_amt', 'req_enddate', 'edit', 'del'])
            ->make(true);
    }
}
