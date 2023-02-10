<?php

namespace App\Http\Controllers\activity\assessment;

use App\Http\Controllers\Controller;

class RecordattendanceController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        return view('activity.recordattendance.index');
    }

    public function create($act_id)
    {
        return view('activity.recordattendance.create', compact('act_id'));
    }

    // public function create($reqform_id)
    // {
    //     return view('activity.recordattendance.create', ['reqform_id' => $reqform_id]);
    // }
}

