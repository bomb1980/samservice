<?php

namespace App\Http\Controllers\activity\join_activity;

use App\Http\Controllers\Controller;

class JoinActivityController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        return view('activity.join_activity.index');
    }
    public function create()
    {
        return view('activity.join_activity.create');
    }
}
