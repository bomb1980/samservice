<?php

namespace App\Http\Livewire\Activity\Operate\ResultTrain;

use App\Models\OoapTblActimage;
use App\Models\OoapTblActImages;
use App\Models\OoapTblActivities;
use App\Models\OoapTblFybdpayment;
use App\Models\OoapTblPopulation;
use App\Models\OoapTblPopulationCheckin;
use App\Models\OoapTblTrainschedule;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\URL;

use function PHPUnit\Framework\isEmpty;

class DetailComponent extends Component
{
    use WithFileUploads;
    public $panel = 1;
    public $act_number, $act_shortname, $act_numofday, $checkdate, $pop_id, $check_instead, $stdate, $checkalert, $act_hrperday;
    public $act_numofpeople, $act_numlecturer, $act_foodrate, $act_amtfood, $course_trainer_amt, $course_trainer_rate, $urltoform;
    public $select_values_list = [], $select_values_agent_list = [], $files_image;
    public $images_no = [0, 1, 2, 3, 4], $files_image_pre = [], $files_image_con = [], $files_image_pro = [], $loop = [];
    public $url, $OoapTblActimagePre, $images_pre_path = [], $images_pre_name = [], $images_no_pre, $image_id =[];
    public $OoapTblActimageCon, $images_con_path = [], $images_con_name = [], $images_no_con;
    public $OoapTblActimagePro, $images_pro_path = [], $images_pro_name = [], $images_no_pro, $selectdate;
    public $starttime, $stoptime, $namelecturer, $selectlecturer_list = [], $stdate_new, $endate_new, $date_list = [];
    public $loop_time_old = [], $timealert, $date_list_old = [];
    public $formdisabled = false, $num_disabled = 1,$activity_run_period_start,$activity_run_period_end;

