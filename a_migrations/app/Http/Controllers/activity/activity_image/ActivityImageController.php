<?php

namespace App\Http\Controllers\activity\activity_image;

use App\Http\Controllers\Controller;

class ActivityImageController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }
    public function index()
    {
        return view('activity.activity_image.index');
    }

    public function create()
    {
        return view('activity.activity_image.create');
    }

    public function images()
    {
        return view('activity.activity_image.images_add');
    }
}
