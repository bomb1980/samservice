<?php

namespace App\Http\Livewire;

use App\Models\OoapMasActtype;
use App\Models\OoapMasGeopraphyTh;
use App\Models\OoapMasProvince;
use App\Models\OoapTblActivities;
use Livewire\Component;

class ActDashboard extends Component
{
    public $acttype_id, $geo_id, $act_val = [], $geo_data = [], $act_province = [], $division_id;
    public $fiscalyear_code, $periodno;
    public $startmonth, $endmonth;
    public $dimension;
    protected $listeners = ['setValue', 'setPeriod', 'startmonth', 'endmonth', 'setDimension', 'setAct', 'setGeo', 'setDiv'];

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
        $this->emit('act_list', [
            'act_val' => $this->act_val,
            'geo_data' => $this->geo_data,
            'act_province' => $this->act_province,
        ]);
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

    public function mount()
    {
        $this->geo_id = 2;
    }

    public function render()
    {
        $acttype_val = OoapTblActivities::select([
            'ooap_tbl_activities.act_acttype',
            'ooap_mas_acttype.name',
            'ooap_tbl_activities.act_year',
            'ooap_tbl_activities.act_province',
            'ooap_mas_province.province_name',
            'ooap_mas_province.geo_id',
            'ooap_mas_geopraphy_th.geo_name',
            'ooap_tbl_activities.act_startmonth',
            'ooap_tbl_activities.act_endmonth'
        ])
            ->where('ooap_tbl_activities.in_active', '=', false)
            ->leftjoin('ooap_mas_acttype', 'ooap_tbl_activities.act_acttype', 'ooap_mas_acttype.id')
            ->leftjoin('ooap_mas_province', 'ooap_tbl_activities.act_province', 'ooap_mas_province.province_id')
            ->leftjoin('ooap_mas_geopraphy_th', 'ooap_mas_province.geo_id', 'ooap_mas_geopraphy_th.geo_id');
        if ($this->fiscalyear_code) {
            $acttype_val = $acttype_val->where('ooap_tbl_activities.act_year', '=', $this->fiscalyear_code);
        }
        if ($this->periodno) {
            $acttype_val = $acttype_val->where('ooap_tbl_activities.act_periodno', '=', $this->periodno);
        }
        if ($this->startmonth) {
            $acttype_val = $acttype_val->where('ooap_tbl_activities.act_startmonth', '>=', $this->startmonth);
        }
        if ($this->endmonth) {
            $acttype_val = $acttype_val->where('ooap_tbl_activities.act_endmonth', '<=', $this->endmonth);
        }
        if ($this->acttype_id) {
            $acttype_val = $acttype_val->where('ooap_tbl_activities.act_acttype', '=', $this->acttype_id);
        }
        if ($this->division_id) {
            $acttype_val = $acttype_val->where('ooap_tbl_activities.act_div', '=', $this->division_id);
        }

        $acttype_val_loop = OoapTblActivities::select('ooap_tbl_activities.act_acttype')
            ->where('ooap_tbl_activities.in_active', '=', false)
            ->leftjoin('ooap_mas_acttype', 'ooap_tbl_activities.act_acttype', 'ooap_mas_acttype.id')
            ->groupBy('ooap_tbl_activities.act_acttype')->get()->toArray();

        foreach ($acttype_val_loop as $key => $val) {
            $act_val = OoapTblActivities::select([
                'ooap_tbl_activities.act_acttype',
                'ooap_mas_acttype.name',
                'ooap_tbl_activities.act_year',
                'ooap_tbl_activities.act_province',
                'ooap_mas_province.province_name',
                'ooap_mas_province.geo_id',
                'ooap_mas_geopraphy_th.geo_name'
            ])
                ->where('ooap_tbl_activities.in_active', '=', false)
                ->leftjoin('ooap_mas_acttype', 'ooap_tbl_activities.act_acttype', 'ooap_mas_acttype.id')
                ->leftjoin('ooap_mas_province', 'ooap_tbl_activities.act_province', 'ooap_mas_province.province_id')
                ->leftjoin('ooap_mas_geopraphy_th', 'ooap_mas_province.geo_id', 'ooap_mas_geopraphy_th.geo_id');
            if ($this->fiscalyear_code) {
                $act_val = $act_val->where('ooap_tbl_activities.act_year', '=', $this->fiscalyear_code);
            }
            if ($this->periodno) {
                $act_val = $act_val->where('ooap_tbl_activities.act_periodno', '=', $this->periodno);
            }
            if ($this->startmonth) {
                $act_val = $act_val->where('ooap_tbl_activities.act_startmonth', '>=', $this->startmonth);
            }
            if ($this->endmonth) {
                $act_val = $act_val->where('ooap_tbl_activities.act_endmonth', '<=', $this->endmonth);
            }
            if ($this->division_id) {
                $act_val = $act_val->where('ooap_tbl_activities.act_div', '=', $this->division_id);
            }

            $act_val = $act_val->where('ooap_tbl_activities.act_acttype', '=', $val['act_acttype'])->get()->toArray();

            $act_val_count = count($act_val);

            $acttype_name = OoapMasActtype::select('id', 'name')
                ->where('id', '=', $val)->where('inactive', '=', false)->first();

            $this->act_val[$key] = array('name' => $acttype_name['name'], 'y' => $act_val_count);
        }

        $geo_name = OoapMasGeopraphyTh::select('geo_id', 'geo_name')->where('in_active', '=', false)->get()->toArray();
        foreach ($geo_name as $key => $val) {
            $act_geo = clone $acttype_val;
            $act_geo = $act_geo->where('ooap_mas_province.geo_id', '=', $val['geo_id'])->get()->toArray();
            $act_geo_val = count($act_geo);
            $this->geo_data[$key] = array('name' => $val['geo_name'], 'y' => $act_geo_val);
        }


        $provinces_sec = OoapMasProvince::where('ooap_mas_province.in_active', '=', false)
            ->where('ooap_mas_province.geo_id', '=', $this->geo_id)->get()->toArray();
        foreach ($provinces_sec as $key2 => $val2) {
            $provinces_val = clone $acttype_val;
            $provinces_val = $provinces_val->where('ooap_tbl_activities.act_province', '=', $val2['province_id'])->get()->toArray();
            if ($provinces_val) {
                $provinces_val = count($provinces_val);
            } else {
                $provinces_val = 0;
            }
            $this->act_province[$key2] = array('name' => $val2['province_name'], 'y' => $provinces_val);
        }

        $this->emit('act_list', [
            'act_val' => $this->act_val,
            'geo_data' => $this->geo_data,
            'act_province' => $this->act_province,
        ]);

        return view('livewire.act-dashboard');
    }
}