    public function mount($act_id, $p_id)
    {
        $this->panel = $p_id;
        if (session()->get('panel_3')) {
            $this->panel = 3;
        } elseif (session()->get('panel_3_message_create')) {
            $this->panel = 3;
        }

        $this->loop[] = array(0);
        // dd($this->loop);
        // $this->selectdate[] = '';
        // $this->starttime[] = '';
        // $this->stoptime[] = '';
        // $this->namelecturer[] = '';
        $this->urltoform = route('activity.operate.assessment_form', ['act_id' => $act_id, 'p_id' => 0]);
        $this->url =  URL::current();
        $this->act_id = $act_id;
        $Ooapactivity = OoapTblActivities::where('act_id', '=', $act_id)->where('in_active', false)->first();
        if ($Ooapactivity->status == 6) {
            $this->formdisabled = true;
            $this->num_disabled = 2;
        }
        $this->act_number = $Ooapactivity->act_number;
        $this->act_year = $Ooapactivity->act_year;
        $this->act_div = $Ooapactivity->act_div;
        $this->act_shortname = $Ooapactivity->act_shortname;
        $this->act_numofday = $Ooapactivity->act_numofday;
        $this->act_startmonth = $Ooapactivity->act_startmonth;
        $this->act_endmonth = $Ooapactivity->act_endmonth;
        $this->act_hrperday = $Ooapactivity->act_hrperday;
        $this->act_numofpeople = $Ooapactivity->act_numofpeople;
        $this->act_numlecturer = $Ooapactivity->act_numlecturer;
        $this->act_periodno = $Ooapactivity->act_periodno;
        $this->stdate_new = datetoview($this->act_startmonth);
        $this->endate_new = datetoview($this->act_endmonth);

        $this->act_foodrate = sprintf('%0.2f', $Ooapactivity->act_foodrate);
        $this->act_amtfood = sprintf('%0.2f', $Ooapactivity->act_amtfood);
        $this->course_trainer_rate = sprintf('%0.2f', $Ooapactivity->act_rate);
        $this->course_trainer_amt = sprintf('%0.2f', $Ooapactivity->act_amtlecturer);
        $this->act_materialrate = sprintf('%0.2f', $Ooapactivity->act_materialrate);
        $this->course_material_amt = sprintf('%0.2f', $Ooapactivity->act_materialamt);
        $this->other_amt = sprintf('%0.2f', $Ooapactivity->act_otheramt);
        $this->act_amount = $Ooapactivity->act_amount;

        $this->food_r = $Ooapactivity->act_foodrate;
        $this->trainer_r = $Ooapactivity->act_rate;
        $this->material_r = $Ooapactivity->act_materialrate;

        $this->target = $Ooapactivity->act_numofpeople + $Ooapactivity->act_numlecturer;
        $this->activity_run_period_start = $Ooapactivity->activity_run_period_start;
        $this->activity_run_period_end = $Ooapactivity->activity_run_period_end;
        $this->stdate_new = datetoview($Ooapactivity->activity_run_period_start);
        $this->endate_new = datetoview($Ooapactivity->activity_run_period_end);
        //
        $period = new DatePeriod(
            new DateTime(DateToSqlExpSlash($this->stdate_new)),
            new DateInterval('P1D'),
            new DateTime(DateToSqlExpSlash($this->endate_new))
        );

        $i_count = 0;
        foreach ($period as $key => $value) {
            $i_count++;
            $this->date_list[$key] = datetoview($value->format('Y-m-d'));
            $this->date_list_old[$key] = datetoview($value->format('Y-m-d'));
        }
        if (isEmpty($this->date_list)) {
            $this->date_list[0] = $this->stdate_new;
        }
        if (isEmpty($this->date_list_old)) {
            $this->date_list_old[0] = $this->stdate_new;
        }
        $this->date_list[$i_count] = $this->endate_new;
        $this->date_list_old[$i_count] = $this->endate_new;
        //

        $Ooappop = OoapTblPopulation::where('pop_actnumber', '=', $this->act_number)->where('in_active', false);
        $this->sumpop = $Ooappop->count();
        if ($Ooappop->first()) {
            $this->sum_instructor = $Ooappop->where('pop_role', '=', 1)->count();
        }

        $this->selectlecturer_list = OoapTblPopulation::select('pop_firstname', 'pop_lastname', 'pop_id')
            ->where('pop_actnumber', '=', $this->act_number)
            ->where('pop_role', '=', 1)
            ->where('in_active', false)
            ->selectRaw("pop_firstname || ' ' || pop_lastname AS fullname2")
            ->pluck('fullname2', 'pop_id')->prepend('เลือกวิทยากร', 0);

        // $this->url = asset('storage/public/public');
        $this->url = asset('storage/');
        $this->OoapTblActimagePre = OoapTblActimage::where('in_active', '=', false)->where('image_group', '=', 'ก่อนดำเนินกิจกรรม')->where('act_id', '=', $this->act_id)->get()->toArray();
        if ($this->OoapTblActimagePre) {
            foreach ($this->OoapTblActimagePre as $key => $val) {
                $this->images_pre_path[$key] = $val['image_path'];
                $this->images_pre_name[$key] = $val['image_name'];
                $this->image_id[$key] = $val['image_id'];
            }
            $this->images_no_pre = count($this->images_no) - count($this->OoapTblActimagePre);
        }
        $this->OoapTblActimageCon = OoapTblActimage::where('in_active', '=', false)->where('image_group', '=', 'ระหว่างดำเนินกิจกรรม')->where('act_id', '=', $this->act_id)->get()->toArray();
        if ($this->OoapTblActimageCon) {
            foreach ($this->OoapTblActimageCon as $key => $val) {
                $this->images_con_path[$key] = $val['image_path'];
                $this->images_con_name[$key] = $val['image_name'];
            }
            $this->images_no_con = count($this->images_no) - count($this->OoapTblActimageCon);
        }
        $this->OoapTblActimagePro = OoapTblActimage::where('in_active', '=', false)->where('image_group', '=', 'หลังดำเนินกิจกรรม')->where('act_id', '=', $this->act_id)->get()->toArray();
        if ($this->OoapTblActimagePro) {
            foreach ($this->OoapTblActimagePro as $key => $val) {
                $this->images_pro_path[$key] = $val['image_path'];
                $this->images_pro_name[$key] = $val['image_name'];
            }
            $this->images_no_pro = count($this->images_no) - count($this->OoapTblActimagePro);
        }
        $loop_time_old = OoapTblTrainschedule::where('act_number', '=', $this->act_number)->where('in_active', '=', false)->get();
        foreach ($loop_time_old as $val) {
            $combine = [
                'startdate' => $val->startdate,
                'starttime' => $val->starttime,
                'endtime' => $val->endtime,
                'pop_id' => $val->pop_id
            ];

            array_push($this->loop_time_old, $combine);
        }
        if(auth()->user()->emp_type == 1){
            $this->formdisabled = true;
        }
    }

