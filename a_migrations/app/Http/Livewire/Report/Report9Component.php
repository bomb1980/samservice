<?php

namespace App\Http\Livewire\Report;

use App\Models\OoapTblActivities;
use Livewire\Component;

use App\Exports\Report1ExelExport;
use Maatwebsite\Excel\Facades\Excel;


class Report9Component extends Component
{
    function submit()
    {

        return;
    }

    function exportExcel()
    {
        $config = [
            'act_year' => ['label' => 'ปี'],
            'region' => ['label' => 'ภูมิภาค'],
            'province' => ['label' => 'จังหวัด'],
            'name' => ['label' => 'อาชีพ'],
            // 't' => ['label' => 'จำนวนกิจกรรมที่จัด'],
            'total_people_checkin' => ['label' => 'จำนวนคนที่เข้าร่วม'],
        ];

        $clone_datas = json_encode($this->clone_datas );
        return Excel::download(new Report1ExelExport( json_decode( $clone_datas ), $config), 'report.xlsx');
    }

    public function mount()
    {
        $this->datas = OoapTblActivities::getReport9( NULL, true )->get()->toArray();


        // dd( $this->datas);
        $this->clearArea($rang = NULL);
    }

    public function render()
    {
        $this->chart();
        $this->emit('loadJquery');

        return view('livewire.report.report9-component');
    }

    function clearArea($rang = NULL)
    {

        if (empty($rang)) {

            $this->year_select = NULL;
            $this->region_select = NULL;
            $this->province_select = NULL;
        }

        if ($rang == 'year_select') {
            $this->region_select = NULL;
            $this->province_select = NULL;
        }

        if ($rang == 'region_select') {
            $this->province_select = NULL;
        }

        $this->year_list = [];
        $this->year_list[''] = 'เลือกปี';

        $this->region_list = [];
        $this->region_list[''] = 'เลือกภูมิภาค';


        $this->province_list = [];
        $this->province_list[''] = 'เลือกจังหวัด';

        $year = str_replace('ปี', '',   $this->year_select);

        $this->clone_datas = [];
        foreach ($this->datas as $kd => $vd) {

            $this->year_list['ปี' . $vd['act_year']] = 'ปี' . $vd['act_year'];

            if (!empty($year)) {

                if ($vd['act_year'] != $year) {
                    continue;
                }
            }

            $this->region_list[$vd['region']] = $vd['region'];

            if (!empty($this->region_select)) {

                if ($vd['region'] != $this->region_select) {
                    continue;
                }
            }

            $this->province_list[$vd['province']] = $vd['province'];

            if (!empty($this->province_select)) {

                if ($vd['province'] != $this->province_select) {
                    continue;
                }
            }

            $this->clone_datas[] = $vd;
        }

    }

    public function chart()
    {

        $res['datas'] = [];

        $keep = [];
        foreach ($this->clone_datas as $ka => $va) {

            $categories[$va['name']] = 1;



            if (!isset($keep['รายได้รวม'][$va['name']])) {
                $keep['รายได้รวม'][$va['name']] = 0;
            }
            if (!isset($keep['จำนวนคนที่เข้าร่วม'][$va['name']])) {
                $keep['จำนวนคนที่เข้าร่วม'][$va['name']] = 0;
            }


            // $keep['จำนวนกิจกรรมที่จัด'][$va['name']] += $va['t'];
            $keep['รายได้รวม'][$va['name']] += $va['total_pop_income'];
            $keep['จำนวนคนที่เข้าร่วม'][$va['name']] += $va['total_people_checkin'];



            if( $keep['จำนวนคนที่เข้าร่วม'][$va['name']]  > 0 ) {

                $keep['รายได้เฉลี่ย'][$va['name']] = $keep['รายได้รวม'][$va['name']] / $keep['จำนวนคนที่เข้าร่วม'][$va['name']];

            }
        }

        $res['title'] = 'ข้อมูลทั้งหมด';
        foreach ($keep as $title => $datas) {


            $res['datas'][] = ['name' => $title, 'data' => array_values($datas)];

            $res['categories'] = array_keys($categories);
        }


        $config['year_select'] = '';
        $config['region_select'] = 'ภาค';
        $config['province_select'] = 'จังหวัด';

        $keep = [];
        foreach ($config as $kc =>  $vc) {

            if (!empty($this->$kc)) {

                $keep[] = '' . $vc . ': ' . $this->$kc . '';
            }
        }

        if( !empty( $keep  ) ) {

            $res['title'] = 'ข้อมูล' . implode(', ', $keep);
        }

        $this->data_chart = json_encode($res, JSON_NUMERIC_CHECK);


        $this->emit('dsddfdfasdfadsfds', $res);
    }
}
