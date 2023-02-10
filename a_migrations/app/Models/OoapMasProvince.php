<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasProvince extends Model
{

    protected $table = 'ooap_mas_province';

    protected $primaryKey = 'province_id';

    protected $fillable = [
        'province_code', 'province_name', 'geo_id', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'deleted_at', 'created_at', 'updated_at'
    ];
}
