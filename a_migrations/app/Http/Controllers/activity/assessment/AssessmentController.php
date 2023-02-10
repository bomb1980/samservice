<?php

namespace App\Http\Controllers\activity\assessment;

use App\Http\Controllers\Controller;

class AssessmentController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    public function index()
    {
        return view('activity.assessment.index');
    }

    public function create()
    {
        return view('activity.assessment.create');
    }
}
