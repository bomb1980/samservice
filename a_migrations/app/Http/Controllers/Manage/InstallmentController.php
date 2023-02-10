<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblFiscalyear;

class InstallmentController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    public function index()
    {
        return view('manage.installment.index');
    }

    public function create()
    {
        // dd($_REQUEST);
        return view('manage.installment.create');
    }

    public function edit($year_id = NULL, $budget_id = NULL)
    {
        $this->params['datas'] =  OoapTblFiscalyear::getBudgetAmtYear($year_id)->first();


        if ($this->params['datas']) {

            $this->params['budget_id'] =  $budget_id;

            $this->params['sub_datas'] = OoapTblBudgetProjectplanPeriod::setSubDatas($this->params['datas']->fiscalyear_code);

            $this->params['sub_totals'] = OoapTblBudgetProjectplanPeriod::getSubDataTotals($this->params['datas']->fiscalyear_code);

            $this->params['title'] =  'ข้อมูลงวดเงิน';

            foreach ($this->params['sub_datas'] as $ka => $va) {

                if ($va['budget_id'] == $budget_id) {


                    $this->params['set_sub_data'] =  $this->params['sub_datas'][$ka];
                    $this->params['sub_title'] =  'ปี 2565 งวดที่ 1';
                    $this->params['icon'] =  getIcon('edit');

                    $this->edit_index = $ka;

                    break;
                }
            }

            if (empty($this->params['set_sub_data'])) {

                $this->edit_index = NULL;
                $this->params['icon'] =  getIcon('add');

                $this->params['set_sub_data'] = [];
                $this->params['set_sub_data']['periodno'] = count($this->params['sub_datas']) + 1;

                $this->params['sub_title'] =  'ปี 2565 งวดที่ ' . $this->params['set_sub_data']['periodno'];

                // $this->params['set_sub_data']['budgetratio'] = 100 - $this->sub_totals['total_budgetratio'];

                $this->params['set_sub_data']['budgetperiod'] = number_format($this->params['datas']->budget_amt -  $this->params['sub_totals']['total_budgetperiod'], 2);
            }

            return view('manage.installment.edit',  $this->params);
        }

        return redirect(route('manage.fiscal.index2'));


        // dd($this->params['datas'] );

    }
}
