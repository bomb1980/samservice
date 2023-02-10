<?php

namespace App\Http\Livewire;

use App\Models\OoapMasActtype;
use App\Models\OoapMasDivision;
use App\Models\OoapMasGeopraphyTh;
use App\Models\OoapMasProvince;
use App\Models\OoapTblActivities;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblRequest;
use Livewire\Component;
use DateTime;

class DashboradLivewire extends Component
{
    public $fiscalyear_list, $fiscalyear_code, $acttype_list, $acttype_id, $periodno, $periodno_list, $dimension, $dimension_list, $geo_id, $geo_list, $division_id, $division_list;
    public $stdate, $endate, $startmonth, $endmonth;

    public function mount()
    {

    }

    public function render()
    {
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active','=',false)->orderBy('fiscalyear_code')->pluck('fiscalyear_code','fiscalyear_code as year_code');
        $this->periodno_list = OoapTblActivities::select('act_periodno')->where('in_active','=',false)->pluck('act_periodno','act_periodno');
        $this->acttype_list = OoapMasActtype::where('inactive','=',false)->pluck('name','id');
        $this->geo_list = OoapMasGeopraphyTh::where('in_active','=',false)->pluck('geo_name','geo_id');
        $this->dimension_list = ['1'=>'กิจกรรม','2'=>'ช่วงอายุ','3'=>'เพศ','4'=>'รายได้','5'=>'อาชีพหลัก','6'=>'หลักสูตร'];
        $this->division_list = OoapMasDivision::where('in_active','=',false)->pluck('division_name','division_id');

        if($this->fiscalyear_code)
        {
            $this->emit('setValue', $this->fiscalyear_code);
            $this->emit('select2');
        }

        if($this->acttype_id)
        {
            $this->emit('setAct', $this->acttype_id);
            $this->emit('select2');
        }

        if($this->geo_id)
        {
            $this->emit('setGeo', $this->geo_id);
            $this->emit('select2');
        }

        if($this->division_id)
        {
            $this->emit('setDiv', $this->division_id);
            $this->emit('select2');
        }

        if($this->dimension)
        {
            $this->emit('setDimension', $this->dimension);
            $this->emit('select2');
        }

        return view('livewire.dashborad-livewire');
    }

    // public function changeYear($val)
    // {
    //     $this->fiscalyear_code = $val;
    //     $this->emit('setValue', $this->fiscalyear_code);
    //     $this->emit('select2');
    // }

    public function changePeriod($val)
    {
        $this->periodno = $val;
        $this->emit('setPeriod', $this->periodno);
        $this->emit('select2');
    }

    // public function changeAct($val)
    // {
    //     $this->acttype_id = $val;
    //     $this->emit('setAct', $this->acttype_id);
    //     $this->emit('select2');
    // }

    // public function changeGeo($val)
    // {
    //     $this->geo_id = $val;
    //     $this->emit('setGeo', $this->geo_id);
    //     $this->emit('select2');
    // }

    // public function changeDimension($val)
    // {
    //     $this->dimension = $val;
    //     $this->emit('setDimension', $this->dimension);
    //     $this->emit('select2');
    // }

    public function setArray()
    {
        $this->startmonth = montYearsToDate($this->stdate);
        $this->endmonth = montYearsToDate($this->endate);
        $this->emit('startmonth', $this->startmonth);
        $this->emit('endmonth', $this->endmonth);
        $this->emit('select2');
    }
}
