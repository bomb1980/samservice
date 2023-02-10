<?php

namespace App\Http\Livewire\Manage\Fiscal;

use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblFiscalyear;
use Livewire\Component;


class FiscalComponent extends Component
{
    public $fiscalyear_select, $fiscalyear_code, $reqform_list = [], $acttype_list = [], $datareq_list = [], $budget_amt, $req_amt, $budget_amt_test;
    public $datas;
    public $view;

    public function render()
    {

        $this->emit('loadJquery');

        $this->fiscalyear_select = OoapTblFiscalyear::getBudgetAmtYear()->get()->pluck('fiscalyear_code', 'id');

        if ($this->datas) {
            $this->sub_totals = OoapTblBudgetProjectplanPeriod::getSubDataTotals($this->datas->fiscalyear_code);

            if ($this->view == 'header') {

                $this->redirect = 'manage.fiscal.save2';

                return view('livewire.manage.fiscal.fiscalheader-component');
            } else {

                $this->getSubDataTotals_ = OoapTblBudgetProjectplanPeriod::getSubDataTotals_($this->datas->fiscalyear_code);

                return view('livewire.manage.fiscal.fiscal-component');
            }
        } else {

            if ($this->view == 'header') {

                $this->redirect = 'manage.fiscal.save';
            } else {

                $this->redirect = 'manage.fiscal.save2';
            }

            return view('livewire.manage.fiscal.fiscalready-component');
        }
    }

    function delete_sub_row($index)
    {

        $this->sub_datas = OoapTblBudgetProjectplanPeriod::setSubDatas($this->datas->fiscalyear_code);


        $this->edit_index = $index;

        $this->set_sub_data = $this->sub_datas[$index];

        if (!empty($this->set_sub_data['total_transfer_amt'])) {


            session()->flash('try_delete', 'ไม่สามารถลบรายการที่มียอดรับโอนแล้วได้');

            return false;
        }

        if( $this->sub_status == 'prepare_delete') {

            OoapTblBudgetProjectplanPeriod::where('budget_id', $this->sub_datas[$this->edit_index]['budget_id'])->delete();

            $this->sub_datas = OoapTblBudgetProjectplanPeriod::setSubDatas($this->datas->fiscalyear_code);

            $this->change_sub_status('ready');
        }
        else {


            $this->sub_status = 'prepare_delete';
        }
    }



    function change_sub_status($status)
    {

        $this->sub_status = $status;
        $this->edit_index = NULL;

        $this->set_sub_data = [];
        $this->set_sub_data['budgetratio'] = 100 - $this->sub_totals['total_budgetratio'];

        $this->set_sub_data['budgetperiod'] = number_format($this->datas->budget_amt -  $this->sub_totals['total_budgetperiod'], 2);
    }

    function save_sub_form($index = NULL)
    {
        $validate[0] = [
            'set_sub_data.startperioddate' => 'required',
            'set_sub_data.endperioddate' => 'required',
            'set_sub_data.budgetratio' => 'required',
        ];

        $this->validate($validate[0]);

        if (empty($this->set_sub_data['budget_id'])) {
            $this->set_sub_data['budget_id'] = NULL;
        }

        $getSubDataTotal = OoapTblBudgetProjectplanPeriod::getSubDataTotals_($this->datas->fiscalyear_code, $this->set_sub_data['budget_id']);


        $sdfads = $getSubDataTotal['total_budgetperiod'] + doMoney($this->set_sub_data['budgetperiod']);

        $error = false;
        if ($sdfads > $this->datas->budget_amt) {

            session()->flash('getSubDataTotal', 'ไม่สามารถกรอกเกิน ' . ($this->datas->budget_amt - $getSubDataTotal['total_budgetperiod'])   . ' ได้');

            $error = true;
        }

        if (datePickerThaiToDB('01/' . $this->set_sub_data['startperioddate']) > datePickerThaiToDB('01/' . $this->set_sub_data['endperioddate'])) {

            $error = true;
            session()->flash('startperioddate', 'ระบุเวลา <= เดือนสิ้นสุด');
        }

        if (config('database.default')  == 'mysql') {

            $str = '?';
        } else {

            $str = 'TO_DATE(?, \'YYYY/MM/DD\')';
        }

        if (empty($this->set_sub_data['budget_id'])) {

            $d = OoapTblBudgetProjectplanPeriod::getDatas()
                ->whereraw(
                    "
                    (  endperioddate >= " . $str . " )",
                    [
                        datePickerThaiToDB('01/' . $this->set_sub_data['startperioddate']),
                    ]
                )
                ->where('budgetyear', '=', $this->datas->fiscalyear_code)
                ->get();
        } else {

            $d = OoapTblBudgetProjectplanPeriod::getDatas()
                ->whereraw(
                    "(
                (  endperioddate >= " . $str . " AND periodno < ? )
                OR

                (  startperioddate <= " . $str . " AND periodno > ? )
                )",
                    [
                        datePickerThaiToDB('01/' . $this->set_sub_data['startperioddate']),
                        $this->set_sub_data['periodno'],
                        datePickerThaiToDB('01/' . $this->set_sub_data['endperioddate']),
                        $this->set_sub_data['periodno'],
                    ]
                )
                ->where('budget_id', '!=',  $this->set_sub_data['budget_id'])
                ->where('budgetyear', '=', $this->datas->fiscalyear_code)
                ->get();
        }


