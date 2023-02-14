<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class per_prename extends Model
{
    use HasFactory;





    protected $table = 'per_prename';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pn_code', 'pn_shortname', 'pn_name', 'pn_eng_name', 'pn_active', 'update_user', 'update_date', 'rank_flag', 'pn_seq_no', 'pn_othername'

    ];
}
