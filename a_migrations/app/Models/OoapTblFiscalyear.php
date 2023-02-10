<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ooap_tbl_fiscalyear_model
class OoapTblFiscalyear extends Model
{

    protected $table = 'ooap_tbl_fiscalyear';

    protected $primaryKey = 'id';


    protected $fillable = [
         'refund_amt', 'startdate', 'enddate', 'req_status', 'fiscalyear_code', 'req_sumreqamt', 'req_amt', 'budget_amt', 'sub_manage_payment_amt1', 'sub_manage_payment_amt2', 'total_manage_payment_amt', 'urgentpayment_amt', 'trainingpayment_amt', 'total_payment_amt', 'centerpayment_amt', 'req_startdate', 'req_enddate', 'status', 'req_urgentamt', 'req_skillamt', 'transfer_amt', 'regionperiod_amt', 'regionpay_amt', 'ostbudget_amt', 'centerbudget_amt', 'regionbudget_amt', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    static function updateTblFiscalyear()
    {

        //คำนวณเก็บเรืองร้องขอ
        self::whereRaw('1=1')->update([
            'req_urgentamt' => 0,
            'req_skillamt' => 0,
            'req_sumreqamt' => 0,

        ]);

        foreach ( OoapTblRequest::getDatas()->get() as $kd => $vd) {

            self::where('fiscalyear_code', '=', $vd->req_year)
                ->update([
                    'req_urgentamt' => $vd->total_req_urgentamt,
                    'req_skillamt' => $vd->total_req_skillamt,
                    'req_sumreqamt' => $vd->total_req_sumreqamt,

                ]);
        }

        //คำนวณ เงินค่าใช้จ่าย
        self::whereRaw('1=1')->update([
            'sub_manage_payment_amt1' => 0,
            'sub_manage_payment_amt2' => 0,
            'total_manage_payment_amt' => 0,
            'urgentpayment_amt' => 0,
            'trainingpayment_amt' => 0,
            'total_payment_amt' => 0,

        ]);


        foreach ( OoapTblFybdpayment::getTotalsByYear() as $kd => $vd) {

            $sub_manage_payment_amt1 = $vd->sub_manage_payment_amt1;

            $sub_manage_payment_amt2 = $vd->sub_manage_payment_amt2;

            $total_manage_payment_amt = ($sub_manage_payment_amt1 + $sub_manage_payment_amt2);

            $urgentpayment_amt = $vd->urgentpayment_amt;

            $trainingpayment_amt = $vd->trainingpayment_amt;

            self::where('fiscalyear_code', '=', $vd->fiscalyear_code)
                ->update([
                    'sub_manage_payment_amt1' => $sub_manage_payment_amt1,
                    'sub_manage_payment_amt2' => $sub_manage_payment_amt2,
                    'total_manage_payment_amt' => $total_manage_payment_amt,
                    'urgentpayment_amt' => ($urgentpayment_amt),
                    'trainingpayment_amt' => ($trainingpayment_amt),
                    'total_payment_amt' => ($total_manage_payment_amt + $urgentpayment_amt + $trainingpayment_amt),

                ]);
        }


        //คำนวณ เงินรับโอน
        self::whereRaw('1=1')->update([
            'transfer_amt' => 0,

        ]);

        foreach ( OoapTblFybdtransfer::getTotalByYears()->get() as $ka => $va) {

            self::where('fiscalyear_code', '=', $va->fiscalyear_code)->update([
                'transfer_amt' => $va->total_transfer_amt,

            ]);
        }
    }

    static function getDatas($id = NULL, $fiscalyear_code = NULL, $payment_group = NULL )
    {
        self::updateTblFiscalyear();

        $data = self::selectraw("
            ooap_tbl_fiscalyear.*,
            transfer_amt as total_transfer_amt

        ")->where('in_active', '=', false);

        if (!empty($fiscalyear_code)) {
            $data = $data->where('fiscalyear_code', '=', $fiscalyear_code);
        }

        if (!empty($id)) {
            $data = $data->where('id', '=', $id);
        }

        if (!empty($payment_group)) {

            if( $payment_group == 1 ) {

                $data = $data->where('centerbudget_amt', '>', 0);
            }
            else {
                $data = $data->where('regionbudget_amt', '>', 0);
            }
        }

        return $data->orderBy('fiscalyear_code', 'desc');
    }



    static function getBudgetAmtYear($id = NULL)
    {
        self::updateTblFiscalyear();

        $data = self::selectraw("ooap_tbl_fiscalyear.*")->where('req_amt', '>', 0)->where('req_sumreqamt', '>', 0)->where('in_active', '=', false);

        if (!empty($id)) {
            $data = $data->where('id', $id);
        }

        return $data->orderBy('fiscalyear_code', 'desc');
    }


}
