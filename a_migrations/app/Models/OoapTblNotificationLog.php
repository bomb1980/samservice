<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OoapTblNotificationLog extends Model
{

    use HasFactory;


    protected $table = 'ooap_tbl_notification_logs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'parent_id', 'receive_nationalid', 'receive_date', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    static function create_($datas = [])
    {

        // foreach (self::select('*')->where([['route_name', '=', $datas['route_name']],  ['username', '=', auth()->user()->emp_citizen_id]])->take(1)->orderby('created_at', 'desc')->get() as $ka => $va) {

        //     return false;
        // }

        // $datas['log_type'] = isset($datas['log_type']) ? $datas['log_type'] : 'view';
        // $datas['route_name'] = !empty($datas['route_name']) ? $datas['route_name'] : NULL;
        self::create([
            'parent_id' => $datas['parent_id'],
            'receive_nationalid' => $datas['receive_nationalid'],
            'receive_date' =>  now(),
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now(),
        ]);
    }


}
