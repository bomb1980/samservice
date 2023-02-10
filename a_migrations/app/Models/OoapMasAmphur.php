<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasAmphur extends Model
{
    protected $table = 'ooap_mas_amphur';

    protected $primaryKey = 'amphur_id';

    protected $fillable = [
        'amphur_id', 'province', 'amphur_code', 'amphur_name', 'geo_id', 'province_id', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];
}
