<?php

namespace App\Http\Controllers\activity\act_detail;

use App\Http\Controllers\Controller;

class Act_DetailController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    public function index()
    {
        return view('activity.act_detail.index');
    }

    public function create($act_id)
    {
        return view('activity.act_detail.create', compact('act_id'));
    }
}
