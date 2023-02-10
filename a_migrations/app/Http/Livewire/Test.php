<?php



namespace App\Http\Livewire;


use Livewire\Component;

class Test extends Component
{
    public $estimate_name, $estimate_short, $acttype_id, $acttype_list, $estimate_type_id, $estimate_type_list;

    public function mount()
    {

        $this->setArea = [

            'subdistricts_name' => ['label' => 'ตำบล/แขวง'],
            'amphur_name' => ['label' => 'อำเภอ/เขต'],
            'province_name' => ['label' => 'จังหวัด'],
            'postcode' => ['label' => 'รหัสไปรษณีย์'],
        ];

        foreach ($this->setArea as $ka => $va) {


            $this->$ka = NULL;
        }

        // $this->subdistricts_id = NULL;
        // $this->amphur_id = NULL;
        // $this->province_id = NULL;
        $this->area_select = NULL;
        // $this->province_name = NULL;
        // $this->amphur_name = NULL;
        // $this->subdistricts_postcode = NULL;
    }

    public function render()
    { //dd('ddsd');
        $this->emit('loadJquery');
        return view('livewire.test');
    }

    function submit()
    {
        dd($this->area_select);
        // $text = '';
        // foreach(  $this->setArea as $ka => $va ) {

        //    $text .=  $this->$ka . ', ';
        // }

        // dd( $text );
    }
}
