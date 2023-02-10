<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapLogTransModel;
use App\Models\OoapMasActtype;
use App\Models\OoapTblPopulationType;
use Illuminate\Http\Request;

class HistoryApiController extends Controller
{



    public function acttype(Request $request)
    {

        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $draw = $request->get('draw');

        $datas = OoapMasActtype::getDatas();

        if( !empty( $request['search_']  )){

            $datas = $datas->whereraw( "(
                ooap_mas_acttype.name LIKE '%". str_replace( ' ', '%', $request['search_'] ) ."%'


            )" );
        }

        $totalRecords = $datas->count();


        $datas = $datas->skip($start)->take($rowperpage)->orderby('created_at', 'DESC')->get();


        $i = $start;
        foreach ($datas as $kd => $vd) {

            // $vd->log_date = datetimeToThaiDatetime($vd->log_date);

            $vd->no = ++$i;
            $vd->edit = '<div class="icondemo vertical-align-middle p-2"> <a href="'. route('master.acttype.edit', ['id'=>$vd->id]).'"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a> </div>';

            $vd->del =  '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $vd->id . ')" title="ลบ"></button> <form action="'. route('master.acttype.destroy', ['id'=>$vd->id]).'" id="delete_form' . $vd->id . '" method="post">
            <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';


        }

        return array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" =>  $datas,
        );
    }

    public function poptype(Request $request)
    {

        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $draw = $request->get('draw');

        $datas = OoapTblPopulationType::getDatas();

        if( !empty( $request['search_']  )){

            $datas = $datas->whereraw( "(
                ooap_tbl_population_types.name LIKE '%". str_replace( ' ', '%', $request['search_'] ) ."%'


            )" );
        }

        $totalRecords = $datas->count();


        $datas = $datas->skip($start)->take($rowperpage)->orderby('created_at', 'DESC')->get();


        $i = $start;
        foreach ($datas as $kd => $vd) {

            // $vd->log_date = datetimeToThaiDatetime($vd->log_date);

            $vd->no = ++$i;
            $vd->edit = '<div class="icondemo vertical-align-middle p-2"> <a href="'. route('master.poptype.edit', ['id'=>$vd->id]).'"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a> </div>';

            $vd->del =  '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $vd->id . ')" title="ลบ"></button> <form action="'. route('master.poptype.destroy', ['id'=>$vd->id]).'" id="delete_form' . $vd->id . '" method="post">
            <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';


        }

        return array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" =>  $datas,
        );
    }

    public function history(Request $request)
    {

        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $draw = $request->get('draw');

        $datas = OoapLogTransModel::getDatas();

        if( !empty( $request['search_']  )){

            $datas = $datas->whereraw( "(
                ooap_log_trans_models.log_name LIKE '%". str_replace( ' ', '%', $request['search_'] ) ."%'
                or
                ooap_log_trans_models.full_name LIKE '%". str_replace( ' ', '%', $request['search_'] ) ."%'

            )" );
        }

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

}
