<?php

namespace App\Http\Livewire\Activity\OtherExpense;

use App\Models\OoapMasActtype;
use App\Models\OoapMasDivision;
use App\Models\OoapMasOcuupation;
use App\Models\OoapTblActivities;
use App\Models\OoapTblActimage;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblFybdpayment;
use App\Models\OoapTblPopulation;
use App\Models\OoapTblPopulationCheckin;

use Livewire\Component;
use Livewire\WithFileUploads;

use DateInterval;
use DatePeriod;
use DateTime;
use function PHPUnit\Framework\isEmpty;

class OtherExpenseComponent extends Component
{
    use WithFileUploads;

    public $resultPop = [];
    public $fiscalyear_code, $fiscalyear_list;
    public $dept_id, $dept_list;
    public $acttype_id, $acttype_list;
    public $act_id = 0, $reqform_no_list = [];
    public $total_amt, $resultForm;
    public $ocuupation_list = [], $pullresult;
    public $act_numlecturer, $c_status = false;

    public $panel = 2;
    public $act_number, $act_shortname, $act_numofday, $act_div, $act_startmonth, $act_endmonth, $target, $act_numofpeople, $act_hrperday, $act_year;
    public $checkdate, $pop_id, $check_instead, $stdate, $sumpop, $sum_instructor, $checkalert, $foodrate, $foodval, $instructorrate, $instructorval, $materialrate, $materialval, $otherval = 0, $pay_amt;
    public $select_values_list = [];
    public $images_no = [0, 1, 2, 3, 4], $files_image_pre = [], $files_image_con = [], $files_image_pro = [];
    public $url, $OoapTblActimagePre, $images_pre_path = [], $images_pre_name = [], $images_no_pre;
    public $OoapTblActimageCon, $images_con_path = [], $images_con_name = [], $images_no_con;
    public $OoapTblActimagePro, $images_pro_path = [], $images_pro_name = [], $images_no_pro;
    public $starttime, $stoptime, $namelecturer, $selectlecturer_list = [], $stdate_new, $endate_new, $date_list = [];
    public $loop_time_old = [], $timealert, $date_list_old = [];
    public $formdisabled = false, $num_disabled = 1, $urltoform, $activity_run_period_start, $activity_run_period_end;
    public $activity_time_period_start, $activity_time_period_end, $act_amtfood, $course_trainer_amt, $course_material_amt;
    public $course_trainer_rate, $act_amount, $show_emer_or_train, $act_foodrate, $act_materialrate, $food_r, $material_r, $trainer_r, $acttyp2;


    public function mount()
    {
        $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code as fiscalyear_code2');

        if (auth()->user()->emp_type == 1) {
            $this->dept_list = OoapMasDivision::whereNotNull('province_id')->pluck('division_name', 'division_id');
        } else {
            $this->dept_list = OoapMasDivision::where('division_id', '=', auth()->user()->division_id)->pluck('division_name', 'division_id');
        }
        $this->acttype_list = OoapMasActtype::where('inactive', '=', false)->pluck('name', 'id');
        $this->ocuupation_list = OoapMasOcuupation::where('in_active', false)->pluck('name', 'id');
    }

