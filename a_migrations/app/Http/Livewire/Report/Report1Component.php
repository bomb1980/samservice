<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;



use App\Models\OoapTblPopulation;
use App\Exports\Report1ExelExport;
use Maatwebsite\Excel\Facades\Excel;


//php artisan make:livewire Livewire/Report/Report2Component
// C:\wamp64\www\tcm\app\Http\Livewire\Report\Report1Component.php
class Report1Component extends Component
{

    public $datas;
    public $setFormSelect;


    public function render()
    {

        $datas = OoapTblPopulation::getReport1($this->region_select, $this->province_select);

        //  dd( $datas );

        $keep = [];
        // $this->province_list = [];
        foreach ($datas as $kd => $vd) {


            // $this->province_list[$vd->province] = $vd->province;


            $keep['ภาพรวมประเทศ'][$vd->region][$vd->province][$vd->act_id] = $vd;
        }

        $trs = [];
        foreach ($keep as $ka => $va) {


            $totalsss = [];

            foreach ($va as $kb => $vb) {


                $totalss = [];

                foreach ($vb as $kc => $vc) {


                    $totals = [];

                    $i = 0;
                    foreach ($vc as $kd => $vd) {

                        if (true) {


                            if (!isset($totals['total_score'])) {
                                $totals['total_score'] = 0;
                            }

                            $totals['total_score'] += $vd->total_score;


                            if (!isset($totals['total_avg'])) {
                                $totals['total_avg'] = 0;
                            }

                            $totals['total_avg'] += $vd->total_avg;

                            if (!isset($totals['people_answer'])) {
                                $totals['people_answer'] = 0;
                            }

                            $totals['people_answer'] += $vd->people_answer;


                            if (!isset($totals['activiti_count'])) {
                                $totals['activiti_count'] = 0;
                            }

                            ++$totals['activiti_count'];


                            if (!isset($totals['people_checkin'])) {
                                $totals['people_checkin'] = 0;
                            }

                            $totals['people_checkin'] += $vd->people_checkin;
                        }

                        if (true) {



                            if (!isset($totalss['total_score'])) {
                                $totalss['total_score'] = 0;
                            }

                            $totalss['total_score'] += $vd->total_score;



                            if (!isset($totalss['total_avg'])) {
                                $totalss['total_avg'] = 0;
                            }

                            $totalss['total_avg'] += $vd->total_avg;

                            if (!isset($totalss['people_answer'])) {
                                $totalss['people_answer'] = 0;
                            }

                            $totalss['people_answer'] += $vd->people_answer;


                            if (!isset($totalss['activiti_count'])) {
                                $totalss['activiti_count'] = 0;
                            }

                            ++$totalss['activiti_count'];

                            if (!isset($totalss['people_checkin'])) {
                                $totalss['people_checkin'] = 0;
                            }

                            $totalss['people_checkin'] += $vd->people_checkin;
                        }



                        if (true) {


                            if (!isset($totalsss['total_score'])) {
                                $totalsss['total_score'] = 0;
                            }

                            $totalsss['total_score'] += $vd->total_score;


                            if (!isset($totalsss['total_avg'])) {
                                $totalsss['total_avg'] = 0;
                            }

                            $totalsss['total_avg'] += $vd->total_avg;

                            if (!isset($totalsss['people_answer'])) {
                                $totalsss['people_answer'] = 0;
                            }

                            $totalsss['people_answer'] += $vd->people_answer;


                            if (!isset($totalsss['activiti_count'])) {
                                $totalsss['activiti_count'] = 0;
                            }

                            ++$totalsss['activiti_count'];


                            if (!isset($totalsss['people_checkin'])) {
                                $totalsss['people_checkin'] = 0;
                            }

                            $totalsss['people_checkin'] += $vd->people_checkin;
                        }


                        $avg = NULL;
                        if (!empty($vd->people_answer))
                            $avg = number_format($vd->total_score / $vd->people_answer, 2);

                        $trs[] = '
                            <tr>
                                <td class="text-left" style="padding-left: 70px;">' . ++$i . '. ' . $vd->act_number . ' ' . $vd->act_shortname . ' </td>
                                <td class="text-right"></td>
                                <td class="text-right">' . number_format($vd->people_checkin, 2) . '</td>
                                <td class="text-right">' . number_format($vd->total_score, 2) . '</td>
                                <td class="text-right">' . number_format($vd->people_answer, 2) . '</td>
                                <td class="text-right">' . $avg . '</td>
                            </tr>
                        ';
                    }


                    $avg = NULL;
                    if (!empty($totals['people_answer']))
                        $avg = number_format($totals['total_score']  / $totals['people_answer'], 2);

                    $trs[] = '
                        <tr style="background-color: #d7dbdb;">
                            <td class="text-left" style="padding-left: 50px;">รวม จังหวัด' . $kc . '</td>
                            <td class="text-right">' . ($totals['activiti_count']) . '</td>
                            <td class="text-right">' . number_format($totals['people_checkin'], 2) . '</td>
                            <td class="text-right">' . number_format($totals['total_score'], 2) . '</td>
                            <td class="text-right">' . number_format($totals['people_answer'], 2) . '</td>
                            <td class="text-right">' . $avg . '</td>
                        </tr>
                    ';
                }


                $avg = NULL;
                if (!empty($totalss['people_answer']))
                    $avg = number_format($totalss['total_score']  / $totalss['people_answer'], 2);

                $trs[] = '

                    <tr style="background-color: #ccc;">
                        <td class="text-left" style="padding-left: 30px;">รวม ภาค' . $kb . '</td>
                        <td class="text-right">' . ($totalss['activiti_count']) . '</td>
                        <td class="text-right">' . number_format($totalss['people_checkin'], 2) . '</td>
                        <td class="text-right">' . number_format($totalss['total_score'], 2) . '</td>
                        <td class="text-right">' . number_format($totalss['people_answer'], 2) . '</td>
                        <td class="text-right">' . $avg . '</td>


                    </tr>
                ';
            }

            $avg = NULL;
            if (!empty($totalsss['people_answer']))
                $avg = number_format($totalsss['total_score']  / $totalsss['people_answer'], 2);


            $trs[] = '
                <tr style="background-color: #DDD;">
                    <td class="text-left">' . $ka . '</td>
                    <td class="text-right">' . ($totalsss['activiti_count']) . '</td>
                        <td class="text-right">' . number_format($totalsss['people_checkin'], 2) . '</td>
                        <td class="text-right">' . number_format($totalsss['total_score'], 2) . '</td>
                        <td class="text-right">' . number_format($totalsss['people_answer'], 2) . '</td>
                        <td class="text-right">' . $avg . '</td>


                </tr>
            ';
        }


        $this->trs = implode('', $trs);

        unset($trs);

        return view('livewire.report.report1-component');
    }


