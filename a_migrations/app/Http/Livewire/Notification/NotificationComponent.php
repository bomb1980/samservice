<?php

namespace App\Http\Livewire\Notification;

use App\Models\OoapTblNotification;
use Livewire\Component;

class NotificationComponent extends Component
{

    public $EmpRoleName;

    public $noti_list, $noti_count, $noti_count_all;
    public $noti_id;


    public function mount()
    {

        $this->setUp();
    }


    public function render()
    {

        return view('livewire.notification.notification-component');
    }


    public function deleteNoti($noti_id)
    {
        $notification = OoapTblNotification::where('id', $noti_id)->first();

        $notification->update([
            'in_active' =>  1
        ]);
        $this->setUp();
        $this->emit('noti_emits');
    }

    public function awareNoti($noti_id)
    {
        date_default_timezone_set('Asia/Bangkok');

        $notification = OoapTblNotification::where('id', $noti_id)->first();

        if($notification->status == 0) {
            $notification->update([
                'status' =>  1,
                'updated_at' =>  now()
            ]);
        }

        return redirect($notification->noti_link);
    }

    public function setUp(){
        if(auth()->user()->roles->role_name=='ROLE_User'){

            $noti_list = OoapTblNotification::whereIn('noti_to',  [auth()->user()->emp_citizen_id, 'all']);

            // $this->EmpRoleName = 'user';
            // query role user

        }else{
            // query role admin, superadmin
            // $this->EmpRoleName = 'admin, super admin';

            $noti_list = OoapTblNotification::whereIn('noti_to', [auth()->user()->emp_citizen_id, 'all']);
        }

        $this->noti_list = $noti_list->where('in_active', 0)->orderby('id', 'desc')->get();

        // $this->noti_list = [];
        // $this->noti_count_all = 0;
        // $this->noti_count = 0;

        // $this->noti_list = $noti_select->where('in_active', 0)->get();
        $this->noti_count_all = $noti_list->where('in_active', 0)->count();
        $this->noti_count = $noti_list->where('status', 0)->count();
    }
}
