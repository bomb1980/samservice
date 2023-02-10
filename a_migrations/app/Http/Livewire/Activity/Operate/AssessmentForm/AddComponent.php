<?php

namespace App\Http\Livewire\Activity\Operate\AssessmentForm;

use App\Models\OoapMasActtype;
use App\Models\OoapMasAssessmentTopic;
use App\Models\OoapMasAssessmentType;
use App\Models\OoapMasPopulatioType;
use App\Models\OoapTblActivities;
use App\Models\OoapTblAssess;
use App\Models\OoapTblAssesslog;
use App\Models\OoapTblPopulation;
use Livewire\Component;

class AddComponent extends Component
{
    public $pop_nationalid, $check_thai_id, $pop_sname, $pop_firstname, $pop_lastname, $remark, $act_id;
    public $type_R = [], $type_O = [];
    public $type_R_ans = [], $type_O_ans = [];
    public $data, $assess_R, $assess_O, $assess_ans_R, $assess_ans_O, $empty = false;
    public $edit_flag_R = false, $edit_flag_O = false, $p_id, $check_edit = false, $check_qrcode = false, $alert_nopop, $act_acttype;
    public $type_form, $topic_form, $pop_role_list, $pop_role, $pop_status;

    public function mount($act_id, $p_id)
    {
        $this->act_id = $act_id;
        $this->pop_id = $p_id;
        $this->pop_sname_list = [1 => 'นาย', 2 => 'นาง', 3 => 'นางสาว'];
        $activity = OoapTblActivities::where('in_active', 0)->where('act_id', '=', $this->act_id)->first();
        if ($activity) {
            $this->act_number = $activity->act_number;
            $this->act_acttype = $activity->act_acttype;
        }

        $this->data = OoapTblPopulation::where('in_active', 0)->where('pop_id', '=', $this->pop_id)->where('pop_actnumber', '=', $this->act_number)->first();
        if ($this->data) {
            $this->pop_id = $this->data->pop_id;
            $this->pop_role = $this->data->pop_role;
            $this->pop_sname = $this->data->pop_title;
            $this->pop_firstname = $this->data->pop_firstname;
            $this->pop_lastname = $this->data->pop_lastname;
            $this->pop_age = $this->data->pop_age;
            $this->pop_gender = $this->data->pop_gender;
            $this->pop_nationalid = $this->data->pop_nationalid;
            $this->pop_actnumber = $this->data->pop_actnumber;

            if ($this->pop_nationalid) {
                $this->check_edit = true;
                $this->check_qrcode = true;
            }
        }
        // dd($this->pop_role);
        $this->pop_role_list = OoapMasPopulatioType::where('in_active', '=', false)->pluck('population_types_name', 'population_types_id');
        if ($this->pop_role) {
            $this->pop_status = $this->pop_role;
        } else {
            $this->pop_status = 0;
        }
        // dd($this->act_acttype);

        $checkdata = false;
        $pulla = OoapMasActtype::where('inactive', '=', false)->where('id', '=', $this->act_acttype)->first() ?? null;
        $this->type_form = $pulla->name;

        $pullt = OoapMasAssessmentTopic::where('in_active', '=', false)->where('acttype_id', '=', $this->act_acttype)->first() ?? null;

        // dd($pullt);
        if ($pullt != null) {
            $pullb = OoapMasAssessmentType::where('in_active', '=', false)->where('assessment_types_id', '=', $pullt->assessment_types_id)->first() ?? null;
            $this->topic_form = $pullb->assessment_types_name;

            $pull_formassessment = OoapTblAssess::where('in_active', 0)
                ->where('assessment_topics_id', '=', $pullt->assessment_topics_id)
                ->first() ?? null;

            if ($pull_formassessment) {
                $this->assess_R = OoapTblAssess::where('in_active', 0)->where('assessment_topics_id', '=', $pullt->assessment_topics_id)->where('status', '=', 1)->where('assess_type', '=', 'R')->get();
                $this->assess_O = OoapTblAssess::where('in_active', 0)->where('assessment_topics_id', '=', $pullt->assessment_topics_id)->where('status', '=', 1)->where('assess_type', '=', 'O')->get();
            }
        } else {
            $this->topic_form = null;
            $this->assess_R = [];
            $this->assess_O = [];
        }

        $this->refID_R = [];
        if ($this->assess_R) {
            $this->empty = true;
            foreach ($this->assess_R as $key => $val) {
                $this->refID_R[] = $val->assess_id;
            }
        }

        $this->refID_O = [];
        if ($this->assess_O) {
            foreach ($this->assess_O as $key => $val) {
                $this->refID_O[] = $val->assess_id;
            }
        }

        $this->assess_ans_R = OoapTblAssesslog::where('in_active', 0)->where('assesslog_pop_id', '=', $this->pop_id)->where('assesslog_type', '=', 'R')->wherein('assesslog_refid', $this->refID_R)->get();
        $this->assess_ans_O = OoapTblAssesslog::where('in_active', 0)->where('assesslog_pop_id', '=', $this->pop_id)->where('assesslog_type', '=', 'O')->wherein('assesslog_refid', $this->refID_O)->get();


        if (!$this->assess_ans_R->isEmpty()) {
            $this->edit_flag_R = true;
        }
        if (!$this->assess_ans_O->isEmpty()) {
            $this->edit_flag_O = true;
        }

        $tt = 1;
        if (!$this->assess_R) {
            $this->type_R[] = null;

            $this->type_R_ans[] = "";
        } else {
            if ($this->edit_flag_R == true) {
                foreach ($this->assess_R as $key => $val) {
                    $this->type_R[] = $val->assess_description;
                    $this->type_R_ans[] = $this->assess_ans_R[$key]->assesslog_score;
                }
            } else {
                foreach ($this->assess_R as $key => $val) {
                    $this->type_R[] = $val->assess_description;

                    $this->type_R_ans[] = "";
                }
            }
        }

        if (!$this->assess_O) {
            $this->type_O[] = null;

            $this->type_O_ans[] = "";
        } else {
            if ($this->edit_flag_O == true) {
                foreach ($this->assess_O as $key => $val) {
                    $this->type_O[] = $val->assess_description;

                    $this->type_O_ans[] = $this->assess_ans_O[$key]->assesslog_answers;
                }
            } else {
                foreach ($this->assess_O as $key => $val) {
                    $this->type_O[] = $val->assess_description;

                    $this->type_O_ans[] = "";
                }
            }
        }
    }

