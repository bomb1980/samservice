<?php

namespace App\Http\Controllers\activity\other_expense;

use App\Http\Controllers\Controller;

class OtherExpenseController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    public function index()
    {
        return view('activity.other_expense.index');
    }

    public function create()
    {
        return view('activity.other_expense.create');
    }
}
