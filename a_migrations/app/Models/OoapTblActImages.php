<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//ooap_tbl_act_images_model
class OoapTblActImages extends Model
{
    protected $table = 'ooap_tbl_act_images';

    protected $primaryKey = 'image_id';

    protected $fillable = [
        'act_id', 'image_group', 'image_file_type', 'image_oriname', 'image_name', 'image_path', 'image_file_size', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];


    static function getDatas( $act_id = NULL ) {

        return self::select( '*')
        ->where('act_id', '=',  $act_id )
        ->orderby('image_group')->get();

    }

}