    public function get_AccessLog_score()
    {
        // dd($this->pop_nationalid);
        $this->pop_data1 = OoapTblPopulation::where('in_active', 0)->where('pop_nationalid', '=', str_replace('-', '', $this->pop_nationalid))->where('pop_actnumber', '=', $this->act_number)->first();
        if ($this->pop_data1) {
            $this->check_qrcode = true;
            $this->alert_nopop = true;
            $this->pop_id = $this->pop_data1->pop_id;
            $this->pop_sname = $this->pop_data1->pop_title;
            $this->pop_firstname = $this->pop_data1->pop_firstname;
            $this->pop_lastname = $this->pop_data1->pop_lastname;
            $this->pop_id = $this->pop_data1->pop_id;
            $this->pop_role = $this->pop_data1->pop_role;
            $this->pop_age = $this->pop_data1->pop_age;
            $this->pop_gender = $this->pop_data1->pop_gender;

            $this->assess_ans_R = OoapTblAssesslog::where('in_active', 0)->where('assesslog_pop_id', '=', $this->pop_id)->where('assesslog_type', '=', 'R')->wherein('assesslog_refid', $this->refID_R)->get();
            $this->assess_ans_O = OoapTblAssesslog::where('in_active', 0)->where('assesslog_pop_id', '=', $this->pop_id)->where('assesslog_type', '=', 'O')->wherein('assesslog_refid', $this->refID_O)->get();

            if (!$this->assess_ans_R->isEmpty()) {
                $this->edit_flag_R = true;
            } else {
                $this->edit_flag_R = false;
            }
            if (!$this->assess_ans_O->isEmpty()) {
                $this->edit_flag_O = true;
            } else {
                $this->edit_flag_O = false;
            }

            $this->type_O_ans = [];
            if (!$this->assess_O) {
                $this->type_O_ans[] = "";
            } else {
                if ($this->edit_flag_O == true) {
                    foreach ($this->assess_O as $key => $val) {
                        $this->type_O_ans[] = $this->assess_ans_O[$key]->assesslog_answers;
                    }
                } else {
                    foreach ($this->assess_O as $key => $val) {
                        $this->type_O_ans[] = "";
                    }
                }
            }

            $this->type_R_ans = [];
            if (!$this->assess_R) {
                $this->type_R_ans[] = "";
            } else {
                if ($this->edit_flag_R == true) {
                    foreach ($this->assess_R as $key => $val) {
                        $this->type_R_ans[] = $this->assess_ans_R[$key]->assesslog_score;
                    }
                } else {
                    foreach ($this->assess_R as $key => $val) {
                        $this->type_R_ans[] = "";
                    }
                }
            }
        } else {
            $this->check_qrcode = false;
            $this->alert_nopop = false;
        }

        return $this->type_R_ans;
    }

