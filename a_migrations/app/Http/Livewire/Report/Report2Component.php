<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;



use App\Models\OoapTblPopulation;
use App\Exports\Report1ExelExport;
use App\Models\OoapTblActImages;
use Maatwebsite\Excel\Facades\Excel;

class Report2Component extends Component
{

    public $datas;

    public function mount()
    {

        $this->region_list = [];
        $this->region_list[''] = 'เลือกภาค';
        $this->region_select = NULL;

        $this->province_list = [];
        $this->province_list[''] = 'เลือกจังหวัด';
        $this->province_select = NULL;

        $this->setFormSelect = OoapTblPopulation::getReport2($this->region_select, $this->province_select, true);

        foreach ($this->setFormSelect as $kd => $vd) {

            $this->region_list[$vd->region] = $vd->region;

            $this->province_list[$vd->province] = $vd->province;
        }
    }


    function submit()
    {

        return;
    }

    function exportExcel()
    {
        $datas = OoapTblPopulation::getReport2($this->region_select, $this->province_select);


        $config = [

            'region' => ['label' => 'ภาค'],
            'province' => ['label' => 'จังหวัด'],
            'act_number' => ['label' => 'เลขที่'],
            'act_shortname' => ['label' => 'กิจกรรม'],
            'people_checkin' => ['label' => 'จำนวนผู้เข้าร่วม'],
            'act_numofday' => ['label' => 'ระยะเวลาตำเนินการ'],
            // 'image_group' => ['label' => 'ช่วงเวลา'],
            'act_amount' => ['label' => 'งบประมาณ'],
        ];
        return Excel::download(new Report1ExelExport($datas, $config), 'report.xlsx');
    }


    //
    //
    function clearArea()
    {
        $this->province_select = NULL;

        $datas = OoapTblPopulation::getReport2($this->region_select, $this->province_select);

        $this->province_list = [];
        $this->province_list[''] = 'เลือกจังหวัด';

        foreach ($datas as $kd => $vd) {

            $this->province_list[$vd->province] = $vd->province;
        }
    }



    public function render()
    {

        $datas = OoapTblPopulation::getReport2($this->region_select, $this->province_select);
        // dd($datas);
        $keep = [];
        foreach ($datas as $kd => $vd) {

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



                            if (!isset($totals['act_amount'])) {
                                $totals['act_amount'] = 0;
                            }

                            $totals['act_amount'] += $vd->act_amount;


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


                            if (!isset($totalss['act_amount'])) {
                                $totalss['act_amount'] = 0;
                            }

                            $totalss['act_amount'] += $vd->act_amount;


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

                            if (!isset($totalsss['act_amount'])) {
                                $totalsss['act_amount'] = 0;
                            }

                            $totalsss['act_amount'] += $vd->act_amount;

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

                        $trs[] = '
                            <tr>
                                <td class="text-left" style="padding-left: 70px;">' . ++$i . '. ' . $vd->act_number  . ' ' . $vd->act_shortname . '</td>
                                <td class="text-right">' . number_format($vd->people_checkin, 2) . '</td>
                                <td class="text-right">' . $vd->act_numofday . '</td>
                                <td class="text-right">' . number_format($vd->act_amount, 2) . '</td>

                            </tr>
                        ';

                        $imgs = OoapTblActImages::getDatas($vd->act_id);


                        $keepImgs = [];
                        foreach ($imgs as $km => $vm) {

                            $path = 'storage' . $vm->image_path . '/' . $vm->image_name;
                            if ( !file_exists(public_path(  $path ))){
                                continue;
                            }



                            $keepImgs[$vm->image_group][] = '<img style="height: 200px;" src="' . $path . '" />';
                        }

                        foreach ($keepImgs as $km => $vm) {

                            $trs[] = '
                                <tr>
                                    <td class="text-left" colspan="4">
                                      <div style="

                                      background-color: #dedede;
                                      padding: 10px;
                                      margin-bottom: 5px;
                                      /* color: white; */
                                      font-size: 120%;

                                  ">' . $km . '</div>
                                  <div style="

                                  display: flex;
                                  justify-content: flex-start;
                                  gap: 10px;
                                  flex-wrap: wrap;

                              ">' . implode('', $vm) . '</div>



                                    </td>

                                </tr>
                            ';
                        }


                    }


                    $trs[] = '
                        <tr style="background-color: #d7dbdb;">
                            <td class="text-left" style="padding-left: 50px;">รวม จังหวัด' . $kc . '</td>
                            <td class="text-right">' . number_format($totals['people_checkin'], 2) . '</td>
                            <td class="text-right">' . number_format($totals['total_avg'], 2) . '</td>
                            <td class="text-right">' . number_format($totals['act_amount'], 2) . '</td>

                        </tr>
                    ';
                }


                $trs[] = '

                    <tr style="background-color: #ccc;">
                        <td class="text-left" style="padding-left: 30px;">รวม ภาค' . $kb . '</td>
                        <td class="text-right">' . number_format($totalss['people_checkin'], 2) . '</td>
                        <td class="text-right">' . number_format($totalss['total_avg'], 2) . '</td>
                        <td class="text-right">' . number_format($totalss['act_amount'], 2) . '</td>



                    </tr>
                ';
            }

            $trs[] = '
                <tr style="background-color: #DDD;">
                    <td class="text-left">' . $ka . '</td>
                        <td class="text-right">' . number_format($totalsss['people_checkin'], 2) . '</td>
                        <td class="text-right">' . number_format($totalsss['total_avg'], 2) . '</td>
                        <td class="text-right">' . number_format($totalsss['act_amount'], 2) . '</td>



                </tr>
            ';
        }


        $this->trs = implode('', $trs);

        return view('livewire.report.report2-component');
    }
}
