<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OoapMasCoursefiles;

class FileController extends Controller
{
    public function view($files_gen)
    {
        $file = OoapMasCoursefiles::where('files_gen','=', $files_gen)->first();
        $file_path = $file->files_path;
        $file_ori = $file->files_or;
        $file_type = $file->files_type;
        $file_size = $file->files_size;

        return response()->file(storage_path('app\public').$file_path.'/'.$files_gen, [
            'Content-Type' => $file_type,
            'Content-Disposition' => 'inline; filename="' . $file_ori . '"',
            'Content-Length' => $file_size,
            'Content-Transfer-Encoding' => 'binary',
            'Expires' => '0',
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public',
        ]);
    }
}
