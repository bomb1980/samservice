<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RequestedExelExport implements FromView
{
    function __construct($datas = NULL, $config = NULL )
    {
        $this->params['config'] = $config;
        $this->params['datas'] = $datas;
    }

    public function view(): View
    {
        return view('request.projects.exel', $this->params);
    }

}
