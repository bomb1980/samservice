<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class surveyController extends Controller
{

    public function survey($reqform_id)
    {
        return view('report.survey.index', ['reqform_id' => $reqform_id]);
    }
}
