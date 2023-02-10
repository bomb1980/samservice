<?php

namespace App\Http\Livewire;

use App\Models\OoapMasGeopraphyTh;
use App\Models\OoapMasProvince;
use App\Models\OoapTblPopulation;
use Livewire\Component;

class GenderDashboard extends Component
{
    public $gender_data = [],$geo_data = [],$pop_province = [], $geo_id, $pop_gender;
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
        $this->emit('genderchart',[
            'gender_data' => $this->gender_data,
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
        $this->pop_province[1] = [];
        $this->pop_province[2] = [];
        $this->pop_province[3] = [];
        $this->pop_province[4] = [];
        $this->pop_province[5] = [];
        $this->pop_province[6] = [];

        $gender = OoapTblPopulation::where('ooap_tbl_populations.in_active','=',false)
        ->leftjoin('ooap_mas_province','ooap_tbl_populations.pop_province','ooap_mas_province.province_id')
        ->leftjoin('ooap_mas_geopraphy_th','ooap_mas_province.geo_id','ooap_mas_geopraphy_th.geo_id')
        ->leftjoin('ooap_tbl_activities','ooap_tbl_populations.pop_actnumber','ooap_tbl_activities.act_number');
        if($this->fiscalyear_code)
        {
            $this->fiscalyear_code = substr($this->fiscalyear_code, 2, 2);
            $gender = $gender->where('pop_year','=',$this->fiscalyear_code);
        }
        if($this->periodno)
        {
            $gender = $gender->where('ooap_tbl_activities.act_periodno','=',$this->periodno);
        }
        if($this->startmonth)
        {
            $gender = $gender->where('ooap_tbl_activities.act_startmonth','>=',$this->startmonth);
        }
        if($this->endmonth)
        {
            $gender = $gender->where('ooap_tbl_activities.act_endmonth','<=',$this->endmonth);
        }
        if($this->pop_gender)
        {
            $gender = $gender->where('pop_gender','=',$this->pop_gender);
        }

        $gender_div = OoapTblPopulation::where('ooap_tbl_populations.in_active','=',false)
        ->leftjoin('ooap_mas_province','ooap_tbl_populations.pop_province','ooap_mas_province.province_id')
        ->leftjoin('ooap_mas_geopraphy_th','ooap_mas_province.geo_id','ooap_mas_geopraphy_th.geo_id');
        $gender_div = $gender_div->select('ooap_tbl_populations.pop_gender')->groupBy('ooap_tbl_populations.pop_gender')->get()->toArray();
        $gender_val = OoapTblPopulation::where('ooap_tbl_populations.in_active','=',false)
        ->leftjoin('ooap_mas_province','ooap_tbl_populations.pop_province','ooap_mas_province.province_id')
        ->leftjoin('ooap_mas_geopraphy_th','ooap_mas_province.geo_id','ooap_mas_geopraphy_th.geo_id');
        foreach($gender_div as $key => $val)
        {
            $gender_val = OoapTblPopulation::where('ooap_tbl_populations.pop_gender','like','%'.$val['pop_gender'].'%')->get();
            $gender_val = count($gender_val);
            $this->gender_data[$key] = array('name'=>$val['pop_gender'], 'y'=>$gender_val);
        }

        $geo_name = OoapMasGeopraphyTh::select('geo_id','geo_name')->where('in_active','=',false)->get()->toArray();
        foreach($geo_name as $key => $val)
        {
            $pop_geo = clone $gender;
            $pop_geo = $pop_geo->where('ooap_mas_province.geo_id','=',$val['geo_id'])->get()->toArray();
            $pop_geo_val = count($pop_geo);
            $this->geo_data[$key] = array('name'=>$val['geo_name'], 'y'=>$pop_geo_val);
        }

        $provinces_sec = OoapMasProvince::where('ooap_mas_province.in_active','=',false)
        ->where('ooap_mas_province.geo_id','=',$this->geo_id)->get()->toArray();
        foreach($provinces_sec as $key2 => $val2)
        {
            $provinces_val = clone $gender;
            $provinces_val = $provinces_val->where('ooap_tbl_populations.pop_province','=',$val2['province_id'])->get()->toArray();
            if($provinces_val){
                $provinces_val = count($provinces_val);
            } else {
                $provinces_val = 0;
            }
            $this->pop_province[$key2] = array('name'=>$val2['province_name'], 'y'=>$provinces_val);
        }

        $this->emit('genderchart',[
            'gender_data' => $this->gender_data,
            'geo_data' => $this->geo_data,
            'pop_province' => $this->pop_province
        ]);

        return view('livewire.gender-dashboard');
    }
}
