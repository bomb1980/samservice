<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasCoursetype;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoursetypeController extends Controller
{
    public function getCoursetype(Request $request)
    {
        $data = OoapMasCoursetype::getDatas();
        // dd($data->toSql());
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href="/master/coursetype/' . $data->id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->id . ')" title="ลบ"></button>';
                $button .= '<form action="/master/coursetype/' . $data->id . '" id="delete_form' . $data->id . '" method="post">
                    <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                return $button;
            })
            ->rawColumns(['edit', 'del'])
            ->make(true);
    }
}
