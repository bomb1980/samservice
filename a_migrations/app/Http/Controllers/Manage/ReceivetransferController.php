<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblFybdtransfer;

class ReceivetransferController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function edit($budget_id = NULL)
    {

        $this->params['budget'] = OoapTblBudgetProjectplanPeriod::getDatas($budget_id)->first();

        if ($this->params['budget']) {


            $this->params['parent_datas'] = null;
            $this->params['title'] = 'ข้อมูลรับโอนเงินจากสำนักงบประมาณ';
            $this->params['sub_title'] = 'แก้ไขข้อมูลรับโอนเงิน ปี ' . $this->params['budget']->budgetyear . ' งวด ' . $this->params['budget']->periodno;
            $this->params['icon'] = getIcon('edit');
        } else {
            $this->params['parent_datas'] = null;
            $this->params['title'] = 'ข้อมูลรับโอนเงินจากสำนักงบประมาณ';
            $this->params['sub_title'] = 'เพิ่มข้อมูลรับโอนเงิน';
            $this->params['icon'] = getIcon('add');
        }


        // dd('sdfasdf');

        return view('manage.receivetransfer.edit', $this->params);
    }

    public function create()
    {

        $this->params['budget'] = NULL;

        $this->params['parent_datas'] = null;
        $this->params['title'] = 'ข้อมูลรับโอนเงินจากสำนักงบประมาณ';
        $this->params['sub_title'] = 'เพิ่มข้อมูลรับโอนเงิน';
        $this->params['icon'] = getIcon('add');

        return view('manage.receivetransfer.edit', $this->params);
    }


    public function index($delete_budget_id = NULL)
    {
        $this->params['delete_budget_id'] = $delete_budget_id;

        if (!empty($delete_budget_id)) {

            $this->params['columns'] = [

                ['name' => 'checkbox', 'label' => 'เลือกรายการที่ต้องการลบ'],
                ['name' => 'fiscalyear_code', 'label' => 'ปีงบประมาณ'],
                ['name' => 'periodno', 'label' => 'งวดที่'],
                ['name' => 'transfer_date_show', 'label' => 'วันที่รับโอน'],
                ['name' => 'transfer_amt_show', 'label' => 'จำนวนเงิน', 'className' => 'text-right'],
                // ['name'=>'transfer_desp', 'label'=>'รายละเอียด', 'className'=>'text-left'],
                // ['name'=>'edit', 'label'=>'แก้ไข'],
                // ['name'=>'del', 'label'=>'ลบ'],
            ];
            // $this->params['bredcum'] = 'dsfdfds';

            $this->params['bredcum'] = '<li class="breadcrumb-item"><a href="'. route('manage.receivetransfer.index') .'" class="keychainify-checked">ข้อมูลรับโอนเงินจากสำนักงบประมาณ</a></li><li class="breadcrumb-item active">ลบรายการ</li>';

            $this->params['title'] = 'ลบข้อมูล';
            $this->params['icon'] = getIcon('delete');

        } else {

            $this->params['columns'] = [

                // ['name'=>'checkbox', 'label'=>'checkbox'],
                // ['name' => 'fiscalyear_code', 'label' => 'ปีงบประมาณ'],
                ['name' => 'periodno', 'label' => 'งวดที่', 'className' => 'text-center col-1'],
                ['name' => 'transfer_date_show', 'label' => 'วันที่รับโอน', 'className' => 'text-center col-1'],
                ['name' => 'transfer_amt_show', 'label' => 'จำนวนเงิน', 'className' => 'text-right'],
                // ['name'=>'transfer_desp', 'label'=>'รายละเอียด', 'className'=>'text-left'],
                ['name' => 'edit', 'label' => 'แก้ไข', 'className' => 'text-center col-1'],
                ['name' => 'del', 'label' => 'ลบ', 'className' => 'text-center col-1'],
            ];
            $this->params['bredcum'] = '<li class="breadcrumb-item active">ข้อมูลรับโอนเงินจากสำนักงบประมาณ</li>';
            $this->params['title'] = 'ข้อมูลรับโอนเงินจากสำนักงบประมาณ';
            $this->params['icon'] = '';
        }

        return view('manage.receivetransfer.index', $this->params);
    }

    public function destroy($id)
    {
        $this->params['parent_datas'] = OoapTblFybdtransfer::getDatas($id)->first();

        if ($this->params['parent_datas']) {

            OoapTblFybdtransfer::where('id', '=', $id)->delete();
        }


        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
