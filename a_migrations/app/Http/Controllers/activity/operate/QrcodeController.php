<?php

namespace App\Http\Controllers\activity\operate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrcodeController extends Controller
{
    public function assessment_form($act_id, $p_id)
    {

        // echo 'ddsdads';
        // exit;
        return view('activity.operate.assessment_form.create', ['act_id' => $act_id, 'p_id' => $p_id]);
    }


    function qrcode($act_id, $p_id)
    {

        $url = route('activity.operate.assessment_form', ['act_id' => $act_id, 'p_id' => $p_id]);
        return view('activity.operate.assessment_form.qrcode', ['url' => $url]);
    }
}
