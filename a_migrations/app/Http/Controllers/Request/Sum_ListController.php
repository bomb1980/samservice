<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\OoapTblFiscalyear;

class Sum_ListController extends Controller
{
    function __construct()
    {
        $this->params['title'] = 'บันทึกข้อมูลการเสนองบประมาณ';

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {

        return view('request.sum_list.index', $this->params);
    }

    public function save($id = NULL)
    {

        $this->params['datas'] = OoapTblFiscalyear::getDatas($id)->first();

        if (!$this->params['datas']) {

            return redirect(route('request.sum_list.index'));
        }

        return view('request.sum_list.save', $this->params);
    }
}
