<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\OoapTblFiscalyear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;


class FiscalController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function save(Request $request, $id = NULL,)
    {

        $this->params['datas'] = OoapTblFiscalyear::getBudgetAmtYear($id)->first();

        if ($this->params['datas']) {

            $this->params['title'] = $this->params['datas']->fiscalyear_code;

            $this->params['icon'] =  getIcon('edit');
        } else {

            $this->params['icon'] =  getIcon('add');

            $this->params['title'] = '';
        }

        $this->params['main_title'] = 'ข้อมูลงบประมาณ';
        $this->params['view'] = 'header';


        return view('manage.fiscal.save',  $this->params);
    }

    // use Session;
    public function index()
    {

        $this->params['icon'] =  getIcon('add');
        $this->params['title'] = '';
        $this->params['main_title'] = 'ข้อมูลงบประมาณ';
        $this->params['datas'] = NULL;
        $this->params['view'] = 'header';


        return view('manage.fiscal.save',  $this->params);
    }

    public function index2()
    {

        $this->params['icon'] =  getIcon('add');
        $this->params['title'] = '';
        $this->params['main_title'] = 'ข้อมูลงวดเงิน';
        $this->params['datas'] = NULL;
        $this->params['view'] = 'table_detail';


        return view('manage.fiscal.save',  $this->params);
    }



    public function save2(Request $request, $id = NULL, $create_budget = NULL)
    {


        if ($create_budget) {


        } else {

            $this->params['datas'] = OoapTblFiscalyear::getBudgetAmtYear($id)->first();

            if ($this->params['datas']) {

                $this->params['title'] = $this->params['datas']->fiscalyear_code;


                $this->params['icon'] =  getIcon('edit');

                $this->params['show_add_budget_button'] =  1;
            } else {

                $this->params['icon'] =  getIcon('add');

                $this->params['title'] = '';
            }

            $this->params['main_title'] = 'ข้อมูลงวดเงิน';

            $this->params['view'] = 'table_detail';


            return view('manage.fiscal.save',  $this->params);
        }
    }
}
