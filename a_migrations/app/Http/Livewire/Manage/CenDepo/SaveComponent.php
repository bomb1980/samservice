<?php

namespace App\Http\Livewire\Manage\CenDepo;

// namespace App\Http\Livewire\Manage\Fiscal;

use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFybdpayment;
use App\Models\OoapTblRequest;
use Livewire\Component;


class SaveComponent extends Component
{
    public $fiscalyear_select, $fiscalyear_code, $reqform_list = [], $acttype_list = [], $datareq_list = [], $budget_amt, $req_amt, $budget_amt_test;
    public $datas;
    public $parent_datas;
    public $payment_group;

    public function mount()
    {

        if ($this->payment_group == 1) {

            $this->redirect_index = 'manage.center';
            $this->redirect_route = 'manage.cen_depo.save';
        } else {
            $this->redirect_index = 'manage.upcountry';
            $this->redirect_route = 'manage.cen_depo.save.upcountry';
        }

        $this->sub_status = 'ready';
        $this->set_sub_data = NULL;
        $this->edit_index = NULL;

        if ($this->parent_datas) {

            $this->allocate_manage = $this->parent_datas->allocate_manage;
            $this->my_time = NULL;
            $this->fiscalyear_code = $this->parent_datas->fiscalyear_code;
            $this->parent_id = NULL;

        } else {

            $this->allocate_manage = 0;
            $this->my_time = NULL;
            $this->fiscalyear_code = NULL;
            $this->parent_id = NULL;
            $this->sub_datas = [];
        }

        $this->fiscalyear_select = OoapTblRequest::getYearDatas( $this->payment_group, NULL )->pluck('req_year', 'req_year');

    }

    public function render()
    {
        $this->emit('loadJquery');

        $this->plane_period_list = [];

        if (!empty($this->fiscalyear_code)) {

            foreach (OoapTblRequest::getYearDatas($this->payment_group, $this->fiscalyear_code)->get() as $ka => $va) {

                // $this->plane_period_list[$va->req_id] = $va->req_number . ' ' . $va->req_province ;
                $this->plane_period_list[$va->req_id] = $va->req_number. ' ' . $va->req_shortname . ' (จังหวัด'. $va->province_name .' ยอด '. number_format( $va->req_amount, 2) .' บาท)';
            }
        }

        if ($this->parent_datas) {

            // dd( $this->sub_status );

            $this->parent_id = $this->my_time;

            $this->sub_datas = OoapTblFybdpayment::setSubDatas($this->parent_id, $this->payment_group, $this->fiscalyear_code);

            $this->show_sub_form = 1;

            $this->test_modal = NULL;

            $this->getSubDataTotals = OoapTblFybdpayment::getSubDataTotals($this->parent_id);

            return view('livewire.manage.cen-depo.save-component');
        } else {

            return view('livewire.manage.cen-depo.select-component');
        }
    }

    function change_sub_status($status)
    {
        $this->sub_status = $status;
        $this->set_sub_data = [];
        $this->set_sub_data['pay_name'] = auth()->user()->fname_th;
        $this->set_sub_data['pay_date'] = date("d/m/Y", mktime(0, 0, 0, date('m'),   date('d'),    date('Y') + 543));
        $this->edit_index = NULL;
        $this->parent_datas = OoapTblFiscalyear::getDatas(NULL, $this->fiscalyear_code)->first();
    }



    function delete_sub_row($index)
    {
        $this->edit_index = $index;

        if ($this->sub_status == 'prepare_delete') {

            OoapTblFybdpayment::where('id', $this->sub_datas[$index]['id'])->delete();

            $this->sub_datas = OoapTblFybdpayment::setSubDatas($this->parent_id, $this->payment_group, $this->fiscalyear_code);

            $this->updateTblBudgetProjectplanPeriods();

            $this->change_sub_status('ready');
        } else {

            $this->sub_status = 'prepare_delete';
        }
    }








    function edit_row($index)
    {

        $this->change_sub_status('edit');
        $this->set_sub_data =  $this->sub_datas[$index];
        // $this->my_time = $this->sub_datas[$index]['parent_id'];
        $this->edit_index = $index;
    }

    function gogo()
    {
    }

