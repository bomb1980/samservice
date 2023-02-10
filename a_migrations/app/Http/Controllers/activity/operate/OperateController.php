<?php

namespace App\Http\Controllers\activity\operate;

use App\Http\Controllers\Controller;
use App\Models\OoapTblActivities;

class OperateController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {

        return view('activity.operate.index');
    }

    public function result_train($id, $p_id)
    {
        $OoapTblActivities = OoapTblActivities::where('act_id', $id)->where('act_acttype', 2)->first();
        if ($OoapTblActivities) {
            return view('activity.operate.result_train.detail', ['act_id' => $id, 'p_id' => $p_id]);
        }
        return redirect()->route('activity.ready_confirm.index');
    }

    public function emer_employ($id, $p_id)
    {
        $OoapTblActivities = OoapTblActivities::where('act_id', $id)->where('act_acttype', 1)->first();
        if ($OoapTblActivities) {
            return view('activity.operate.emer_employ.detail', ['act_id' => $id, 'p_id' => $p_id]);
        }
        return redirect()->route('activity.ready_confirm.index');

        // return view('activity.operate.emer_employ.detail');
    }

    // public function assessment_form($act_id, $p_id)
    // {

    //     // echo 'ddsdads';
    //     // exit;
    //     return view('activity.operate.assessment_form.create', ['act_id' => $act_id, 'p_id' => $p_id]);
    // }


    // function qrcode($act_id, $p_id) {

    //     $url = route('activity.operate.assessment_form', ['act_id' => $act_id, 'p_id' => $p_id]);
    //     return view('activity.operate.assessment_form.qrcode', ['url' => $url]);
    // }

}