    public function get_AccessLog_score_0()
    {
        $this->pop_data1 = OoapTblPopulation::where('in_active', 0)->where('pop_nationalid', '=', str_replace('-', '', $this->pop_nationalid))->where('pop_actnumber', '=', $this->act_number)->first();
        if ($this->check_thai_id) {
            if ($this->pop_data1) {
                $this->check_qrcode = true;
                $this->alert_nopop = true;
                $this->pop_id = $this->pop_data1->pop_id;
                $this->pop_sname = $this->pop_data1->pop_title;
                $this->pop_firstname = $this->pop_data1->pop_firstname;
                $this->pop_lastname = $this->pop_data1->pop_lastname;
                $this->pop_id = $this->pop_data1->pop_id;
                $this->pop_role = $this->pop_data1->pop_role;
                $this->pop_age = $this->pop_data1->pop_age;
                $this->pop_gender = $this->pop_data1->pop_gender;

                $this->assess_ans_R = OoapTblAssesslog::where('in_active', 0)->where('assesslog_pop_id', '=', $this->pop_id)->where('assesslog_type', '=', 'R')->wherein('assesslog_refid', $this->refID_R)->get();
                $this->assess_ans_O = OoapTblAssesslog::where('in_active', 0)->where('assesslog_pop_id', '=', $this->pop_id)->where('assesslog_type', '=', 'O')->wherein('assesslog_refid', $this->refID_O)->get();

                if (!$this->assess_ans_R->isEmpty()) {
                    $this->edit_flag_R = true;
                } else {
                    $this->edit_flag_R = false;
                }
                if (!$this->assess_ans_O->isEmpty()) {
                    $this->edit_flag_O = true;
                } else {
                    $this->edit_flag_O = false;
                }

                $this->type_O_ans = [];
                if (!$this->assess_O) {
                    $this->type_O_ans[] = "";
                } else {
                    if ($this->edit_flag_O == true) {
                        foreach ($this->assess_O as $key => $val) {
                            $this->type_O_ans[] = $this->assess_ans_O[$key]->assesslog_answers;
                        }
                    } else {
                        foreach ($this->assess_O as $key => $val) {
                            $this->type_O_ans[] = "";
                        }
                    }
                }

                $this->type_R_ans = [];
                if (!$this->assess_R) {
                    $this->type_R_ans[] = "";
                } else {
                    if ($this->edit_flag_R == true) {
                        foreach ($this->assess_R as $key => $val) {
                            $this->type_R_ans[] = $this->assess_ans_R[$key]->assesslog_score;
                        }
                    } else {
                        foreach ($this->assess_R as $key => $val) {
                            $this->type_R_ans[] = "";
                        }
                    }
                }
            } else {
                $this->check_qrcode = false;
                $this->alert_nopop = false;
            }
        }

        return $this->type_R_ans;
    }

