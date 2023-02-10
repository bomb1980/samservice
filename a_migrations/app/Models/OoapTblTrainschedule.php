<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapTblTrainschedule extends Model
{
    use HasFactory;
    protected $table = 'ooap_tbl_trainschedules';

    protected $primarykey = 'train_id';

    protected $fillable = [

        'act_number',  'pop_id', 'startdate', 'starttime', 'enddate', 'endtime', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];
}