    public function changePanel($num_panel)
    {
        $this->panel = $num_panel;
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('operate.result_train.detail', ['id' => $this->act_id, 'p_id' => $this->panel]);
    }

    public function callback()
    {
        return redirect()->route('operate.index');
    }

    // public function setArray($name, $val)
    // {
    //     $chdates = substr($this->act_startmonth, 0, 10);
    //     $chdatee = substr($this->act_endmonth, 0, 10);
    //     if (DateToSqlExpSlash($val) >= $chdates && DateToSqlExpSlash($val) <= $chdatee) {
    //         $this->checkalert = false;
    //     } else {
    //         $this->checkalert = true;
    //     }
    //     $this->checkdate = $this->stdate;
    // }

    public function save()
    {
        // dd(DateToSqlExpSlash($this->stdate));
        if ($this->stdate == $this->date_list_old[0]) {
            $this->stdate = 0;
        }
        $this->validate([
            'stdate' => 'required',
        ], [
            'stdate.required' => 'กรุณาเลือก วันที่เข้าร่วม',
        ]);

        // if (DateToSqlExpSlash($this->checkdate) >= $this->act_startmonth && DateToSqlExpSlash($this->checkdate) <= $this->act_endmonth) {
        //     //pass
        // } else {
        //     $this->validate([
        //         'stdate' => 'required',
        //     ], [
        //         'stdate.required' => 'ไม่อยู่ในช่วงวันที่เริ่ม-จบงาน',
        //     ]);
        // }

        foreach ($this->select_values_list as $key => $value) {
            $data = OoapTblPopulationCheckin::where('pop_id', '=', $key)->where('in_active', false);
            if ($this->select_values_list[$key] != null) {
                if ($data->where('check_date', '=', DateToSqlExpSlash($this->date_list_old[$this->stdate]))->first()) {
                    //dd('f');
                    $data->update([
                        'check_date' => DateToSqlExpSlash($this->date_list_old[$this->stdate]),
                        'check_status' => $value,
                        'remember_token' => csrf_token(),
                        'updated_by' => auth()->user()->emp_citizen_id,
                        'updated_at' => now(),
                    ]);
                } else {
                    // dd('ss');
                    $datacheck = OoapTblPopulationCheckin::insert([
                        'pop_id' => $key,
                        'act_number' => $this->act_number,
                        'check_date' => DateToSqlExpSlash($this->date_list_old[$this->stdate]),
                        'check_status' => $value,
                        'remember_token' => csrf_token(),
                        'created_by' => auth()->user()->emp_citizen_id,
                        'created_at' => now(),
                    ]);
                }
            }
        }

        $count_accept = 0;
        $count_denied = 0;
        $pull_pop = OoapTblPopulation::where('pop_actnumber', '=', $this->act_number)->where('pop_role', 2)->where('in_active', false)->get();
        foreach ($pull_pop as $key => $value) {
            $accept = OoapTblPopulationCheckin::where('pop_id', $value->pop_id)->where('in_active', false)->whereIn('check_status', [1, 2])->first();
            $denied = OoapTblPopulationCheckin::where('pop_id', $value->pop_id)->where('in_active', false)->where('check_status', 0)->first();
            if ($accept) {
                $count_accept++;
            }
            if ($denied) {
                $count_denied++;
            }
        }
        OoapTblActivities::UpdateTblActivities($this->act_id, $count_accept, $count_denied);

        $logs['route_name'] = 'operate.result_train.detail';
        $logs['submenu_name'] = 'บันทึกเวลาเข้าร่วมกิจกรรม';
        $logs['log_type'] = 'edit';
        createLogTrans($logs);

        $this->emit('popup', 1);
    }

