<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapTblFiscalyear;

class FiscalyearController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function closeYear($id = NULL)
    {

        $this->param['index_link'] = route('manage.fiscalyear_cls.index');

        $this->param['parent_datas'] = OoapTblFiscalyear::getDatas($id)->first();

        $this->param['title'] = 'ปิดปีงบประมาณ';

        if ($this->param['parent_datas']) {

            $this->param['sub_title'] = $this->param['parent_datas']->fiscalyear_code;

            return view('manage.fiscalyear_cls.save', $this->param);

        }

        return view('master.fiscalyear.close_year', $this->param);

    }

    public function cls_list()
    {

        $this->param['index_link'] = route('manage.fiscalyear_cls.index');

        $this->param['parent_datas'] = Null;

        $this->param['title'] = 'ปิดปีงบประมาณ';

        return view('master.fiscalyear.close_year', $this->param);
    }



    public function edit($fiscalyear_id)
    {
        $icon = getIcon('edit');

        $logs['route_name'] = route('master.fiscalyear.edit', ['id' => $fiscalyear_id]);
        $logs['submenu_name'] = 'แก้ไขปีงบประมาณ';
        $logs['log_type'] = 'edit';

        createLogTrans($logs);

        $OoapTblFiscalyear = OoapTblFiscalyear::getDatas($fiscalyear_id)->first();

        if ($OoapTblFiscalyear) {

            $title = 'ปี ' . $OoapTblFiscalyear->fiscalyear_code;
        } else {

            $title = 'เพิ่มปีงบประมาณ';
        }
        return view('master.fiscalyear.edit', compact('fiscalyear_id'));
        //  ['datacentermaster' => $OoapTblFiscalyear, 'title' => $title, 'icon' => $icon]);
    }



    public function create()
    {

        $logs['route_name'] = 'master.fiscalyear.create';
        $logs['submenu_name'] = 'เพิ่มปีงบประมาณ';
        $logs['log_type'] = 'add';

        createLogTrans($logs);

        $icon = getIcon('add');
        $title = 'เพิ่มปีงบประมาณ';
        return view('master.fiscalyear.create');
    }




    public function index()
    {
        $logs['route_name'] = 'master.fiscalyear.index';
        $logs['submenu_name'] = 'ปีงบประมาณ';
        $logs['log_type'] = 'view';

        createLogTrans($logs);

        return view('master.fiscalyear.index');
    }



    public function destroy($id)
    {
        $logs['route_name'] = route('master.fiscalyear.destroy', ['id' => $id]);
        $logs['submenu_name'] = 'ลบปีงบประมาณ';
        $logs['log_type'] = 'delete';

        createLogTrans($logs);

        OoapTblFiscalyear::getDatas($id)->delete();


        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
