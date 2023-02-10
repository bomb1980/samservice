<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\OoapTblRequest;
use Illuminate\Http\Request;

class Request3_3Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('request.request3.request3_3.index');
    }

    public function detail($acttype_id, $id)
    {
        $OoapTblReqform = OoapTblRequest::where('req_id', $id)->first();
        if ($OoapTblReqform) {
            $pullreqform = OoapTblRequest::find($id);
            return view('request.request3.request3_3.detail2', ['acttype_id' => $acttype_id, 'pullreqform' => $pullreqform]);
        } else {
            return redirect()->route('request.request3.request3_3.index');
        }
    }
}
