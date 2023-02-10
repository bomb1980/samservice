<?php

namespace App\Http\Controllers\QrCode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrcodeController extends Controller
{
    function index($act_id, $p_id) {


        $url = route('activity.operate.assessment_form', ['act_id' => $act_id, 'p_id' => $p_id]);
        return view('activity.operate.assessment_form.qrcode', ['url' => $url]);

    }
}
