<?php

namespace App\Http\Livewire\Request\SumList;

use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblReqform;
use Livewire\Component;

class IndexComponent extends Component
{
    public $sum_total_labour = [], $sum_total_skill = [], $fiscalyear_list, $fiscalyear_code, $reqform;
    public $sum_total_labour2, $sum_total_skill2, $total_sum2, $req_amt, $total_amt = [], $total_amt2 = [], $sum_noyear;
    public $reqform_no_labour = [], $actname_labour = [], $reqform_no_skill = [], $actname_skill = [];
    public $reqform_no_labour2 = [], $actname_labour2 = [], $reqform_no_skill2 = [], $actname_skill2 = [];
    public $datas;
    // public $fiscalyear_code = 2565;

    public function render()
    {

        return view('livewire.request.save.save-component');
    }

    public function mount()
    {
        $this->req_amt = 0;

        $this->fiscalyear_list = OoapTblFiscalyear::pluck('fiscalyear_code', 'fiscalyear_code as new');

        $this->fiscalyear_code = date("Y") + 543;

        $this->reqform = OoapTblReqform::where('in_active', '=', false)->where('fiscalyear_code', '=', $this->fiscalyear_code)->get() ?? null;

        $this->sum_total_skill = OoapTblReqform::where('in_active', '=', false)->where('status', '=', 3)
            ->where('fiscalyear_code', '=', $this->fiscalyear_code)
            ->where('acttype_id', '=', 2)->get()->sum('total_amt') ?? 0;
        $this->sum_total_labour = OoapTblReqform::where('in_active', '=', false)->where('status', '=', 3)
            ->where('fiscalyear_code', '=', $this->fiscalyear_code)
            ->where('acttype_id', '=', 1)->get()->sum('total_amt') ?? 0;

        $this->total_sum2 = $this->sum_total_skill + $this->sum_total_labour;

        $dfdffd = OoapTblFiscalyear::select('req_amt')->where('fiscalyear_code', '=', $this->fiscalyear_code)->first();

        if ($dfdffd) {

            $this->req_amt = $dfdffd->req_amt;
        }

        if ($this->req_amt == 0) {
            $this->total_sum2 = $this->sum_total_skill + $this->sum_total_labour;

            $this->req_amt = $this->total_sum2;
        }


        $this->req_amt = $this->datas->req_amt;
    }

    public function submit()
    {

        OoapTblFiscalyear::where('id', '=', $this->datas->id)
            ->update([
                'req_amt' => str_replace(',', '', $this->req_amt),
                'status' => 2,
                'remember_token' => csrf_token(),
                'updated_by' => auth()->user()->emp_citizen_id,
                'updated_at' => now(),
            ]);



        $this->emit('popup');
    }

    public function changeYears_backup($val)
    {
        $this->fiscalyear_code = $val;

        $this->reqform = OoapTblReqform::where('in_active', '=', false)->where('fiscalyear_code', '=', $this->fiscalyear_code)->get() ?? null;

        $req = OoapTblReqform::where('in_active', '=', false)->where('status', '=', 3)->where('fiscalyear_code', '=', $this->fiscalyear_code)
            ->pluck('total_amt');

        $fiscalyear_mount = OoapTblFiscalyear::where('in_active', '=', false)->where('fiscalyear_code', '=', $this->fiscalyear_code)
            ->pluck('req_amt')->first();

        // $req_amt_mount = $fiscalyear_mount;

        if (!$req->isEmpty()) {
            foreach ($req as $key => $val) {
                $req_arr[$key] = $val;
            }
            if ($fiscalyear_mount) {
                $this->req_amt = $fiscalyear_mount;
            } else {
                $this->req_amt = array_sum($req_arr);
            }
        } else {
            $this->req_amt = 0;
        }

        // dd($req_amt_mount);
    }

    public function changeYears($val)
    {
        $this->fiscalyear_code = $val;

        $this->reqform = OoapTblReqform::where('in_active', '=', false)->where('fiscalyear_code', '=', $this->fiscalyear_code)->get();

        $this->sum_total_skill = OoapTblReqform::where('in_active', '=', false)->where('status', '=', 3)
            ->where('fiscalyear_code', '=', $this->fiscalyear_code)
            ->where('acttype_id', '=', 2)->get()->sum('total_amt') ?? 0;
        $this->sum_total_labour = OoapTblReqform::where('in_active', false)->where('status', '=', 3)
            ->where('fiscalyear_code', '=', $this->fiscalyear_code)
            ->where('acttype_id', '=', 1)->get()->sum('total_amt') ?? 0;

        $this->total_sum2 = $this->sum_total_skill + $this->sum_total_labour;

        // $this->reqform = OoapTblReqform::where('in_active', false)->where('fiscalyear_code', $this->fiscalyear_id)->get();
        $this->req_amt = OoapTblFiscalyear::select('req_amt')->where('fiscalyear_code', '=', $this->fiscalyear_code)->first()->req_amt;
        if ($this->req_amt == 0) {
            $this->req_amt = OoapTblReqform::where('in_active', '=', false)->where('status', '=', 3)->where('fiscalyear_code', '=', $this->fiscalyear_code)->sum('total_amt') ?? 0;
        }
    }



    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('request.sum_list.index');
    }
}
