<?php

namespace App\Http\Controllers\activity\plan_adjust;

use App\Http\Controllers\Controller;
use App\Models\OoapTblActivities;

class Plan_AdjustController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    public function index()
    {
        return view('activity.plan_adjust.index');
    }

    public function hire()
    {
        return view('activity.plan_adjust.hire');
    }

    public function train()
    {
        return view('activity.plan_adjust.train');
    }

    public function edit_train($id)
    {
        $OoapTblActivities = OoapTblActivities::where('act_id', $id)->first();
        if ($OoapTblActivities) {
            $pullactivities = OoapTblActivities::find($id);
            return view('activity.plan_adjust.train_edit', ['pullactivities' => $pullactivities]);
        } else {
            return redirect()->route('activity.plan_adjust.index');
        }
    }

    public function edit_hire($id)
    {
        $OoapTblActivities = OoapTblActivities::where('act_id', $id)->first();
        if ($OoapTblActivities) {
            $pullactivities = OoapTblActivities::find($id);
            return view('activity.plan_adjust.hire_edit', ['pullactivities' => $pullactivities]);
        } else {
            return redirect()->route('activity.plan_adjust.index');
        }
    }

}
