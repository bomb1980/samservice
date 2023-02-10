<?php

namespace App\Http\Livewire\Permission;

use App\Models\OoapTblEmployee;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class PermissionComponent extends Component
{
    public $columns;
    protected $listeners = ['delete-to' => 'delete_to'];

    public function render()
    {
        return view('livewire.permission.permission-component');
    }
    public function delete_to($val)
    {
        // dd($val);
        OoapTblEmployee::find($val['data'])->update([
            'in_active' => 1,
            'deleted_by' => auth()->user()->em_citizen_id,
            'deleted_at' => now()
        ]);
        $em_citizen_id = OoapTblEmployee::find($val['data'])->emp_citizen_id;
        if ($em_citizen_id != 'tcmad') {
            Http::withHeaders([
                'Authorization' => 'Bearer ' . config('app.umts_token'),
                'Accept' => 'application/json'
            ])->post(config('app.umts_api') . '/eis/updateroleportal_form_new', ['em_citizen_id' => $em_citizen_id, 'system_menus_id' => 2, 'create_or_delete' => 2])->json();
        }
        return redirect()->route('permission.index');
    }
}
