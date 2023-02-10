<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasCmleader extends Model
{

    protected $table = 'ooap_mas_cmleader';

    protected $primaryKey = 'id';

    protected $fillable = [
        'cmleader_prefix', 'cmleader_name', 'cmleader_surname', 'cmleaderjob_id', 'moo', 'province_id', 'amphur_id', 'tambon_id', 'cmleader_birthdate', 'cmleader_tel', 'cmleader_fax', 'cmleader_mobile', 'cmleader_email', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];
}
