<?php

namespace App\Http\Controllers;

use App\Models\dasdfsdsadf;
use App\Http\Requests\StoredasdfsdsadfRequest;
use App\Http\Requests\UpdatedasdfsdsadfRequest;
use App\Models\per_org;

class DasdfsdsadfController extends Controller
{

    function createSeedText($modelName = null)
    {
        $skip = ['remember_token',];

        $load = 'App\\Models\\' . $modelName . '';

        $model = new $load();

        // foreach ($model->get()->skip(0)->take(10) as $km => $vm) {
        foreach ($model->get() as $km => $vm) {
            $keep = [];
            foreach ($model->getFillable() as $kf => $name) {
                if (in_array($name, $skip)) {
                    continue;
                }

                if (empty($vm->$name)) {
                    //continue;
                    $keep[] = '"' . $name . '" => NULL';
                } else {
                    $keep[] = '"' . $name . '" => "' . addslashes($vm->$name) . '"';
                }
            }

            echo '[' . implode(', ', $keep) . '],<br>';
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        foreach(per_org::get() as $ka => $va ){

            dd($va);
        }

        echo 'dsaafdds';

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
     * @param  \App\Http\Requests\StoredasdfsdsadfRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoredasdfsdsadfRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\dasdfsdsadf  $dasdfsdsadf
     * @return \Illuminate\Http\Response
     */
    public function show(dasdfsdsadf $dasdfsdsadf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dasdfsdsadf  $dasdfsdsadf
     * @return \Illuminate\Http\Response
     */
    public function edit(dasdfsdsadf $dasdfsdsadf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatedasdfsdsadfRequest  $request
     * @param  \App\Models\dasdfsdsadf  $dasdfsdsadf
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatedasdfsdsadfRequest $request, dasdfsdsadf $dasdfsdsadf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dasdfsdsadf  $dasdfsdsadf
     * @return \Illuminate\Http\Response
     */
    public function destroy(dasdfsdsadf $dasdfsdsadf)
    {
        //
    }
}
