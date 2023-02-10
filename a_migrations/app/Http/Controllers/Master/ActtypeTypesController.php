<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasActtype;
use App\Models\OoapTblPopulationType;

class ActtypeTypesController extends Controller
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

        $this->params['title'] = 'ประเภทกิจกรรม';
        $this->params['api'] = 'api.master.acttype';


        return view('poptype', $this->params );

    }


    public function create()
    {

        $icon = getIcon('add');
        $getResult = NULL;
        $title = 'เพิ่มข้อมูลประเภทกิจกรรม';

        $logs['route_name'] = route('master.coursegroup.create');



        $icon = getIcon('add');

        // $getResult = OoapMasActtype::find($va->id);

        $sub_title = '';


        $logs['submenu_name'] =  $title;
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );

        return view('master.acttype.edit', ['dataCoursegroup' => $getResult, 'title' => $title, 'icon' => $icon, 'sub_title' => $sub_title]);


    }


    public function edit($id)
    {


        $icon = getIcon('add');
        $getResult = NULL;
        $title = 'เพิ่มข้อมูลประเภทกิจกรรม';

        $logs['route_name'] = route('master.coursegroup.create');



        $icon = getIcon('add');

        $sub_title = '';

        foreach (OoapMasActtype::getDatas($id)->get() as $ka => $va) {
            $title = 'แก้ไขข้อมูลประเภทกิจกรรม';
            $icon = getIcon('edit');

            $getResult = OoapMasActtype::find($va->id);

            $sub_title = $getResult->name;
            $logs['route_name'] = route('master.coursegroup.edit', ['id' => $id]);
        }
        $logs['submenu_name'] =  $title;
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );

        return view('master.acttype.edit', ['dataCoursegroup' => $getResult, 'title' => $title, 'icon' => $icon, 'sub_title' => $sub_title]);

    }


    public function destroy($id)
    {

        $logs['route_name'] = route('master.poptype.destroy', ['id' => $id]);
        $logs['submenu_name'] = 'ลบข้อมูลประเภทกิจกรรม';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );


        foreach (OoapTblPopulationType::getDatas($id)->get() as $ka => $va) {

            OoapTblPopulationType::where('id','=', $id)->update([
                'inactive' => 1,
                'deleted_by' => auth()->user()->name,
                'deleted_at' => now()
            ]);

        }

        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
