<?php

namespace App\Http\Livewire\Request\Projects;

use App\Models\OoapMasActtype;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblNotification;
use App\Models\OoapTblRequest;

use App\Models\OoapLogTransModel;
use App\Models\OoapTblEmployee;
use App\Models\OoapTblFiscalyearReqPeriod;
use App\Models\OoapTblReqapprovelog;
use Livewire\Component;


use DateTime;


class IndexComponent extends Component
{
    // public $selecterC1, $selecterC2, $selecterC3, $selecterC4, $selecterC5;
    // public $selecterS1, $selecterS2, $selecterS3, $selecterS4, $selecterS5;

    public $fiscalyear_list, $FiscalyearList;
    public $left_fiscalyear_list;

    public $years_list, $years_code;
    public $acttype_list, $acttype_code;

    public $division, $division_id;

    public $total_count, $total_sum;

    public $select_record_list, $role, $check = 0;

    public $initial = 5;
    public $columns;
    public $api;
    public $show_status;
    public $template;

    public function mount()
    {

        $this->myYear = NULL;
        if (session('pending_room') != null) {
            if (session('pending_room') != 'blank') {
                $this->years_code = session('pending_room');
            }
            $this->initial = 2;
        } else if (session('message_delete') != null) {
            $this->years_code = session('message_delete');
            $this->initial = 1;
        }


        $this->division_id = auth()->user()->division_id;

        $this->division = auth()->user()->division_name;

        $this->years_code = date("Y") + 543;

        $this->years_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code');

        $this->text_desc = NULL;

        $this->canRequest = OoapTblFiscalyearReqPeriod::canRequest();

        
        $this->setArea();
        
        $this->select_docs = [];
        
        
        // foreach( $datas as $ka => $va ) {
            
            //     $va->name = 'dsadsfd';
            
            // }
        }
        
        function setArea($name = NULL)
        {
            
            $this->getAreas = OoapTblRequest::getAreas(auth()->user()->emp_type, $this->template)->get();
        if (empty($name)) {
            $this->years_code = NULL;

            $this->req_acttype = NULL;
            $this->serachbox = NULL;
            $this->divi_code = NULL;
        } elseif ($name == 'years_code') {

            $this->req_acttype = NULL;
            $this->serachbox = NULL;
            $this->divi_code = NULL;
        } elseif ($name == 'divi_code') {

            $this->req_acttype = NULL;
            $this->serachbox = NULL;
        } elseif ($name == 'req_acttype') {


            $this->serachbox = NULL;
        } else {
        }

        $this->years_list = [];
        $this->acttype_list = [];
        $this->divi_list = [];

        $this->totals = [];

        $arr = ['15','2','3','4','all_status'];

        foreach( $arr as $ks => $status ) {

            $this->totals[$status]['count_req'] = 0;
            $this->totals[$status]['sum_amt'] = 0;
        }

        foreach ($this->getAreas as $ka => $va) {

            $va['req_year'] = 'ปี' . $va['req_year'];


            if (empty($name)) {

                if (empty($this->years_code)) {

                    $this->years_code = $va['req_year'];
                }
            }

            $this->years_list[$va['req_year']] = $va['req_year'];

            if (!empty($this->years_code)) {

                if ($this->years_code != $va['req_year']) {
                    continue;
                }
            }

            $this->divi_list[$va['req_div']] = $va['division_name'];

            if (!empty($this->divi_code)) {

                if ($this->divi_code != $va['req_div']) {
                    continue;
                }
            }

            $this->acttype_list[$va['req_acttype']] = $va['acttype_name'];

            if (!empty($this->req_acttype)) {

                if ($this->req_acttype != $va['req_acttype']) {
                    continue;
                }
            }

            if( in_array( $va['status'], [1,5]  )) {

                $status = 15;
            }
            else {

                $status = $va['status'];
            }

            $this->totals[$status]['count_req'] += $va['count_req'];
            $this->totals[$status]['sum_amt'] += $va['sum_amt'];

            if( in_array( $va['status'], [1,2,3,4,5]  )) {

                $status = 'all_status';
            }
            $this->totals[$status]['count_req'] += $va['count_req'];
            $this->totals[$status]['sum_amt'] += $va['sum_amt'];

        }


        $this->selecterS1 = number_format($this->totals[15]['sum_amt'], 2);;
        $this->selecterS2 = number_format($this->totals[2]['sum_amt'], 2);
        $this->selecterS3 = number_format($this->totals[3]['sum_amt'], 2);
        $this->selecterS4 = number_format($this->totals[4]['sum_amt'], 2);
        $this->selecterS5 = number_format($this->totals['all_status']['sum_amt'], 2);

        $this->selecterC1 = number_format($this->totals[15]['count_req'], 0);
        $this->selecterC2 = number_format($this->totals[2]['count_req'], 0);
        $this->selecterC3 = number_format($this->totals[3]['count_req'], 0);
        $this->selecterC4 = number_format($this->totals[4]['count_req'], 0);
        $this->selecterC5 = number_format($this->totals['all_status']['count_req'], 0);


    }

    public function render()
    {
        $this->getReqformYearsNoti($this->years_code);

        $this->emit('loadJquery');

        if ($this->template == 1) {

            return view('livewire.request.projects.component');
        } else {

            return view('livewire.request.projects.component2');
        }
    }


    function setSelectDoc($id = NULL)
    {
        if (!isset($this->select_docs[$id])) {

            $this->select_docs[$id] = $id;
        } else {

            unset($this->select_docs[$id]);
        }
    }


