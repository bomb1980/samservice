<?php

namespace App\Http\Controllers\Manage\draw_budget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Draw_budgetController extends Controller
{
    public function index()
    {
        return view('manage.draw_budget.index');
    }
}
