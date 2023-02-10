<?php

namespace App\Http\Livewire\Master\Projectpeople;

use App\Models\OoapMasPeopleStatus;
use App\Models\OoapMasProjectPeoples;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectpeopleEditComponent extends Component
{
  use WithFileUploads;

  public $data, $peostatus,  $peostatusname_select;
  public $peoid, $peoname, $peoaddress_no, $peosurname, $peobirthdate, $peoage, $peoeducation, $peoposition, $peoaddress_moo, $peoaddress_tambon, $peoaddress_aumphur, $peoaddress_province, $peoaddress_zip;
  public $peoaddress_used = false, $peolectel, $peolecfax, $peolecmobile, $peolecemail, $peoleceducation, $peolecexperience,
    $peocurlecaddress_no, $peocurlecaddress_moo, $peocurlecaddress_tambon, $peocurlecaddress_aumphur, $peocurlecaddress_province, $peocurlecaddress_zip,
    $status, $remember_token, $created_by, $updated_by, $created_at, $updated_at, $deleted_at, $pathfilepeoname;
  public $pathfilepeoname_new;

  public function mount()
  {
    $this->peostatus = OoapMasPeopleStatus::where('inactive', false)->orderby('peostatus', 'asc')->first()->peostatus ?? null;
    // dd($this->data);
    $this->peoautoid = $this->data->peoautoid;
    $this->peoid = $this->data->peoid;
    $this->peoname = $this->data->peoname;
    $this->peosurname = $this->data->peosurname;
    $this->peobirthdate = datetoview($this->data->peobirthdate);
    $this->peoage = $this->data->peoage;
    $this->peoeducation = $this->data->peoeducation;
    $this->peoposition = $this->data->peoposition;
    $this->peoaddress_no = $this->data->peoaddress_no;
    $this->peoaddress_moo = $this->data->peoaddress_moo;
    $this->peoaddress_tambon = $this->data->peoaddress_tambon;
    $this->peoaddress_aumphur = $this->data->peoaddress_aumphur;
    $this->peoaddress_province = $this->data->peoaddress_province;
    $this->peoaddress_zip = $this->data->peoaddress_zip;
    $this->peolectel = $this->data->peolectel;
    $this->peolecmobile = $this->data->peolecmobile;
    $this->peolecemail = $this->data->peolecemail;
    $this->peoleceducation = $this->data->peoleceducation;
    $this->peolecexperience = $this->data->peolecexperience;
    $this->peocurlecaddress_no = $this->data->peocurlecaddress_no;
    $this->peocurlecaddress_moo = $this->data->peocurlecaddress_moo;
    $this->peocurlecaddress_tambon = $this->data->peocurlecaddress_tambon;
    $this->peocurlecaddress_aumphur = $this->data->peocurlecaddress_aumphur;
    $this->peocurlecaddress_province = $this->data->peocurlecaddress_province;
    $this->peocurlecaddress_zip = $this->data->peocurlecaddress_zip;
    $this->pathfilepeoname = $this->data->pathfilepeoname;
    $this->peolecfax = $this->data->peolecfax;
  }
  public function submit()
  {
    $this->validate([
      'peoid' => 'required',
      'peoname' => 'required',
      'peosurname' => 'required',
      'pathfilepeoname' => 'required',
      'peobirthdate' => 'required',
      'peoeducation' => 'required',
      'peoposition' => 'required',
      'peoposition' => 'required',

      'peoaddress_no' => 'required',
      'peoaddress_moo' => 'required',
      'peoaddress_tambon' => 'required',
      'peoaddress_aumphur' => 'required',
      'peoaddress_province' => 'required',
      'peoaddress_zip' => 'required',

      'peocurlecaddress_no' => 'required',
      'peocurlecaddress_moo' => 'required',
      'peocurlecaddress_tambon' => 'required',
      'peocurlecaddress_aumphur' => 'required',
      'peocurlecaddress_province' => 'required',
      'peocurlecaddress_zip' => 'required',
      'peoage' => 'required|numeric',

      'peolectel' => 'required',
      'peolecfax' => 'required',
      'peolecmobile' => 'required',
      'peolecemail' => 'required',
      'peoleceducation' => 'required',
      'peolecexperience' => 'required',
    ], [
      'peoid.required' => 'โปรดใส่เลขบัตรประชาชน',
      'peoname.required' => 'โปรดใส่ชื่อ',
      'peosurname.required' => 'โปรดใส่นามสกุล',
      'pathfilepeoname.required' => 'โปรดเลือกไฟล์',
      'peobirthdate.required' => 'โปรดใส่ ว/ด/ป เกิด',
      'peoeducation.required' => 'โปรดใส่การศึกษา',
      'peoposition.required' => 'โปรดใส่ตำแหน่งปัจจุบัน',

      'peoaddress_no.required' => 'โปรดใส่เลขที่บ้าน',
      'peoaddress_moo.required' => 'โปรดใส่หมู่',
      'peoaddress_tambon.required' => 'โปรดใส่ตำบล',
      'peoaddress_aumphur.required' => 'โปรดใส่อำเภอ',
      'peoaddress_province.required' => 'โปรดใส่จังหวัด',
      'peoaddress_zip.required' => 'โปรดใส่รหัสไปรษณีย์',

      'peocurlecaddress_no.required' => 'โปรดใส่เลขที่บ้าน',
      'peocurlecaddress_moo.required' => 'โปรดใส่หมู่',
      'peocurlecaddress_tambon.required' => 'โปรดใส่ตำบล',
      'peocurlecaddress_aumphur.required' => 'โปรดใส่อำเภอ',
      'peocurlecaddress_province.required' => 'โปรดใส่จังหวัด',
      'peocurlecaddress_zip.required' => 'โปรดใส่รหัสไปรษณีย์',
      'peoage.required' => 'โปรดใส่อายุ',

      'peolectel.required' => 'โปรดใส่เบอร์โทรโทรศัพท์',
      'peolecfax.required' => 'โปรดใส่โทรสาร',
      'peolecmobile.required' => 'โปรดใส่โทรศัพท์มือถือ',
      'peolecemail.required' => 'โปรดใส่อีเมลล์',
      'peoleceducation.required' => 'โปรดใส่ประวัติการศึกษา',
      'peolecexperience.required' => 'โปรดใส่ประวัติการศึกษา',
    ]);
    // dd(datePickerThaiToDB($this->peobirthdate));
    if ($this->pathfilepeoname_new) {
      $path_file = '/projectpeople';
      $this->pathfilepeoname_new->store('/public' . $path_file);
      $has = $path_file . '/' . $this->pathfilepeoname_new->hashName();
      OoapMasProjectPeoples::where('peoautoid', $this->peoautoid)->update([
        'filepeoname' => $has,
        'pathfilepeoname' => $has,
      ]);
    }
    OoapMasProjectPeoples::where('peoautoid', $this->peoautoid)->update([
      'peoid' => $this->peoid,
      'peoname' => $this->peoname,
      'peosurname' => $this->peosurname,
      'peostatus' => $this->peostatus,
      'peobirthdate' =>  datePickerThaiToDB($this->peobirthdate),
      'peoage' => $this->peoage,
      'peoeducation' => $this->peoeducation,
      'peoposition' => $this->peoposition,
      'peoaddress_no' => $this->peoaddress_no,
      'peoaddress_moo' => $this->peoaddress_moo,
      'peoaddress_tambon' => $this->peoaddress_tambon,
      'peoaddress_aumphur' => $this->peoaddress_aumphur,
      'peoaddress_province' => $this->peoaddress_province,
      'peoaddress_zip' => $this->peoaddress_zip,
      'peoaddress_used' => $this->peoaddress_used,
      'peolectel' => $this->peolectel,
      'peolecfax' => $this->peolecfax,
      'peolecmobile' => $this->peolecmobile,
      'peolecemail' => $this->peolecemail,
      'peoleceducation' => $this->peoleceducation,
      'peolecexperience' => $this->peolecexperience,

      'peocurlecaddress_no' => $this->peocurlecaddress_no,
      'peocurlecaddress_moo' => $this->peocurlecaddress_moo,
      'peocurlecaddress_tambon' => $this->peocurlecaddress_tambon,
      'peocurlecaddress_aumphur' => $this->peocurlecaddress_aumphur,
      'peocurlecaddress_province' => $this->peocurlecaddress_province,
      'peocurlecaddress_zip' => $this->peocurlecaddress_zip,

      'remember_token' => csrf_token(),
      'updated_by' => auth()->user()->emp_citizen_id,
      'updated_at' => now()
    ]);
    // }
    return redirect()->route('master.projectpeople.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    return redirect()->to('/master/projectpeople');
  }

  public function changePeoStatus($value)
  {
    $this->peostatus = $value;
  }

  public function render()
  {
    $this->peostatusname_select = OoapMasPeopleStatus::where('inactive', false)->pluck('peostatusname', 'peostatus');
    return view('livewire.master.projectpeople.projectpeople-edit-component');
  }
}