    public function save($year_index)
    {

        $canRequest = OoapTblFiscalyearReqPeriod::canRequest();

        if ($canRequest == 'close') {
            session()->flash('send_error', 'ไม่สามารถส่งเรืองพิจารณาได้เนื่องจากสิ้นสุดเวลายื่นคำของบประมาณแล้ว');

            return redirect(request()->header('Referer'));
        }

        $data = OoapTblRequest::whereIn('req_id', $this->select_record_list)->get();

        foreach ($data as $ka => $va) {

            $va->update(['status' => '2', 'req_sendappdate' => now()]);

            $datas = [
                'req_id' => $va->req_id,
                'status' => '2',
                'req_sendappdate' => now()
            ];

            $logs['route_name'] = 'request.projects.index';
            $logs['submenu_name'] = 'ส่งพิจารณาคำขอรับการจัดสรรงบประมาณเลขที่ ' . $va->req_number;
            $logs['log_type'] = 'edit';

            $logs['submenu_id'] = !empty($logs['submenu_id']) ? $logs['submenu_id'] : NULL;
            $logs['submenu_name'] = !empty($logs['submenu_name']) ? $logs['submenu_name'] : NULL;
            OoapLogTransModel::create([
                'data_array' => json_encode($datas),
                'log_type' => $logs['log_type'],
                'route_name' => $logs['route_name'],
                'log_name' => $logs['submenu_name'],
                'full_name' =>  auth()->user()->fname_th . ' ' . auth()->user()->lname_th,
                'submenu_id' => $logs['submenu_id'],
                'log_date' => now(),
                'ip' => $_SERVER['REMOTE_ADDR'],
                'username' => auth()->user()->emp_citizen_id,
                'created_by' => auth()->user()->emp_citizen_id,
                'created_at' => now(),
            ]);

            OoapTblReqapprovelog::create([
                'log_type' => 'APP',
                'ref_id' => $va->req_id,
                'log_date' => now(),
                'log_actions' => 'การบันทึก/ยืนยันคำขอรับจัดสรรงบ',
                'log_details' => 'ส่งพิจารณาคำขอรับจัดสรรงบ',
                'status' => 2,
            ]);

            $pull_emp_1 = OoapTblEmployee::where('emp_type', '=', 1)->where('in_active', '=', false)->get()->toArray();
            foreach ($pull_emp_1 as $key => $val) {
                if ($val['emp_type'] == 1) {
                    $notis = [
                        'noti_name' => 'คุณ '.auth()->user()->fname_th . ' ' . auth()->user()->lname_th.' ส่งเรื่องร้องขอ เลขที่ '. $va->req_number .' เข้ามาใหม่ กรุณาตรวจสอบ',
                        'noti_detail' => '',
                        'noti_to' => [$val['emp_citizen_id']],
                        'noti_link' => route('request.consider.detail', ['acttype_id' => $va->req_acttype, 'id' => $va->req_id]),
                    ];

                    OoapTblNotification::create_($notis);
                }
            }

        }


        session()->flash('pending_room', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        return redirect(request()->header('Referer'));
    }

    public function getReqformYearsNoti($fiscalyear_code)
    {
        $this->text_desc = NULL;

        $fadssd = OoapTblFiscalyear::select(['req_startdate', 'req_enddate'])->where('fiscalyear_code', '=', str_replace('ปี', '', $fiscalyear_code))->first();

        if ($fadssd) {

            $st =  $fadssd->req_startdate;
            $en = $fadssd->req_enddate;

            // $st = '2022-10-01';
            // $en = '2022-10-31';

            $long_line = strtotime($en) - strtotime($st);

            $now = date("Y-m-d");
            // $now = '2021-10-10';

            $shot_line = strtotime($en) - strtotime($now);


            $diff_now =  $shot_line / (60 * 60 * 24);


            $per = !empty($long_line) ? $shot_line /  $long_line * 100 : 0;

            if ($per > 100) {

                $alert = '#c4d3ff';

                $shot_line = strtotime($st) - strtotime($now);

                $diff_now =  $shot_line / (60 * 60 * 24);

                $text_desc = 'จะเริ่มขึ้นในอีก : ' . $diff_now . ' วัน';
            } else {


                $alert = '#28a745';
                if ($per <= 15) {
                    $alert = '#dc3545';
                } else if ($per <= 30) {
                    $alert = '#ffc107';
                } else {
                    $alert = '#28a745';
                }

                $text_desc = 'เหลือเวลาอีก : ' . $diff_now . ' วัน';
                if ($diff_now < 0) {
                    $text_desc = 'สิ้นสุดเวลายื่นคำของบประมาณ';
                } else if ($diff_now == 0) {
                    $text_desc = 'สามารถยื่นเรืองได้วันนี้วันสุดท้าย';
                }
            }

            $this->arr = [
                'st' => datetimeToThaiDatetime($st, 'd M Y'), 'en' => datetimeToThaiDatetime($en, 'd M Y'), 'per' => $per, 'alert' => $alert
            ];

            $this->text_desc = $text_desc;
        } else {

            $alert = '#28a745';

            $this->arr = [
                'st' => NULL, 'en' => NULL, 'per' => 0, 'alert' => $alert
            ];
        }
    }

    public function setMyYear($myYear = NULL)
    {
        $this->myYear = $myYear;
    }
}
