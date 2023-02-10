<?php

namespace App\Http\Livewire;

use App\Models\OoapMasGeopraphyTh;
use App\Models\OoapMasProvince;
use App\Models\OoapTblPopulation;
use Livewire\Component;

class CourseDashboard extends Component
{
    public $geo_data = [],$pop_province = [], $geo_id, $course_name = [], $course_income = [];
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
        $this->emit('coursechart',[
            'course_name' => $this->course_name,
            'course_income' => $this->course_income,
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
        $course = OoapTblPopulation::where('ooap_tbl_populations.in_active','=',false)
        ->leftjoin('ooap_mas_province','ooap_tbl_populations.pop_province','ooap_mas_province.province_id')
        ->leftjoin('ooap_mas_geopraphy_th','ooap_mas_province.geo_id','ooap_mas_geopraphy_th.geo_id')
        ->leftjoin('ooap_tbl_activities','ooap_tbl_populations.pop_actnumber','ooap_tbl_activities.act_number')
        ->leftjoin('ooap_mas_course','ooap_tbl_activities.act_course','ooap_mas_course.id');
        if($this->fiscalyear_code)
        {
            $this->fiscalyear_code = substr($this->fiscalyear_code, 2, 2);
            $course = $course->where('pop_year','=',$this->fiscalyear_code);
        }
        if($this->periodno)
        {
            $course = $course->where('ooap_tbl_activities.act_periodno','=',$this->periodno);
        }
        if($this->startmonth)
        {
            $course = $course->where('ooap_tbl_activities.act_startmonth','>=',$this->startmonth);
        }
        if($this->endmonth)
        {
            $course = $course->where('ooap_tbl_activities.act_endmonth','<=',$this->endmonth);
        }

        $course_name = clone $course;
        $course_name = $course_name->select('ooap_tbl_activities.act_number', 'ooap_tbl_activities.act_course','ooap_mas_course.name')
        ->where('ooap_tbl_activities.act_course','!=',null)
        ->groupBy('ooap_tbl_activities.act_number', 'ooap_tbl_activities.act_course','ooap_mas_course.name')
        ->get()->toArray();
        foreach($course_name as $key => $val)
        {
            $this->course_name[$key] = $val['name'];
            $course_income = clone $course;
            $course_income = $course_income->where('ooap_tbl_activities.act_course','=',$val['act_course'])->avg('ooap_tbl_populations.pop_income');
            $course_income = (int) $course_income;
            $this->course_income[$key] = $course_income;
        }
        // dd($this->course_income);

        $geo_name = OoapMasGeopraphyTh::select('geo_id','geo_name')->where('in_active','=',false)->get()->toArray();
        foreach($geo_name as $key => $val)
        {
            $pop_geo = clone $course;
            $pop_geo = $pop_geo->where('ooap_mas_province.geo_id','=',$val['geo_id'])->get()->toArray();
            $pop_geo_val = count($pop_geo);
            $this->geo_data[$key] = array('name'=>$val['geo_name'], 'y'=>$pop_geo_val);
        }

        $provinces_sec = OoapMasProvince::where('ooap_mas_province.in_active','=',false)
        ->where('ooap_mas_province.geo_id','=',$this->geo_id)->get()->toArray();
        foreach($provinces_sec as $key2 => $val2)
        {
            $provinces_val = clone $course;
            $provinces_val = $provinces_val->where('ooap_tbl_populations.pop_province','=',$val2['province_id'])->get()->toArray();
            if($provinces_val){
                $provinces_val = count($provinces_val);
            } else {
                $provinces_val = 0;
            }
            $this->pop_province[$key2] = array('name'=>$val2['province_name'], 'y'=>$provinces_val);
        }

        $this->emit('coursechart',[
            'course_name' => $this->course_name,
            'course_income' => $this->course_income,
            'geo_data' => $this->geo_data,
            'pop_province' => $this->pop_province
        ]);

        return view('livewire.course-dashboard');
    }
}
