<?php

namespace App\Http\Controllers\Api\Request;

use App\Http\Controllers\Controller;
use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblRequest;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime;
use Yajra\DataTables\Facades\DataTables;

class RequestProjectController extends Controller
{
    public function getRequestProject(Request $request)
    {

        $this->start = $request->get("start");
        $rowperpage = $request->get("length");

        $data = OoapTblRequest::getTbDatas(NULL, auth()->user()->emp_type, $request->req_acttype, $request->req_year, $request->status, $request->serachbox, $request->divi_code);

        $data = $data->whereIn('ooap_tbl_requests.status', [1, 2, 3, 4, 5]);

        $totalRecords = $data->count();

        if (isset($request->order[0])) {
            $data = $data->orderby($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
        }

        $data = $data
            ->orderby('ooap_tbl_requests.req_year', 'desc')
            ->orderby('order_status', 'asc')
            ->orderby('ooap_tbl_requests.req_id', 'asc');

        $data = $data->skip($this->start)->take($rowperpage);

        return DataTables::of($data)
            ->setTotalRecords($totalRecords)
            ->addIndexColumn()
            ->addColumn('status_confirm', function ($data) use ($request) {
                $button = '';
                if ($data->status == '1') {
                    $button .= '<span class="text-primary">บันทึกแบบร่าง</span>';
                } else if ($data->status == '2') {
                    $button .= '<span class="text-warning">รอพิจารณา</span>';
                } else if ($data->status == '3') {
                    $button .= '<span class="text-success">ผ่านการพิจารณา</span>';
                } else if ($data->status == '4') {
                    $button .= '<span class="text-danger">ไม่ผ่านการพิจารณา</span>';
                } else if ($data->status == '5') {
                    $button .= '<span class="text-danger">ส่งคำขอกลับ</span>';
                }
                return '<div class="icondemo vertical-align-middle p-2">'. $button .'</div>';
            })
            ->addColumn('checkbox', function ($data) {
                $text = "";
                if ( in_array( $data->status, [1,5]) ) {
                    $text .= '<input type="checkbox" id="' . $data->req_id . '"value="' . $data->req_id . '" name="checkAll" class="checkSingle">';
                }

                else {
                    $text .= '<p>-</p>';
                }
                return $text;
            })
            ->addColumn('req_amount_format', function ($data) {
                $text = number_format(($data->req_amount), 2);
                return $text;
            })
            ->addColumn('req_startmonth_format', function ($data) {
                $text = formatDateThai($data->req_startmonth) . ' - ' . formatDateThai($data->req_endmonth);
                return $text;
            })

            ->addColumn('edit', function ($data) {
                $button = '';
                if (auth()->user()->emp_type == '1') {
                    if ($data->req_acttype == '1') {
                        $button .= '<a href="/request/hire/' . $data->req_id . '/edit"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    } else {
                        $button .= '<a href="/request/train/' . $data->req_id . '/edit"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    }
                } else {
                    if ($data->status == '1' || $data->status == '5') {

                        if ($data->req_enddate < now()) {

                            $button = '';
                        } else {
                        }
                        if ($data->req_acttype == '1') {
                            $button .= '<a href="/request/hire/' . $data->req_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';

                        } else {
                            $button .= '<a href="/request/train/' . $data->req_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';

                        }
                    } else {
                        if ($data->req_acttype == '1') {
                            $button .= '<a href="/request/hire/' . $data->req_id . '/edit"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                        } else {
                            $button .= '<a href="/request/train/' . $data->req_id . '/edit"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                        }

                    }
                }

                return '<div class="icondemo vertical-align-middle p-2">' . $button . '</div>';

            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                if (auth()->user()->emp_type == '2') {
                    if ($data->status == '1' || $data->status == '5') {
                        $button .= '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->req_id . ')" title="ลบ"></button>';
                        $button .= '<form action="/request/project/' . $data->req_id . '" id="delete_form' . $data->req_id . '" method="post">
                                     <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                    } else if ($data->status == '2') {
                        $button .= '<p>-</p>';
                    }
                }


                $button .= '</div>';
                return $button;
            })
            ->rawColumns([
                // 'status_show',
                'status_confirm',
                'edit',
                'checkbox',
                'del'
            ])
            ->make(true);
    }

    public function getReqform_seperate(Request $request)
    {
        return OoapTblRequest::select('req_id')
            ->addSelect(['col1' => function ($data) use ($request) {
                $data->selectRaw('SUM(req_amount)')
                    ->from('ooap_tbl_request')
                    ->where('status', '=', 1)
                    ->where('fiscalyear_code', '=', 2565)
                    ->where('in_active', '=', false);

                if ($request->acttype_id) {
                    $data = $data->where('ooap_tbl_request.acttype_id', '=', $request->acttype_id);
                }

                if ($request->dept_id) {
                    $data = $data->where('ooap_tbl_request.dept_id', '=', $request->dept_id);
                }

                if ($request->fiscalyear_code) {
                    $data = $data->where('ooap_tbl_request.fiscalyear_code', '=', $request->fiscalyear_code);
                }

                $data = $data->groupBy('status');
            }])->addSelect(['col2' => function ($data) use ($request) {
                $data->selectRaw('count(*)')
                    ->from('ooap_tbl_reqform')
                    ->where('status', '=', 1)
                    // ->where('fiscalyear_code', 2565)
                    ->where('in_active', '=', false)
                    ->groupBy('status');

                if ($request->acttype_id) {
                    $data = $data->where('ooap_tbl_reqform.acttype_id', '=', $request->acttype_id);
                }

                if ($request->dept_id) {
                    $data = $data->where('ooap_tbl_reqform.dept_id', '=', $request->dept_id);
                }

                if ($request->fiscalyear_code) {
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code', '=', $request->fiscalyear_code);
                }
            }])
            ->addSelect(['col3' => function ($data) use ($request) {
                $data->selectRaw('SUM(total_amt)')
                    ->from('ooap_tbl_reqform')
                    ->where('status', '=', 2)
                    // ->where('fiscalyear_code', 2565)
                    ->where('in_active', '=', false)
                    ->groupBy('status');

                if ($request->acttype_id) {
                    $data = $data->where('ooap_tbl_reqform.acttype_id', '=', $request->acttype_id);
                }

                if ($request->dept_id) {
                    $data = $data->where('ooap_tbl_reqform.dept_id', '=', $request->dept_id);
                }

                if ($request->fiscalyear_code) {
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code', '=', $request->fiscalyear_code);
                }
            }])->addSelect(['col4' => function ($data) use ($request) {
                $data->selectRaw('count(*)')
                    ->from('ooap_tbl_reqform')
                    ->where('status', '=', 2)
                    // ->where('fiscalyear_code', 2565)
                    ->where('in_active', '=', false)
                    ->groupBy('status');

                if ($request->acttype_id) {
                    $data = $data->where('ooap_tbl_reqform.acttype_id', '=', $request->acttype_id);
                }

                if ($request->dept_id) {
                    $data = $data->where('ooap_tbl_reqform.dept_id', '=', $request->dept_id);
                }

                if ($request->fiscalyear_code) {
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code', '=', $request->fiscalyear_code);
                }
            }])
            ->addSelect(['col5' => function ($data) use ($request) {
                $data->selectRaw('SUM(total_amt)')
                    ->from('ooap_tbl_reqform')
                    ->where('status', '=', 3)
                    // ->where('fiscalyear_code', 2565)
                    ->where('in_active', '=', false)
                    ->groupBy('status');

                if ($request->acttype_id) {
                    $data = $data->where('ooap_tbl_reqform.acttype_id', '=', $request->acttype_id);
                }

                if ($request->dept_id) {
                    $data = $data->where('ooap_tbl_reqform.dept_id', '=', $request->dept_id);
                }

                if ($request->fiscalyear_code) {
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code', '=', $request->fiscalyear_code);
                }
            }])->addSelect(['col6' => function ($data) use ($request) {
                $data->selectRaw('count(*)')
                    ->from('ooap_tbl_reqform')
                    ->where('status', '=', 3)
                    // ->where('fiscalyear_code', 2565)
                    ->where('in_active', '=', false)
                    ->groupBy('status');

                if ($request->acttype_id) {
                    $data = $data->where('ooap_tbl_reqform.acttype_id', '=', $request->acttype_id);
                }

                if ($request->dept_id) {
                    $data = $data->where('ooap_tbl_reqform.dept_id', '=', $request->dept_id);
                }

                if ($request->fiscalyear_code) {
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code', '=', $request->fiscalyear_code);
                }
            }])
            ->addSelect(['col7' => function ($data) use ($request) {
                $data->selectRaw('SUM(total_amt)')
                    ->from('ooap_tbl_reqform')
                    ->where('status', '=', 4)
                    // ->where('fiscalyear_code', 2565)
                    ->where('in_active', '=', false)
                    ->groupBy('status');

                if ($request->acttype_id) {
                    $data = $data->where('ooap_tbl_reqform.acttype_id', '=', $request->acttype_id);
                }

                if ($request->dept_id) {
                    $data = $data->where('ooap_tbl_reqform.dept_id', '=', $request->dept_id);
                }

                if ($request->fiscalyear_code) {
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code', '=', $request->fiscalyear_code);
                }
            }])->addSelect(['col8' => function ($data) use ($request) {
                $data->selectRaw('count(*)')
                    ->from('ooap_tbl_reqform')
                    ->where('status', '=', 4)
                    // ->where('fiscalyear_code', 2565)
                    ->where('in_active', '=', false)
                    ->groupBy('status');

                if ($request->acttype_id) {
                    $data = $data->where('ooap_tbl_reqform.acttype_id', '=', $request->acttype_id);
                }

                if ($request->dept_id) {
                    $data = $data->where('ooap_tbl_reqform.dept_id', '=', $request->dept_id);
                }

                if ($request->fiscalyear_code) {
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code', '=', $request->fiscalyear_code);
                }
            }])
            ->addSelect(['col9' => function ($data) use ($request) {
                $data->selectRaw('SUM(total_amt)')
                    ->from('ooap_tbl_reqform')
                    ->where('status', '=', 9)
                    // ->where('fiscalyear_code', 2565)
                    ->where('in_active', '=', false)
                    ->groupBy('status');

                if ($request->acttype_id) {
                    $data = $data->where('ooap_tbl_reqform.acttype_id', '=', $request->acttype_id);
                }

                if ($request->dept_id) {
                    $data = $data->where('ooap_tbl_reqform.dept_id', '=', $request->dept_id);
                }

                if ($request->fiscalyear_code) {
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code', '=', $request->fiscalyear_code);
                }
            }])->addSelect(['col10' => function ($data) use ($request) {
                $data->selectRaw('count(*)')
                    ->from('ooap_tbl_reqform')
                    ->where('status', '=', 9)
                    // ->where('fiscalyear_code', 2565)
                    ->where('in_active', '=', false)
                    ->groupBy('status');

                if ($request->acttype_id) {
                    $data = $data->where('ooap_tbl_reqform.acttype_id', '=', $request->acttype_id);
                }

                if ($request->dept_id) {
                    $data = $data->where('ooap_tbl_reqform.dept_id', '=', $request->dept_id);
                }

                if ($request->fiscalyear_code) {
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code', '=', $request->fiscalyear_code);
                }
            }])
            ->addSelect(['col11' => function ($data) use ($request) {
                $data->selectRaw('SUM(total_amt)')
                    ->from('ooap_tbl_reqform')
                    ->whereIn('status', [1, 2, 3, 4])
                    // ->where('fiscalyear_code', 2565)
                    ->where('in_active', '=', false);

                if ($request->acttype_id) {
                    $data = $data->where('ooap_tbl_reqform.acttype_id', '=', $request->acttype_id);
                }

                if ($request->dept_id) {
                    $data = $data->where('ooap_tbl_reqform.dept_id', '=', $request->dept_id);
                }

                if ($request->fiscalyear_code) {
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code', '=', $request->fiscalyear_code);
                }
            }])->addSelect(['col12' => function ($data) use ($request) {
                $data->selectRaw('count(*)')
                    ->from('ooap_tbl_reqform')
                    ->whereIn('status', [1, 2, 3, 4])
                    // ->where('fiscalyear_code', 2565)
                    ->where('in_active', '=', false);

                if ($request->acttype_id) {
                    $data = $data->where('ooap_tbl_reqform.acttype_id', '=', $request->acttype_id);
                }

                if ($request->dept_id) {
                    $data = $data->where('ooap_tbl_reqform.dept_id', '=', $request->dept_id);
                }

                if ($request->fiscalyear_code) {
                    $data = $data->where('ooap_tbl_reqform.fiscalyear_code', '=', $request->fiscalyear_code);
                }
            }])
            ->first();
    }
    public function getReqformYearsNoti(Request $request)
    {
        $fiscalyear_code = $request->fiscalyear_code ?? date("Y") + 543;
        $st = OoapTblFiscalyear::select(['req_startdate'])->where('fiscalyear_code', '=', $fiscalyear_code)->first()->req_startdate;
        $en = OoapTblFiscalyear::select(['req_enddate'])->where('fiscalyear_code', '=', $fiscalyear_code)->first()->req_enddate;

        $date1 = date_create($st);
        $date2 = date_create($en);
        $now = new DateTime();

        $diff1 = date_diff($date1, $date2);
        $diff_all = $diff1->format("%a") ?? 0;

        $diff2 = date_diff($now, $date2);
        $diff_now = $diff2->format('%a') ?? 0;

        $per = ($diff_now / $diff_all) * 100 ?? 0;

        if ($per <= 15) {
            $alert = '#dc3545';
        } else if ($per <= 30) {
            $alert = '#ffc107';
        } else {
            $alert = '#28a745';
        }

        return $arr = ['st' => datetoview($st), 'en' => datetoview($en), 'amount' => $diff_all, 'diff' => $diff_now, 'per' => $per, 'alert' => $alert];
    }

    public function getRequestCopy(Request $request)
    {
        $data = OoapTblRequest::where('ooap_tbl_requests.in_active', '=', false)
            ->leftJoin('ooap_mas_acttype', 'ooap_tbl_requests.req_acttype', 'ooap_mas_acttype.id')
            ->where('ooap_tbl_requests.status', '=', 3);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($data) {
                $text = "";
                $text .= '<input type="checkbox" id="' . $data->req_id . '"value="' . $data->req_id . '" name="checkAll" class="checkSingle">';

                return $text;
            })
            ->addColumn('req_amount_format', function ($data) {
                $text = number_format(($data->req_amount), 2);
                return $text;
            })
            ->addColumn('req_startmonth_format', function ($data) {
                // $text = onlyMonthThai($data->req_startmonth) . ' - ' . onlyMonthThai($data->req_endmonth);
                $text = formatDateThai($data->req_startmonth) . ' - ' . formatDateThai($data->req_endmonth);
                return $text;
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
                    $button .= '<span class="text-ddanger">ไม่ผ่านการพิจารณา</span>';
                } else if ($data->status == 5) {
                    $button .= '<span class="text-primary">ส่งคำขอกลับ</span>';
                }
                $button .= '</div>';
                return $button;
            })
            // ->addColumn('del', function ($data) use ($request) {
            //     $button = '<div class="icondemo vertical-align-middle p-2">';
            //     $button .= '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->req_id . ', ' . $data->req_number . ')" title="ลบ"></button>';
            //     $button .= '<form action="/request/request2_3/' . $data->req_id .'"'. $data->req_number .'"" id="delete_form' . $data->req_id . '" method="post">
            //                 <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
            //     $button .= '</div>';
            //     return $button;
            // })
            // ->addColumn('status_show', function ($data) use ($request) {
            //     $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->req_id . ')" title="ลบ"></button>';
            //     $button .= '<form action="/request/reqform/' . $data->req_id .'" id="delete_form' . $data->req_id . '" method="post">
            //         <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
            //     return $button;
            // })
            // // ->rawColumns(['startdate_view','enddate_view','edit', 'del'])
            ->rawColumns([
                // 'status_show',
                'status_confirm',
                'edit',
                'checkbox',
                'del'
            ])
            ->make(true);
    }
}
