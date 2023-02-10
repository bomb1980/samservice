<?php

namespace App\Http\Middleware;

use App\Models\OoapLogTransModel;
use App\Models\OoapMasRolePer;
use App\Models\OoapMasSubmenu;
use App\Models\OoapMasUserPer;
use Closure;
use Illuminate\Http\Request;


class User
{

    public function handle(Request $request, Closure $next)
    {
        if ($this->checkCanAccessRoute($request->route()->getName())) {

            return $next($request);
        };

        abort(code: 404);

    }

    function checkCanAccessRoute($routeName = NULL)
    {


        if ( auth()->user()->role_id == 1 ) {

            foreach (OoapMasSubmenu::getDatas([], $routeName, NULL)->toArray() as $ks => $data) {

                createLogTrans( $data );
            }

        }
        else {

            $allow_menus = OoapMasUserPer::getPermission(auth()->user()->emp_id)->pluck('submenu_id')->toArray();

            if (empty($allow_menus)) {

                $allow_menus = OoapMasRolePer::getPermission(auth()->user()->role_id)->pluck('submenu_id')->toArray();
            }

            foreach (OoapMasSubmenu::getDatas([], $routeName, NULL)->toArray() as $ks => $data) {

                // abort(code: 404);
                if (in_array($data['submenu_id'], $allow_menus)) {

                    createLogTrans( $data );

                    return true;
                }

                return false;
            }

        }

        return true;
    }
}


