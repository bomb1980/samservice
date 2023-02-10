<?php

namespace App\Http\Controllers\report\pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class dashboardPdfController extends Controller
{
    public function pdf()
    {
        $pdf = PDF::loadView('exports.report.dashboard1-pdf', [
            // 'items' => $data,
            // 'year' => $year,
            // 'division_name' => $division_name
        ], [], [
            'title' => 'รายงานสรุปงบประมาณประจำปีที่ได้รับจัดสรร ประจำปี ',
            'default_font_size' => 9.5,
        ]);

        return $pdf->stream('รายงานสรุปงบประมาณประจำปีที่ได้รับจัดสรร ประจำปี.pdf');
    }
}
