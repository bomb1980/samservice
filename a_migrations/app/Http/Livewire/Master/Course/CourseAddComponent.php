<?php

namespace App\Http\Livewire\Master\Course;

use App\Models\OoapMasCoursesubgroup;
use App\Models\OoapMasCoursetype;
use App\Models\OoapMasCoursegroup;
use App\Models\OoapMasCourse;
use App\Models\OoapMasCoursefiles;
use App\Models\OoapMasCourseOwnertype;
use App\Models\OoapMasActtype;
use App\Models\UmMasDepartment;
use App\Models\OoapTblEmployee;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class CourseAddComponent extends Component
{
  use WithFileUploads;
  public $dept_list, $dept_id;
  public $ownertype_list, $ownertype_id;
  public $acttype_list, $acttype_id = 2;
  public $coursetype_list, $coursetype_id = null;
  public $coursegroup_list, $coursegroup_id,$province_id;
  public $coursesubgroup_list, $coursesubgroup_id = null;
  public $code, $name, $shortname, $descp, $ownerdescp, $hour_descp, $day_descp, $people_descp, $trainer_descp, $status, $in_active, $remember_token, $create_by, $create_at;
  public $file_array = [], $files;
  public $fileuploadpreviewing = [], $budget_files = [], $course_files = []; // section upload files
  public $duplicate = 0;
  // public $cgCd;


  public function submit_file_array()
  {
    // dd($this->files);
    $this->validate([
      'files' => 'required',
    ], [
      'files.required' => 'กรุณาเลือกไฟล์',
    ]);
    array_push($this->file_array, $this->files);
    $this->files = null;
    // dd($this->file_array);
  }

  public function destroy_array($key)
  {
    unset($this->file_array[$key]);
    $this->file_array = array_values($this->file_array);
  }

  public function mount()
  {
    // $this->dept_list = DB::connection('oracle_umts')->table('um_mas_department')->pluck('dept_name_th', 'dept_id');
    $this->acttype_list = OoapMasActtype::where('inactive', '=', 0)->pluck('name', 'id as acttype_id');
    $this->coursegroup_list = OoapMasCoursegroup::where('in_active', '=', false)->pluck('name', 'id as cousegroup_id');
    $this->ownertype_list = OoapMasCourseOwnertype::where('in_active', '=', false)->pluck('name', 'id as ownertype_id');
    $this->dept_list = UmMasDepartment::pluck('dept_name_th', 'dept_id');

    $OoapTblEmployee = OoapTblEmployee::where('emp_id', '=', auth()->user()->emp_id)->first();


    $this->province_id = $OoapTblEmployee->province_id;





    // $this->acttype_id = 2;
  }

  public function submit()
  {
    $this->reset('duplicate');

    $this->validate([
    //   'code' => 'required|max:20',
    //   'name' => 'required',
    //   'shortname' => 'required',
    //   'descp' => 'required',
    //   'dept_id' => 'required',
    //   'ownertype_id' => 'required',
    //   'ownerdescp' => 'required',
    //   'acttype_id' => 'required',
    //   'coursegroup_id' => 'required',
    //   'hour_descp' => 'required',
      'day_descp' => 'required',
      'people_descp' => 'required',
      'trainer_descp' => 'required',
      // 'fileuploadpreviewing.*' => 'mimetypes:application/pdf,image/*,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,csv,doc,docx'
    ], [
    //   'code.required' => 'กรุณาใส่รหัสหลักสูตรอบรม',
    //   'code.max' => 'รหัสหลักสูตรอบรมไม่เกิน 20 ตัวอักษร',
    //   'name.required' => 'กรุณากรอกชื่อหลักสูตรอบรม',
    //   'shortname.required' => 'กรุณากรอกชื่อย่อ',
    //   'descp.required' => 'กรุณากรอกรายละเอียด',
    //   'dept_id.required' => 'กรุณาเลือกหน่วยงานเจ้าของหลักสูตร',
    //   'ownertype_id.required' => 'กรุณาเลือกแหล่งที่มาของหลักสูตร',
    //   'ownerdescp.required' => 'กรุณากรอกรายละเอียดแหล่งที่มาหลักสูตร',
    //   'acttype_id.required' => 'กรุณาเลือกประเภทกิจกรรม',
    //   'coursegroup_id.required' => 'กรุณาเลือกกลุ่มหลักสูตร',
      'hour_descp.required' => 'กรุณากรอกระยะเวลาการฝึก',
      'day_descp.required' => 'กรุณากรอกจำนวนวัน',
      'people_descp.required' => 'กรุณากรอกจำนวนกลุ่มเป้าหมาย',
      'trainer_descp.required' => 'กรุณากรอกจำนวนวิทยากร',
      // 'fileuploadpreviewing.*.mimetypes' => 'ไฟล์ที่อัพโหลดต้องเป็นไฟล์ pdf, jpeg, jpg, png, xls, xlsx, csv, doc, docx เท่านั้น',
    ]);
    $data = OoapMasCourse::create([
      'code' => $this->code,
      'name' => $this->name,
      'shortname' => $this->shortname,
      'descp' => $this->descp,
      'dept_id' => $this->dept_id,
      'ownertype_id' => $this->ownertype_id,
      'ownerdescp' => $this->ownerdescp,
      'acttype_id' => $this->acttype_id,
      'coursegroup_id' => $this->coursegroup_id,
      'coursesubgroup_id' => $this->coursesubgroup_id,
      'coursetype_id' => $this->coursetype_id,
      'hour_descp' => $this->hour_descp,
      'day_descp' => $this->day_descp,
      'people_descp' => $this->people_descp,
      'trainer_descp' => $this->trainer_descp,
      'province_id' => $this->province_id,
      'remember_token' => csrf_token(),
      'created_by' => auth()->user()->emp_citizen_id
    ]);

    if (!empty($this->file_array)) {
      $path_file = '/course';
      foreach ($this->file_array as $file) {
        $file->store('/public' . $path_file);
        OoapMasCoursefiles::create([
          'course_id' => $data->id,
          'files_ori' => $file->getClientOriginalName(),
          'files_gen' => $file->hashName(),
          'files_path' => $path_file,
          'files_type' => $file->getMimeType(),
          'files_size' => $file->getSize(),
          'remember_token' => csrf_token(),
          'created_by' => auth()->user()->emp_citizen_id,
          'created_at' => now()
        ]);
      }
    }

    return redirect()->route('master.course.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');

    $this->emit('popup');
  }

  protected $listeners = ['redirect-to' => 'redirect_to'];

  public function redirect_to()
  {
    return redirect()->route('master.course.index');
  }

  public function thisReset()
  {
    return redirect()->route('master.course.index');
  }

  public function render()
  {
    $this->emit('emits');
    $this->coursesubgroup_list = OoapMasCoursesubgroup::where([['in_active', '=', false], ['coursegroup_id', '=', $this->coursegroup_id]])->pluck('name', 'id as coursegroup_id') ?? null;
    $this->coursetype_list = OoapMasCoursetype::where([['in_active', '=', false], ['coursesubgroup_id', '=', $this->coursesubgroup_id]])->pluck('name', 'id as coursetype_id') ?? null;
    $cgCd = OoapMasCoursegroup::where([['id', '=', $this->coursegroup_id]])->pluck('code')->first() ?? null;
    $csgCd = OoapMasCoursesubgroup::where([['id', '=', $this->coursesubgroup_id]])->pluck('code')->first() ?? null;
    $ctCd = OoapMasCoursetype::where([['id', '=', $this->coursetype_id]])->pluck('code')->first() ?? null;
    $cntYear = (OoapMasCourse::whereYear('created_at', '=', date('Y'))->count()) + 1 ?? 1;
    $runNo = substr(date('Y') + 543, 2) . "-" . sprintf('%03d', $cntYear);
    $this->code = (($cgCd) ? (($csgCd) ? (($ctCd) ? ($cgCd . "-" . $csgCd . "-" . $ctCd . "-" . $runNo) : ($cgCd . "-" . $csgCd . "-000-" . $runNo)) : ($cgCd . "-00-000-" . $runNo)) : null);
    return view('livewire.master.course.course-add-component');
  }
}
