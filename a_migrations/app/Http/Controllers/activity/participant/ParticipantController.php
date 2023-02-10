<?php

namespace App\Http\Controllers\activity\participant;

use App\Http\Controllers\Controller;

class ParticipantController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    public function index()
    {
        return view('activity.participant.index');
    }

    public function create($reqform_id)
    {
        return view('activity.participant.create', ['reqform_id' => $reqform_id]);
    }
}
