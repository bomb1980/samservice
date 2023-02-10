<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasPopulatioType extends Model
{
    protected $table = 'ooap_mas_populatio_types';

    protected $primaryKey = 'population_types_id';

    protected $fillable = [
        'population_types_name',
        'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'deleted_at', 'created_at', 'updated_at'
    ];
}
