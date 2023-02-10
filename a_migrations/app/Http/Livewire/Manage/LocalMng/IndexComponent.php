<?php

namespace App\Http\Livewire\Manage\LocalMng;

use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapMasDivision;
use Livewire\Component;

class IndexComponent extends Component
{
    public $dept_list, $fiscalyear_list, $fiscalyear_code, $total_sum, $centerbudget_amt, $regionbudget_amt;
    public $mng_hold, $disburse, $balance_center, $balance_region, $balance_sum, $mng_bond, $pro_bond, $tran_back;
    public $able_mng_bud, $mng_center, $mng_region, $balance_end;

    // public $fiscalyear_list, $fiscalyear_code;
    public $sumreqamt = "-", $amt = "-", $budget = "-", $transfer = "-", $wait = "-";

    public $division_name_list = [], $division_name_code;
    public $req_sumreqamt_list, $req_amt_list, $budget_amt_list , $tranfer_amt_list, $wait_amt_list ;
    public $peri_list, $peri_code;
    public $budgetperiod;
    public $totalSum;

    //dolls
    public $doll_BUDGETPERIOD = 0, $doll_peri_list = [], $doll_peri_placeholder;
    public $doll_BUDGET_MANAGE = 0, $doll_BUDGET_SUMMANAGE = 0, $doll_BUDGET_BALANCE = 0, $doll_sum1 = 0, $doll_sum2 = 0;
    public $doll_BUDGET_PROJECT = 0, $doll_BUDGET_SUMMANAGEPROJECT = 0, $doll_BUDGET_SUMPAYMENTPROJECT = 0;
    public $doll_sum3 = 0;

    public function mount()
    {
        // $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->whereIn('status',['3', '4'])->select('fiscalyear_code')->pluck('fiscalyear_code', 'fiscalyear_code');
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)
        ->where('status','=',3)
        ->select('fiscalyear_code')->pluck('fiscalyear_code', 'fiscalyear_code');

        $data = OoapTblFiscalyear::where('in_active', '=', false)
        ->where('status','=',3)
        ->whereIn('fiscalyear_code', $this->fiscalyear_list)->get();
        // $datao = OoapTblBudgetProjectplanPeriod::where('in_active', '=', false)->whereIn('budgetyear', $this->fiscalyear_list)->whereIn('periodno', $this->peri_list);
        foreach($data as $key=>$val){
            $this->req_sumreqamt_list[$val->fiscalyear_code] = number_format($val->req_sumreqamt, 2);
            $this->req_amt_list[$val->fiscalyear_code] = number_format($val->req_amt, 2);
            $this->budget_amt_list[$val->fiscalyear_code] = number_format($val->budget_amt, 2);
            $this->tranfer_amt_list[$val->fiscalyear_code] = number_format($val->transfer_amt, 2);
            $this->wait_amt_list[$val->fiscalyear_code] = number_format($val->budget_amt - $val->transfer_amt, 2);

            $datap = OoapTblBudgetProjectplanPeriod::where('in_active', '=', false)->where('budgetyear', '=', $val->fiscalyear_code)->select('periodno')->groupBy('periodno');
            // $this->peri_list[$val->fiscalyear_code] = $datap->where('budgetyear', '=', $val->fiscalyear_code)->pluck('periodno', 'periodno');
            $this->peri_list[$val->fiscalyear_code] = $datap->get();
            if($this->peri_list[$val->fiscalyear_code] != null){
                $this->peri_list[$val->fiscalyear_code] = $this->peri_list[$val->fiscalyear_code]->pluck('periodno', 'periodno');

                foreach($this->peri_list[$val->fiscalyear_code] as $skey=>$sval){
                    $datao = OoapTblBudgetProjectplanPeriod::where('in_active', '=', false);
                    // $this->budgetperiod[$val->fiscalyear_code][$sval] =  OoapTblBudgetProjectplanPeriod::where('in_active', '=', false)->where('budgetyear', '=', $val->fiscalyear_code)->where('periodno', '=', $sval)->select('budgetperiod')->groupBy('budgetperiod')->pluck('budgetperiod', 'budgetperiod');
                    $this->budgetperiod[$val->fiscalyear_code][$sval] =  $datao->where('budgetyear', '=', $val->fiscalyear_code)->where('periodno', '=', $sval)->select('budgetperiod', 'budgetbalance', 'budget_manage', 'budget_summanage', 'budget_project', 'budget_summanageproject', 'budget_sumpaymentproject')->first();
                }
            }else{
                $this->budgetperiod[$val->fiscalyear_code] = null;
            }
        }

