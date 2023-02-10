<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasCourse extends Model
{

    protected $table = 'ooap_mas_course';

    protected $primaryKey = 'id';

    protected $fillable = [
        'code', 'name', 'shortname', 'descp', 'dept_id', 'ownertype_id', 'ownerdescp', 'acttype_id', 'coursegroup_id', 'coursesubgroup_id', 'coursetype_id', 'hour_descp', 'day_descp', 'people_descp', 'trainer_descp', 'province_id', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    static function getDatas( $id = NULL ) {

        $data = OoapMasCourse::select(
            'ooap_mas_course.id',
            'ooap_mas_course.acttype_id',
            'ooap_mas_acttype.name as acttype_name',
            'ooap_mas_course_ownertype.name as ownertype_name',
            'ooap_mas_course.code',
            'ooap_mas_course.name',
            'ooap_mas_course.shortname',
            'ooap_mas_course.descp',
            'ooap_mas_coursegroup.name as coursegroup_name',
            'ooap_mas_coursetype.name as coursetype_name',
            'ooap_mas_coursesubgroup.name as coursesubgroup_name',
            'ooap_mas_course.hour_descp',
            'ooap_mas_course.day_descp',
            'ooap_mas_course.people_descp',
            'ooap_mas_course.province_id'
        )
            ->leftjoin('ooap_mas_course_ownertype', 'ooap_mas_course_ownertype.id', 'ooap_mas_course.ownertype_id')
            ->leftjoin('ooap_mas_acttype', 'ooap_mas_acttype.id', 'ooap_mas_course.acttype_id')
            ->leftjoin('ooap_mas_coursegroup', 'ooap_mas_coursegroup.id', 'ooap_mas_course.coursegroup_id')
            ->leftjoin('ooap_mas_coursesubgroup', 'ooap_mas_coursesubgroup.id', 'ooap_mas_course.coursesubgroup_id')
            ->leftjoin('ooap_mas_coursetype', 'ooap_mas_coursetype.id', 'ooap_mas_course.coursetype_id')
            ->where('ooap_mas_course.in_active', '=', false);


        if( !empty( $id ) ) {
            $data = $data->where('ooap_mas_course.id', $id );

        }


        return $data->orderBy('ooap_mas_course.code','asc');
    }
}
