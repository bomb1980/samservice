<?php

namespace App\View\Components;

use App\Models\OoapMasRolePer;
use App\Models\OoapMasSubmenu;
use App\Models\OoapMasUserPer;
use Illuminate\View\Component;
use Illuminate\Http\Request;


class MenuComponent extends Component
{

    function __construct($activePage = NULL, Request $request)
    {
        $this->params['menu'] = $this->show_menu($activePage, $request->route()->getName());
    }

    public function render()
    {

        return view('components.menu-component', $this->params);
    }


    function show_menu($activePage = NULL, $routeName = NULL)
    {

        $allow_menus = [];
        if (auth()->user()->role_id != 1) {

            $allow_menus = OoapMasUserPer::getPermission(auth()->user()->emp_id)->pluck('submenu_id')->toArray();

            if (empty($allow_menus)) {

                $allow_menus = OoapMasRolePer::getPermission(auth()->user()->role_id)->pluck('submenu_id')->toArray();
            }
        }

        $menus = [];
        foreach (OoapMasSubmenu::getDatas($allow_menus, NULL, $show_on_menu = 1) as $ks => $vs) {

            if ($routeName == $vs->route_name) {
                $activeByRoute = 1;
            }

            $menus[$vs->menu_id][] = $vs;
        }

        $lis = [];
        foreach ($menus as $km => $vm) {

            $menu = $vm[0];

            $active = '';

            $sub_lis = [];

            foreach ($vm as $ks => $vs) {

                if ($routeName == $vs->route_name) {
                    $active = 'active';
                }

                if ($vs->error == 1) {
                    $sub_lis[] = '
                        <li class="site-menu-item">
                            <a class="animsition-link" href="#">
                                <span style="color: red;" class="site-menu-title">' . $vs->submenu_name . '</span>
                            </a>
                        </li>
                    ';
                } else if ($vs->route_name == 'activity.plan_adjust.index') {
                    $sub_lis[] = '
                        <li class="site-menu-item">
                            <a class="animsition-link" href="#">
                                <span class="site-menu-title">' . $vs->submenu_name . '</span>
                            </a>
                        </li>
                    ';
                } else {


                    $sub_lis[] = '
                        <li class="site-menu-item">
                            <a class="animsition-link" href="' . route($vs->route_name) . '">
                                <span class="site-menu-title">' . $vs->submenu_name . '</span>
                            </a>
                        </li>
                    ';
                }
            }


            if (empty($activeByRoute)) {

                if ($activePage == $menu->activepage_name) {
                    $active = 'active';
                }
            }

            $lis[] = '
                <li class="dropdown site-menu-item has-sub  ' . $active . '">
                    <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                        <i class="site-menu-icon site-menu-icon wb-layout" aria-hidden="true"></i>
                        <span class="site-menu-title">' . $menu->menu_name . '</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="site-menu-scroll-wrap">
                            <ul class="site-menu-sub">
                                ' . implode('', $sub_lis) . '
                            </ul>
                        </div>
                    </div>
                </li>
            ';
        }

        unset($menus);

        return  implode('', $lis);
    }
}
