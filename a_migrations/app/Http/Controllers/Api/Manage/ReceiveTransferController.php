<?php

namespace App\Http\Controllers\Api\Manage;

use App\Http\Controllers\Controller;
use App\Models\OoapTblFybdtransfer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReceiveTransferController extends Controller
{
    public function getRequest(Request $request)
    {
        $data = OoapTblFybdtransfer::getGroupDatas(NULL, $request->fiscalyear_code, NULL, $request->delete_budget_id);


        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($data) {

                return '<input type="checkbox"   value="'. $data->id .'" name="adsdfdds['. $data->id .']" class="checkSingle">';
            })
            ->addColumn('transfer_date_show', function ($data) {
                return datetimeToThaiDatetime($data->max_transfer_date, 'd M Y');
            })
            ->addColumn('transfer_amt_show', function ($data) {
                return number_format($data->total_transfer_amt, 2);
            })
            ->addColumn('edit', function ($data) {

                return '<div class="icondemo vertical-align-middle p-2"><a href="' . route('manage.receivetransfer.edit', ['budget_id' => $data->parent_id]) . '"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a></div>';
            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<a href="'. route( 'manage.receivetransfer.select_del', ['delete_budget_id'=>$data->parent_id]) .'">'. getIcon('delete') .'</a>';
                return $button;
            })
            ->rawColumns(['edit', 'transfer_date_show', 'transfer_amt_show', 'del', 'checkbox'])
            ->make(true);
    }
}
