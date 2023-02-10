<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasCourseOwnertype;
use Illuminate\Http\Request;

class OwnertypeController extends Controller
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
        $logs['route_name'] = 'master.ownertype.index';
        $logs['submenu_name'] = 'ข้อมูลแหล่งที่มาของหลักสูตร';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        return view('master.ownertype.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $logs['route_name'] = 'master.ownertype.create';
        $logs['submenu_name'] = 'เพิ่มข้อมูลแหล่งที่มาของหลักสูตร';
        $logs['log_type'] = 'add';

        createLogTrans( $logs );

        return view('master.ownertype.create');
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
        $logs['route_name'] = route('master.ownertype.edit', ['id' => $id]);
        $logs['submenu_name'] = 'แก้ไขข้อมูลแหล่งที่มาของหลักสูตร';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );

        $getResult = OoapMasCourseOwnertype::find($id);
        return view('master.ownertype.edit', ['dataOwnertype' => $getResult]);
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
        $logs['route_name'] = route('master.ownertype.destroy', ['id' => $id]);
        $logs['submenu_name'] = 'ลบข้อมูลแหล่งที่มาของหลักสูตร';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );
        $checkResult = OoapMasCourseOwnertype::find($id);
        ($checkResult->in_active == 1) ? $in_active = 0 : $in_active = 1;
        // dd($in_active);
        OoapMasCourseOwnertype::where('id','=', $id)->update([
            'in_active' => $in_active,
            'deleted_by' => auth()->user()->name,
            'deleted_at' => now()
        ]);
        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
