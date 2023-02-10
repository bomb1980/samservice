<?php

namespace App\Http\Controllers;

use App\Models\per_prename;
use App\Http\Requests\Storeper_prenameRequest;
use App\Http\Requests\Updateper_prenameRequest;

class PerPrenameController extends Controller
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
     * @param  \App\Http\Requests\Storeper_prenameRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeper_prenameRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\per_prename  $per_prename
     * @return \Illuminate\Http\Response
     */
    public function show(per_prename $per_prename)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\per_prename  $per_prename
     * @return \Illuminate\Http\Response
     */
    public function edit(per_prename $per_prename)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateper_prenameRequest  $request
     * @param  \App\Models\per_prename  $per_prename
     * @return \Illuminate\Http\Response
     */
    public function update(Updateper_prenameRequest $request, per_prename $per_prename)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\per_prename  $per_prename
     * @return \Illuminate\Http\Response
     */
    public function destroy(per_prename $per_prename)
    {
        //
    }
}
