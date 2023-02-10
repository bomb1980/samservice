<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;

class AllocateController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    public function create()
    {
        return view('manage.allocate.create');
    }
}
