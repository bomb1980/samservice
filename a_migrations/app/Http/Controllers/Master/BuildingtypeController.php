<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasBuildingtype;
use Illuminate\Http\Request;

class BuildingtypeController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs['route_name'] = 'master.buildingtype.index';
        $logs['submenu_name'] = 'ข้อมูลประเภทสถานที่';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        return view('master.buildingtype.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $logs['route_name'] = 'master.buildingtype.create';
        $logs['submenu_name'] = 'เพิ่มข้อมูลประเภทสถานที่';
        $logs['log_type'] = 'add';

        createLogTrans( $logs );

        return view('master.buildingtype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $logs['route_name'] = route('master.buildingtype.edit', ['id' => $id]);
        $logs['submenu_name'] = 'แก้ไขข้อมูลประเภทสถานที่';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );

        $getResult = OoapMasBuildingtype::find($id);
        return view('master.buildingtype.edit', ['dataBuildingtype' => $getResult]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $logs['route_name'] = route('master.buildingtype.destroy', ['id' => $id]);
        $logs['submenu_name'] = 'ลบข้อมูลสถานที่ดำเนินการ';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );
        $checkResult = OoapMasBuildingtype::find($id);
        ($checkResult->in_active == 1) ? $in_active = 0 : $in_active = 1;
        // dd($in_active);
        OoapMasBuildingtype::where('buildingtype_id','=', $id)->update([
            'in_active' => $in_active,
            'deleted_by' => auth()->user()->name,
            'deleted_at' => now()
        ]);
        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
