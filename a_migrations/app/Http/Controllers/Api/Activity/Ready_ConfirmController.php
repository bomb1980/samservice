<?php

namespace App\Http\Controllers\api\Activity;

use App\Http\Controllers\Controller;
use App\Models\OoapMasDivision;
use App\Models\OoapTblActivities;
use App\Models\OoapTblPlanAdjust;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Ready_ConfirmController extends Controller
{
    public function getAct(Request $request)
    {
        $data = OoapTblActivities::select(
            'ooap_tbl_activities.act_id',
            'ooap_mas_tambon.tambon_name',
            'ooap_mas_amphur.amphur_name',
            'ooap_tbl_activities.act_number',
            'ooap_tbl_activities.act_year',
            'ooap_tbl_activities.act_periodno',
            'ooap_tbl_activities.act_acttype',
            'ooap_tbl_activities.act_div',
            'ooap_tbl_activities.act_acttype',
            'ooap_mas_acttype.name',
            'ooap_tbl_activities.act_district',
            'ooap_tbl_activities.act_subdistrict',
            'ooap_tbl_activities.act_moo',
            'ooap_tbl_activities.act_startmonth',
            'ooap_tbl_activities.act_endmonth',
            'ooap_tbl_activities.act_numofday',
            'ooap_tbl_activities.act_numofpeople',
            'ooap_tbl_activities.act_amount',
            'ooap_tbl_activities.status',
            'ooap_tbl_activities.act_plan_adjust_status'
        )
            ->leftjoin('ooap_mas_acttype', 'ooap_tbl_activities.act_acttype', 'ooap_mas_acttype.id')
            ->leftjoin('ooap_mas_tambon', 'ooap_tbl_activities.act_subdistrict', 'ooap_mas_tambon.tambon_id')
            ->leftjoin('ooap_mas_amphur', 'ooap_tbl_activities.act_district', 'ooap_mas_amphur.amphur_id')

            ->where('ooap_tbl_activities.in_active', '=', false);
        // ->where('ooap_tbl_activities.status', '=', 0);

        if ($request->fiscalyear_code) {
            $data = $data->where('ooap_tbl_activities.act_year', '=', $request->fiscalyear_code);
        }

        if (auth()->user()->emp_type == 2) {
            $data = $data->where('ooap_tbl_activities.act_province', '=', auth()->user()->province_id);
        }

        if ($request->txt_search) {
            $data = $data->where(function ($query) use ($request) {
                $query->where('ooap_tbl_activities.act_number', 'LIKE', '%' . $request->txt_search . '%')
                    ->orWhere('ooap_mas_acttype.name', 'LIKE', '%' . $request->txt_search . '%')
                    ->orWhere('ooap_mas_amphur.amphur_name', 'LIKE', '%' . $request->txt_search . '%')
                    ->orWhere('ooap_mas_tambon.tambon_name', 'LIKE', '%' . $request->txt_search . '%')
                    ->orWhere('ooap_tbl_activities.act_moo', 'LIKE', '%' . $request->txt_search . '%');
            });
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('period', function ($data) {
                $text = '<div>';
                $text .= onlyMonthThai($data->act_startmonth) . ' - ' . onlyMonthThai($data->act_endmonth);
                $text .= '</div>';
                return $text;
            })
            ->addColumn('act_amount', function ($data) {
                $text = number_format($data->act_amount,2);
                return $text;
            })
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                if ($data->act_acttype == 1) {
                    if (auth()->user()->emp_type == 1) {
                        $button .= '<a href="/activity/ready_confirm/hire/' . $data->act_id . '/edit"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    } else {
                        if ($data->status == 1) {
                            $button .= '<a href="/activity/ready_confirm/hire/' . $data->act_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                        } else {
                            $button .= '<a href="/activity/ready_confirm/hire/' . $data->act_id . '/edit"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                        }
                    }
                } elseif ($data->act_acttype == 2) {
                    if (auth()->user()->emp_type == 1) {
                        $button .= '<a href="/activity/ready_confirm/train/' . $data->act_id . '/edit"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    } else {
                        if ($data->status == 1) {
                            $button .= '<a href="/activity/ready_confirm/train/' . $data->act_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                        } else {
                            $button .= '<a href="/activity/ready_confirm/train/' . $data->act_id . '/edit"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                        }
                    }
                }
                $button .= '</div>';
                return $button;
            })
            ->addColumn('edit_plan', function ($data) use ($request) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                if ($data->act_acttype == 1) {
                    if ($data->act_plan_adjust_status == 2 || $data->act_plan_adjust_status == 3 || $data->act_plan_adjust_status == 4) {
                        $button .= '<a href="/activity/ready_confirm/hire/' . $data->act_id . '/edit"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    } elseif ($data->act_plan_adjust_status == 1) {
                        $button .= '<a href="/activity/ready_confirm/hire/' . $data->act_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                    }
                } elseif ($data->act_acttype == 2) {
                    if ($data->act_plan_adjust_status == 2 || $data->act_plan_adjust_status == 3 || $data->act_plan_adjust_status == 4) {
                        $button .= '<a href="/activity/plan_adjust/train/' . $data->act_id . '/edit"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    } elseif ($data->act_plan_adjust_status == 1) {
                        $button .= '<a href="/activity/plan_adjust/train/' . $data->act_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                    }
                }
                $button .= '</div>';
                return $button;
            })
            ->addColumn('approve', function ($data) use ($request) {
                if (auth()->user()->emp_type == 2) {
                    if ($data->status == 1) {
                        $button = '<button type="button" class="btn btn-pure btn-success icon wb-check"  onclick="change_approve(' . $data->act_id . ')" title="ยืนยัน"></button>';
                        return $button;
                    }
                }
            })
            ->addColumn('del', function ($data) use ($request) {
                if (auth()->user()->emp_type == 2) {
                    if ($data->status == 1) {
                        $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->act_id . ')" title="ลบ"></button>';
                        $button .= '<form action="/activity/ready_confirm/' . $data->act_id . '" id="delete_form' . $data->act_id . '" method="post">
                    <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                        return $button;
                    }
                }
            })
            ->addColumn('del2', function ($data) use ($request) {
                if ($data->act_plan_adjust_status == 1) {
                    $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->act_id . ')" title="ลบ"></button>';
                    // $button .= '<form action="/activity/plan_adjust/' . $data->act_id . '" id="delete_form' . $data->act_id . '" method="post">
                    // <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                    return $button;
                }
            })
            ->addColumn('division_name', function ($data) use ($request) {
                $name = OoapMasDivision::where('division_id', '=', $data->act_div)->where('in_active', '=', false)->first();
                return $name->division_name;
            })
            ->addColumn('status_confirm', function ($data) use ($request) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                if ($data->status == 1) {
                    $button .= '<span class="text-primary">บันทึกแบบร่าง</span>';
                } else if ($data->status == 2) {
                    $button .= '<span class="text-warning">รอพิจารณา</span>';
                } else if ($data->status == 3) {
                    $button .= '<span class="text-success">ผ่านการพิจารณา</span>';
                } else if ($data->status == 4) {
                    $button .= '<span class="text-danger">ไม่ผ่านการพิจารณา</span>';
                } else if ($data->status == 5) {
                    $button .= '<span class="text-primary">ส่งคำขอกลับ</span>';
                }
                $button .= '</div>';
                return $button;
            })
            ->addColumn('status_confirm2', function ($data) use ($request) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                if ($data->act_plan_adjust_status == 1) {
                    $button .= '<span class="text-primary">บันทึก</span>';
                } else if ($data->act_plan_adjust_status == 2) {
                    $button .= '<span class="text-warning">รอพิจารณา</span>';
                } else if ($data->act_plan_adjust_status == 3) {
                    $button .= '<span class="text-success">ผ่านการพิจารณา</span>';
                } else if ($data->act_plan_adjust_status == 4) {
                    $button .= '<span class="text-danger">ไม่ผ่านการพิจารณา</span>';
                }
                $button .= '</div>';
                return $button;
            })
            ->addColumn('status_confirm3', function ($data) use ($request) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                if ($data->status == 1) {
                    $button .= '<span class="text-warning">บันทึกแบบร่าง </span>';
                } else if ($data->status == 2) {
                    $button .= '<span class="text-success">ยืนยันความพร้อม </span>';
                } else if ($data->status == 3) {
                    $button .= '<span class="text-success">จัดสรรโอนเงิน </span>';
                } else if ($data->status == 4) {
                    $button .= '<span class="text-success">บันทึกข้อมูลปรับแผน/โครงการ </span>';
                } else if ($data->status == 5) {
                    $button .= '<span class="text-success">เริ่มกิจกรรม </span>';
                } else if ($data->status == 6) {
                    $button .= '<span class="text-danger">ปิดกิจกรรม </span>';
                }
                $button .= '</div>';
                return $button;
            })
            ->rawColumns([
                'period',
                'approve',
                'edit',
                'del',
                'del2',
                'division_name',
                'status_confirm',
                'status_confirm2',
                'status_confirm3',
                'edit_plan',
            ])
            ->make(true);
    }
}
