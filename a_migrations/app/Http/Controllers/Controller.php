<?php

namespace App\Http\Controllers;

use App\Models\OoapMasSubmenu;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function __construct(Request  $request)
    {
        if (!empty($request->route()->getName()))
            $this->OoapMasSubmenu = OoapMasSubmenu::getData($request->route()->getName())->first();

    }
}