        foreach ($d as $kd => $vd) {

            $error = true;
            session()->flash('startperioddate', 'เวลาต้องไม่คาบเกียวกับช่วงเวลาก่อนหน้า');
            session()->flash('endperioddate', 'เวลาต้องไม่คาบเกียวกับช่วงเวลาถัดไป');
        }


        if (!empty($this->set_sub_data['total_transfer_amt'])) {

            if (doMoney($this->set_sub_data['budgetperiod']) < $this->set_sub_data['total_transfer_amt']) {


                $error = true;
                session()->flash('budgetperiod', 'ไม่สามารถปรับยอดต่ำกว่ายอดรับโอนแล้วได้');
            }
        }





        if ($error == true) {

            return false;
        }

        $this->set_sub_data['updated_at'] = now();
        $this->set_sub_data['created_at'] = now();
        $this->set_sub_data['startperioddate'] = datePickerThaiToDB('01/' . $this->set_sub_data['startperioddate']);
        $this->set_sub_data['endperioddate'] = datePickerThaiToDB('01/' . $this->set_sub_data['endperioddate']);

        $this->set_sub_data['budget_transferdate'] = empty($this->set_sub_data['budget_transferdate']) ? NULL : datePickerThaiToDB($this->set_sub_data['budget_transferdate']);

        $this->set_sub_data['budgetperiod'] = doMoney($this->set_sub_data['budgetperiod']);


        $this->set_sub_data['budgetyear'] = $this->datas->fiscalyear_code;

        unset($this->set_sub_data['total_transfer_amt']);

        if (isset($index)) {

            OoapTblBudgetProjectplanPeriod::where('budget_id', $this->sub_datas[$index]['budget_id'])->update($this->set_sub_data);
        } else {

            OoapTblBudgetProjectplanPeriod::create($this->set_sub_data);
        }

        $this->sub_datas = OoapTblBudgetProjectplanPeriod::setSubDatas($this->datas->fiscalyear_code);

        $this->change_sub_status('ready');
    }




    public function submit($formData)
    {

        $budget_amt = doMoney($formData['budget_amt']);

        $budgetyear = $this->datas->fiscalyear_code;
        $OoapTblBudgetProjectplanPeriod = OoapTblBudgetProjectplanPeriod::getSubDataTotals($budgetyear);

        $error = false;

        if ($budget_amt < $OoapTblBudgetProjectplanPeriod['total_budgetperiod']) {


            $error = true;
            session()->flash('budget_amt', 'ไม่สามารถปรับยอดงบประมาณต่ำกว่า ' . number_format($OoapTblBudgetProjectplanPeriod['total_budgetperiod'], 2)  . 'บาท ได้');
            if ($error == true) {

                return false;
            }
        }

        $datas = OoapTblFiscalyear::getDatas($this->datas->id);

        $datas->update([
            'budget_amt' => $budget_amt,
            'updated_at' => now(),
            'updated_by' => auth()->user()->emp_citizen_id
        ]);
        $this->show_sub_form = 1;
        $this->emit('popup');
    }




    public function mount()
    {

        if ($this->datas) {

            // dd();

            $this->sub_status = 'ready';
            $this->set_sub_data = NULL;
            $this->edit_index = NULL;

            $model = new OoapTblFiscalyear();

            $this->parent_id = $this->datas->id;

            foreach ($model->getFillable() as $kf => $name) {

                $this->$name = $this->datas->$name;
            }

            $this->sub_datas = OoapTblBudgetProjectplanPeriod::setSubDatas($this->datas->fiscalyear_code);

            $this->show_sub_form = 0;

            if ($this->datas->budget_amt > 0) {
                $this->show_sub_form = 1;
            }
        } else {

            $this->sub_status = 'ready';
            $this->set_sub_data = NULL;
            $this->edit_index = NULL;

            $model = new OoapTblFiscalyear();

            foreach ($model->getFillable() as $kf => $name) {

                $this->$name = NULL;
            }

            $this->sub_datas = [];
            $this->show_sub_form = 0;
        }

        $this->test_modal = NULL;
    }


    public function submit_modal($formData)
    {
        // dd($formData);


    }




    public function cal_me()
    {

        if (empty($this->datas->budget_amt)) {

            $this->set_sub_data['budgetperiod'] = 0;
        } else {

            $this->set_sub_data['budgetperiod'] = number_format(($this->set_sub_data['budgetratio'] / 100 * $this->datas->budget_amt), 2);
        }
    }






    public function changeyear($years)
    {
        $this->fiscalyear_code = $years;

        $this->datareq_list = OoapTblFiscalyear::select('req_amt', 'budget_amt')
            ->where('fiscalyear_code', '=', $this->fiscalyear_code)
            ->first();

        $this->req_amt = $this->datareq_list->req_amt ?? 0;

        $this->budget_amt = $this->datareq_list->budget_amt ?? 0;
        $this->budget_amt_test = $this->budget_amt ?? 0;
    }
}