        $this->division_name_list = OoapMasDivision::where('ooap_mas_divisions.in_active','=', 0)
        ->where('ooap_mas_divisions.division_name', 'like', 'สำนักงานแรงงานจังหวัด%')->pluck('division_name','division_name');
    }

    public function cleanPeri(){
        $this->doll_BUDGETPERIOD = 0;
        $this->doll_BUDGET_MANAGE = 0;
        $this->doll_BUDGET_SUMMANAGE = 0;
        $this->doll_sum1 = 0;
        $this->doll_BUDGET_PROJECT = 0;
        $this->doll_BUDGET_SUMMANAGEPROJECT = 0;
        $this->doll_BUDGET_SUMPAYMENTPROJECT = 0;
        $this->doll_BUDGET_BALANCE = 0;
        $this->doll_sum2 = 0;
    }

    public function setYearValue($val, $prevent_peri_null)
    {
        if($prevent_peri_null == false){
            $this->peri_code = null;
            $this->cleanPeri();
        }
        $this->fiscalyear_code = $val;
        if($this->fiscalyear_code != null){
            $this->sumreqamt = $this->req_sumreqamt_list[$this->fiscalyear_code];
            $this->amt = $this->req_amt_list[$this->fiscalyear_code];
            $this->budget = $this->budget_amt_list[$this->fiscalyear_code];
            $this->transfer = $this->tranfer_amt_list[$this->fiscalyear_code];
            $this->wait = $this->wait_amt_list[$this->fiscalyear_code];
        }else{
            $this->sumreqamt = "-";
            $this->amt = "-";
            $this->budget = "-";
            $this->transfer = "-";
            $this->wait = "-";
        }
        $this->emit('year');
    }

    public function setPeriValue($val)
    {
        $this->peri_code = $val;
        if($this->peri_code != null){
            $this->doll_BUDGETPERIOD = number_format($this->budgetperiod[$this->fiscalyear_code][$this->peri_code]['budgetperiod'], 2);
            $this->doll_BUDGET_MANAGE = $this->budgetperiod[$this->fiscalyear_code][$this->peri_code]['budget_manage'];
            $this->doll_BUDGET_SUMMANAGE = $this->budgetperiod[$this->fiscalyear_code][$this->peri_code]['budget_summanage'];

            $this->doll_BUDGET_PROJECT = $this->budgetperiod[$this->fiscalyear_code][$this->peri_code]['budget_project'];
            $this->doll_BUDGET_SUMMANAGEPROJECT = $this->budgetperiod[$this->fiscalyear_code][$this->peri_code]['budget_summanageproject'];
            $this->doll_BUDGET_SUMPAYMENTPROJECT = $this->budgetperiod[$this->fiscalyear_code][$this->peri_code]['budget_sumpaymentproject'];
            $this->doll_BUDGET_BALANCE = $this->budgetperiod[$this->fiscalyear_code][$this->peri_code]['budgetbalance'];

            $this->doll_sum1 = (float) $this->doll_BUDGET_MANAGE - (float) $this->doll_BUDGET_SUMMANAGE;
            $this->doll_sum2 = (float) $this->doll_BUDGET_PROJECT - ( ( (float) $this->doll_BUDGET_SUMMANAGEPROJECT + (float) $this->doll_BUDGET_SUMPAYMENTPROJECT ) + (float) $this->doll_BUDGET_BALANCE );
            $this->doll_sum3 = number_format((float) $this->doll_sum1 +  (float) $this->doll_sum2, 2);

            $this->doll_sum1 = number_format($this->doll_sum1, 2);
            $this->doll_sum2 = number_format($this->doll_sum2, 2);

            $this->doll_BUDGET_MANAGE = number_format($this->doll_BUDGET_MANAGE, 2);
            $this->doll_BUDGET_SUMMANAGE = number_format($this->doll_BUDGET_SUMMANAGE, 2);

            $this->doll_BUDGET_PROJECT = number_format($this->doll_BUDGET_PROJECT, 2);
            $this->doll_BUDGET_SUMMANAGEPROJECT = number_format($this->doll_BUDGET_SUMMANAGEPROJECT, 2);
            $this->doll_BUDGET_SUMPAYMENTPROJECT = number_format($this->doll_BUDGET_SUMPAYMENTPROJECT, 2);
            $this->doll_BUDGET_BALANCE = number_format($this->doll_BUDGET_BALANCE, 2);
        }else{
            $this->cleanPeri();
        }
        $this->emit('peri');
        // dd($this->budgetperiod);
    }

    public function setUpdatePertri($bmanage, $bproject, $year, $peri)
    {
        $datas = [
            'budget_manage' => $bmanage,
            'budget_project' => $bproject,
        ];
        $data = OoapTblBudgetProjectplanPeriod::where('budgetyear','=', $year)->where('periodno', '=', $peri)->first()
        ->update($datas);

        $this->budgetperiod[$year][$peri]['budget_manage'] = $bmanage;
        $this->budgetperiod[$year][$peri]['budget_project'] = $bproject;
        $this->doll_BUDGET_PROJECT = $this->budgetperiod[$this->fiscalyear_code][$this->peri_code]['budget_project'];

        $this->setPeriValue($peri);

        $logs['route_name'] = 'manage.local_mng.index';
        $logs['submenu_name'] = 'จัดสรรงบประมาณ';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs, $datas );

        $this->emit('popup');
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('manage.local_mng.index');
    }

    public function render()
    {
        if($this->fiscalyear_code != null){
            if($this->peri_list[$this->fiscalyear_code] != null){
                $this->doll_peri_list = $this->peri_list[$this->fiscalyear_code];
                // $this->doll_peri_list = [0=>"in if"];
                $this->doll_peri_placeholder = "--เลือกงวดที่--";
            }
            else{
                $this->doll_peri_list = [];
                $this->doll_peri_placeholder = "--ไม่พบงวดที่--";
            }
        }else{
            $this->doll_peri_list = [];
            $this->doll_peri_placeholder = "--ไม่พบงวดที่--";
        }
        return view('livewire.manage.local-mng.index-component');
    }
}
