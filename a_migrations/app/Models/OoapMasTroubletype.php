<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasTroubletype extends Model
{

    protected $table = 'ooap_mas_troubletype';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'shotname', 'status', 'inactive', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'upadated_at', 'deleted_at'
    ];

    protected $dates = [
        'created_at', 'upadated_at', 'deleted_at'
    ];
}