    public function calsum($name, $cal)
    {
        $this->act_foodrate = $this->act_foodrate ? $this->act_foodrate : 0;
        $this->act_numofday = $this->act_numofday ? $this->act_numofday : 0;
        $this->act_numofpeople = $this->act_numofpeople ? $this->act_numofpeople : 0;

        $this->course_trainer_rate = $this->course_trainer_rate ? $this->course_trainer_rate : 0;
        $this->act_numlecturer = $this->act_numlecturer ? $this->act_numlecturer : 0;

        $this->act_materialrate = $this->act_materialrate ? $this->act_materialrate : 0;
        $this->act_amtfood = $this->act_amtfood ? $this->act_amtfood : 0;
        $this->course_material_amt = $this->course_material_amt ? $this->course_material_amt : 0;

        if ($name == 'act_amtfood') {
            $numori = $this->act_foodrate * $this->act_numofday * $this->act_numofpeople;
            if ($cal > $numori) {
                $this->act_amtfood = sprintf('%0.2f', $numori);
            } else {
                $this->act_amtfood = $cal;
            }
        }
        if ($name == 'course_trainer_amt') {
            $numori = $this->course_trainer_rate * $this->act_numofday * $this->act_numlecturer * 6;
            if ($cal > $numori) {
                $this->course_trainer_amt = sprintf('%0.2f', $numori);
            } else {
                $this->course_trainer_amt = $cal;
            }
        }
        if ($name == 'course_material_amt') {
            $numori = $this->act_materialrate * $this->act_numofpeople;
            if ($cal > $numori) {
                $this->course_material_amt = sprintf('%0.2f', $numori);
            } else {
                $this->course_material_amt = $cal;
            }
        }

        if ($name == 'act_foodrate') {
            if ($this->act_foodrate <= $this->food_r) {
                $this->act_amtfood = sprintf('%0.2f', $this->act_foodrate * $this->act_numofday * ($this->act_numofpeople));
            }
        }
        if ($name == 'course_trainer_rate') {
            if ($this->course_trainer_rate <= $this->trainer_r) {
                $this->course_trainer_amt = sprintf('%0.2f', $this->course_trainer_rate * $this->act_numofday * $this->act_numlecturer * 6);
            }
        }
        if ($name == 'act_materialrate') {
            if ($this->act_materialrate <= $this->material_r) {
                $this->course_material_amt = sprintf('%0.2f', $this->act_materialrate * $this->act_numofpeople);
            }
        }
    }

