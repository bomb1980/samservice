<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasActivityType extends Model
{
    protected $table = 'ooap_mas_activity_types';

    protected $primaryKey = 'activity_types_id';

    protected $fillable = [
        'activity_types_name',
        'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'deleted_at', 'created_at', 'updated_at'
    ];
}
