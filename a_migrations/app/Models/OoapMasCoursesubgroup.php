<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasCoursesubgroup extends Model
{

    protected $table = 'ooap_mas_coursesubgroup';

    protected $primaryKey = 'id';

    protected $fillable = [
        'code', 'name', 'shortname', 'acttype_id', 'coursegroup_id', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    static function getDatas( $id = NULL ) {

        $data = OoapMasCoursesubgroup::select('ooap_mas_coursesubgroup.id','ooap_mas_coursesubgroup.acttype_id','ooap_mas_acttype.name as acttype_name',
        'ooap_mas_coursesubgroup.code','ooap_mas_coursesubgroup.name','ooap_mas_coursesubgroup.shortname','ooap_mas_coursegroup.name as coursegroup_name')
            ->leftjoin('ooap_mas_acttype','ooap_mas_coursesubgroup.acttype_id','ooap_mas_acttype.id')
            ->leftjoin('ooap_mas_coursegroup','ooap_mas_coursegroup.id','ooap_mas_coursesubgroup.coursegroup_id')
            ->where('ooap_mas_coursesubgroup.in_active','=', false);


        if( !empty( $id ) ) {
            $data = $data->where('ooap_mas_coursesubgroup.id', $id );

        }

        $data = $data->orderBy('ooap_mas_coursesubgroup.id','asc');

        return $data;
    }




}