    function submit()
    {

        return;
    }

    function exportExcel()
    {
        $datas = OoapTblPopulation::getReport1($this->region_select, $this->province_select);

        $config = [
            'region' => ['label' => 'ภาค'],
            'province' => ['label' => 'จังหวัด'],
            'act_shortname' => ['label' => 'กิจกรรม'],
            'people_checkin' => ['label' => 'จำนวนผู้เข้าร่วม'],
            'total_score' => ['label' => 'ความพึงพอใจ'],
            'people_answer' => ['label' => 'จำนวนผู้ประเมิน'],
            // 'avg' => ['label' => 'ความพึงพอใจเฉลี่ย'],
        ];
        return Excel::download(new Report1ExelExport($datas, $config), 'report.xlsx');
    }


    //
    //
    function clearArea() {
        $this->province_select = NULL;

        $datas = OoapTblPopulation::getReport1($this->region_select, $this->province_select);

        $this->province_list = [];
        $this->province_list[''] = 'เลือกจังหวัด';

        foreach ($datas as $kd => $vd) {

            $this->province_list[$vd->province] = $vd->province;

        }
    }

    public function mount()
    {


        $this->region_list = [];
        $this->region_list[''] = 'เลือกภาค';
        $this->region_select = NULL;

        $this->province_list = [];
        $this->province_list[''] = 'เลือกจังหวัด';
        $this->province_select = NULL;

        $this->setFormSelect = OoapTblPopulation::getReport1( $this->region_select, $this->province_select, true );
        foreach (  $this->setFormSelect as $kd => $vd) {

            $this->region_list[$vd->region] = $vd->region;

            $this->province_list[$vd->province] = $vd->province;
        }
    }



}
