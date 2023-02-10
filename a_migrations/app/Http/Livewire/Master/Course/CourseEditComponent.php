<?php

namespace App\Http\Livewire\Master\Course;

use App\Models\OoapMasCoursesubgroup;
use App\Models\OoapMasCoursegroup;
use App\Models\OoapMasCoursetype;
use App\Models\OoapMasCourse;
use App\Models\OoapMasCoursefiles;
use App\Models\OoapMasCourseOwnertype;
use App\Models\OoapMasActtype;
use App\Models\UmMasDepartment;
use App\Models\OoapTblEmployee;
use Livewire\Component;
use Livewire\WithFileUploads;

class CourseEditComponent extends Component
{
    use WithFileUploads;
    public $course_id;
    public $dept_list, $dept_id;
    public $ownertype_list, $ownertype_id;
    public $acttype_list, $acttype_id;
    public $coursetype_list, $coursetype_id;
    public $coursegroup_list, $coursegroup_id;
    public $coursesubgroup_list, $coursesubgroup_id;
    public $code, $name, $shortname, $descp, $ownerdescp, $hour_descp, $day_descp, $people_descp, $trainer_descp, $status, $in_active, $remember_token, $created_by, $created_at;
    public $file_array = [], $files, $file_array_old;
    public $duplicate = 0; // section select plan
    public $fileuploadpreviewing = [], $course_files = [], $edit_files = [], $delete_files = [], $file_key = 1; // section upload files
    public $support = []; // section support budget
    public $data_flow;
    public $datas;
    public $em_province_id, $province_id;
    public $button_status;
    public $formdisabled = false;
    public $emp_type;

    public function mount()
    {

        if ($this->datas) {
            $this->file_array_old = OoapMasCoursefiles::where('course_id', '=',  $this->datas->id)->where('in_active', '=', false)->get()->toArray() ?? [];

            $this->code = $this->datas->code;
            $this->course_id = $this->datas->id;
            $this->name = $this->datas->name;
            $this->shortname = $this->datas->shortname;
            $this->descp = $this->datas->descp;
            $this->dept_id = $this->datas->dept_id;
            $this->ownertype_id = $this->datas->ownertype_id;
            $this->ownerdescp = $this->datas->ownerdescp;
            $this->acttype_id = $this->datas->acttype_id;
            $this->coursegroup_id = $this->datas->coursegroup_id;
            $this->coursesubgroup_id = $this->datas->coursesubgroup_id;
            $this->coursetype_id = $this->datas->coursetype_id;
            $this->hour_descp = $this->datas->hour_descp;
            $this->day_descp = $this->datas->day_descp;
            $this->people_descp = $this->datas->people_descp;
            $this->trainer_descp = $this->datas->trainer_descp;
            $this->province_id = $this->datas->province_id;
            $this->emp_type = auth()->user()->emp_type;
            if ($this->emp_type == 2) {

                $this->em_province_id = auth()->user()->province_id;

                if ($this->province_id != $this->em_province_id) {
                    $this->button_status = 'disabled';
                    $this->formdisabled = true;
                } else {
                    $this->button_status = '';
                    $this->formdisabled = false;
                }
            } else {
                $this->button_status = '';
                $this->formdisabled = false;
            }


        } else {

            $this->file_array_old = [];

            $this->code = NULL;
            $this->course_id = NULL;
            $this->name = NULL;
            $this->shortname = NULL;
            $this->descp = NULL;
            $this->dept_id = NULL;
            $this->ownertype_id = NULL;
            $this->ownerdescp = NULL;
            $this->acttype_id = 2;
            $this->coursegroup_id = NULL;
            $this->coursesubgroup_id = NULL;
            $this->coursetype_id = NULL;
            $this->hour_descp = NULL;
            $this->day_descp = NULL;
            $this->people_descp = NULL;
            $this->trainer_descp = NULL;
            $this->em_province_id = auth()->user()->province_id;
            $this->button_status = '';
            $this->formdisabled = false;
        }
    }



