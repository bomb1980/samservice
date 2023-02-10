<?php

namespace App\Http\Livewire\Master\Acttype;



use App\Models\OoapMasActtype;
use Livewire\Component;

class EditComponent extends Component
{
    public $acttype_list, $acttype_id, $dataCoursegroup;
    public $coursegroup_id, $code, $name, $shortname, $status, $in_active, $remember_token, $create_by, $create_at;

    public function mount()
    {
        // $this->acttype_id = OoapMasActtype::where('inactive', '=', 0)->orderby('id', 'asc')->first()->id;

        if ($this->dataCoursegroup) {
            $this->parent_id = $this->dataCoursegroup->id;
            $this->acttype_id = $this->dataCoursegroup->acttype_id;
            $this->code = $this->dataCoursegroup->code;
            $this->name = $this->dataCoursegroup->name;
            $this->shortname = $this->dataCoursegroup->shortname;
        } else {

            $this->parent_id = NULL;
            $this->acttype_id = 2;
            $this->code = NULL;
            $this->name = NULL;
            $this->shortname = NULL;
        }
    }

    public function submit()
    {
        $this->validate([

            'name' => 'required',

        ], [

            'name.required' => 'กรุณากรอกชื่อประเภทกิจกรรม',

        ]);

        if ($this->dataCoursegroup) {
            $checkResult = OoapMasActtype::where('id', '=', $this->parent_id)->first();
            if ($checkResult) {
                $checkResult->update([

                    'name' => $this->name,

                    'updated_by' => auth()->user()->emp_citizen_id
                ]);

                // $this->parent_id = $this->dataCoursegroup->id;
            }
        } else {


            $OoapMasActtype = OoapMasActtype::create([

                'name' => $this->name,

                'created_by' => auth()->user()->emp_citizen_id,
            ]);



            $this->parent_id = $OoapMasActtype->id;
        }

        $this->emit('popup');
    }

    protected $listeners = ['redirect-to' => 'redirectToMain'];

    public function redirectToMain()
    {

        return redirect(route('master.acttype.index'));

    }

    public function render()
    {
        $this->acttype_list = OoapMasActtype::where('inactive', '=', 0)->pluck('name', 'id');

        $this->emit('emits');

        return view('livewire.master.acttype.edit-component');


    }
}