    public function setTypeR_ans($key, $val)
    {

        $this->type_R_ans[$key] = $val;
    }
    public function setTypeO_ans($key, $val)
    {

        $this->type_O_ans[$key] = $val;
    }

    public function submit()
    {
        $ch = false;
        foreach ($this->assess_R as $key => $val) {
            if ($this->type_R_ans[$key] == null) {
                $ch = true;
            }
        }
        if ($ch == false) {
            if ($this->edit_flag_R == true) {
                foreach ($this->assess_R as $key => $val) {
                    OoapTblAssesslog::where('assesslog_refid', $this->refID_R[$key])->where('assesslog_pop_id', $this->pop_id)->update([
                        'assesslog_pop_id' => $this->pop_id,
                        'assesslog_act_id' => $this->act_id,
                        // 'assesslog_gender' => $this->pop_gender,
                        // 'assesslog_sname' => $this->pop_sname,
                        // 'assesslog_fname' => $this->pop_firstname,
                        // 'assesslog_lname' => $this->pop_lastname,
                        // 'assesslog_age' => $this->pop_age,
                        // 'assesslog_role_id' => $this->pop_role,

                        'assesslog_type' => $val->assess_type,
                        'assesslog_description' => $val->assess_description,
                        'assesslog_score' => $this->type_R_ans[$key],

                        'status' => true,
                        'in_active' => false,
                        'updated_by' => NULL,
                        'updated_at' => now()
                    ]);
                }
            } else {
                foreach ($this->assess_R as $key => $val) {
                    OoapTblAssesslog::create([
                        'assesslog_pop_id' => $this->pop_id,
                        'assesslog_act_id' => $this->act_id,
                        // 'assesslog_gender' => $this->pop_gender,
                        // 'assesslog_sname' => $this->pop_sname,
                        // 'assesslog_fname' => $this->pop_firstname,
                        // 'assesslog_lname' => $this->pop_lastname,
                        // 'assesslog_age' => $this->pop_age,
                        // 'assesslog_role_id' => $this->pop_role,

                        'assesslog_refid' => $val->assess_id,
                        'assesslog_type' => $val->assess_type,
                        'assesslog_description' => $val->assess_description,
                        'assesslog_score' => $this->type_R_ans[$key],

                        'status' => true,
                        'remember_token' => csrf_token(),
                        'created_by' => NULL,
                        'created_at' => now()
                    ]);
                    OoapTblPopulation::where('pop_id', '=', $this->pop_id)->where('in_active', 0)->where('pop_actnumber', '=', $this->act_number)->update([
                        'pop_assessflag' => 1,
                    ]);
                }
            }

            if ($this->edit_flag_O == true) {
                foreach ($this->assess_O as $key => $val) {
                    OoapTblAssesslog::where('assesslog_refid', $this->refID_O[$key])->where('assesslog_pop_id', $this->pop_id)->update([
                        'assesslog_pop_id' => $this->pop_id,
                        'assesslog_act_id' => $this->act_id,
                        // 'assesslog_gender' => $this->pop_gender,
                        // 'assesslog_sname' => $this->pop_sname,
                        // 'assesslog_fname' => $this->pop_firstname,
                        // 'assesslog_lname' => $this->pop_lastname,
                        // 'assesslog_age' => $this->pop_age,
                        // 'assesslog_role_id' => $this->pop_role,

                        'assesslog_refid' => $val->assess_id,
                        'assesslog_type' => $val->assess_type,
                        'assesslog_description' => $val->assess_description,
                        'assesslog_answers' => $this->type_O_ans[$key],

                        'status' => true,
                        'in_active' => false,
                        'updated_by' => NULL,
                        'updated_at' => now()
                    ]);
                }
            } else {
                foreach ($this->assess_O as $key => $val) {
                    OoapTblAssesslog::create([
                        'assesslog_pop_id' => $this->pop_id,
                        'assesslog_act_id' => $this->act_id,
                        // 'assesslog_gender' => $this->pop_gender,
                        // 'assesslog_sname' => $this->pop_sname,
                        // 'assesslog_fname' => $this->pop_firstname,
                        // 'assesslog_lname' => $this->pop_lastname,
                        // 'assesslog_age' => $this->pop_age,
                        // 'assesslog_role_id' => $this->pop_role,

                        'assesslog_refid' => $val->assess_id,
                        'assesslog_type' => $val->assess_type,
                        'assesslog_description' => $val->assess_description,
                        'assesslog_answers' => $this->type_O_ans[$key],

                        'status' => true,
                        'remember_token' => csrf_token(),
                        'created_by' => NULL,
                        'created_at' => now()
                    ]);
                    OoapTblPopulation::where('pop_id', '=', $this->pop_id)->where('in_active', 0)->where('pop_actnumber', '=', $this->act_number)->update([
                        'pop_assessflag' => 1,
                    ]);
                }
            }
        }
        if (empty(auth()->user()->emp_citizen_id)) {
            if ($ch == true) {
                $this->emit('popup', 3);
            } else {
                $this->emit('popup', 2);
            }
        } else {
            if ($ch == true) {
                $this->emit('popup', 3);
            } else {
                $this->emit('popup', 1);
            }
            if ($this->edit_flag_R == true || $this->edit_flag_O == true) {
                $logs['route_name'] = 'activity.operate.assessment_form';
                $logs['submenu_name'] = 'บันทึกแบบประเมิน';
                $logs['log_type'] = 'edit';
                createLogTrans($logs);
            } else {
                $logs['route_name'] = 'activity.operate.assessment_form';
                $logs['submenu_name'] = 'บันทึกแบบประเมิน';
                $logs['log_type'] = 'create';
                createLogTrans($logs);
            }
        }
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        if ($this->act_acttype == 1) {
            return redirect()->route('operate.emer_employ.detail', ['id' => $this->act_id, 'p_id' => 3]);
        } else {
            return redirect()->route('operate.result_train.detail', ['id' => $this->act_id, 'p_id' => 3]);
        }
    }

