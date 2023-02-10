<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasGeopraphyTh extends Model
{

    protected $table = 'ooap_mas_geopraphy_th';

    protected $primaryKey = 'geo_id';

    protected $fillable = [
        'geo_name', 'status', 'remember_token', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'
    ];
}
