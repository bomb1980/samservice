<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapLogTransModel extends Model
{
    use HasFactory;


    protected $table = 'ooap_log_trans_models';

    protected $primaryKey = 'id';

    protected $fillable = [
        'log_type', 'log_name', 'log_date', 'submenu_id', 'data_array', 'ip', 'username', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at', 'full_name', 'route_name'
    ];

    static function getDatas()
    {

        return self::select('*');
    }

    static function getLastLog($datas = [])
    {
        return self::select('*')->where([['route_name', '=', $datas['route_name']], ['username', '=', auth()->user()->emp_citizen_id]])->take(1)->orderby('created_at', 'desc');
    }
}
