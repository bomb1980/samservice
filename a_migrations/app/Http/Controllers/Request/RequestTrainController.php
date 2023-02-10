<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\OoapTblFiscalyearReqPeriod;
use App\Models\OoapTblReqform;
use App\Models\OoapTblRequest;
use Illuminate\Http\Request;

class RequestTrainController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        return view('request.train.index');
    }

    public function create()
    {

        return view('request.train.create');

        if (OoapTblFiscalyearReqPeriod::canRequest() == 'open') {


        }

        $this->params['next_time'] = NULL;


        $getNextRequestTime =  OoapTblFiscalyearReqPeriod::getNextRequestTime();

        if ($getNextRequestTime) {

            $this->params['next_time'] = $getNextRequestTime;
        }

        return view('request.hire.close_request', $this->params);
    }

    public function edit($id)
    {
        $OoapTblReqform = OoapTblRequest::getTbDatas($id, auth()->user()->emp_type, 2 )->first();

        if ($OoapTblReqform) {
            $pullreqform = OoapTblRequest::find($id);
            return view('request.train.edit', ['pullreqform' => $pullreqform]);
        } else {
            return redirect()->route('request.projects.index');

            // return redirect()->route('request.train.index');
        }
    }
}