    public function SubmitOrClose_payment($num)
    {
        $checkFybdpayment = OoapTblFybdpayment::where('refer_actnumber', '=', $this->act_number)->where('in_active', '=', false);
        if ($checkFybdpayment->first()) {
            $checkFybdpayment->update([
                'pay_date' => now(),
                'pay_amt' => $this->act_amount,
                'pay_trainamt' => $this->act_amount,
                'pay_name' => auth()->user()->emp_citizen_id,
                'updated_by' => auth()->user()->emp_citizen_id,
                'updated_at' => now(),
            ]);
        } else {
            OoapTblFybdpayment::create([
                'parent_id' => $this->act_id,
                'payment_group' => 2,
                // 'year_period' => $this->act_periodno,
                'division_id' => auth()->user()->division_id,
                'refer_actnumber' => $this->act_number,
                'fiscalyear_code' => $this->act_year,
                'pay_date' => now(),
                'pay_amt' => $this->act_amount,
                'pay_trainamt' => $this->act_amount,
                'pay_desp' => 'ค่าใช้จ่ายโครงการพัฒนาทักษะฝีมือแรงงาน เลขที่ใบคำขอ ' . $this->act_number,
                'pay_name' => auth()->user()->emp_citizen_id,
                'remember_token' => csrf_token(),
                'created_by' => auth()->user()->emp_citizen_id,
                'created_at' => now(),
            ]);
        }

        OoapTblActivities::where('act_id', '=', $this->act_id)->where('in_active', '=', false)->update([
            'act_foodrate' => $this->act_foodrate,
            'act_rate' => $this->course_trainer_rate,
            'act_materialrate' => $this->act_materialrate,
            'act_amtfood' => $this->act_amtfood,
            'act_amtlecturer' => $this->course_trainer_amt,
            'act_materialamt' => $this->course_material_amt,
            'act_otheramt' => $this->other_amt,
            'act_amount' => $this->act_amount,
            'updated_at' => now(),
            'updated_by' => auth()->user()->emp_citizen_id,
        ]);

        if ($num == 2) {
            //close
            OoapTblActivities::where('act_number', '=', $this->act_number)->where('in_active', false)->update([
                'status' => 6,
                'updated_at' => now(),
                'updated_by' => auth()->user()->emp_citizen_id
            ]);
            $checkFybdpayment->update([
                'pay_type' => 2,
            ]);
        }

        $logs['route_name'] = 'operate.result_train.detail';
        $logs['submenu_name'] = 'บันทึกค่าใช้จ่ายอื่นๆ';
        $logs['log_type'] = 'edit';
        createLogTrans($logs);

        $this->emit('popup', 1);
    }

    public function submit_images()
    {
        // dd($this->files_image_pre, $this->OoapTblActimagePre);
        // dd($this->files_image_pre);
        foreach ($this->files_image_pre as $key => $val) {
            $image_path = '/operate/images_pre_train';
            $this->files_image_pre[$key]->store('/public' . $image_path);
            $OoapTblActimage = OoapTblActimage::create([
                'act_id' => $this->act_id,
                'image_group' => 'ก่อนดำเนินกิจกรรม',
                'image_name' => $val->hashName(),
                'image_oriname' => $val->getClientOriginalName(),
                'image_path' => $image_path,
                'image_file_type' => $val->getMimeType(),
                'image_file_size' => $val->getSize(),
                'remember_token' => csrf_token(),
                'created_by' => auth()->user()->emp_citizen_id,
                'created_at' => now(),
            ]);
        }

        foreach ($this->files_image_con as $key => $val) {
            $image_path = '/operate/images_con_train';
            $this->files_image_con[$key]->store('/public' . $image_path);
            $OoapTblActimage = OoapTblActimage::create([
                'act_id' => $this->act_id,
                'image_group' => 'ระหว่างดำเนินกิจกรรม',
                'image_name' => $val->hashName(),
                'image_oriname' => $val->getClientOriginalName(),
                'image_path' => $image_path,
                'image_file_type' => $val->getMimeType(),
                'image_file_size' => $val->getSize(),
                'remember_token' => csrf_token(),
                'created_by' => auth()->user()->emp_citizen_id,
                'created_at' => now(),
            ]);
        }

        foreach ($this->files_image_pro as $key => $val) {
            $image_path = '/operate/images_pro_train';
            $this->files_image_pro[$key]->store('/public' . $image_path);
            $OoapTblActimage = OoapTblActimage::create([
                'act_id' => $this->act_id,
                'image_group' => 'หลังดำเนินกิจกรรม',
                'image_name' => $val->hashName(),
                'image_oriname' => $val->getClientOriginalName(),
                'image_path' => $image_path,
                'image_file_type' => $val->getMimeType(),
                'image_file_size' => $val->getSize(),
                'remember_token' => csrf_token(),
                'created_by' => auth()->user()->emp_citizen_id,
                'created_at' => now(),
            ]);
        }
        $check_log = OoapTblActimage::where('in_active', '=', false)->where('act_id', '=', $this->act_id)->first();
        if ($check_log) {
            $logs['route_name'] = 'operate.result_train.detail';
            $logs['submenu_name'] = 'บันทึกรูปกิจกรรม';
            $logs['log_type'] = 'edit';
            createLogTrans($logs);
        } else {
            $logs['route_name'] = 'operate.result_train.detail';
            $logs['submenu_name'] = 'บันทึกรูปกิจกรรม';
            $logs['log_type'] = 'create';
            createLogTrans($logs);
        }


        $this->emit('popup', 1);
    }

