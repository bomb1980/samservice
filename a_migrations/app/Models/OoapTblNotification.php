<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

//ooap_tbl_notifications_model
class OoapTblNotification extends Model
{
    use HasFactory;


    protected $table = 'ooap_tbl_notifications';

    protected $primaryKey = 'id';


    protected $fillable = [
        'sender', 'created_by', 'noti_to', 'noti_name', 'noti_icon', 'noti_detail', 'noti_date', 'noti_link', 'status', 'in_active', 'remember_token', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];


    static function getDatas($emp_citizen_id = NULL)
    {
        //
        return self::select('*')
            ->where('noti_to', 'LIKE', '%' . $emp_citizen_id . '%')
            ->orwhere('noti_to', 'LIKE', '%all%')
            ->orderby('noti_date', 'desc');
    }

    static function create_($datas = [])
    {
        $datas['noti_link'] = !empty($datas['noti_link']) ? $datas['noti_link'] : NULL;
        $datas['noti_icon'] = !empty($datas['noti_icon']) ? $datas['noti_icon'] : NULL;

        if (empty($datas['noti_to']) || in_array('all',  $datas['noti_to'])) {

            $datas['noti_to'] = ['all'];

            $sql = "UPDATE ooap_tbl_employees SET new_noti = ( new_noti + 1 )";
        } else {

            $sql = "UPDATE ooap_tbl_employees SET new_noti = ( new_noti + 1 ) WHERE emp_citizen_id IN ( '" . implode("', '", $datas['noti_to']) . "' )";
        }

        DB::update($sql);

        self::create([
            'sender' =>  auth()->user()->fname_th . ' ' . auth()->user()->lname_th,
            'noti_to' => implode(',',  $datas['noti_to']),
            'noti_name' => $datas['noti_name'],
            'noti_detail' => $datas['noti_detail'],
            'noti_link' =>  $datas['noti_link'],
            'noti_icon' => $datas['noti_icon'],
            'noti_date' =>  now(),
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now(),
            'status'=> false
        ]);
    }
}
