<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapTblPopulationType;

class PopulationTypesController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {

        $this->params['columns'] = [
            ['name'=>'no', 'label'=>'ลำดับ'],
            ['name'=>'name', 'label'=>'ประเภท'],
            ['name'=>'edit', 'label'=>'แก้ไข'],
            ['name'=>'del', 'label'=>'ลบ'],

        ];

        $this->params['title'] = 'ประเภทแบบประเมิน';
        $this->params['api'] = 'api.master.poptype';


        return view('poptype', $this->params );

    }


    public function create()
    {

        $icon = getIcon('add');
        $getResult = NULL;
        $title = 'เพิ่มข้อมูลประเภทแบบประเมิน';

        $logs['route_name'] = route('master.coursegroup.create');


        $logs['submenu_name'] =  $title;
        $logs['log_type'] = 'add';

        createLogTrans( $logs );

        return view('master.poptype.edit', ['dataCoursegroup' => $getResult, 'title' => $title, 'icon' => $icon, 'sub_title' => NULL]);

    }


    public function edit($id)
    {


        $icon = getIcon('add');
        $getResult = NULL;
        $title = 'เพิ่มข้อมูลประเภทแบบประเมิน';

        $logs['route_name'] = route('master.coursegroup.create');

        foreach (OoapTblPopulationType::getDatas($id)->get() as $ka => $va) {
            $title = 'แก้ไขข้อมูลประเภทแบบประเมิน';
            $icon = getIcon('edit');

            $getResult = OoapTblPopulationType::find($va->id);

            $sub_title = $getResult->name;
            $logs['route_name'] = route('master.coursegroup.edit', ['id' => $id]);
        }
        $logs['submenu_name'] =  $title;
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );

        return view('master.poptype.edit', ['dataCoursegroup' => $getResult, 'title' => $title, 'icon' => $icon, 'sub_title' => $sub_title]);



    }


    public function destroy($id)
    {

        // dd('adfdfds');
        $logs['route_name'] = route('master.poptype.destroy', ['id' => $id]);
        $logs['submenu_name'] = 'ลบข้อมูลประเภทแบบประเมิน';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );


        foreach (OoapTblPopulationType::getDatas($id)->get() as $ka => $va) {

            OoapTblPopulationType::where('id','=', $id)->update([
                'in_active' => 1,
                'deleted_by' => auth()->user()->name,
                'deleted_at' => now()
            ]);

        }

        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
