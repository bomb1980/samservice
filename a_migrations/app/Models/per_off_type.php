<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class per_off_type extends Model
{

    protected $table = 'per_off_type';

    protected $primaryKey = 'id';

    protected $fillable = [

        'ot_code', 'ot_name', 'ot_active', 'update_user', 'update_date', 'ot_seq_no', 'ot_othername'
    ];
}