    public function callBack()
    {
        $this->emit('callback');
        // if ($this->act_acttype == 1) {
        //     return redirect()->route('operate.emer_employ.detail', ['id' => $this->act_id, 'p_id' => 3]);
        // } else {
        //     return redirect()->route('operate.result_train.detail', ['id' => $this->act_id, 'p_id' => 3]);
        // }

    }

    public function render()
    {
        $this->emit('emits');

        if ($this->pop_nationalid) {
            $this->pop_role_list = OoapMasPopulatioType::where('in_active', '=', false)->pluck('population_types_name', 'population_types_id');
            $this->pop_status = $this->pop_role;
        }
        if ($this->p_id == 0) {
            if ($this->check_thai_id) {
                if ($this->alert_nopop) {
                    if ($this->pop_data1) {
                        $this->pop_sname = $this->pop_data1->pop_title;
                        $this->pop_firstname = $this->pop_data1->pop_firstname;
                        $this->pop_lastname = $this->pop_data1->pop_lastname;
                        $this->pop_id = $this->pop_data1->pop_id;
                        $this->pop_role = $this->pop_data1->pop_role;
                        $this->pop_age = $this->pop_data1->pop_age;
                        $this->pop_gender = $this->pop_data1->pop_gender;
                    }

                    $this->check_qrcode = true;
                }
            } else {
                $this->check_qrcode = false;
            }
        }
        return view('livewire.activity.operate.assessment-form.add-component');
    }
}
