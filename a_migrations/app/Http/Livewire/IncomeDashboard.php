<?php

namespace App\Http\Livewire;

use App\Models\OoapMasGeopraphyTh;
use App\Models\OoapMasProvince;
use App\Models\OoapTblPopulation;
use Livewire\Component;

class IncomeDashboard extends Component
{
    public $geo_data = [],$pop_province = [], $geo_id, $pop_income_male, $pop_income_female;
    public $fiscalyear_code, $periodno, $dimension, $startmonth, $endmonth;
    protected $listeners = ['setValue','setPeriod','startmonth','endmonth','setDimension'];

    public function setValue($fiscalyear_code)
    {
        $this->fiscalyear_code = $fiscalyear_code;
    }

    public function setPeriod($periodno)
    {
        $this->periodno = $periodno;
    }

    public function startmonth($startmonth)
    {
        $this->startmonth = $startmonth;
    }

    public function endmonth($endmonth)
    {
        $this->endmonth = $endmonth;
    }

    public function setDimension($dimension)
    {
        $this->dimension = $dimension;
        $this->emit('incomechart',[
            'pop_income_male' => $this->pop_income_male,
            'pop_income_female' => $this->pop_income_female,
            'geo_data' => $this->geo_data,
            'pop_province' => $this->pop_province
        ]);
    }

    public function mount()
    {
        $this->geo_id = 2;
    }

    public function render()
    {
        $income = OoapTblPopulation::where('ooap_tbl_populations.in_active','=',false)
        ->leftjoin('ooap_mas_province','ooap_tbl_populations.pop_province','ooap_mas_province.province_id')
        ->leftjoin('ooap_mas_geopraphy_th','ooap_mas_province.geo_id','ooap_mas_geopraphy_th.geo_id')
        ->leftjoin('ooap_tbl_activities','ooap_tbl_populations.pop_actnumber','ooap_tbl_activities.act_number');
        if($this->fiscalyear_code)
        {
            $this->fiscalyear_code = substr($this->fiscalyear_code, 2, 2);
            $income = $income->where('ooap_tbl_populations.pop_year','=',$this->fiscalyear_code);
        }
        if($this->periodno)
        {
            $income = $income->where('ooap_tbl_activities.act_periodno','=',$this->periodno);
        }
        if($this->startmonth)
        {
            $income = $income->where('ooap_tbl_activities.act_startmonth','>=',$this->startmonth);
        }
        if($this->endmonth)
        {
            $income = $income->where('ooap_tbl_activities.act_endmonth','<=',$this->endmonth);
        }

        $pop_income_male = clone $income;
        $pop_income_male_count = clone $income;
        $pop_income_male_count = $pop_income_male_count->where('ooap_tbl_populations.pop_gender','=','ชาย')->count();
        $pop_income_female = clone $income;
        $pop_income_female_count = clone $income;
        $pop_income_female_count = $pop_income_female_count->where('ooap_tbl_populations.pop_gender','=','หญิง')->count();
        $this->pop_income_male = $pop_income_male->select('ooap_tbl_populations.pop_income')->where('ooap_tbl_populations.pop_gender','=','ชาย')->sum('ooap_tbl_populations.pop_income');
        if( empty( $pop_income_male_count ) ) {

            $this->pop_income_male = 0;
        }
        else {

            $this->pop_income_male = (int) $this->pop_income_male / $pop_income_male_count;
        }
        $this->pop_income_female = $pop_income_female->select('ooap_tbl_populations.pop_income')->where('ooap_tbl_populations.pop_gender','=','หญิง')->sum('ooap_tbl_populations.pop_income');

        if( empty( $pop_income_female_count ) ) {

            $this->pop_income_female = 0;
        }
        else {

            $this->pop_income_female = (int) $this->pop_income_female / $pop_income_female_count;
        }

        $geo_name = OoapMasGeopraphyTh::select('geo_id','geo_name')->where('in_active','=',false)->get()->toArray();
        foreach($geo_name as $key => $val)
        {
            $pop_geo = clone $income;
            $pop_geo = $pop_geo->where('ooap_mas_province.geo_id','=',$val['geo_id'])->get()->toArray();
            $pop_geo_val = count($pop_geo);
            $this->geo_data[$key] = array('name'=>$val['geo_name'], 'y'=>$pop_geo_val);
        }

        $provinces_sec = OoapMasProvince::where('ooap_mas_province.in_active','=',false)
        ->where('ooap_mas_province.geo_id','=',$this->geo_id)->get()->toArray();
        foreach($provinces_sec as $key2 => $val2)
        {
            $provinces_val = clone $income;
            $provinces_val = $provinces_val->where('ooap_tbl_populations.pop_province','=',$val2['province_id'])->get()->toArray();
            if($provinces_val){
                $provinces_val = count($provinces_val);
            } else {
                $provinces_val = 0;
            }
            $this->pop_province[$key2] = array('name'=>$val2['province_name'], 'y'=>$provinces_val);
        }

        $this->emit('incomechart',[
            'pop_income_male' => $this->pop_income_male,
            'pop_income_female' => $this->pop_income_female,
            'geo_data' => $this->geo_data,
            'pop_province' => $this->pop_province
        ]);

        return view('livewire.income-dashboard');
    }
}
