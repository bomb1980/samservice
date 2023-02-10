<?php

namespace App\Http\Controllers\activity\summary_expenses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SummaryExpensesYearController extends Controller
{
    public function index()
    {
        return view('activity.summaryexpensesyear.index');
    }
}
