<?php

namespace App\Http\Livewire\Permission;

use App\Models\OoapMasDivision;
use App\Models\OoapMasMenu;
use App\Models\OoapMasRole;
use App\Models\OoapMasRolePer;
use App\Models\OoapMasSubmenu;
use App\Models\OoapMasUserPer;
use App\Models\OoapTblEmployee;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class PermissionEditComponent extends Component
{
    public $menulist, $Role, $selectYear, $dataRoleUser;
    public $view_data = [], $insert_data = [], $update_data = [], $delete_data = [];
    public $role_id, $selectall;
    public $change_checkbox;
    public $name_search, $employee_list, $employee_search;
    public $Data_new_user;
    public $user_id, $RolePerlist;

    protected $listeners = ['redirect-to' => 'redirect_to', 'redirect-to-edit' => 'redirect_to_edit', 'redirect-to-name_search' => 'name_search'];

    public function mount($dataRoleUser)
    {
        $this->name_search = $dataRoleUser->title_th . ' ' .  $dataRoleUser->fname_th . ' ' . $dataRoleUser->lname_th;
        $this->role_id = $dataRoleUser->role_id;
        $this->em_id = $dataRoleUser->emp_id;
        $this->custom_permission = empty($dataRoleUser->custom_permission) ? 0 : 1;
        $this->custom_permission();
    }


    public function render()
    {
        $this->Role = OoapMasRole::where('in_active', false)->orderBy('role_id', 'asc')->pluck('role_name_th', 'role_id');
        $this->menulist_f();
        return view('livewire.permission.permission-edit-component');
    }

    public function custom_permission()
    {
        $this->menulist_f();
        if (!empty($this->custom_permission)) {
            $this->change_checkbox = 1;
            $RolePerlist = OoapMasUserPer::where('user_id', $this->em_id)->get();
            foreach ($RolePerlist as  $value) {
                $this->view_data[$value->submenu_id] = (int)$value->view_data;
                $this->insert_data[$value->submenu_id] = (int)$value->insert_data;
                $this->update_data[$value->submenu_id] = (int)$value->update_data;
                $this->delete_data[$value->submenu_id] = (int)$value->delete_data;
            }
        } else {
            $this->change_checkbox = 0;
            $RolePerlist = OoapMasRolePer::getPermission($this->role_id)->get();
            foreach ($RolePerlist as $value) {
                $this->view_data[$value->submenu_id] = (int)$value->view_data;
                $this->insert_data[$value->submenu_id] = (int)$value->insert_data;
                $this->update_data[$value->submenu_id] = (int)$value->update_data;
                $this->delete_data[$value->submenu_id] = (int)$value->delete_data;
            }
        }
    }
    public function submit()
    {
        $this->validate([
            'role_id' => 'required',
        ], [
            'role_id.required' => 'กรุณาเลือก กลุ่มผู้ใช้งาน',
        ]);
        $OoapTblEmployee = OoapTblEmployee::where([['emp_id', $this->em_id]])->first();

        if ($OoapTblEmployee) {
            OoapMasUserPer::where('user_id',  $this->em_id)->delete();
            if (!empty($this->change_checkbox)) {
                $this->menulist_f();
                foreach ($this->menulist as $value) {
                    if (!empty($this->view_data[$value->submenu_id]) || !empty($this->insert_data[$value->submenu_id])  || !empty($this->update_data[$value->submenu_id])  || !empty($this->delete_data[$value->submenu_id])) {
                        OoapMasUserPer::create([
                            'user_id' => (int)$this->em_id,
                            'menu_id' => $value->menu_id,
                            'submenu_id' => $value->submenu_id,
                            'view_data' => !empty($this->view_data[$value->submenu_id]) ? 1 : 0,
                            'insert_data' => !empty($this->insert_data[$value->submenu_id]) ? 1 : 0,
                            'update_data' => !empty($this->update_data[$value->submenu_id]) ? 1 : 0,
                            'delete_data' => !empty($this->delete_data[$value->submenu_id]) ? 1 : 0,
                            'remember_token' => csrf_token(),
                            'created_by' => auth()->user()->em_citizen_id,
                            'created_at' => now()
                        ]);
                    }
                }
            }
            $OoapTblEmployee->update([
                'role_id' => (int)$this->role_id,
                'custom_permission' => $this->change_checkbox,
                'remember_token' => csrf_token(),
                'updated_by' => auth()->user()->em_citizen_id,
                'updated_at' => now()
            ]);
            $this->emit('popup');
        }
    }

    public function changeRole($val)
    {
        $this->menulist_f();
        $this->role_id = $val;
        $checkupdate = OoapMasRolePer::where('role_id', $this->role_id)->count();
        if ($checkupdate) {
            $this->reset('view_data', 'insert_data', 'update_data', 'delete_data');
            $RolePerlist = OoapMasRolePer::where([['in_active', false], ['role_id', $this->role_id]])
                ->orderBy('role_per_id', 'asc')
                ->get();
            foreach ($RolePerlist as $value) {
                $this->view_data[$value->submenu_id] = (int)$value->view_data ? 1 : 0;
                $this->insert_data[$value->submenu_id] = (int)$value->insert_data ? 1 : 0;
                $this->update_data[$value->submenu_id] = (int)$value->update_data ? 1 : 0;
                $this->delete_data[$value->submenu_id] = (int)$value->delete_data ? 1 : 0;
            }
        } else {

            foreach ($this->menulist as $value) {
                $this->view_data[$value->submenu_id] = 0;
                $this->insert_data[$value->submenu_id] = 0;
                $this->update_data[$value->submenu_id] = 0;
                $this->delete_data[$value->submenu_id] = 0;
            }
        }
    }



    public function redirect_to_edit()
    {
        return redirect(route('permission.edit', ['id' => $this->check_userper[0]->emp_id]));
    }

    public function menulist_f()
    {
        $this->menulist = OoapMasMenu::where([['ooap_mas_menu.in_active', false]])
            ->select('ooap_mas_menu.menu_name', 'ooap_mas_submenu.submenu_name', 'ooap_mas_menu.menu_id', 'ooap_mas_submenu.submenu_id')
            ->leftjoin('ooap_mas_submenu', 'ooap_mas_menu.menu_id', 'ooap_mas_submenu.menu_id')
            ->orderBy('ooap_mas_menu.menu_id', 'asc')
            ->orderBy('ooap_mas_submenu.submenu_id', 'asc')
            ->get();
    }

    public function allrow()
    {
        foreach ($this->menulist as  $value) {
            $this->view_data[$value->submenu_id] = $this->selectall ? 1 : 0;
            $this->insert_data[$value->submenu_id] = $this->selectall ? 1 : 0;
            $this->update_data[$value->submenu_id] = $this->selectall ? 1 : 0;
            $this->delete_data[$value->submenu_id] = $this->selectall ? 1 : 0;
        }
    }
    public function viewall()
    {
        foreach ($this->menulist as $value) {
            $this->view_data[$value->submenu_id] = $this->viewall ? 1 : 0;
        }
    }
    public function addall()
    {
        foreach ($this->menulist as $value) {
            $this->insert_data[$value->submenu_id] = $this->addall ? 1 : 0;
        }
    }
    public function editall()
    {
        foreach ($this->menulist as $value) {
            $this->update_data[$value->submenu_id] = $this->editall ? 1 : 0;
        }
    }
    public function delall()
    {
        foreach ($this->menulist as $value) {
            $this->delete_data[$value->submenu_id] = $this->delall ? 1 : 0;
        }
    }

    public function thisReset()
    {
        return redirect(route('permission.index'));
    }



    public function redirect_to()
    {
        return redirect(route('permission.index'));
    }
}
