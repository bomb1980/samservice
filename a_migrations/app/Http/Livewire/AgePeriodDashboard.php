<?php

namespace App\Http\Livewire;

use App\Models\OoapMasGeopraphyTh;
use App\Models\OoapMasProvince;
use App\Models\OoapTblPopulation;
use Livewire\Component;

class AgePeriodDashboard extends Component
{
    public $youngAdult_val, $adult_val, $elder_val, $geo_id, $geo_data = [],$pop_province = [];
    public $bottom_age, $top_age;
    public $fiscalyear_code, $periodno, $dimension, $startmonth, $endmonth, $acttype_id, $division_id;
    protected $listeners = ['setValue','setPeriod','startmonth','endmonth','setDimension', 'setAct', 'setGeo', 'setDiv'];

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
        $this->emit('agechart', [
            'youngAdult_val' => $this->youngAdult_val,
            'adult_val' => $this->adult_val,
            'elder_val' => $this->elder_val,
            'geo_data' => $this->geo_data
        ]);

        if ($this->geo_id == 1) {
            $this->emit('province_north',[
                'pop_province' => $this->pop_province[1]
            ]);
        }
        elseif ($this->geo_id == 2) {
            $this->emit('province_center',[
                'pop_province' => $this->pop_province[2]
            ]);
        }
        elseif ($this->geo_id == 3) {
            $this->emit('province_north_e',[
                'pop_province' => $this->pop_province[3]
            ]);
        }
        elseif ($this->geo_id == 4) {
            $this->emit('province_west',[
                'pop_province' => $this->pop_province[4]
            ]);
        }
        elseif ($this->geo_id == 5) {
            $this->emit('province_east',[
                'pop_province' => $this->pop_province[5]
            ]);
        }
        elseif ($this->geo_id == 6) {
            $this->emit('province_south',[
                'pop_province' => $this->pop_province[6]
            ]);
        }
        else {
            $this->emit('province_center',[
                'pop_province' => $this->pop_province[2]
            ]);
        }
    }

    public function setAct($acttype_id)
    {
        $this->acttype_id = $acttype_id;
    }

    public function setGeo($geo_id)
    {
        $this->geo_id = $geo_id;
    }

    public function setDiv($division_id)
    {
        $this->division_id = $division_id;
    }

    public function render()
    {
        // $this->fiscalyear_code = 'abc';
        $pop = OoapTblPopulation::where('ooap_tbl_populations.in_active','=',false)
        ->leftjoin('ooap_mas_province','ooap_tbl_populations.pop_province','ooap_mas_province.province_id')
        ->leftjoin('ooap_mas_geopraphy_th','ooap_mas_province.geo_id','ooap_mas_geopraphy_th.geo_id')
        ->leftjoin('ooap_tbl_activities','ooap_tbl_populations.pop_actnumber','ooap_tbl_activities.act_number');
        if($this->fiscalyear_code)
        {
            $this->fiscalyear_code = substr($this->fiscalyear_code, 2, 2);
            $pop = $pop->where('pop_year','=',$this->fiscalyear_code);
        }
        if($this->periodno)
        {
            $pop = $pop->where('ooap_tbl_activities.act_periodno','=',$this->periodno);
        }
        if($this->startmonth)
        {
            $pop = $pop->where('ooap_tbl_activities.act_startmonth','>=',$this->startmonth);
        }
        if($this->endmonth)
        {
            $pop = $pop->where('ooap_tbl_activities.act_endmonth','<=',$this->endmonth);
        }
        if($this->bottom_age && $this->top_age)
        {
            $pop = $pop->where('pop_age','>=',$this->bottom_age)->where('pop_age','<=',$this->top_age);
        }

        $youngAdult = OoapTblPopulation::where('ooap_tbl_populations.in_active','=',false)
        ->leftjoin('ooap_mas_province','ooap_tbl_populations.pop_province','ooap_mas_province.province_id')
        ->leftjoin('ooap_mas_geopraphy_th','ooap_mas_province.geo_id','ooap_mas_geopraphy_th.geo_id');
        if($this->fiscalyear_code)
        {
            $this->fiscalyear_code = substr($this->fiscalyear_code, 2, 2);
            $youngAdult = $youngAdult->where('pop_year','=',$this->fiscalyear_code);
        }
        $youngAdult = $youngAdult->where('pop_age','>=',18)->where('pop_age','<=',25)->get()->toArray();
        $this->youngAdult_val = count($youngAdult);

        $adult = OoapTblPopulation::where('ooap_tbl_populations.in_active','=',false)
        ->leftjoin('ooap_mas_province','ooap_tbl_populations.pop_province','ooap_mas_province.province_id')
        ->leftjoin('ooap_mas_geopraphy_th','ooap_mas_province.geo_id','ooap_mas_geopraphy_th.geo_id');
        if($this->fiscalyear_code)
        {
            $this->fiscalyear_code = substr($this->fiscalyear_code, 2, 2);
            $adult = $adult->where('pop_year','=',$this->fiscalyear_code);
        }
        $adult = $adult->where('pop_age','>=',26)->where('pop_age','<=',40)->get()->toArray();
        $this->adult_val = count($adult);

        $elder = OoapTblPopulation::where('ooap_tbl_populations.in_active','=',false)
        ->leftjoin('ooap_mas_province','ooap_tbl_populations.pop_province','ooap_mas_province.province_id')
        ->leftjoin('ooap_mas_geopraphy_th','ooap_mas_province.geo_id','ooap_mas_geopraphy_th.geo_id');
        if($this->fiscalyear_code)
        {
            $this->fiscalyear_code = substr($this->fiscalyear_code, 2, 2);
            $elder = $elder->where('pop_year','=',$this->fiscalyear_code);
        }
        $elder = $elder->where('pop_age','>=',41)->where('pop_age','<=',60)->get()->toArray();
        $this->elder_val = count($elder);

        $geo_name = OoapMasGeopraphyTh::select('geo_id','geo_name')->where('in_active','=',false)->get()->toArray();
        foreach($geo_name as $key => $val)
        {
            $pop_geo = clone $pop;
            $pop_geo = $pop_geo->where('ooap_mas_province.geo_id','=',$val['geo_id'])->get()->toArray();
            $pop_geo_val = count($pop_geo);
            $this->geo_data[$key] = array('name'=>$val['geo_name'], 'y'=>$pop_geo_val);
        }


        $this->pop_province[1] = [];
        $this->pop_province[2] = [];
        $this->pop_province[3] = [];
        $this->pop_province[4] = [];
        $this->pop_province[5] = [];
        $this->pop_province[6] = [];
        // $this->pop_province[1] = [];

        foreach($geo_name as $key => $val)
        {
            $provinces_sec = OoapMasProvince::where('ooap_mas_province.in_active','=',false)
            ->where('ooap_mas_province.geo_id','=',$val['geo_id'])->get()->toArray();
            foreach($provinces_sec as $key2 => $val2)
            {
                $provinces_val[$val['geo_id']] = clone $pop;
                $provinces_val[$val['geo_id']] = $provinces_val[$val['geo_id']]
                ->where('ooap_tbl_populations.pop_province','=',$val2['province_id'])
                ->get()->toArray();
                if($provinces_val[$val['geo_id']]){
                    $provinces_val[$val['geo_id']] = count($provinces_val[$val['geo_id']]);
                } else {
                    $provinces_val[$val['geo_id']] = 0;
                }
                $this->pop_province[$val['geo_id']][$key2] = array('name'=>$val2['province_name'], 'y'=>$provinces_val[$val['geo_id']]);
            }
        }

        $this->emit('agechart', [
            'youngAdult_val' => $this->youngAdult_val,
            'adult_val' => $this->adult_val,
            'elder_val' => $this->elder_val,
            'geo_data' => $this->geo_data
        ]);


        if ($this->geo_id == 1) {
            $this->emit('province_north',[
                'pop_province' => $this->pop_province[1]
            ]);
        }
        elseif ($this->geo_id == 2) {
            $this->emit('province_center',[
                'pop_province' => $this->pop_province[2]
            ]);
        }
        elseif ($this->geo_id == 3) {
            $this->emit('province_north_e',[
                'pop_province' => $this->pop_province[3]
            ]);
        }
        elseif ($this->geo_id == 4) {
            $this->emit('province_west',[
                'pop_province' => $this->pop_province[4]
            ]);
        }
        elseif ($this->geo_id == 5) {
            $this->emit('province_east',[
                'pop_province' => $this->pop_province[5]
            ]);
        }
        elseif ($this->geo_id == 6) {
            $this->emit('province_south',[
                'pop_province' => $this->pop_province[6]
            ]);
        }
        else {
            $this->emit('province_center',[
                'pop_province' => $this->pop_province[2]
            ]);
        }
        return view('livewire.age-period-dashboard');
    }
}
