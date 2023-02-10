<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapTblPopulationType extends Model
{
    use HasFactory;

    protected $table = 'ooap_tbl_population_types';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];



    static function getDatas( $id = NULL ) {

        $data = self::select('*')->where('in_active', false);

        if( !empty( $id ) ) {
            $data = $data->where('ooap_tbl_population_types.id', $id );

        }

        // $data = $data->orderBy('ooap_mas_coursegroup.id','asc');

        return $data;
    }
}

