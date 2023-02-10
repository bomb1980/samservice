<?php

namespace App\Http\Livewire\Master\poptype;

use App\Models\OoapMaspoptype;
use Livewire\Component;

class PoptypeEditComponent extends Component
{
    public $poptype_id, $name, $shortname, $status, $in_active, $remember_token, $create_by, $create_at;

    public function mount($datapoptype)
    {
        $this->poptype_id = $datapoptype->id;
        $this->name = $datapoptype->name;
        $this->shotname = $datapoptype->shotname;
    }

    public function submit()
    {
        // $this->validate([
        //   'name' => 'required',
        // ], [
        //   'name.required' => 'กรุณากรอกชื่อประเภทความเดือดร้อน',
        // ]);
        // $checkResult = App\Http\Livewire\Master\poptype\OoapMaspoptype::where('id', '=', $this->poptype_id)->first();
        // if ($checkResult) {
        //   OoapMaspoptype::where('id', '=', $this->poptype_id)->update([
        //     'name' => $this->name,
        //     'shotname' => $this->shotname,
        //     'updated_by' => auth()->user()->emp_citizen_id
        //   ]);
        // }
        $this->emit('popup');
    }

    protected $listeners = ['redirect-to' => 'redirect_to'];

    public function redirect_to()
    {
        return redirect()->route('master.poptype.index');
    }

    public function thisReset()
    {
        return redirect()->route('master.poptype.index');
    }

    public function render()
    {
        return view('livewire.master.poptype.poptype-edit-component');
    }
}
