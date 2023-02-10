<?php

namespace App\Http\Livewire\Permission;

use App\Models\OoapMasMenu;
use App\Models\OoapMasRole;
use App\Models\OoapMasRolePer;
use App\Models\OoapMasSubmenu;
use Livewire\Component;

class GrouppermissionAddComponent extends Component
{
    public $dataGroupPermission, $Role, $role_id, $menulist;
    public $view_data = [], $insert_data = [], $update_data = [], $delete_data = [], $apprv_data = [], $selectall, $selectall_form;
    public $sub_menu, $subMenu, $func, $subFunc, $role_per, $role_level_id, $Role_level, $data_role_level_id, $role_level_id_mount, $mountRole;
    public $currentStep = 1;

    public $function_menu, $view_data_form = [];
    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function menulist_f()
    {
        $this->menulist = OoapMasMenu::where([['ooap_mas_menu.in_active', false]])
            ->select('ooap_mas_menu.menu_name', 'ooap_mas_submenu.submenu_name', 'ooap_mas_menu.menu_id', 'ooap_mas_submenu.submenu_id')
            ->leftjoin('ooap_mas_submenu', 'ooap_mas_menu.menu_id', 'ooap_mas_submenu.menu_id')
            ->orderBy('ooap_mas_menu.menu_id', 'asc')
            ->orderBy('ooap_mas_submenu.submenu_id', 'asc')
            ->get();
    }
    public function mount()
    {

        $this->role_id = NULL;
        $this->sub_menu = OoapMasSubmenu::getDatas();

        foreach ($this->sub_menu as $value) {
            $this->view_data[$value->submenu_id] = 0;
            $this->insert_data[$value->submenu_id] = 0;
            $this->update_data[$value->submenu_id] = 0;
            $this->delete_data[$value->submenu_id] = 0;
        }
    }

    public function render()
    {
        $this->Role = OoapMasRole::where('in_active', false)->pluck('role_name_th', 'role_id');
        $this->sub_menu = OoapMasSubmenu::getDatas();
        return view('livewire.permission.grouppermission-add-component');
    }

    public function changeRole($value)
    {
        $this->role_id = $value;
        $this->menulist_f();

        $this->reset('view_data', 'insert_data', 'update_data', 'delete_data');
        $this->RolePerlist = OoapMasRolePer::where([['in_active', false], ['role_id',  $this->role_id]])->get();
        if ($this->RolePerlist) {
            foreach ($this->RolePerlist as $value) {
                $this->view_data[$value->submenu_id] = (int)$value->view_data;
                $this->insert_data[$value->submenu_id] = (int)$value->insert_data;
                $this->update_data[$value->submenu_id] = (int)$value->update_data;
                $this->delete_data[$value->submenu_id] = (int)$value->delete_data;
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

    public function allrow()
    {
        foreach ($this->sub_menu as  $value) {
            $this->view_data[$value->submenu_id] = $this->selectall ? 1 : 0;
            $this->insert_data[$value->submenu_id] = $this->selectall ? 1 : 0;
            $this->update_data[$value->submenu_id] = $this->selectall ? 1 : 0;
            $this->delete_data[$value->submenu_id] = $this->selectall ? 1 : 0;
        }
    }

    public function save_menu()
    {
        $this->validate([
            'role_id' => 'required'
        ], [
            'role_id.required' => 'กรุณากรอก กลุ่มผู้ใช้งาน'
        ]);
        OoapMasRolePer::where('role_id', $this->role_id)->delete();
        foreach ($this->sub_menu as $value) {

            if (!empty($this->view_data[$value->submenu_id]) || !empty($this->insert_data[$value->submenu_id])  || !empty($this->update_data[$value->submenu_id])  || !empty($this->delete_data[$value->submenu_id])) {
                OoapMasRolePer::create(
                    [
                        'role_id' => $this->role_id,
                        'submenu_id' => $value->submenu_id,
                        'view_data' => !empty($this->view_data[$value->submenu_id]) ? 1 : 0,
                        'insert_data' => !empty($this->insert_data[$value->submenu_id]) ? 1 : 0,
                        'update_data' => !empty($this->update_data[$value->submenu_id]) ? 1 : 0,
                        'delete_data' => !empty($this->delete_data[$value->submenu_id]) ? 1 : 0,
                        'remember_token' => csrf_token(),
                        'created_by' =>
                        auth()->user()->em_citizen_id,
                        'created_at' => now()
                    ]
                );
            }
        }
        $this->emit('popup');
    }
    public function redirect_to()
    {
        return redirect()->route('permission.index');
    }
}
