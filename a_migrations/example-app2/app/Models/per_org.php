<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class per_org extends Model
{
    use HasFactory;

    protected $table = 'per_org_ass';

    protected $primaryKey = 'id';

    protected $fillable = [

        'org_id', 'org_code', 'org_name', 'org_short', 'ol_code', 'ot_code', 'org_addr1', 'org_addr2', 'org_addr3', 'ap_code', 'pv_code', 'ct_code', 'org_date', 'org_job', 'org_id_ref', 'org_active', 'update_user', 'update_date', 'org_website', 'org_seq_no', 'department_id', 'org_eng_name', 'pos_lat', 'pos_long', 'org_dopa_code', 'dt_code', 'mg_code', 'pg_code', 'org_zone', 'org_id_ass'
    ];
}
