<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{

    protected $table = 'role_user';

    protected $primaryKey = 'id';

    protected $fillable = [
        'role_id', 'user_id', 'created_at', 'updated_at', 'role_id', 'user_id', 'created_at', 'updated_at'
    ];
}