    public function submit()
    {
        if ($this->datas) {

            $this->validate([
                'acttype_id' => 'required',
                'name' => 'required',
                'shortname' => 'required|max:200',
                'descp' => 'required',
                'ownertype_id' => 'required',
                'ownerdescp' => 'required',
                'dept_id' => 'required',
                'coursegroup_id' => 'required',
                'hour_descp' => 'required',
                'day_descp' => 'required',
                'people_descp' => 'required',
                'trainer_descp' => 'required',

            ], [
                'acttype_id.required' => 'กรุณาเลือกประเภทกิจกรรม',
                'name.required' => 'กรุณากรอกชื่อหลักสูตรอบรม',
                'shortname.max' => 'ชื่อย่อยาวเกินไป',
                'shortname.required' => 'กรุณากรอกชื่อย่อ',
                'descp.required' => 'กรุณากรอกรายละเอียด',
                'ownertype_id.required' => 'กรุณาเลือกแหล่งที่มาหลักสูตร',
                'ownerdescp.required' => 'กรุณากรอกรายละเอียดแหล่งที่มาหลักสูตร',
                'dept_id.required' => 'กรุณาเลือกหน่วยงาน เจ้าของหลักสูตร',
                'coursegroup_id.required' => 'กรุณาเลือกกลุ่มหลักสูตร',
                'hour_descp.required' => 'กรุณากรอกระยะเวลาการฝึก',
                'day_descp.required' => 'กรุณากรอกจำนวนวันที่ดำเนินการ',
                'people_descp.required' => 'กรุณากรอกจำนวนกลุ่มเป้าหมาย',
                'trainer_descp.required' => 'กรุณากรอกจำนวนวิทยากร',
            ]);

            $this->parent_id = $this->datas->id;

            OoapMasCourse::where('id', '=', $this->datas->id)->update([
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
                'updated_by' => auth()->user()->emp_citizen_id
            ]);

        } else {

            $this->validate([
                'acttype_id' => 'required',
                'name' => 'required|unique:ooap_mas_course',
                'shortname' => 'required|max:200',
                'descp' => 'required',
                'ownertype_id' => 'required',
                'ownerdescp' => 'required',
                'dept_id' => 'required',
                'coursegroup_id' => 'required',
                'hour_descp' => 'required',
                'day_descp' => 'required',
                'people_descp' => 'required',
                'trainer_descp' => 'required',

            ], [
                'acttype_id.required' => 'กรุณาเลือกประเภทกิจกรรม',
                'name.required' => 'กรุณากรอกชื่อหลักสูตรอบรม',
                'name.unique' => 'มีชื่อหลักสูตรอบรมนี้แล้ว',
                'shortname.max' => 'ชื่อย่อยาวเกินไป',
                'shortname.required' => 'กรุณากรอกชื่อย่อ',
                'descp.required' => 'กรุณากรอกรายละเอียด',
                'ownertype_id.required' => 'กรุณาเลือกแหล่งที่มาหลักสูตร',
                'ownerdescp.required' => 'กรุณากรอกรายละเอียดแหล่งที่มาหลักสูตร',
                'dept_id.required' => 'กรุณาเลือกหน่วยงาน เจ้าของหลักสูตร',
                'coursegroup_id.required' => 'กรุณาเลือกกลุ่มหลักสูตร',
                'hour_descp.required' => 'กรุณากรอกระยะเวลาการฝึก',
                'day_descp.required' => 'กรุณากรอกจำนวนวันที่ดำเนินการ',
                'people_descp.required' => 'กรุณากรอกจำนวนกลุ่มเป้าหมาย',
                'trainer_descp.required' => 'กรุณากรอกจำนวนวิทยากร',
            ]);
            // $cgCd = OoapMasCoursegroup::where([['id', '=', $this->coursegroup_id]])->pluck('code')->first();  //กลุ่มหลักสูตร
            // $csgCd = OoapMasCoursesubgroup::where([['id', '=', $this->coursesubgroup_id]])->pluck('code')->first();
            // $ctCd = OoapMasCoursetype::where([['id', '=', $this->coursetype_id]])->pluck('code')->first();


            // $year =  date("y", mktime(0, 0, 0, date("m"),   date("d"),   date("Y") + 543));
            // $gName = $cgCd . '-' .  $csgCd . '-' .  $ctCd . '-'. $year;
            // $runNo = makeFrontZero(  OoapMasCourse::where('code', 'LIKE', ''. $gName .'%')->count() + 1, 3 );
            // $this->code = $gName .'-'. $runNo;

            $cgCd = OoapMasCoursegroup::where([['id', '=', $this->coursegroup_id]])->pluck('code')->first() ?? null;
            $csgCd = OoapMasCoursesubgroup::where([['id', '=', $this->coursesubgroup_id]])->pluck('code')->first() ?? null;
            $ctCd = OoapMasCoursetype::where([['id', '=', $this->coursetype_id]])->pluck('code')->first() ?? null;
            $cntYear = (OoapMasCourse::whereYear('created_at', '=', date('Y'))->count()) + 1 ?? 1;
            $runNo = substr(date('Y') + 543, 2) . "-" . sprintf('%03d', $cntYear);
            $this->code = (($cgCd) ? (($csgCd) ? (($ctCd) ? ($cgCd . "-" . $csgCd . "-" . $ctCd . "-" . $runNo) : ($cgCd . "-" . $csgCd . "-000-" . $runNo)) : ($cgCd . "-00-000-" . $runNo)) : null);

            //  dd($this->code);

            $parent = OoapMasCourse::create([
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
                'province_id' => $this->em_province_id,
                'remember_token' => csrf_token(),
                'created_by' => auth()->user()->emp_citizen_id,
                'created_at' => now()
            ]);

            $this->parent_id = $parent->id;
        }

        $array_left = array_column($this->file_array_old, 'files_id') ?? []; // ที่เหลือจากลบแล้ว

        OoapMasCoursefiles::where('course_id', '=', $this->parent_id)->whereNotIn('files_id', $array_left)->update([ // ลบไฟล์ที่ไม่มีออก
            'in_active' => 1,
            'deleted_by' => auth()->user()->name,
            'deleted_at' => now()
        ]);

        if (!empty($this->file_array)) {
            $path_file = '/course';
            foreach ($this->file_array as $file) {
                $file->store('/public' . $path_file);
                OoapMasCoursefiles::create([
                    'files_ori' => $file->getClientOriginalName(),
                    'files_gen' => $file->hashName(),
                    'files_path' => $path_file,
                    'files_type' => $file->getMimeType(),
                    'files_size' => $file->getSize(),
                    'course_id' => $this->parent_id,
                    'remember_token' => csrf_token(),
                    'created_by' => auth()->user()->emp_citizen_id,
                    'created_at' => now(),
                ]);
            }
        }

        return redirect()->route('master.course.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        $this->emit('popup');

    }


    public function submit_file_array()
    {
        $this->validate([
            'files' => 'required',
        ], [
            'files.required' => 'กรุณาเลือกไฟล์',
        ]);
        array_push($this->file_array, $this->files);
        $this->files = null;
    }

    public function destroy_array($key)
    {
        unset($this->file_array[$key]);
        $this->file_array = array_values($this->file_array);
    }

    public function destroy_old_array($key)
    {
        unset($this->file_array_old[$key]);
        $this->file_array_old = array_values($this->file_array_old);
    }


    protected $listeners = ['redirect-to' => 'redirectToMain'];

    public function redirectToMain()
    {
        return redirect(route('master.course.index'));

        // if ($this->datas) {
        //     return redirect(route('master.course.edit', ['id' => $this->parent_id]));
        // } else {
        //     return redirect(route('master.course.index'));
        // }


        //  return redirect()->to('/master/course');
    }





    public function render()
    {
        $this->emit('emits');

        $this->dept_list = UmMasDepartment::pluck('dept_name_th', 'dept_id');

        $this->ownertype_list = OoapMasCourseOwnertype::where('in_active', '=', false)->pluck('name', 'id');

        $this->acttype_list = OoapMasActtype::where('inactive', '=', 0)->pluck('name', 'id');
        $this->coursegroup_list = OoapMasCoursegroup::where('in_active', '=', false)->pluck('name', 'id');

        $this->coursesubgroup_list = OoapMasCoursesubgroup::where([['in_active', '=', false], ['coursegroup_id', '=', $this->coursegroup_id]])->pluck('name', 'id');
        $this->coursetype_list = OoapMasCoursetype::where([['in_active', '=', false], ['coursesubgroup_id', '=', $this->coursesubgroup_id]])->pluck('name', 'id');
        if (!empty($this->datas)) {
            $cgCd = OoapMasCoursegroup::where([['id', '=', $this->coursegroup_id]])->pluck('code')->first() ?? null;
            $csgCd = OoapMasCoursesubgroup::where([['id', '=', $this->coursesubgroup_id]])->pluck('code')->first() ?? null;
            $ctCd = OoapMasCoursetype::where([['id', '=', $this->coursetype_id]])->pluck('code')->first() ?? null;
            $runNo = substr(OoapMasCourse::where([['id', '=', $this->course_id]])->pluck('code')->first(), -6);
            // $subfixCd = OoapMasCourse::where([['id','=',$this->course_id]])->pluck('code')->first();
            // $subfixCd =substr($subfixCd,-6);
            // $subfixCd =substr($subfixCd,(strlen($subfixCd)-6),6);
            $this->code = (($cgCd) ? (($csgCd) ? (($ctCd) ? ($cgCd . "-" . $csgCd . "-" . $ctCd . "-" . $runNo) : ($cgCd . "-" . $csgCd . "-000-" . $runNo)) : ($cgCd . "-00-000-" . $runNo)) : null);

        }
        // if ($this->datas) {

        // } else {
        //     $cgCd = OoapMasCoursegroup::where([['id', '=', $this->coursegroup_id]])->pluck('code')->first() ?? null;
        //     $csgCd = OoapMasCoursesubgroup::where([['id', '=', $this->coursesubgroup_id]])->pluck('code')->first() ?? null;
        //     $ctCd = OoapMasCoursetype::where([['id', '=', $this->coursetype_id]])->pluck('code')->first() ?? null;
        //     $cntYear = (OoapMasCourse::whereYear('created_at', '=', date('Y'))->count()) + 1 ?? 1;
        //     $runNo = substr(date('Y') + 543, 2) . "-" . sprintf('%03d', $cntYear);
        //     $this->code = (($cgCd) ? (($csgCd) ? (($ctCd) ? ($cgCd . "-" . $csgCd . "-" . $ctCd . "-" . $runNo) : ($cgCd . "-" . $csgCd . "-000-" . $runNo)) : ($cgCd . "-00-000-" . $runNo)) : null);
        // }
        return view('livewire.master.course.course-edit-component');
    }

    public function upload_file()
    {
        $duplicate = check_duplicate_files($this->fileuploadpreviewing, $this->course_files, $this->edit_files);

        if ($duplicate) {
            $this->emit('duplicate_file');
            return;
        }

        foreach ($this->fileuploadpreviewing as $file_upload) {
            array_push($this->course_files, $file_upload);
        }
    }

    public function destroyArr($key)
    {
        unset($this->course_files[$key]);
        $this->course_files = array_values($this->course_files);
        $this->resetValidation('course_files.*');
        $this->resetErrorBag('course_files.*');
    }

    public function delete_edit_file($file_id, $key)
    {
        array_push($this->delete_files, $file_id);
        unset($this->edit_files[$key]);
        $this->edit_files = array_values($this->edit_files);
    }
}
