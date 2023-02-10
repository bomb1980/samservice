<?php

namespace App\View\Components;

use App\Models\OoapTblNotification;
use Illuminate\View\Component;

class NavbarsComponent extends Component
{

    public function render()
    {


        $this->params['badge'] = NULL;

        if( auth()->user()->new_noti > 0 ) {

            $this->params['badge'] = '<span class="noti-badg badge-danger">'. auth()->user()->new_noti .'</span>';
        }


        $this->params['datas'] = OoapTblNotification::getDatas( auth()->user()->emp_citizen_id )->take(5)->get();



        return view('components.navbars-component', $this->params);
    }
}
