<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapTblFybdperiod extends Model
{
    protected $table = 'ooap_tbl_fybdperiod';

    protected $primaryKey = 'id';

    protected $fillable = [
        'fiscalyear_code', 'period_no', 'startdate', 'enddate', 'period_month', 'period_rate', 'period_amt', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $dates = [
        'startdate', 'enddate', 'created_at', 'updated_at', 'deleted_at'
    ];

    public $timestamps = true;
}
