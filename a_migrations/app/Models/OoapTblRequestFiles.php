<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapTblRequestFiles extends Model
{
    protected $table = 'ooap_tbl_request_files';

    protected $primaryKey = 'files_id';

    protected $fillable = [
        'files_ori',
        'files_gen',
        'files_path',
        'files_type',
        'files_size',
        'req_id',

        'status',
        'in_active',
        'remember_token',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