    function save_sub_form()
    {
        $validate[0] = [
            'set_sub_data.pay_desp' => 'required',
            'set_sub_data.pay_date' => 'required',
            'set_sub_data.pay_name' => 'required',
            'set_sub_data.pay_amt' => 'required',
        ];
        $validate[1] = [
            'set_sub_data.pay_desp.required' => 'กรุณากรอกรายการ',
            'set_sub_data.pay_date.required' => 'กรุณากรอกวันที่',
            'set_sub_data.pay_name.required' => 'required',
            'set_sub_data.pay_amt.required' => 'กรุณากรอกจำนวนเงิน',
        ];

        $this->validate($validate[0], $validate[1]);

        if (isset($this->edit_index)) {

            $getCheckSave = OoapTblFybdpayment::getCheckSave($this->parent_datas->req_id, $this->payment_group, $this->sub_datas[$this->edit_index]['id']);
        } else {

            $getCheckSave = OoapTblFybdpayment::getCheckSave($this->parent_datas->req_id, $this->payment_group);

            if (empty($this->my_time)) {
                return session()->flash('my_time', 'กรุณาเลือกคำร้องขอ');
            }
        }



        // if ($this->payment_group == 1) {

        //     $total_pay_amt = $getCheckSave['total_pay_amt'] + doMoney($this->set_sub_data['pay_amt']);

        //     if ($total_pay_amt > $this->parent_datas->budget_manage) {

        //         return session()->flash('getSubDataTotal', 'กรุณากรอกค่าใช้จ่ายไม่เกิน งบประมาณจัดสรร (' . number_format($this->parent_datas->budget_manage   -  $getCheckSave['total_pay_amt'], 2) . 'บาท) ');
        //     }
        // } else {

        //     $total_pay_amt = $getCheckSave['total_pay_amt'] + doMoney($this->set_sub_data['pay_amt']);

        //     if ($total_pay_amt > $this->allocate_manage) {

        //         return session()->flash('getSubDataTotal', 'กรุณากรอกค่าใช้จ่ายไม่เกิน งบประมาณจัดสรร (' . number_format($this->allocate_manage - $getCheckSave['total_pay_amt'], 2) . 'บาท) ');
        //     }
        // }






        $this->set_sub_data['updated_at'] = now();
        $this->set_sub_data['created_at'] = now();
        $this->set_sub_data['pay_date'] =  datePickerThaiToDB($this->set_sub_data['pay_date']);
        // $this->set_sub_data['parent_id'] = $this->parent_id;
        $this->set_sub_data['fiscalyear_code'] = $this->parent_datas->fiscalyear_code;
        $this->set_sub_data['division_id'] = auth()->user()->division_id;
        $this->set_sub_data['pay_type'] = 1;
        $this->set_sub_data['year_period'] = $this->parent_datas->req_number;
        $this->set_sub_data['payment_group'] = $this->payment_group;
        $this->set_sub_data['pay_amt'] = doMoney($this->set_sub_data['pay_amt']);

        // dd( $this->set_sub_data);

        // $this->payment_group

        if (isset($this->edit_index)) {

            unset($this->set_sub_data['type_name']);
            unset($this->set_sub_data['req_province']);

            // dd($this->set_sub_data);

            $edit = OoapTblFybdpayment::where('id', $this->sub_datas[$this->edit_index]['id']);

            $edit->update($this->set_sub_data);
        } else {
            $this->set_sub_data['parent_id'] = $this->my_time;

            OoapTblFybdpayment::create($this->set_sub_data);
        }

        $this->sub_datas = OoapTblFybdpayment::setSubDatas($this->parent_id, $this->payment_group, $this->fiscalyear_code);
        $this->updateTblBudgetProjectplanPeriods();
        // dd('dsadds');
        $this->change_sub_status('ready');
    }

    function updateTblBudgetProjectplanPeriods()
    {

        $this->getSubDataTotals = OoapTblFybdpayment::getSubDataTotals($this->parent_id);
        // $OoapTblBudgetProjectplanPeriod = OoapTblBudgetProjectplanPeriod::where('req_id', '=', $this->parent_id)->first();
        // $OoapTblBudgetProjectplanPeriod->update(['budget_summanage' => $this->getSubDataTotals['total_pay_amt']]);
    }







    public function submit()
    {
        return true;
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

    public function submit_modal($formData)
    {
        dd($formData);
    }
}
