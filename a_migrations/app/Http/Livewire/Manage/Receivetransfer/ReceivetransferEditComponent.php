<?php

namespace App\Http\Livewire\Manage\Receivetransfer;

use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblFybdtransfer;
use Livewire\Component;

class ReceivetransferEditComponent extends Component
{
    public $fiscalyear_list, $fiscalyear_code, $fybdperiod_list, $fybdperiod_id, $transfer_date, $transfer_amt, $transfer_desp;
    public $ret_id;
    public $parent_datas;
    public $budget;

    public function render()
    {

        // dd('sdfasdfasd');
        $this->emit('dfdfdfdfdfdfdfdf');

        return view('livewire.manage.receivetransfer.receivetransfer-edit-component');
    }

    public function mount()
    {
        $this->fybdtransfer_id = NULL;

        if ($this->budget) {


            $this->fiscalyear_code = $this->budget->budgetyear; //ปีงบ
            $this->fybdperiod_id = $this->budget->periodno; //งวดเงิน
            $this->transfer_date = datetoview(now());
            $this->transfer_amt = NULL;
            $this->transfer_desp = NULL;

        } else {
            // dd( 'ddfdf');

            $this->fiscalyear_code = NULL; //ปีงบ
            $this->fybdperiod_id = NULL; //งวดเงิน
            $this->transfer_date = datetoview(now());
            $this->transfer_amt = NULL;
            $this->transfer_desp = NULL;
        }


        // dd( $this->budget );

        $this->clearArea();
    }



    function clearArea($rang = NULL)
    {
        $this->getBudgetYearPeriodnoList = OoapTblBudgetProjectplanPeriod::getBudgetYearPeriodnoList( NULL )->get()->toArray();

        if ($rang == 'fiscalyear_code') {
            $this->fybdperiod_id = NULL; //งวดเงิน
        }

        $this->year_list = [];
        $this->periodno_list = [];

        foreach ($this->getBudgetYearPeriodnoList as $ka => $va) {

            $this->year_list[$va['budgetyear']] = $va['budgetyear'];

            if (!empty($this->fiscalyear_code)) {

                if ($va['budgetyear'] != $this->fiscalyear_code) {
                    continue;
                }
            }

            $this->periodno_list[$va['periodno']] = $va['periodno'];
        }

        $this->transfer_list = [];
        if( !empty( $this->fiscalyear_code )  && !empty( $this->fybdperiod_id   ) ) {

            $OoapTblFybdtransfer = OoapTblFybdtransfer::getDatas(NULL, $this->fiscalyear_code, NULL, $this->fybdperiod_id)->get();

            foreach ($OoapTblFybdtransfer as $kf => $vf) {
                $vf->transfer_date . ' ยอดรับโอน ' . number_format($vf->transfer_amt, 2) . ' บาท';

                $this->transfer_list[$vf->id] = 'ครั้งที่ ' . ($kf + 1) . ' ณ วันที่ ' .  datetimeToThaiDatetime($vf->transfer_date, 'd M Y') . ' ยอดโอน ' . number_format($vf->transfer_amt, 2) . ' บาท';
            }
        }


        $this->OoapTblFybdtransfer = NULL;
        if( !empty( $this->fybdtransfer_id ) ) {

            $this->OoapTblFybdtransfer = OoapTblFybdtransfer::getDatas($this->fybdtransfer_id)->first();


            if(  $this->OoapTblFybdtransfer ) {

                // dd( $this->OoapTblFybdtransfer);

                $this->transfer_date = datetoview($this->OoapTblFybdtransfer->transfer_date);


                $this->transfer_amt = $this->OoapTblFybdtransfer->transfer_amt;
                $this->transfer_desp = $this->OoapTblFybdtransfer->transfer_desp;
            }
        }
    }



    public function submit($formData)
    {

        $this->validate([
            'fiscalyear_code' => 'required',
            'fybdperiod_id' => 'required',
            'transfer_date' => 'required',
            'transfer_amt' => 'required',
        ], [
            'fiscalyear_code.required' => 'กรุณากรอก ปีงบประมาณ',
            'fybdperiod_id.required' => 'กรุณากรอก งวดที่',
            'transfer_date.required' => 'กรุณากรอก วันที่รับโอน',
            'transfer_amt.required' => 'กรุณากรอก จำนวนเงิน',
        ]);


        if (!is_numeric(str_replace(',', '', $this->transfer_amt))) {
            return session()->flash('total_transfer_amt', 'กรุณากรอกข้อมูลตัวเลข');
        }

        $OoapTblBudgetProjectplanPeriod = OoapTblBudgetProjectplanPeriod::getDatas(NULL, $this->fiscalyear_code, $this->fybdperiod_id)->first();

        if ($OoapTblBudgetProjectplanPeriod) {

            $getSubDataTotals = OoapTblFybdtransfer::getSubDataTotals($OoapTblBudgetProjectplanPeriod->budget_id,  $this->fybdtransfer_id);

            $total_transfer_amt = floatval(str_replace(',', '', $this->transfer_amt)) + $getSubDataTotals['total_transfer_amt'];

            if ($total_transfer_amt > $OoapTblBudgetProjectplanPeriod->budgetperiod) {

                return session()->flash('total_transfer_amt', 'ไม่สามารถกรอกเกิน ' . number_format($OoapTblBudgetProjectplanPeriod->budgetperiod -  $getSubDataTotals['total_transfer_amt'], 2) . ' ได้');
            }

            $OoapTblFybdtransfer = OoapTblFybdtransfer::where('ooap_tbl_fybdtransfer.id', '=', $this->fybdtransfer_id)->first();

            if ($OoapTblFybdtransfer) {
                // dd($formData);

                $OoapTblFybdtransfer->update([
                    'parent_id' => $OoapTblBudgetProjectplanPeriod->budget_id,
                    'fiscalyear_code' => $this->fiscalyear_code,
                    'fybdperiod_id' => $this->fybdperiod_id,
                    'transfer_date' => datePickerThaiToDB($this->transfer_date),
                    'transfer_amt' => str_replace(',', '', $this->transfer_amt),
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->emp_citizen_id,
                    'transfer_desp' => addslashes($formData['transfer_desp']),
                ]);
            } else {

                OoapTblFybdtransfer::create([
                    'parent_id' => $OoapTblBudgetProjectplanPeriod->budget_id,
                    'fiscalyear_code' => $this->fiscalyear_code,
                    'fybdperiod_id' => $this->fybdperiod_id,
                    'transfer_date' => datePickerThaiToDB($this->transfer_date),
                    'transfer_amt' => str_replace(',', '', $this->transfer_amt),
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->emp_citizen_id,
                    'transfer_desp' => addslashes($formData['transfer_desp']),
                ]);
            }
        }

        $this->emit('popup');
    }



    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('manage.receivetransfer.index');
    }
}
