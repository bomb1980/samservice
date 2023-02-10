<?php

namespace App\Http\Livewire\Master\Projectpeople;

use App\Models\OoapMasPeopleStatus;
use App\Models\OoapMasProjectPeoples;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectpeopleAddComponent extends Component
{
  use WithFileUploads;

  public $peostatus,  $peostatusname_select;
  public $peoid, $peoname, $peoaddress_no, $peosurname, $peobirthdate, $peoage, $peoeducation, $peoposition, $peoaddress_moo, $peoaddress_tambon, $peoaddress_aumphur, $peoaddress_province,
    $peoaddress_zip, $peoaddress_used = false, $peolectel, $peolecfax, $peolecmobile, $peolecemail, $peoleceducation, $peolecexperience,
    $peocurlecaddress_no, $peocurlecaddress_moo, $peocurlecaddress_tambon, $peocurlecaddress_aumphur, $peocurlecaddress_province, $peocurlecaddress_zip, $pathfilepeoname;
  public $files;

  public function mount()
  {
    $this->peostatus = OoapMasPeopleStatus::where('inactive', false)->orderby('peostatus', 'asc')->first()->peostatus ?? null;
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
    if ($this->peobirthdate) {
      $convertdate = Carbon::createFromFormat('d/m/Y', $this->peobirthdate)->format('m/d/Y');
    } else {
      $convertdate = null;
    }

    if ($this->pathfilepeoname) {
      $path_file = '/projectpeople';
      $this->pathfilepeoname->store('/public' . $path_file);
      $has = $path_file . '/' . $this->pathfilepeoname->hashName();
    } else {
      $has = null;
    }
    OoapMasProjectPeoples::create([
      'peoid' => $this->peoid,
      'peoname' => $this->peoname,
      'peosurname' => $this->peosurname,
      'filepeoname' => $has,
      'pathfilepeoname' => $has,
      'peostatus' => $this->peostatus,
      'peobirthdate' =>  datetodatabase($convertdate),
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
      'created_by' => auth()->user()->emp_citizen_id,
      'created_at' => now()
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
    return view('livewire.master.projectpeople.projectpeople-add-component');
  }
}
