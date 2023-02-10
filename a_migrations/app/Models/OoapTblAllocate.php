<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapTblAllocate extends Model
{
    protected $table = 'ooap_tbl_allocate';

    protected $primaryKey = 'id';

    protected $fillable = [

        'budgetyear', 'periodno', 'division_id', 'division_name', 'count_urgent', 'sum_urgent', 'count_training', 'sum_training', 'allocate_urgent', 'allocate_training', 'allocate_manage', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];
}
