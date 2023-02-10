<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasTroubletype;
use Illuminate\Http\Request;

class TroubletypeController extends Controller
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
        $logs['route_name'] = 'master.troubletype.index';
        $logs['submenu_name'] = 'ข้อมูลประเภทความเดือดร้อน';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        return view('master.troubletype.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $logs['route_name'] = 'master.troubletype.create';
        $logs['submenu_name'] = 'เพิ่มข้อมูลประเภทความเดือดร้อน';
        $logs['log_type'] = 'add';

        createLogTrans( $logs );

        return view('master.troubletype.create');
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
        $logs['route_name'] = route('master.troubletype.edit', ['id' => $id]);
        $logs['submenu_name'] = 'แก้ไขข้อมูลประเภทความเดือดร้อน';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );

        $getResult = OoapMasTroubletype::find($id);
        return view('master.troubletype.edit', ['dataTroubletype' => $getResult]);
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
        $logs['route_name'] = route('master.troubletype.destroy', ['id' => $id]);
        $logs['submenu_name'] = 'ลบข้อมูลประเภทความเดือดร้อน';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );
        $checkResult = OoapMasTroubletype::find($id);
        ($checkResult->inactive == 1) ? $inactive = 0 : $inactive = 1;
        // dd($in_active);
        OoapMasTroubletype::where('id','=', $id)->update([
            'inactive' => $inactive,
            'deleted_by' => auth()->user()->name,
            'deleted_at' => now()
        ]);
        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
