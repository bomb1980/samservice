<?php

namespace App\Http\Livewire\Manage\FiscalyearCls;

use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFybdpayment;
use App\Models\OoapTblReqform;
use Livewire\Component;

class IndexComponent extends Component
{
    public $fiscalyear_list, $fiscalyear_code, $total_sum, $total_sum_labour, $total_sum_train, $req_amt, $budget_amt, $refund_amt, $centerbudget_amt, $regionbudget_amt,
        $total_budget_off, $parent_datas;

    public function render()
    {
        return view('livewire.manage.fiscalyear_cls.index-component');
    }

    public function mount()
    {

        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)
            // ->where('req_status',1)
            ->pluck('fiscalyear_code', 'fiscalyear_code AS fiscalyear_code2');

        $this->fiscalyear_code = date("Y") + 543;

        $req_get = OoapTblReqform::where('in_active', '=', false)->where('fiscalyear_code', '=', $this->fiscalyear_code)
            ->where('status', '=', 3)->get()->toArray();

        foreach ($req_get as $key => $val) {
            $total_sum[] = $val['total_amt'];
        }

        $fiscal_get = OoapTblFiscalyear::where('in_active', '=', false)->where('fiscalyear_code', '=', $this->fiscalyear_code)
            ->where('status', '=', 3)
            // ->where('req_status',1)
            ->first();

        if ($req_get) {
            $this->req_amt = $fiscal_get->req_amt ?? 0;
            $this->total_sum = array_sum($total_sum);
            $this->budget_amt = $fiscal_get->budget_amt ?? 0;
            $this->centerbudget_amt = OoapTblFybdpayment::where('in_active', '=', 0)->where('fiscalyear_code', '=', $this->fiscalyear_code)->sum('pay_amt');
        } else {
            $this->req_amt = null;
            $this->total_sum = null;
            $this->budget_amt = null;
            $this->centerbudget_amt = null;
            $this->regionbudget_amt = null;
            $this->total_budget_off =  null;
            $this->refund_amt = null;
        }
    }

    public function submit()
    {
        $this->validate([
            'fiscalyear_code' => 'required',
            'total_sum' => 'required',
            'req_amt' => 'required',
            'budget_amt' => 'required',
            'centerbudget_amt' => 'required',
            'regionbudget_amt' => 'required',
            'total_budget_off' => 'required',
            'refund_amt' => 'required',
        ], [
            'fiscalyear_code.required' => 'กรุณาเลือก ปีงบประมาณ',
            'total_sum.required' => 'ปีงบประมาณนี้ยังไม่มีการทำรายงานคำของบประมาณ',
            'req_amt.required' => 'ปีงบประมาณนี้ยังไม่มีการทำรายงานเสนองบประมาณ',
            'budget_amt.required' => 'ปีงบประมาณนี้ยังไม่มีการอนุมัติงบประมาณ',
            'centerbudget_amt.required' => 'ปีงบประมาณนี้ยังไม่มีการจัดสรรงบประมาณส่วนกลาง',
            'regionbudget_amt.required' => 'ปีงบประมาณนี้ยังไม่มีการจัดสรรงบประมาณส่วนภูมิภาค',
            'total_budget_off.required' => 'ปีงบประมาณนี้ยังไม่สามารถคำนวณค่าใช้จ่ายจากการจัดสรรได้',
            'refund_amt.required' => 'ปีงบประมาณนี้ไม่สามารถคำนวณค่าคืนเงินแผ่นดินได้',
        ]);
        OoapTblFiscalyear::where('fiscalyear_code', '=', $this->fiscalyear_code)
            ->update([
                'refund_amt' => $this->refund_amt,
                'updated_by' => auth()->user()->emp_citizen_id,
                'updated_at' => now(),
            ]);
        $this->emit('popup');
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('manage.fiscalyear_cls.index');
    }

    // public function setValue($name, $val)
    // {
    //     dd($name, $val);
    //     $this->$name = $val;
    // }

    public function changeYears($year)
    {
        $this->fiscalyear_code = $year;

        $req_get = OoapTblReqform::where('in_active', '=', false)->where('fiscalyear_code', '=', $this->fiscalyear_code)
            ->where('status', '=', 3)->get()->toArray();

        // $this->total_sum_labour = OoapTblReqform::where('in_active', false)->where('fiscalyear_code', $this->fiscalyear_code)
        // ->where('acttype_id', 1)->where('status', 3)->sum('total_amt');
        // $this->total_sum_train = OoapTblReqform::where('in_active', false)->where('fiscalyear_code', $this->fiscalyear_code)
        // ->where('acttype_id', 2)->where('status', 3)->sum('total_amt');

        foreach ($req_get as $key => $val) {
            $total_sum[] = $val['total_amt'];
        }

        $fiscal_get = OoapTblFiscalyear::where('in_active', '=', false)->where('fiscalyear_code', '=', $this->fiscalyear_code)
            ->where('status', '=', 3)
            // ->where('req_status',1)
            ->first();

        // dd($req_get);

        if ($req_get) {
            $this->req_amt = $fiscal_get->req_amt;
            $this->total_sum = array_sum($total_sum);
            $this->budget_amt = $fiscal_get->budget_amt;
            // $this->centerbudget_amt = $fiscal_get->centerbudget_amt;
            $this->centerbudget_amt = OoapTblFybdpayment::where('in_active', '=', 0)->where('fiscalyear_code', '=', $this->fiscalyear_code)->sum('pay_amt');
            // $this->regionbudget_amt = $fiscal_get->regionbudget_amt;
            // $this->total_budget_off =  $this->total_sum_labour + $this->total_sum_train;
            // $this->refund_amt = $this->budget_amt - $this->total_budget_off;
        } else {
            $this->req_amt = null;
            $this->total_sum = null;
            $this->budget_amt = null;
            $this->centerbudget_amt = null;
            $this->regionbudget_amt = null;
            $this->total_budget_off =  null;
            $this->refund_amt = null;
        }

        // dd($this->total_sum);
    }
}