    public function calsum($name, $cal)
    {
        $this->act_foodrate = $this->act_foodrate ? $this->act_foodrate : 0;
        $this->act_numofday = $this->act_numofday ? $this->act_numofday : 0;
        $this->act_numofpeople = $this->act_numofpeople ? $this->act_numofpeople : 0;

        $this->course_trainer_rate = $this->course_trainer_rate ? $this->course_trainer_rate : 0;
        $this->act_numlecturer = $this->act_numlecturer ? $this->act_numlecturer : 0;
        $this->act_rate = $this->act_rate ? $this->act_rate : 0;

        $this->act_materialrate = $this->act_materialrate ? $this->act_materialrate : 0;
        $this->act_amtfood = $this->act_amtfood ? $this->act_amtfood : 0;
        $this->course_material_amt = $this->course_material_amt ? $this->course_material_amt : 0;

        if ($name == 'act_rate') {
            $this->act_amount = $this->act_numofday * $this->act_rate * $this->act_numofpeople;
        }

        if ($name == 'act_foodrate') {
            if ($this->act_foodrate <= $this->food_r) {
                $this->act_amtfood = sprintf('%0.2f', $this->act_foodrate * $this->act_numofday * ($this->act_numofpeople));
            }
        }
        if ($name == 'course_trainer_rate') {
            if ($this->course_trainer_rate <= $this->trainer_r) {
                // $this->course_trainer_amt = sprintf('%0.2f', $this->course_trainer_rate * $this->act_numofday * $this->act_numlecturer * 6);
                $this->course_trainer_amt = sprintf('%0.2f', $this->course_trainer_rate * $this->act_numofday * $this->act_numlecturer);
            }
        }
        if ($name == 'act_materialrate') {
            $this->course_material_amt = sprintf('%0.2f', $this->act_materialrate * $this->act_numofpeople);
        }
    }

    public function changePanel($num_panel)
    {
        $this->panel = $num_panel;
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('activity.other_expense.index');
    }

    public function save()
    {
        if ($this->stdate == $this->date_list_old[0]) {
            $this->stdate = 0;
        }
        $this->validate([
            'stdate' => 'required',
        ], [
            'stdate.required' => 'กรุณาเลือก วันที่เข้าร่วม',
        ]);

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

        $this->emit('popup', $this->act_id, 1);
    }

