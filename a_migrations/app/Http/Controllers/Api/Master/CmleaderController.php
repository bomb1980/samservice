<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasCmleader;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CmleaderController extends Controller
{
    public function getCmleader(Request $request)
    {
    $data = OoapMasCmleader::select('ooap_mas_cmleader.id','ooap_mas_cmleader.cmleader_prefix','ooap_mas_cmleader.cmleader_name','ooap_mas_cmleader.cmleader_surname',
        'ooap_mas_cmleader.moo','ooap_mas_province.province_name','ooap_mas_amphur.amphur_name','ooap_mas_tambon.tambon_name')
            ->leftjoin('ooap_mas_province','ooap_mas_cmleader.province_id','ooap_mas_province.province_id')
            ->leftjoin('ooap_mas_amphur','ooap_mas_cmleader.amphur_id','ooap_mas_amphur.amphur_id')
            ->leftjoin('ooap_mas_tambon','ooap_mas_cmleader.tambon_id','ooap_mas_tambon.tambon_id')
            ->where('ooap_mas_cmleader.in_active','=', false)
            ->orderBy('ooap_mas_cmleader.cmleader_prefix','asc');
        // dd($data->toSql());
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href="/master/cmleader/' . $data->id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->id . ')" title="ลบ"></button>';
                $button .= '<form action="/master/cmleader/' . $data->id .'" id="delete_form' . $data->id . '" method="post">
                    <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                return $button;
            })
            ->rawColumns(['edit', 'del'])
            ->make(true);
        }
}
