<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasBuildingtype;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BuildingtypeController extends Controller
{
    public function getBuildingtype(Request $request)
    {
    $data = OoapMasBuildingtype::select('ooap_mas_buildingtypes.buildingtype_id',
            'ooap_mas_buildingtypes.name',
            'ooap_mas_buildingtypes.shortname',
            'ooap_mas_buildingtypes.acttype_id',
            'ooap_mas_acttype.name as acttype_name')
            ->leftJoin('ooap_mas_acttype','ooap_mas_buildingtypes.acttype_id','=','ooap_mas_acttype.id')
            ->where('ooap_mas_buildingtypes.in_active','=', false)
            ->orderBy('ooap_mas_buildingtypes.buildingtype_id','asc');
        // dd($data->toSql());
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href="/master/buildingtype/' . $data->buildingtype_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->buildingtype_id . ')" title="ลบ"></button>';
                $button .= '<form action="/master/buildingtype/' . $data->buildingtype_id .'" id="delete_form' . $data->buildingtype_id . '" method="post">
                    <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                return $button;
            })
            ->rawColumns(['edit', 'del'])
            ->make(true);
    }
}
