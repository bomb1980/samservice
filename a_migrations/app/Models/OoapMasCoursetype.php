<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OoapMasCoursetype extends Model
{
    protected $table = 'ooap_mas_coursetype';

    protected $primaryKey = 'id';

    protected $fillable = [
        'code', 'name', 'shortname', 'coursegroup_id', 'coursesubgroup_id', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];


    static function getDatas($id = NULL)
    {
        $data = self::select(
            'ooap_mas_coursetype.id',
            'ooap_mas_coursetype.code',
            'ooap_mas_coursetype.name',
            'ooap_mas_coursetype.shortname',
            'ooap_mas_coursegroup.name as coursegroup_name',
            'ooap_mas_coursesubgroup.name as coursesubgroup_name'
        )
            ->leftjoin('ooap_mas_coursegroup', 'ooap_mas_coursetype.coursegroup_id', 'ooap_mas_coursegroup.id')
            ->leftjoin('ooap_mas_coursesubgroup', 'ooap_mas_coursesubgroup.id', 'ooap_mas_coursetype.coursesubgroup_id')
            ->where('ooap_mas_coursetype.in_active', '=', false);

        if (!empty($id)) {
            $data = $data->where('ooap_mas_coursetype.id', $id);
        }

        return $data->orderBy('ooap_mas_coursetype.id', 'asc');
    }
}
