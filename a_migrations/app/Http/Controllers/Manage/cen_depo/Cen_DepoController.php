<?php

namespace App\Http\Controllers\Manage\cen_depo;

use App\Http\Controllers\Controller;
use App\Models\OoapTblFiscalyear;

class Cen_DepoController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function save_upcountry($id = NULL)
    {

        $this->params['parent_datas'] = OoapTblFiscalyear::getDatas(NULL, $id)->first();

        if ($this->params['parent_datas']) {

            $this->params['title'] = 'ปี ' . $this->params['parent_datas']->fiscalyear_code . '';
        } else {

            $this->params['title'] = '';
        }

        $this->params['main_title'] = 'บันทึกค่าใช้จ่ายงานบริหาร (สรจ.)';

        $this->params['payment_group'] = 2;

        return view('manage.cen_depo.save',  $this->params);

    }

    public function save($id = NULL)
    {

        $this->params['parent_datas'] = OoapTblFiscalyear::getDatas(NULL, $id)->first();


        if ($this->params['parent_datas']) {

            $this->params['title'] = 'ปี ' . $this->params['parent_datas']->fiscalyear_code . '';
        } else {

            $this->params['title'] = '';
        }

        $this->params['main_title'] = 'บันทึกค่าใช้จ่ายงานบริหารส่วนกลาง';

        $this->params['payment_group'] = 1;

        return view('manage.cen_depo.save',  $this->params);
    }

    public function index()
    {
        // dd('dsfadsf');

        $this->params['payment_group'] = 1;

        $this->params['parent_datas'] = NULL;

        $this->params['icon'] =  getIcon('add');

        $this->params['title'] = '';

        $this->params['main_title'] = 'บันทึกค่าใช้จ่ายงานบริหารส่วนกลาง';

        return view('manage.cen_depo.save',  $this->params);
    }

    public function upcountry()
    {

        $this->params['payment_group'] = 2;

        $this->params['parent_datas'] = NULL;

        $this->params['icon'] =  getIcon('add');

        $this->params['title'] = '';

        $this->params['main_title'] = 'บันทึกค่าใช้จ่ายงานบริหาร (สรจ.)';

        return view('manage.cen_depo.save',  $this->params);
    }



    // public function create()
    // {
    //     return view('manage.cen_depo.create');
    // }

    // public function edit($id)
    // {
    //     return view('manage.cen_depo.edit', ['den_id' => $id]);
    // }
}
