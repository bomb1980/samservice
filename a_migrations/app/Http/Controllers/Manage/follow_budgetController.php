<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;

class Follow_budgetController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        return view('manage.follow_budget.index');
    }
}
