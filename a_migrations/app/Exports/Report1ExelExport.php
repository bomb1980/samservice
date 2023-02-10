<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Report1ExelExport implements FromView
{
    function __construct($datas = NULL, $config = NULL )
    {
        $this->params['config'] = $config;
        $this->params['datas'] = $datas;
    }

    public function view(): View
    {
        return view('activity.act_detail.excel', $this->params);
    }

}
