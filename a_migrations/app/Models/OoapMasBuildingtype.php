<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapMasBuildingtype extends Model
{
    protected $table = 'ooap_mas_buildingtypes';

    protected $primaryKey = 'buildingtype_id';

    protected $fillable = [
        'name', 'shortname', 'acttype_id', 'status',
        'in_active', 'remember_token', 'created_by', 'updated_by',
        'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $hidden = [];

    protected $casts = [
        'buildingtype_id' => 'int',
        'name' => 'string',
        'shortname' => 'string',
        'acttype_id' => 'int',
        'status' => 'boolean',
        'created_by' => 'string',
        'created_date' => 'datetime',
        'updated_by' => 'string',
        'updated_date' => 'datetime'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public $timestamps = true;
}
