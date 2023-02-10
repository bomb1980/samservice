<?php

namespace App\Http\Controllers\activity\ready_confirm;

use App\Http\Controllers\Controller;
use App\Models\OoapTblActivities;

class Ready_ConfirmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        $check = 0;

        if(auth()->user()->emp_type == 2){
            $check = 1;
        }

        return view('activity.ready_confirm.index', ['check' => $check]);
    }

    public function act_copy()
    {
        return view('activity.ready_confirm.copy');
    }

    public function list()
    {
        return view('activity.ready_confirm.list');
    }

    public function hire_create()
    {
        return view('activity.ready_confirm.hire.create');
    }

    public function hire_edit($id)
    {
        $OoapTblActivities = OoapTblActivities::where('act_id', $id)->first();
        if($OoapTblActivities){
            $pullactivities = OoapTblActivities::find($id);
            return view('activity.ready_confirm.hire.edit', ['pullactivities' => $pullactivities]);
        }else{
            return redirect()->route('activity.ready_confirm.index');
        }
    }

    public function train_create()
    {
        return view('activity.ready_confirm.train.create');
    }

    public function train_edit($id)
    {
        $OoapTblActivities = OoapTblActivities::where('act_id', $id)->first();
        if($OoapTblActivities){
            $pullactivities = OoapTblActivities::find($id);
            return view('activity.ready_confirm.train.edit', ['pullactivities' => $pullactivities]);
        }else{
            return redirect()->route('activity.ready_confirm.index');
        }
    }

    public function destroy($id)
    {
        $checkResult = OoapTblActivities::find($id);
        ($checkResult->in_active == 0) ? $in_active = 1 : $in_active = 0;
        // dd($in_active);
        OoapTblActivities::where('act_id','=', $id)->update([
            'in_active' => $in_active,
            'deleted_by' => auth()->user()->name,
            'deleted_at' => now()
        ]);

        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
