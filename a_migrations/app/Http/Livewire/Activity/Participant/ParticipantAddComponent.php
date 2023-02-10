<?php

namespace App\Http\Livewire\Activity\Participant;

use App\Models\OoapTblEmp;
use App\Models\OoapTblReqmEmp;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ParticipantAddComponent extends Component
{
    public $reqform_id;
    public $resultNlic;
    // public $identification_id = '1659900290464';
    public $identification_id;
    public $customer_fname, $customer_lname, $sex = '', $dateofbirth, $status_id;
    public $address_number, $address_moo, $address_tumbol, $address_amphur, $address_province, $mobile, $occupation_text;

    public function mount($reqform_id)
    {
        $this->reqform_id = $reqform_id;
    }

    public function render()
    {

        return view('livewire.activity.participant.participant-add-component');
    }

    public static function  derived($password, $salt)
    {
        $AESKeyLength = 256 / 8;
        $AESIVLength = 128 / 8;
        $pbkdf2 = hash_pbkdf2("sha1", $password, $salt, 1000, $AESKeyLength + $AESIVLength, true);
        $key = substr($pbkdf2, 0, $AESKeyLength);
        $iv = substr($pbkdf2, $AESKeyLength, $AESIVLength);
        $derived = new \stdClass();
        $derived->key = $key;
        $derived->iv = $iv;
        return $derived;
    }

    public static function  encrypt($message, $password, $salt, $cipher)
    {
        $derived = self::derived($password, $salt);
        $enc = openssl_encrypt($message, $cipher, $derived->key, 0, $derived->iv);
        return $enc;
    }

    public static function  decrypt($message, $password, $salt, $cipher)
    {
        $derived = self::derived($password, $salt);
        $dec = openssl_decrypt($message, $cipher, $derived->key, 0, $derived->iv);
        return $dec;
    }

    public function getnlic()
    {

        $this->validate([
            'identification_id' => 'required',
        ], [
            'identification_id.required' => 'กรุณากรอก หมายเลขบัตรประชาชน',
        ]);

        $publicKey = '2KBip3qFPbSt9JeWl9x1EDJmXyRf-eLnpES1WaWPeB74s9bUYy4AzScSnPW_NrKkldCjkWsI4ZKHFecd1XhG3HRX77MsLujSzerxXxF2-sZTBx21WB5hL7tN649rG-4hKDT8q_2XMbByURwTtbD_D0deoBbFUFh3NS-XhtKfsyYKymvZUmYLHQ0LspxfPS9CkqtNY8GPEYe5WVIovjQsJFKd8o_qGyBzO-BmKOa-_8PjomkUUHZweE5GN9nrRDBMA3uxQOAujzJ8XOcPCcJLKs4QeS-j5e-DMzWKKJ0TvBGHqCrT12fVvPfNbDYzL0Gy6PXenkAB8BHOvhKGx_4LlNMc0OWlHFo4Uy0RVphZdCMJMUVlfOpEMvnAV4X3y1m7aaBiDWIwW-52IXsyX7a-txzGjbzrDy6oDxTpKC10Z6TdZx_69iVMsriP-TfsexnW-98gTkKJnyypmOPAS1n0v49CU3TZmpxMF0TvjMXmfsqln0T9gwHXTeSDgo3sD_jp';
        $data = [
            "ServiceCode" => "68e5a1685500425d8ba434c2701fee812022314",
            "Param" => [
                [
                    "FieldName" => "IDENTIFICATION_ID",
                    "DataType" => "String",
                    "Value" => $this->identification_id,
                    "Operator" => "Equal"
                ]
            ]
        ];
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $publicKey
        ])->withBody(json_encode($data), 'application/json')->post('http://api.nlic.mol.go.th/api/NlicAPI/MOL_SURVEY');

        $encStr = $response->json('results');

        $cipher = 'AES-256-CBC';
        $password = "Mol+P@ssw0rd+12345+Nlic";

        // Hash the password with SHA256
        $passwordBytes = hash('sha256', $password, true);
        $saltBytes = array(1, 2, 3, 4, 5, 6, 7, 8);
        $saltBytesstring = "";
        for ($i = 0; $i < count($saltBytes); $i++) {
            $saltBytesstring = $saltBytesstring . chr($saltBytes[$i]);
        }

        $outStr = self::decrypt($encStr, $passwordBytes, $saltBytesstring, $cipher);

        if ($outStr) {


            $json = json_decode($outStr, true);
            $this->loadDataNlic($json[0]);
        } else {
            $this->addError('identification_id', 'ไม่พบข้อมูล ตามเลขบัตรประชาชน');
            return false;
            // $this->identification_id = null;

            // $this->validate([
            //     'identification_id' => 'required',
            // ], [
            //     'identification_id.required' => 'ไม่พบข้อมูล ตามเลขบัตรประชาชน',
            // ]);
        }
    }

    public function loadDataNlic($resultNlic)
    {

        if ($resultNlic['IDENTIFICATION_ID'] != '') {

            $this->identification_id = $resultNlic['IDENTIFICATION_ID'];
            $this->customer_fname = $resultNlic['CUSTOMER_FNAME'];
            $this->customer_lname = $resultNlic['CUSTOMER_LNAME'];
            if ($resultNlic['SEX_ID'] == 2) {

                $this->sex = 'หญิง';
            } else {
                $this->sex = 'ชาย';
            }

            $this->dateofbirth = DateToView($resultNlic['DATEOFBIRTH']);

            if ($resultNlic['STATUS_ID'] == 1) {

                $this->status_id = 'โสต';
            } else {
                $this->status_id = 'สมรส';
            }
            $this->address_number = $resultNlic['ADDRESS_NUMBER'];
            $this->address_moo = $resultNlic['ADDRESS_MOO'];
            $this->address_tumbol = $resultNlic['ADDRESS_TUMBOL'];
            $this->address_amphur = $resultNlic['ADDRESS_AMPHUR'];
            $this->address_province = $resultNlic['ADDRESS_PROVINCE'];
            $this->mobile = $resultNlic['MOBILE'];
            $this->occupation_text = $resultNlic['OCCUPATION_TEXT'];
        } else {

            $this->identification_id = null;
        }
    }

    public function callBack()
    {

        return redirect()->route('activity.participant.index');
    }

    public function submit()
    {
        $this->validate([
            'identification_id' => 'required',
        ], [
            'identification_id.required' => 'กรุณากรอก หมายเลขบัตร ประชาชน',
        ]);

        if (!empty($this->identification_id)) {

            $checkEmp = OoapTblEmp::where('identification_id', '=', $this->identification_id)->first();

            if ($checkEmp) {
                $checkEmp->update([
                    'customer_fname' => $this->customer_fname,
                    'customer_lname' => $this->customer_lname,
                    'sex' => $this->sex,
                    'dateofbirth' => datePickerThaiToDB($this->dateofbirth),
                    'status_id' => $this->status_id,
                    'address_number' => $this->address_number,
                    'address_moo' => $this->address_moo,
                    'address_tumbol' => $this->address_tumbol,
                    'address_amphur' => $this->address_amphur,
                    'address_province' => $this->address_province,
                    'mobile' => $this->mobile,
                    'occupation_text' => $this->occupation_text,
                ]);
            } else {
                $checkEmp = OoapTblEmp::create([
                    'identification_id' => $this->identification_id,
                    'customer_fname' => $this->customer_fname,
                    'customer_lname' => $this->customer_lname,
                    'sex' => $this->sex,
                    'dateofbirth' => datePickerThaiToDB($this->dateofbirth),
                    'status_id' => $this->status_id,
                    'address_number' => $this->address_number,
                    'address_moo' => $this->address_moo,
                    'address_tumbol' => $this->address_tumbol,
                    'address_amphur' => $this->address_amphur,
                    'address_province' => $this->address_province,
                    'mobile' => $this->mobile,
                    'occupation_text' => $this->occupation_text,
                    'created_at' => now(),
                    'created_by' => auth()->user()->emp_citizen_id,
                ]);
            }


            if (($this->reqform_id != '') && ($checkEmp->emps_id != '')) {


                $checkReqEmp = OoapTblReqmEmp::where('reqform_id', '=', $this->reqform_id)
                    ->where('emps_id', '=', $checkEmp->emps_id)
                    ->first();

                if (empty($checkReqEmp)) {

                    OoapTblReqmEmp::create([
                        'reqform_id' => $this->reqform_id,
                        'emps_id' => $checkEmp->emps_id,
                        'created_at' => now(),
                        'created_by' => auth()->user()->emp_citizen_id,
                    ]);
                }
            }

            session()->flash('message_create', 'บันทึกข้อมูลเรียบร้อยแล้ว');
            return redirect()->route('activity.participant.index');
        }
    }
}
