<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Request3_1Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('request.request3.request3_1.index');
    }

    public function edit($id)
    {
        // dd($id);
        return view('request.request3.request3_1.edit', ['reqform_id' => $id]);
    }
}
