<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\OoapTblFiscalyearReqPeriod;
use App\Models\OoapTblRequest;
use Illuminate\Http\Request;

class RequestHireController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }


    public function notfound() {

        $this->params = [];

        return view('request.hire.notfound', $this->params );
    }


    public function index()
    {
        return view('request.hire.index');
    }

    public function create()
    {

        return view('request.hire.create');

        if( OoapTblFiscalyearReqPeriod::canRequest() == 'open' ) {


        }

        $this->params['next_time'] = NULL;


        $getNextRequestTime =  OoapTblFiscalyearReqPeriod::getNextRequestTime();

        if($getNextRequestTime  ) {

            $this->params['next_time'] = $getNextRequestTime;
        }

        return view('request.hire.close_request', $this->params );
    }

    public function edit($id)
    {

        $OoapTblReqform = OoapTblRequest::getTbDatas($id, auth()->user()->emp_type, 1 )->first();

        if($OoapTblReqform){

            $pullrequest = OoapTblRequest::find($id);
            return view('request.hire.edit', ['pullrequest' => $pullrequest]);
        }

        return redirect()->route('request.projects.index');
    }
}
