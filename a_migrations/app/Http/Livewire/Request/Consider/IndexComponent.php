<?php

namespace App\Http\Livewire\Request\Consider;

use App\Models\OoapMasActtype;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblRequest;
use App\Models\OoapTblEmployee;
use Livewire\Component;
use DateTime;

class IndexComponent extends Component
{
    public $selecterC1, $selecterC2, $selecterC3 , $selecterC4, $selecterC5;
    public $selecterS1, $selecterS2, $selecterS3 , $selecterS4, $selecterS5;

    public $divi_list, $divi_code;

    public $fiscalyear_list;
    public $left_fiscalyear_list;

    public $years_list, $years_code = '';
    public $acttype_list, $acttype_code;

    public $division_id;

    public $total_count, $total_sum;

    public $select_record_list;

    public $initial = 5;

    public function mount()
    {
        // $this->division_id = auth()->user()->division_id;
        $this->divi_list = OoapTblEmployee::where('in_active', '=', false)->whereNotNull('division_name')->groupBy('division_name')->pluck('division_name','division_name');

        // $this->years_list = OoapTblRequest::whereIn('status',["2", "3", "4"])->groupBy('req_year')->pluck('req_year','req_year');
        $this->years_list = OoapTblRequest::where('in_active', '=', false)->whereIn('status',["2", "3", "4"])->groupBy('req_year')->orderBy('req_year', 'DESC')->pluck('req_year');
        $this->acttype_list = OoapMasActtype::where('inactive', '=', false)->groupBy('name')->pluck('name','name');

        $fiscalYeardata = OoapTblFiscalyear::where('in_active', '=', false)->wherein('fiscalyear_code',$this->years_list)->get();
        foreach ($fiscalYeardata as $value) {

            $this->selecterC2[$value->fiscalyear_code] = OoapTblRequest::where('in_active', '=', false)->where('req_year', $value->fiscalyear_code)->where('status', "2")->get()->count();
            $this->selecterS2[$value->fiscalyear_code] = number_format(OoapTblRequest::where('in_active', '=', false)->where('req_year', $value->fiscalyear_code)->where('status', "2")->sum('req_amount'), 2);

            $this->selecterC3[$value->fiscalyear_code] = OoapTblRequest::where('req_year', $value->fiscalyear_code)->where('status', "3")->get()->count();
            $this->selecterS3[$value->fiscalyear_code] = number_format(OoapTblRequest::where('in_active', '=', false)->where('req_year', $value->fiscalyear_code)->where('status', "3")->sum('req_amount'), 2);

            $this->selecterC4[$value->fiscalyear_code] = OoapTblRequest::where('in_active', '=', false)->where('req_year', $value->fiscalyear_code)->where('status', "4")->get()->count();
            $this->selecterS4[$value->fiscalyear_code] = number_format(OoapTblRequest::where('in_active', '=', false)->where('req_year', $value->fiscalyear_code)->where('status', "4")->sum('req_amount'), 2);

            $this->selecterC5[$value->fiscalyear_code] = OoapTblRequest::where('in_active', '=', false)->where('req_year', $value->fiscalyear_code)->whereIn('status',["2", "3", "4"])->get()->count();
            $this->selecterS5[$value->fiscalyear_code] = number_format(OoapTblRequest::where('in_active', '=', false)->where('req_year', $value->fiscalyear_code)->whereIn('status',["2", "3", "4"])->sum('req_amount'), 2);
        }
        $this->selecterC2["all"] = OoapTblRequest::where('in_active', '=', false)->where('status', "2")->get()->count();
        $this->selecterS2["all"] = number_format(OoapTblRequest::where('in_active', '=', false)->where('status', "2")->sum('req_amount'), 2);

        $this->selecterC3["all"] = OoapTblRequest::where('in_active', '=', false)->where('status', "3")->get()->count();
        $this->selecterS3["all"] = number_format(OoapTblRequest::where('status', "3")->sum('req_amount'), 2);

        $this->selecterC4["all"] = OoapTblRequest::where('in_active', '=', false)->where('status', "4")->get()->count();
        $this->selecterS4["all"] = number_format(OoapTblRequest::where('in_active', '=', false)->where('status', "4")->sum('req_amount'), 2);

        $this->selecterC5["all"] = OoapTblRequest::where('in_active', '=', false)->whereIn('status',["2", "3", "4"])->get()->count();
        $this->selecterS5["all"] = number_format(OoapTblRequest::where('in_active', '=', false)->whereIn('status',["2", "3", "4"])->sum('req_amount'), 2);

    }

    public function render()
    {
        $this->emit('emits');
        return view('livewire.request.consider.component');
    }
}
