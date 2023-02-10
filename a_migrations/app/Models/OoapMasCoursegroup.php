<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasCoursegroup extends Model
{

    protected $table = 'ooap_mas_coursegroup';

    protected $primaryKey = 'id';

    protected $fillable = [
        'code', 'name', 'shortname', 'acttype_id', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    static function getDatas( $id = NULL ) {

        $data = OoapMasCoursegroup::select('ooap_mas_coursegroup.id','ooap_mas_coursegroup.acttype_id','ooap_mas_acttype.name as acttype_name',
        'ooap_mas_coursegroup.code','ooap_mas_coursegroup.name as name','ooap_mas_coursegroup.shortname')
            ->leftjoin('ooap_mas_acttype','ooap_mas_acttype.id','ooap_mas_coursegroup.acttype_id')
            ->where('ooap_mas_coursegroup.in_active','=', false);

        if( !empty( $id ) ) {
            $data = $data->where('ooap_mas_coursegroup.id', $id );

        }

        $data = $data->orderBy('ooap_mas_coursegroup.id','asc');

        return $data;
    }


}
