<?php

namespace App\Http\Controllers\Api\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RequestHireController extends Controller
{
    public function getRequest(Request $request)
    {
        $data = DB::select('SELECT * FROM users');

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('edit', function ($data) {
            $button = '<div class="icondemo vertical-align-middle p-2">';
            $button .= '<a href="request/hire/' . $data->district_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
            $button .= '</div>';
            return $button;
        })
        // ->addColumn('del', function ($data) use ($request) {
        //     $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->district_id . ')" title="ลบ"></button>';
        //     $button .= '<form action="/request/request2_1/' . $data->district_id .'" id="delete_form' . $data->district_id . '" method="post">
        //         <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
        //     return $button;
        // })
        // ->rawColumns(['startdate_view','enddate_view','edit', 'del'])
        ->rawColumns([
            'edit',
            // 'del'
        ])
        ->make(true);
    }
}
