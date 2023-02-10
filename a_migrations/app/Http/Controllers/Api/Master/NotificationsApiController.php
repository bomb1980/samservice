<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapTblNotification;
use Illuminate\Http\Request;

class NotificationsApiController extends Controller
{

    public function notifications(Request $request)
    {

        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $draw = $request->get('draw');
        $datas = OoapTblNotification::getDatas();

        $totalRecords = $datas->count();

        $datas = $datas->skip($start)->take($rowperpage)->orderby('created_at', 'DESC')->get();


        $i = $start;
        foreach ($datas as $kd => $vd) {

            $vd->log_date = datetimeToThaiDatetime($vd->noti_date);

            $vd->noti_name = '<a href="'. $vd->noti_link .'" >'. $vd->noti_name .'</a>';
            $vd->no = ++$i;
        }

        return array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" =>  $datas,
        );
    }


}