    public function submit_p1()
    {
        $this->validate([
            'stdate_new' => 'required',
            'endate_new' => 'required',
        ], [
            'stdate_new.required' => 'กรุณาระบุ วันที่เริ่ม',
            'endate_new.required' => 'กรุณาระบุ วันที่สิ้นสุด',
        ]);
        if ($this->stdate_new && $this->endate_new) {

            OoapTblActivities::where('act_number', '=', $this->act_number)->where('in_active', false)->update([
                'act_startmonth' => DateToSqlExpSlash($this->stdate_new),
                'act_endmonth' => DateToSqlExpSlash($this->endate_new),
                'act_numofday' => $this->act_numofday,
                'updated_at' => now(),
                'updated_by' => auth()->user()->emp_citizen_id
            ]);
            $logs['route_name'] = 'operate.result_train.detail';
            $logs['submenu_name'] = 'บันทึกเวลาเข้าร่วมกิจกรรม';
            $logs['log_type'] = 'edit';
            createLogTrans($logs);
        }

        if ($this->loop_time_old) {
            OoapTblTrainschedule::where('act_number', '=', $this->act_number)->delete();

            foreach ($this->loop_time_old as $val) {
                $starttime = timegi($val['starttime'], $val['startdate']);
                $endtime = timegi($val['endtime'], $val['startdate']);
                OoapTblTrainschedule::insert([
                    'pop_id' => $val['pop_id'],
                    'act_number' => $this->act_number,
                    'startdate' => DateToSqlExpSlash($val['startdate']),
                    'starttime' => $starttime,
                    'endtime' => $endtime,
                    'remember_token' => csrf_token(),
                    'created_by' => auth()->user()->emp_citizen_id,
                    'created_at' => now(),
                ]);
            }
        }

        $this->emit('popup', 1);
    }

