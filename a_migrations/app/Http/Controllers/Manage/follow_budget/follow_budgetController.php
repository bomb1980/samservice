<?php

namespace App\Http\Controllers\Manage\follow_budget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class follow_budgetController extends Controller
{
    public function index()
    {
        return view('manage.follow_budget.index');
    }
}
