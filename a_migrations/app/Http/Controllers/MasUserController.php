<?php

namespace App\Http\Controllers;

use App\Models\mas_user;
use App\Http\Requests\Storemas_userRequest;
use App\Http\Requests\Updatemas_userRequest;

class MasUserController extends Controller
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
     * @param  \App\Http\Requests\Storemas_userRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storemas_userRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mas_user  $mas_user
     * @return \Illuminate\Http\Response
     */
    public function show(mas_user $mas_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mas_user  $mas_user
     * @return \Illuminate\Http\Response
     */
    public function edit(mas_user $mas_user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatemas_userRequest  $request
     * @param  \App\Models\mas_user  $mas_user
     * @return \Illuminate\Http\Response
     */
    public function update(Updatemas_userRequest $request, mas_user $mas_user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mas_user  $mas_user
     * @return \Illuminate\Http\Response
     */
    public function destroy(mas_user $mas_user)
    {
        //
    }
}
