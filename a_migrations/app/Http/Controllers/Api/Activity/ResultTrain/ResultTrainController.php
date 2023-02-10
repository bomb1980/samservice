<?php

namespace App\Http\Controllers\Api\Activity\ResultTrain;

use App\Http\Controllers\Controller;
use App\Models\OoapMasLecturerType;
use App\Models\OoapTblPopulation;
use App\Models\OoapTblPopulationCheckin;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ResultTrainController extends Controller
{
    public function getResultTrain(Request $request)
    {
        $data = OoapTblPopulation::select([
            'ooap_tbl_populations.pop_id',
            'ooap_tbl_populations.pop_actnumber',
            'ooap_tbl_populations.pop_nationalid',
            'ooap_tbl_populations.pop_title',
            'ooap_tbl_populations.pop_firstname',
            'ooap_tbl_populations.pop_lastname',
            'ooap_tbl_populations.pop_role',
            'ooap_tbl_populations.pop_age',
            'ooap_tbl_populations.pop_gender',
            'ooap_tbl_populations.pop_mobileno',
            'ooap_tbl_populations.pop_div',
        ])
            ->selectRaw("ooap_tbl_populations.pop_title || ' ' || ooap_tbl_populations.pop_firstname || '  ' || ooap_tbl_populations.pop_lastname AS fullname")
            ->where('ooap_tbl_populations.in_active', '=', false);

        if ($request->act_number) {
            $data = $data->where('ooap_tbl_populations.pop_actnumber', '=', $request->act_number);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('fullname', function ($data) {
                $titlename = titlename($data->pop_title);
                $fullname = $titlename . " " . $data->pop_firstname . " " . $data->pop_lastname;
                return $fullname;
            })
            ->addColumn('rolelist', function ($data) {
                $rolelist = rolelist($data->pop_role);
                return $rolelist;
            })
            ->addColumn('nationalid', function ($data) {
                $nation_id = hideStr($data->pop_nationalid);
                return $nation_id;
            })
            ->addColumn('detail', function ($data) use ($request) {
                $button = '<div class="icon-demo vertical-align-middle p-2">';
                if ($data->pop_div == $request->act_div) {
                    $button .= '<a href="/population/' . $request->act_id . '/' . $data->pop_id . '/edit"><i class="icon wb-edit" aria-hidden="true" title="รายละเอียด"></i></a>';
                } else {
                    $button .= '<a href="#" onclick="return theFunction();" ><i class="icon wb-edit" aria-hidden="true" title="รายละเอียด"></i></a>';
                }
                $button .= '</div>';
                return $button;
            })
            ->rawColumns([
                'fullname',
                'rolelist',
                'nationalid',
                'detail',
            ])
            ->make(true);
    }

    public function getpoptime(Request $request)
    {
        $data = OoapTblPopulation::select([
            'ooap_tbl_populations.pop_id',
            'ooap_tbl_populations.pop_actnumber',
            'ooap_tbl_populations.pop_nationalid',
            'ooap_tbl_populations.pop_title',
            'ooap_tbl_populations.pop_firstname',
            'ooap_tbl_populations.pop_lastname',
            'ooap_tbl_populations.pop_role',
            'ooap_tbl_populations.pop_age',
            'ooap_tbl_populations.pop_gender',
            'ooap_tbl_populations.pop_mobileno',
            'ooap_tbl_populations.pop_div',

        ])
            ->selectRaw("ooap_tbl_populations.pop_title || ' ' || ooap_tbl_populations.pop_firstname || '  ' || ooap_tbl_populations.pop_lastname AS fullname")
            ->whereIn('ooap_tbl_populations.pop_role', [2,3])
            ->where('ooap_tbl_populations.in_active', '=', false);
        if ($request->act_number) {
            $data = $data->where('ooap_tbl_populations.pop_actnumber', '=', $request->act_number);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            // ->addColumn('showdate', function ($data) {
            //     if ($data->check_status == 0) {
            //         $showdate = 'ไม่เข้าร่วม';
            //     } else {
            //         $showdate = datetoview($data->check_date);
            //     }
            //     return $showdate;
            // })
            ->addColumn('fullname', function ($data) {
                $titlename = titlename($data->pop_title);
                $fullname = $titlename . " " . $data->pop_firstname . " " . $data->pop_lastname;
                return $fullname;
            })
            ->addColumn('checkbox_s1', function ($data) use ($request) {
                $pop_check = OoapTblPopulationCheckin::where('in_active', '=', false)
                    ->where('ooap_tbl_population_checkins.check_date', '=', DateToSqlExpSlash($request->date))
                    ->where('ooap_tbl_population_checkins.pop_id', '=', $data->pop_id)->first();
                $checkbox = "";
                $checkbox .= '<input type="radio" id="1"value="' . $data->pop_id . '" name="check' . $data->pop_id . '" class="checkSingle1"';
                if(auth()->user()->emp_type == 1){
                    $checkbox .= 'disabled="disabled"';
                }
                if ($pop_check) {
                    if ($pop_check->check_status == 1) {
                        $checkbox .= 'checked';
                    }
                }
                $checkbox .= '>';
                return $checkbox;
            })
            ->addColumn('checkbox_s0', function ($data) use ($request) {
                $pop_check = OoapTblPopulationCheckin::where('in_active', '=', false)
                    ->where('ooap_tbl_population_checkins.check_date', '=', DateToSqlExpSlash($request->date))
                    ->where('ooap_tbl_population_checkins.pop_id', '=', $data->pop_id)->first();
                $checkbox = "";
                $checkbox .= '<input type="radio" id="0"value="' . $data->pop_id . '" name="check' . $data->pop_id . '" class="checkSingle0"';
                if(auth()->user()->emp_type == 1){
                    $checkbox .= 'disabled="disabled"';
                }
                if ($pop_check) {
                    if ($pop_check->check_id != null) {
                        if ($pop_check->check_status == 0) {
                            $checkbox .= 'checked';
                        }
                    }
                }
                $checkbox .= '>';
                return $checkbox;
            })
            // ->addColumn('checkbox_s2', function ($data) {
            //     $checkbox = "";
            //     $checkbox .= '<input type="radio" id="2"value="' . $data->pop_id . '" name="check' . $data->pop_id . '" class="checkSingle2"';
            //     if ($data->check_status == 2) {
            //         $checkbox .= 'checked >';
            //     } else {
            //         $checkbox .= '>';
            //     }
            //     return $checkbox;
            // })
            // ->addColumn('agent', function ($data) {
            //     $text = "";
            //     $text .= '<input type="text" id="' . $data->pop_id . '" value="' . $data->check_instead . '" class="form-control checkagent col-md-12">';
            //     return $text;
            // })
            ->rawColumns([
                // 'showdate',
                'fullname',
                'checkbox_s1',
                'checkbox_s0',
                // 'checkbox_s2',
                // 'agent',
            ])
            ->make(true);
    }

    public function getform_train(Request $request)
    {
        $data = OoapTblPopulation::select([
            'ooap_tbl_populations.pop_id',
            'ooap_tbl_populations.pop_actnumber',
            'ooap_tbl_populations.pop_nationalid',
            'ooap_tbl_populations.pop_title',
            'ooap_tbl_populations.pop_firstname',
            'ooap_tbl_populations.pop_lastname',
            'ooap_tbl_populations.pop_mobileno',
            'ooap_tbl_populations.pop_role',

            'ooap_mas_tambon.tambon_id',
            'ooap_mas_tambon.tambon_name',
            'ooap_mas_amphur.amphur_id',
            'ooap_mas_amphur.amphur_name',
            'ooap_mas_province.province_id',
            'ooap_mas_province.province_name',
        ])
            ->leftjoin('ooap_tbl_population_checkins', 'ooap_tbl_populations.pop_id', '=', 'ooap_tbl_population_checkins.pop_id')
            ->leftjoin('ooap_mas_tambon', 'ooap_mas_tambon.tambon_id', '=', 'ooap_tbl_populations.pop_subdistrict')
            ->leftjoin('ooap_mas_amphur', 'ooap_mas_amphur.amphur_id', '=', 'ooap_tbl_populations.pop_district')
            ->leftjoin('ooap_mas_province', 'ooap_mas_province.province_id', '=', 'ooap_tbl_populations.pop_province')
            ->selectRaw("'ต.'||tambon_name || ' ' || 'อ.'||amphur_name || ' ' || 'จ.'||province_name AS address")
            ->whereIn('ooap_tbl_population_checkins.check_status', [1])
            ->where('ooap_tbl_populations.in_active', '=', false)
            ->whereIn('ooap_tbl_populations.pop_role', [2,3])
            ->groupby([
                'ooap_tbl_populations.pop_id',
                'ooap_tbl_populations.pop_actnumber',
                'ooap_tbl_populations.pop_nationalid',
                'ooap_tbl_populations.pop_title',
                'ooap_tbl_populations.pop_firstname',
                'ooap_tbl_populations.pop_lastname',
                'ooap_tbl_populations.pop_mobileno',
                'ooap_tbl_populations.pop_role',

                'ooap_tbl_population_checkins.pop_id',
                'ooap_tbl_population_checkins.check_status',
                'ooap_mas_tambon.tambon_id',
                'ooap_mas_tambon.tambon_name',
                'ooap_mas_amphur.amphur_id',
                'ooap_mas_amphur.amphur_name',
                'ooap_mas_province.province_id',
                'ooap_mas_province.province_name',
            ]);


        if ($request->act_number) {
            $data = $data->where('ooap_tbl_populations.pop_actnumber', '=', $request->act_number);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('fullname', function ($data) {
                if($data->pop_title == null){
                    $titlename = '';
                }else{
                    $titlename = titlename($data->pop_title);
                }
                $fullname = $titlename . " " . $data->pop_firstname . " " . $data->pop_lastname;
                return $fullname;
            })
            ->addColumn('nationalid', function ($data) {
                $nation_id = hideStr($data->pop_nationalid);
                return $nation_id;
            })
            ->addColumn('role', function ($data) {
                $role = rolelist($data->pop_role);
                return $role;
            })
            ->addColumn('address', function ($data) {
                $tambon_name = $data->tambon_id == 0 ? '' : 'ต.' . $data->tambon_name;
                $amphur_name = $data->amphur_id == 0 ? '' : ' อ.' . $data->amphur_name;
                $province_name = $data->province_id == 0 ? '' : ' จ.' . $data->province_name;
                $address = $tambon_name . $amphur_name . $province_name;
                return $address;
            })
            ->addColumn('detail', function ($data) use ($request) {
                $button = '<div class="icon-demo vertical-align-middle p-2">';
                $button .= '<a target="_blank" href="/assessment_form/' . $request->act_id . '/form/' . $data->pop_id . '"><i class="icon wb-edit" aria-hidden="true" title="รายละเอียด"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns([
                'fullname',
                'nationalid',
                'role',
                'address',
                'detail',
            ])
            ->make(true);
    }

    public function getResultTrain_role1(Request $request)
    {
        $data = OoapTblPopulation::select([
            'ooap_tbl_populations.pop_id',
            'ooap_tbl_populations.pop_actnumber',
            'ooap_tbl_populations.pop_nationalid',
            'ooap_tbl_populations.pop_title',
            'ooap_tbl_populations.pop_firstname',
            'ooap_tbl_populations.pop_lastname',
            'ooap_tbl_populations.pop_role',
            'ooap_tbl_populations.pop_age',
            'ooap_tbl_populations.pop_gender',
            'ooap_tbl_populations.pop_mobileno',
            'ooap_tbl_populations.pop_div',
            'ooap_tbl_populations.pop_typelecturer',
        ])
            ->selectRaw("ooap_tbl_populations.pop_title || ' ' || ooap_tbl_populations.pop_firstname || '  ' || ooap_tbl_populations.pop_lastname AS fullname")
            // ->where('ooap_tbl_populations.pop_role', '=', 1)
            ->where('ooap_tbl_populations.in_active', '=', false);

        if ($request->act_number) {
            $data = $data->where('ooap_tbl_populations.pop_actnumber', '=', $request->act_number);
        }
        if ($request->role == 1) {
            $data = $data->where('ooap_tbl_populations.pop_role', '=', 1);
        } else {
            $data = $data->where('ooap_tbl_populations.pop_role', '=', 2);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('fullname', function ($data) {
                // $titlename = titlename($data->pop_title);
                $fullname = $data->pop_firstname . " " . $data->pop_lastname;
                return $fullname;
            })
            ->addColumn('rolelist', function ($data) {
                $check = OoapMasLecturerType::where('in_active', '=', false)->where('lecturer_types_id', '=', $data->pop_typelecturer)->first();
                // $rolelist = rolelist($data->pop_role);
                return $check->lecturer_types_name;
            })
            ->addColumn('nationalid', function ($data) {
                $nation_id = hideStr($data->pop_nationalid);
                return $nation_id;
            })
            // ->addColumn('detail', function ($data) use ($request) {
            //     $button = '<div class="icon-demo vertical-align-middle p-2">';
            //     if ($data->pop_div == $request->act_div) {
            //         $button .= '<a href="/population/' . $request->act_id . '/' . $data->pop_id . '/edit" target="_blank"><i class="icon wb-edit" aria-hidden="true" title="รายละเอียด"></i></a>';
            //     } else {
            //         $button .= getIcon('lock');
            //     }
            //     $button .= '</div>';
            //     return $button;
            // })
            ->rawColumns([
                'fullname',
                'rolelist',
                'nationalid',
                'detail',
            ])
            ->make(true);
    }

    public function getResultTrain_role1_form(Request $request)
    {
        $data = OoapTblPopulation::select([
            'ooap_tbl_populations.pop_id',
            'ooap_tbl_populations.pop_actnumber',
            'ooap_tbl_populations.pop_nationalid',
            'ooap_tbl_populations.pop_title',
            'ooap_tbl_populations.pop_firstname',
            'ooap_tbl_populations.pop_lastname',
            'ooap_tbl_populations.pop_role',
            'ooap_tbl_populations.pop_age',
            'ooap_tbl_populations.pop_gender',
            'ooap_tbl_populations.pop_mobileno',
            'ooap_tbl_populations.pop_div',
            'ooap_tbl_populations.pop_typelecturer',
        ])
            ->selectRaw("ooap_tbl_populations.pop_title || ' ' || ooap_tbl_populations.pop_firstname || '  ' || ooap_tbl_populations.pop_lastname AS fullname")
            // ->where('ooap_tbl_populations.pop_role', '=', 1)
            ->where('ooap_tbl_populations.in_active', '=', false);

        if ($request->act_number) {
            $data = $data->where('ooap_tbl_populations.pop_actnumber', '=', $request->act_number);
        }
        if ($request->role == 1) {
            $data = $data->where('ooap_tbl_populations.pop_role', '=', 1);
        } else {
            $data = $data->where('ooap_tbl_populations.pop_role', '=', 2);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('fullname', function ($data) {
                // $titlename = titlename($data->pop_title);
                $fullname = $data->pop_firstname . " " . $data->pop_lastname;
                return $fullname;
            })
            ->addColumn('rolelist', function ($data) {
                $check = OoapMasLecturerType::where('in_active', '=', false)->where('lecturer_types_id', '=', $data->pop_typelecturer)->first();
                // $rolelist = rolelist($data->pop_role);
                return $check->lecturer_types_name;
            })
            ->addColumn('nationalid', function ($data) {
                $nation_id = hideStr($data->pop_nationalid);
                return $nation_id;
            })
            ->addColumn('detail', function ($data) use ($request) {
                $button = '<div class="icon-demo vertical-align-middle p-2">';
                $button .= '<a href="/assessment_form/' . $request->act_id . '/form/' . $data->pop_id . '"><i class="icon wb-edit" aria-hidden="true" title="รายละเอียด"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns([
                'fullname',
                'rolelist',
                'nationalid',
                'detail',
            ])
            ->make(true);
    }
}
