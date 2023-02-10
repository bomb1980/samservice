<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapTblFybdpayment extends Model
{
    protected $table = 'ooap_tbl_fybdpayment';

    protected $primaryKey = 'id';


    protected $fillable = [
        'pay_type', 'year_period','parent_id', 'payment_group', 'division_id', 'refer_actnumber', 'fiscalyear_code', 'pay_date', 'pay_amt', 'pay_manageamt', 'pay_urgentamt', 'pay_trainamt', 'pay_name', 'pay_desp', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    static function setSubDatas($parent_id = NULL, $payment_group = NULL, $fiscalyear_code = NULL )
    {

        $sub_datas = self::selectraw( '
            ooap_tbl_fybdpayment.*,
            ooap_tbl_requests.req_province,
            ( CASE WHEN ooap_tbl_fybdpayment.payment_group = 1 THEN \'ค่าใช้จ่ายส่วนกลาง\' ELSE \'ค่าใช้จ่ายส่วนภูมิภาค\' END  ) as type_name
        ')->join( 'ooap_tbl_requests', 'ooap_tbl_requests.req_id', '=', 'ooap_tbl_fybdpayment.parent_id');



        if( !empty( $fiscalyear_code ) ) {
            $sub_datas = $sub_datas->where('ooap_tbl_fybdpayment.fiscalyear_code', '=', $fiscalyear_code );

        }

        if( !empty( $parent_id ) ) {
            $sub_datas = $sub_datas->where('ooap_tbl_fybdpayment.parent_id', '=', $parent_id );

        }

        if( !empty( $payment_group ) ) {
            $sub_datas = $sub_datas->where('ooap_tbl_fybdpayment.payment_group', '=', $payment_group );



            if( $payment_group == 2 ) {

                if(auth()->user()->emp_type == 2 ) {

                    $sub_datas = $sub_datas->where('ooap_tbl_requests.req_province', '=', auth()->user()->province_id );
                }
            }

        }



        $sub_datas = $sub_datas->get()->toArray();

        foreach ($sub_datas as $ka => $va) {

            $sub_datas[$ka]['pay_date'] = empty( $va['pay_date'] ) ? null: datetimetodatethai($va['pay_date']);
            // $sub_datas[$ka]['pay_desp'] = 'จังหวัด ' . $va['req_province'];
        }

        return $sub_datas;
    }

    static function getCheckSave($parent_id = NULL, $payment_group = NULL, $unset_id = NULL )
    {
        $datas = self::selectraw('
            sum( pay_amt ) as total_pay_amt
        ')
        ->where( 'parent_id', '=', $parent_id )
        ->where( 'payment_group', '=', $payment_group );



        if( $unset_id ) {


            $datas = $datas->where( 'id', '!=', $unset_id );
        }


        $datas = $datas->get()->toArray();

        foreach( $datas as $kd => $vd ) {
            return $vd;
        }

        return ['total_pay_amt' => 0];
    }


    //
    //
    static function getTotalsByYear($parent_id = NULL)
    {
        return self::selectraw('
            ooap_tbl_fybdpayment.fiscalyear_code,
            sum(ooap_tbl_fybdpayment.pay_amt * ( CASE WHEN payment_group = 1 THEN 1 ELSE 0 END ) ) as sub_manage_payment_amt1,
            sum(ooap_tbl_fybdpayment.pay_amt * ( CASE WHEN payment_group = 2 THEN 1 ELSE 0 END ) ) as sub_manage_payment_amt2,
            sum(ooap_tbl_fybdpayment.pay_urgentamt ) as urgentpayment_amt,
            sum(ooap_tbl_fybdpayment.pay_trainamt ) as trainingpayment_amt,
            count( * ) as t
        ')
        ->join( 'ooap_tbl_requests', 'ooap_tbl_requests.req_id', '=', 'ooap_tbl_fybdpayment.parent_id')
        ->groupby('ooap_tbl_fybdpayment.fiscalyear_code')
        ->get();


    }

    static function getSubDataTotals($parent_id = NULL)
    {

        $datas = self::selectraw('
            parent_id,
            sum(ooap_tbl_fybdpayment.pay_amt) as total_pay_amt,
            SUM( ooap_tbl_fybdpayment.pay_amt * ( CASE WHEN ooap_tbl_fybdpayment.payment_group = 1 THEN 1 ELSE 0 END   )   ) as total_pay_center,
            SUM( ooap_tbl_fybdpayment.pay_amt * ( CASE WHEN ooap_tbl_fybdpayment.payment_group = 2 THEN 1 ELSE 0 END   )   ) as total_pay_upcountry,
            count( * ) as t
        ')->where('parent_id', $parent_id)
            ->groupby('parent_id')
            ->first();

        if ($datas) {
            return $datas->toArray();
        }

        return [
            't' => 0,
            'total_pay_amt' => 0,
            'total_pay_center' => 0,
            'total_pay_upcountry' => 0,
        ];
    }






}
