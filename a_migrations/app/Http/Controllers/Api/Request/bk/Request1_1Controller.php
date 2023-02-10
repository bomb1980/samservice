<?php

namespace App\Http\Controllers\Api\Request;

use App\Http\Controllers\Controller;
use App\Models\OoapTblFiscalyear;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Request1_1Controller extends Controller
{

    public function getRequest1_1(Request $request)
    {
        $data = OoapTblFiscalyear::select('id','fiscalyear_code','req_status','req_startdate','req_enddate','status')
            ->where('in_active', '=', false)
            ->orderBy('fiscalyear_code','desc');
        //     if ($request->budgetyear){
        //         $data=$data->where('budgetyear',$request->budgetyear);
        // $data = OoapTblBudProjectplan::select('projectplansid','budgetyear','startdate','enddate','reqbudget','allocatebudget');
            // if ($request->budgetyear){
            //     $data=$data->where('budgetyear',$request->budgetyear);
            // }
        return DataTables::of($data)
            ->addIndexColumn()
            // ->addColumn('startdate_view', function ($data) {
            //     $text = datetoview($data->startdate) ?? '-';
            //     return $text;
            // })
            // ->addColumn('enddate_view', function ($data) {
            //     $text = datetoview($data->enddate) ?? '-';
            //     return $text;
            // })
            //    ->addColumn('reqbudget', function ($data) {
            //     $text = number_format($data->reqbudget,2);
            //     return $text;
            // })
            // ->addColumn('allocatebudget', function ($data) {
            //     $text = number_format($data->allocatebudget,2);
            //     return $text;
            // })
            // ->addColumn('transfers', function ($data) {
            //     $text = number_format($data->transfers,2);
            //     return $text;
            // })
            // ->addColumn('bindings', function ($data) {
            //     $text = number_format($data->bindings,2);
            //     return $text;
            // })
            // ->addColumn('withdraws', function ($data) {
            //     $text = number_format($data->withdraws,2);
            //     return $text;
            // })
            // ->addColumn('balances', function ($data) {
            //     $text = number_format($data->balances,2);
            //     return $text;
            // })
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href="request1_1/' . $data->id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->id . ')" title="ลบ"></button>';
                $button .= '<form action="/request/request1_1/' . $data->id .'" id="delete_form' . $data->id . '" method="post">
                    <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                return $button;
            })
            // ->rawColumns(['startdate_view','enddate_view','edit', 'del'])
            ->rawColumns(['id','fiscalyear_code','edit', 'del'])
            ->make(true);
    }
}