    public function l_add()
    {
        if ($this->selectdate == null || $this->selectdate == '') {
            $this->selectdate = 0;
        }
        if ($this->starttime > $this->stoptime) {
            $this->timealert = null;
        } else {
            $this->timealert = 1;
        }
        $this->validate([
            'selectdate' => 'required',
            'starttime' => 'required',
            'stoptime' => 'required',
            'namelecturer' => 'required',
            'timealert' => 'required',
        ], [
            'selectdate.required' => 'กรุณาเลือก วันที่',
            'starttime.required' => 'กรุณาระบุ ช่วงเวลาเริ่ม',
            'stoptime.required' => 'กรุณาระบุ ช่วงเวลาสิ้นสุด',
            'namelecturer.required' => 'กรุณาเลือก วิทยากร',
            'timealert.required' => 'เวลาที่ระบุไม่ถูกต้อง กรุณาระบุเวลาใหม่',
        ]);

        $combine = [
            'startdate' => $this->date_list[$this->selectdate],
            'starttime' => $this->starttime,
            'endtime' => $this->stoptime,
            'pop_id' => $this->namelecturer,
        ];

        array_push($this->loop_time_old, $combine);

        $this->selectdate = null;
        $this->starttime = null;
        $this->stoptime = null;
        $this->namelecturer = null;
    }
    public function lec_del($id)
    {
        unset($this->loop[$id]);
    }
    public function lec_del_old($key)
    {
        unset($this->loop_time_old[$key]);
        $this->loop_time_old = array_values($this->loop_time_old);
    }
    public function setValue_date1($key, $val)
    {
        $this->date_list = [];
        $this->date_list[] = '';
        if ($this->stdate_new != null && $this->endate_new != null) {
            if (substr($this->stdate_new, 2, 1) == '/' && substr($this->endate_new, 2, 1) == '/') {
                $startDate = new DateTime(DateToSqlExpSlash($this->stdate_new));
                $endDate   = new DateTime(DateToSqlExpSlash($this->endate_new));

                $daysDifference = ($startDate->diff($endDate)->days);
                $this->act_numofday = $daysDifference + 1;
                $period = new DatePeriod(
                    new DateTime(DateToSqlExpSlash($this->stdate_new)),
                    new DateInterval('P1D'),
                    new DateTime(DateToSqlExpSlash($this->endate_new))
                );

                foreach ($period as $key => $value) {
                    $this->date_list[$key] = datetoview($value->format('Y-m-d'));
                }
                $this->date_list[$daysDifference + 1] = $this->endate_new;

                // for ($date = $startDate; $date <= $endDate; $date->modify('+1 day')) {
                //     dd($date->format('l') . "\n");
                //   }

                if (DateToSqlExpSlash($this->endate_new) < DateToSqlExpSlash($this->stdate_new)) {
                    $this->endate_new = '';
                }
                $this->validate([
                    'endate_new' => 'required',
                ], [
                    'endate_new.required' => 'กรุณาเลือก วันที่สิ้นสุดหลังจากวันที่เริ่มกิจกรรม',
                ]);
            }
        }
    }

    public function setdbtime($val)
    {
        if ($val == '') {
            $this->emit('emits2', 1);
            $this->stdate = '';
        }
        $this->emit('emits2', $val);
    }

    public function del($val)
    {
        // dd($val);

        OoapTblActimage::where('image_id','=', $val)->delete();
    }

    public function render()
    {
        $this->emit('emits');
        if($this->panel == 1){
            $this->panel = 2;
        }
        if ($this->stdate == '') {
            $this->stdate = $this->date_list_old[0];
        }

        if ($this->act_foodrate > $this->food_r) {
            $this->act_foodrate = sprintf('%0.2f', $this->food_r);
        }
        if ($this->course_trainer_rate > $this->trainer_r) {
            $this->course_trainer_rate = sprintf('%0.2f', $this->trainer_r);
        }
        if ($this->act_materialrate > $this->material_r) {
            $this->act_materialrate = sprintf('%0.2f', $this->material_r);
        }

        if ($this->other_amt > 0) {
            $this->act_amount = sprintf('%0.2f', $this->act_amtfood + $this->course_trainer_amt + $this->course_material_amt + $this->other_amt);
        } else {
            if ($this->act_amtfood == null) {
                $this->act_amount = sprintf('%0.2f', $this->course_trainer_amt + $this->course_material_amt);
            }
            if ($this->course_trainer_amt == null) {
                $this->act_amount = sprintf('%0.2f', $this->act_amtfood + $this->course_material_amt);
            }
            if ($this->course_material_amt == null) {
                $this->act_amount = sprintf('%0.2f', $this->act_amtfood + $this->course_trainer_amt);
            }
            if ($this->act_amtfood != null && $this->course_trainer_amt != null && $this->course_material_amt != null) {
                $this->act_amount = sprintf('%0.2f', $this->act_amtfood + $this->course_trainer_amt + $this->course_material_amt);
            }
        }

        return view('livewire.activity.operate.result_train.detail-component');
    }
}
