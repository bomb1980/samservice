<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasEstimate;

class EstimateActivityController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        return view('master.estimate.index');
    }

    public function create()
    {
        return view('master.estimate.create');
    }

    public function edit($id)
    {
        $getResult = OoapMasEstimate::find($id);
        return view('master.estimate.edit', ['data' => $getResult]);
    }

    public function destroy($id)
    {
        $checkResult = OoapMasEstimate::find($id);
        ($checkResult->in_active == 1) ? $in_active = 0 : $in_active = 1;
        OoapMasEstimate::where('estimate_id', $id)->update([
            'in_active' => $in_active
        ]);

        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
