<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//ooap_mas_ocuupations_model
class OoapMasOcuupation extends Model
{
    use HasFactory;

    protected $table = 'ooap_mas_ocuupations';

    protected $primaryKey = 'id';

    protected $fillable = [

        'name', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    static function getDatas($id = NULL)
    {
        $data = self::selectraw( "ooap_mas_ocuupations.*" )->where('in_active', '=', false);

        if (!empty($id)) {
            $data = $data->where('id', $id);
        }

        return $data->orderBy('name', 'asc');

    }


}
