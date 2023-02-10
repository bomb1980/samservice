<?php

namespace App\Http\Controllers;

use App\Models\aaa_test;
use App\Http\Requests\Storeaaa_testRequest;
use App\Http\Requests\Updateaaa_testRequest;

class AaaTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storeaaa_testRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeaaa_testRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\aaa_test  $aaa_test
     * @return \Illuminate\Http\Response
     */
    public function show(aaa_test $aaa_test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\aaa_test  $aaa_test
     * @return \Illuminate\Http\Response
     */
    public function edit(aaa_test $aaa_test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateaaa_testRequest  $request
     * @param  \App\Models\aaa_test  $aaa_test
     * @return \Illuminate\Http\Response
     */
    public function update(Updateaaa_testRequest $request, aaa_test $aaa_test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\aaa_test  $aaa_test
     * @return \Illuminate\Http\Response
     */
    public function destroy(aaa_test $aaa_test)
    {
        //
    }
}
