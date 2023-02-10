<?php

namespace App\Http\Controllers\activity\tran_mng;

use App\Http\Controllers\Controller;

class Tran_MngController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    public function index()
    {
        return view('activity.tran_mng.index');
    }

    public function manage()
    {
        return view('activity.tran_mng.manage');
    }

    public function transfer()
    {
        return view('activity.tran_mng.transfer');
    }

    public function allocate($id)
    {
        return view('activity.tran_mng.allocate',['division_id'=>$id]);
    }

    public function allocate_edit($id)
    {
        return view('activity.tran_mng.allocate_edit',['allocate_id'=>$id]);
    }
}
