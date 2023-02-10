<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasActtype extends Model
{
    protected $table = 'ooap_mas_acttype';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'shortname',
        'job_wage_maxrate',
        'couse_lunch_maxrate',
        'couse_trainer_maxrate',
        'couse_material_maxrate',
        'other_maxrate',
        'status',
        'inactive',
        'remember_token',
        'create_by',
        'update_by',
        'delete_by',
        'create_date',
        'upadate_date',
        'delete_date',
    ];

    protected $hidden = [];

    protected $dates = [
        'create_date',
        'upadate_date',
        'delete_date',
        'create_date',
        'upadate_date',
        'delete_date',
    ];

    static function getDatas( $id = NULL ) {

        $data = self::select('*')->where('inactive', false);

        if( !empty( $id ) ) {
            $data = $data->where('ooap_mas_acttype.id', $id );

        }
        return $data;
    }
}
