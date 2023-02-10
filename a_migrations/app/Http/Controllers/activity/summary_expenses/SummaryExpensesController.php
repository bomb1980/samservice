<?php

namespace App\Http\Controllers\activity\summary_expenses;

use App\Http\Controllers\Controller;

class SummaryExpensesController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    public function index()
    {
        return view('activity.summaryexpenses.index');
    }
}
