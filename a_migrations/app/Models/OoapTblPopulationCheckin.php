<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapTblPopulationCheckin extends Model
{
    use HasFactory;
    protected $table = 'ooap_tbl_population_checkins';

    protected $primarykey = 'check_id';

    protected $fillable = [
        'pop_id',
        'check_date',
        'check_status',
        'check_instead',
        'act_number',
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