    public function submit_pay()
    {
        $checkFybdpayment = OoapTblFybdpayment::where('refer_actnumber', '=', $this->act_number)->where('in_active', '=', false);
        if ($this->acttype_id == 1) {
            if ($checkFybdpayment->first()) {
                $checkFybdpayment->update([
                    'pay_date' => now(),
                    'pay_amt' => $this->act_amount,
                    // 'year_period' => $this->act_periodno,
                    'division_id' => auth()->user()->division_id,
                    'fiscalyear_code' => $this->act_year,
                    'pay_urgentamt' => $this->act_amount,
                    'pay_name' => auth()->user()->emp_citizen_id,
                    'updated_by' => auth()->user()->emp_citizen_id,
                    'updated_at' => now(),
                ]);
            } else {
                OoapTblFybdpayment::create([
                    'parent_id' => $this->act_id,
                    'payment_group' => auth()->user()->emp_type,
                    'pay_type' => 2,
                    // 'year_period' => $this->act_periodno,
                    'division_id' => auth()->user()->division_id,
                    'refer_actnumber' => $this->act_number,
                    'fiscalyear_code' => $this->act_year,
                    'pay_date' => now(),
                    'pay_amt' => $this->act_amount,
                    'pay_urgentamt' => $this->act_amount,
                    'pay_desp' => 'ค่าใช้จ่ายโครงการจ้างงานเร่งด่วน เลขที่ใบคำขอ ' . $this->act_number,
                    'pay_name' => auth()->user()->emp_citizen_id,
                    'remember_token' => csrf_token(),
                    'created_by' => auth()->user()->emp_citizen_id,
                    'created_at' => now(),
                ]);
            }
            OoapTblActivities::where('act_id', '=', $this->act_id)->where('in_active', '=', false)->update([
                'act_rate' => $this->act_rate,
                'act_amount' => $this->act_amount,
                'updated_at' => now(),
                'updated_by' => auth()->user()->emp_citizen_id,
            ]);
        } else {
            if ($checkFybdpayment->first()) {
                $checkFybdpayment->update([
                    'pay_date' => now(),
                    'pay_amt' => $this->act_amount,
                    // 'year_period' => $this->act_periodno,
                    'division_id' => auth()->user()->division_id,
                    'fiscalyear_code' => $this->act_year,
                    'pay_trainamt' => $this->act_amount,
                    'pay_name' => auth()->user()->emp_citizen_id,
                    'updated_by' => auth()->user()->emp_citizen_id,
                    'updated_at' => now(),
                ]);
            } else {
                OoapTblFybdpayment::create([
                    'parent_id' => $this->act_id,
                    'payment_group' => auth()->user()->emp_type,
                    'pay_type' => 2,
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
                'act_amount' => $this->act_amount,
                'updated_at' => now(),
                'updated_by' => auth()->user()->emp_citizen_id,
            ]);
        }

        $this->emit('popup', $this->act_id, 1);
    }

    public function setdb($name, $val)
    {
        if ($name == 'stdate') {
            if ($val == '') {
                $this->emit('emits2', 0);
                $this->stdate = '';
            }
            $this->emit('emits2', $val);
        } else {
            $this->panel = 4;
            if ($this->acttype_id == 1) {
                $this->show_emer_or_train = 1;
            } else {
                $this->show_emer_or_train = 2;
            }

            $this->acttype2 = OoapMasActtype::where('inactive', false)->where('id', '=', 2)->first();
            if ($this->acttype2) {
                $this->food_r = $this->acttype2->couse_lunch_maxrate;
                $this->trainer_r = $this->acttype2->couse_trainer_maxrate;
                // $this->material_r = $this->acttype2->req_materialrate;
            } else {
                $this->food_r =  sprintf('%0.2f', 240);
                $this->trainer_r = sprintf('%0.2f', 600);
            }

            if (!empty($this->fiscalyear_code) && !empty($this->dept_id) && !empty($this->acttype_id)) {
                if ($this->act_id > 0) {
                    if (!isset($this->reqform_no_list[$this->act_id])) {
                        $this->act_id = 0;
                    }

                    $resultAcc = OoapTblActivities::where('act_id', '=', $this->act_id)->first();
                    if ($resultAcc) {
                        $this->resultAcc = $resultAcc->first();

                        $this->urltoform = route('activity.operate.assessment_form', ['act_id' => $this->act_id, 'p_id' => 0]);

                        // form step 1-4 old
                        $this->activity_time_period_start = $resultAcc->activity_time_period_start;
                        $this->activity_time_period_end = $resultAcc->activity_time_period_end;
                        $this->act_year = $resultAcc->act_year;
                        $this->act_number = $resultAcc->act_number;
                        $this->act_div = $resultAcc->act_div;
                        $this->act_shortname = $resultAcc->act_shortname;
                        $this->act_numofday = $resultAcc->act_numofday;
                        $this->act_startmonth = $resultAcc->act_startmonth;
                        $this->act_endmonth = $resultAcc->act_endmonth;
                        $this->act_rate = sprintf('%0.2f', $resultAcc->act_rate);
                        $this->act_amount = $resultAcc->act_amount;
                        $this->act_numofpeople = $resultAcc->act_numofpeople;
                        $this->act_hrperday = $resultAcc->act_hrperday;
                        $this->act_periodno = $resultAcc->act_periodno;
                        $this->target = $resultAcc->act_numofpeople + $resultAcc->act_numlecturer;
                        $this->activity_run_period_start = $resultAcc->activity_run_period_start;
                        $this->activity_run_period_end = $resultAcc->activity_run_period_end;
                        $this->course_trainer_rate = $resultAcc->course_trainer_rate;
                        $this->act_numlecturer = $resultAcc->act_numlecturer;
                        $this->act_foodrate = sprintf('%0.2f', $resultAcc->act_foodrate);
                        $this->act_amtfood = sprintf('%0.2f', $resultAcc->act_amtfood);
                        $this->course_trainer_rate = sprintf('%0.2f', $resultAcc->act_rate);
                        $this->course_trainer_amt = sprintf('%0.2f', $resultAcc->act_amtlecturer);
                        $this->act_materialrate = sprintf('%0.2f', $resultAcc->act_materialrate);
                        $this->course_material_amt = sprintf('%0.2f', $resultAcc->act_materialamt);
                        $this->other_amt = sprintf('%0.2f', $resultAcc->act_otheramt);

                        if ($resultAcc->status == 3) {
                            $this->formdisabled = true;
                            $this->num_disabled = 2;
                        }

                        $this->stdate_new = datetoview($resultAcc->activity_run_period_start);
                        $this->endate_new = datetoview($resultAcc->activity_run_period_end);

                        $period = new DatePeriod(
                            new DateTime(DateToSqlExpSlash($this->stdate_new)),
                            new DateInterval('P1D'),
                            new DateTime(DateToSqlExpSlash($this->endate_new))
                        );
                        $i_count = 0;
                        $this->date_list = [];
                        $this->date_list_old = [];
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


                        $Ooappop = OoapTblPopulation::where('pop_actnumber', '=', $this->act_number)->where('in_active', false);
                        $this->sumpop = $Ooappop->count();
                        if ($Ooappop->first()) {
                            $this->sum_instructor = $Ooappop->where('pop_role', '=', 1)->count();
                        }

                        $this->url = asset('storage/');
                        $this->OoapTblActimagePre = OoapTblActimage::where('in_active', '=', false)->where('image_group', '=', 'ก่อนดำเนินกิจกรรม')->where('act_id', '=', $this->act_id)->get()->toArray();
                        if ($this->OoapTblActimagePre) {
                            foreach ($this->OoapTblActimagePre as $key => $val) {
                                $this->images_pre_path[$key] = $val['image_path'];
                                $this->images_pre_name[$key] = $val['image_name'];
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
                        if (auth()->user()->emp_type == 1) {
                            $this->formdisabled = true;
                        }
                        // end form step 1-4 old

                    } else {
                        $this->resultAcc = null;
                    }
                } else {
                    $this->act_id = 0;
                }
            } else {
                $this->act_id = 0;
            }

            $this->emit('emits2', '');
        }
    }

    public function submit_images()
    {
        foreach ($this->files_image_pre as $key => $val) {
            $image_path = '/operate/images_pre';
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
            $image_path = '/operate/images_con';
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
            $image_path = '/operate/images_pro';
            $this->files_image_pro[$key]->store('/public' . $image_path);
            $OoapTblActimage = OoapTblActImage::create([
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

        $this->emit('popup', $this->act_id, 1);
    }

    public function render()
    {
        $this->emit('emits');
        if (auth()->user()->emp_type == 1) {
            $this->formdisabled == true;
        } else {
            $this->formdisabled == false;
        }

        if ($this->stdate == '') {
            $this->stdate = $this->date_list_old[0] ?? null;
        }

        if ($this->act_foodrate > $this->food_r) {
            $this->act_foodrate = sprintf('%0.2f', $this->food_r);
        }
        if ($this->course_trainer_rate > $this->trainer_r) {
            $this->course_trainer_rate = sprintf('%0.2f', $this->trainer_r);
        }

        if ($this->acttype_id == 1) {
            $this->show_emer_or_train = 1;
            // $this->act_amount =
        } else {
            $this->show_emer_or_train = 2;
            $this->act_amount = sprintf('%0.2f', $this->act_amtfood + $this->course_trainer_amt + $this->course_material_amt);
        }

        if (!empty($this->fiscalyear_code) && !empty($this->dept_id) && !empty($this->acttype_id)) {

            $resultForm = OoapTblActivities::select('ooap_tbl_activities.act_id', 'ooap_tbl_activities.act_number');
            $resultForm = $resultForm->where('ooap_tbl_activities.in_active', '=', false);
            $resultForm = $resultForm->where('ooap_tbl_activities.act_year', '=', $this->fiscalyear_code);
            $resultForm = $resultForm->where('ooap_tbl_activities.act_div', '=', $this->dept_id);
            $resultForm = $resultForm->where('ooap_tbl_activities.act_acttype', '=', $this->acttype_id);
            $resultForm = $resultForm->where('ooap_tbl_activities.status', '=', 5);

            $this->reqform_no_list = $resultForm->pluck('ooap_tbl_activities.act_number', 'ooap_tbl_activities.act_id');
            if ($this->act_id) {
                if (!isset($this->reqform_no_list[$this->act_id])) {
                    $this->act_id = 0;
                }
            }
        } else {
            $this->act_id = 0;
            $this->setdb('', '');
        }

        return view('livewire.activity.other-expense.other-expense-component');
    }
}
