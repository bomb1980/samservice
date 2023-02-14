<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PER_LEVEL extends Model
{
    use HasFactory;

    protected $table = 'per_level';

    protected $primaryKey = 'id';

    protected $fillable = [
        'level_active', 'update_user', 'level_name', 'per_type', 'level_shortname', 'level_seq_no', 'position_type', 'position_level', 'level_othername', 'level_engname', 'level_no', 'update_date'
    ];
}
