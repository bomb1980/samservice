<?php

namespace App\Http\Livewire\Manage\Installment;

use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFybdperiod;
use Livewire\Component;

class InstallmentEditComponent extends Component
{
    public $period_id, $fiscalyear_select, $fiscalyear_code, $databudget_list, $startdate, $enddate, $period_no, $budget_amt, $period_rate, $period_amt;
    public $left_per, $left_amt;
    public $datas;
    public $budget_id;
    public $sub_datas;

    public function render()
    {

        $fdfdd = OoapTblFiscalyear::getDatas(NULL,$this->datas->fiscalyear_code, NULL)->first();

        // dd($fdfdd );

        if($fdfdd) {


            $this->period_rate = number_format(  doMoney($this->set_sub_data['budgetperiod']) / $fdfdd->budget_amt  * 100, 2);
        }
        else {
            $this->period_rate = 0;

        }

        // $this->emit('dddddfdfdfdf');

        return view('livewire.manage.installment.installment-edit-component');
    }

    public function redirect_to()
    {
        return redirect()->route('manage.fiscal.save2', ['id' => $this->datas->id]);
    }

    public function mount()
    {
        $this->sub_datas = OoapTblBudgetProjectplanPeriod::setSubDatas($this->datas->fiscalyear_code);

        $this->sub_totals = OoapTblBudgetProjectplanPeriod::getSubDataTotals($this->datas->fiscalyear_code);


        foreach ($this->sub_datas as $ka => $va) {

            if ($va['budget_id'] == $this->budget_id) {


                $this->set_sub_data =  $this->sub_datas[$ka];

                $this->edit_index = $ka;

                break;
            }
        }

        if (empty($this->set_sub_data)) {

            $this->edit_index = NULL;

            $this->set_sub_data = [];
            $this->set_sub_data['periodno'] = count( $this->sub_datas ) + 1;
            // $this->set_sub_data['budgetratio'] = 100 - $this->sub_totals['total_budgetratio'];

            $this->set_sub_data['budgetperiod'] = number_format($this->datas->budget_amt -  $this->sub_totals['total_budgetperiod'], 2);
        }

        $this->fiscalyear_select = OoapTblFiscalyear::where('in_active', '=', false)->get()->pluck('fiscalyear_code', 'fiscalyear_code');





    //   dd(  $this->sub_totals);

    }



    function submit()
    {
        $validate[0] = [
            'set_sub_data.startperioddate' => 'required',
            'set_sub_data.endperioddate' => 'required',
            'set_sub_data.budgetperiod' => 'required',
            // 'set_sub_data.budgetratio' => 'required',
        ];

        $validate[1] = [
            'set_sub_data.startperioddate.required' => 'กรุณากรอกช่วงเวลาเริ่มต้น',
            'set_sub_data.endperioddate.required' => 'กรุณากรอกช่วงเวลาสิ้นสุด',
            'set_sub_data.budgetperiod.required' => 'กรุณากรอกจำนวนเงิน',
            // 'set_sub_data.budgetratio.required' => 'required',
        ];

        // dd('ddddsfd');
        $this->validate($validate[0], $validate[1]);

        if (empty($this->set_sub_data['budget_id'])) {
            $this->set_sub_data['budget_id'] = NULL;
        }

        $getSubDataTotal = OoapTblBudgetProjectplanPeriod::getSubDataTotals_($this->datas->fiscalyear_code, $this->set_sub_data['budget_id']);

        $sdfads = $getSubDataTotal['total_budgetperiod'] + doMoney($this->set_sub_data['budgetperiod']);

        $error = false;
        if ($sdfads > $this->datas->budget_amt) {

            $error = true;
            session()->flash('getSubDataTotal', 'ไม่สามารถกรอกเกิน ' . ($this->datas->budget_amt - $getSubDataTotal['total_budgetperiod'])   . ' ได้');

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

        $todb = $this->set_sub_data;

        $todb['updated_at'] = now();
        $todb['created_at'] = now();
        $todb['startperioddate'] = datePickerThaiToDB('01/' . $todb['startperioddate']);
        $todb['endperioddate'] = datePickerThaiToDB('01/' . $todb['endperioddate']);

        $todb['budget_transferdate'] = empty($todb['budget_transferdate']) ? NULL : datePickerThaiToDB($todb['budget_transferdate']);

        $todb['budgetperiod'] = doMoney($todb['budgetperiod']);

        $todb['budgetyear'] = $this->datas->fiscalyear_code;

        unset($todb['total_transfer_amt']);

        if (isset($this->edit_index)) {

            OoapTblBudgetProjectplanPeriod::where('budget_id', $this->sub_datas[$this->edit_index]['budget_id'])->update($todb);
        } else {


            // dd('dsads');

            OoapTblBudgetProjectplanPeriod::create($todb);
        }

        $this->emit('popup');
    }


    protected $listeners = ['redirect-to' => 'redirect_to'];



    public function thisReset()
    {
        return redirect()->route('manage.installment.index');
    }


    public function submit____()
    {


        return false;
        // dd($this);
        $this->validate([
            'fiscalyear_code' => 'required',
            'period_no' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'period_rate' => 'required',
            'period_amt' => 'numeric|max:' . $this->left_amt,
        ], [
            'fiscalyear_code.required' => 'กรุณาเลือก ปีงบประมาณ',
            'period_no.required' => 'กรุณากรอก งวดที่',
            'startdate.required' => 'กรุณากรอก ช่วงเวลาเริ่มต้น',
            'enddate.required' => 'กรุณากรอก ช่วงเวลาสิ้นสุด',
            'period_rate.required' => 'กรุณากรอก สัดส่วน',
            'period_amt.required' => 'กรุณากรอก จำนวนเงิน',
            'period_amt.max' => 'กรุณากรอก จำนวนเงินไม่เกิน ' . $this->left_amt,
        ]);
        // dd();
        $OoapTblFybdperiod = OoapTblFybdperiod::where('id', '=', $this->period_id)->update([
            'fiscalyear_code' => $this->fiscalyear_code,
            'period_no' => $this->period_no,
            'startdate' => montYearsToDate($this->startdate),
            'enddate' => montYearsToDate($this->enddate),
            'period_month' => 1,
            'period_rate' => $this->period_rate,
            'period_amt' => $this->period_amt,
            'updated_at' => now(),
            'updated_by' => auth()->user()->emp_citizen_id,
        ]);
        $this->emit('popup');
    }
}
