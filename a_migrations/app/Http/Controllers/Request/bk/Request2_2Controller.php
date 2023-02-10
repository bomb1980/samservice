<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\OoapTblReqform;
use App\Models\OoapTblRequest;
use Illuminate\Http\Request;

class Request2_2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('request.request2.request2_2.index');
    }

    public function create()
    {
        return view('request.request2.request2_2.create');
    }

    public function edit($id)
    {
        $OoapTblReqform = OoapTblRequest::where('req_id', $id)->first();
        if($OoapTblReqform){
            $pullreqform = OoapTblRequest::find($id);
            return view('request.request2.request2_2.edit', ['pullreqform' => $pullreqform]);
        }else{
            return redirect()->route('request.request2_3.index');
        }
    }
}
