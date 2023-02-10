<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasCourseOwnertype extends Model
{
    protected $table = 'ooap_mas_course_ownertype';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'shortname', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];
}
