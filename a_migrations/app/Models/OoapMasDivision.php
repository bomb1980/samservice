<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//ooap_mas_divisions_model
class OoapMasDivision extends Model
{
    use HasFactory;

    protected $table = 'ooap_mas_divisions';

    protected $primaryKey = 'division_id ';

    protected $fillable = [
          'division_initial', 'division_name', 'division_address', 'division_phone', 'division_fax', 'division_email', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at', 'province_id'
    ];

    static function getDatas( $division_id = NULL )
    {

        $data = self::selectraw( "ooap_mas_divisions.*" )
        ->where('ooap_mas_divisions.in_active', '=', false);

        if( !empty( $division_id ) ) {

            $data = $data->where('ooap_mas_divisions.division_id', '=', $division_id);

        }

        return $data->orderBy('ooap_mas_divisions.division_name','asc');
    }

}
