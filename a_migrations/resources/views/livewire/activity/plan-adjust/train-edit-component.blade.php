<div>
    <br>
    <div class="row">
        <div class="col-md-2 form-group">
            <div>
                <button type="button" class="btn btn-primary w-full form-group {{ $panel == 1 ? '' : 'btn-outline' }}"
                    wire:click="changPanel(1)">ข้อมูลใบคำขอ
                    @if ($circle1 == true)
                        <span class="dot-checkmark text-center">
                            <i></i>
                        </span>
                    @elseif ($alert1 == true)
                        <span class="text-center">
                            <i class="icon wb-alert" aria-hidden="true" style="color:red"></i>
                        </span>
                    @endif
                </button>

                <button type="button" class="btn btn-primary w-full form-group {{ $panel == 2 ? '' : 'btn-outline' }}"
                    wire:click="changPanel(2)">ข้อมูลกิจกรรม
                    @if ($circle2 == true)
                        <span class="dot-checkmark text-center">
                            <i></i>
                        </span>
                    @elseif ($alert2 == true)
                        <span class="text-center">
                            <i class="icon wb-alert" aria-hidden="true" style="color:red"></i>
                        </span>
                    @endif
                </button>
                <button type="button" class="btn btn-primary w-full form-group {{ $panel == 3 ? '' : 'btn-outline' }}"
                    wire:click="changPanel(3)">พื้นที่ดำเนินการ
                    @if ($circle3 == true)
                        <span class="dot-checkmark text-center">
                            <i></i>
                        </span>
                    @elseif ($alert3 == true)
                        <span class="text-center">
                            <i class="icon wb-alert" aria-hidden="true" style="color:red"></i>
                        </span>
                    @endif
                </button>
                <button type="button" class="btn btn-primary w-full form-group {{ $panel == 4 ? '' : 'btn-outline' }}"
                    wire:click="changPanel(4)">ค่าใช้จ่าย
                    @if ($circle4 == true)
                        <span class="dot-checkmark text-center">
                            <i></i>
                        </span>
                    @elseif ($alert4 == true)
                        <span class="text-center">
                            <i class="icon wb-alert" aria-hidden="true" style="color:red"></i>
                        </span>
                    @endif
                </button>
                <button type="button" class="btn btn-primary w-full form-group {{ $panel == 5 ? '' : 'btn-outline' }}"
                    wire:click="changPanel(5)">แนบไฟล์
                    @if ($circle5 == true)
                        <span class="dot-checkmark text-center">
                            <i></i>
                        </span>
                    @endif
                </button>
            </div>
            <br>
            <hr>
            <br>
            <div class="{{ $act_plan_adjust_status == 1 ? '' : 'd-none' }}">
                {{-- <button type="button" class="w-full form-group btn btn-secondary"
                    onclick="submit_prototype(1)">บันทึก</button> --}}
                <button type="button" class="w-full form-group btn btn-success" onclick="submit_prototype(2)"
                    {{ $show ? '' : 'disabled' }}>บันทึกส่งตรวจสอบ</button>
                <button type="button" class="w-full form-group btn btn-danger"
                    onclick="button_function()">ยกเลิก</button>
            </div>
            {{-- <div class="{{ $act_plan_adjust_status != 1 ? '' : 'd-none' }}">
                <button type="button" class="w-full form-group btn btn-default" disabled>
                    @if ($act_plan_adjust_status == 2)
                        ยืนยันความพร้อม
                    @elseif ($act_plan_adjust_status == 3)
                        ปิดโครงการ
                    @endif
                </button>
            </div> --}}
        </div>
        <div class="form-group col-md-10 panel">
            <div class="panel-body container-fluid">
                {{-- <div class="pearls row form-group">
                    <div class="pearl col-3 current {{ $status >= 1 ? 'active' : 'disabled' }}" aria-expanded="true">
                        <div class="pearl-icon"><i class="icon wb-clipboard" aria-hidden="true"></i></div>
                        <span class="pearl-title">บันทึกคำขอ</span>
                    </div>
                    <div class="pearl col-2 current {{ $status >= 2 ? 'active' : 'disabled' }}" aria-expanded="false">
                        <div class="pearl-icon"><i class="icon wb-payment" aria-hidden="true"></i></div>
                        <span class="pearl-title">พิจารณาคำขอ</span>
                    </div>
                    <div class="pearl col-3 current {{ $status >= 3 ? 'active' : 'disabled' }}" aria-expanded="false">
                        <div class="pearl-icon">
                            @if ($status == 3)
                                <i class="icon wb-check" aria-hidden="true"></i>
                            @elseif($status == 4)
                                <i class="icon wb-close" aria-hidden="true"></i>
                            @else
                                <i class="icon wb-help" aria-hidden="true"></i>
                            @endif
                        </div>
                        <span class="pearl-title">
                            @if ($status == 3)
                                ผ่าน
                            @elseif($status == 4)
                                ไม่ผ่าน
                            @else
                                ผลพิจารณาคำขอ
                            @endif
                        </span>
                    </div>
                    <div class="pearl col-2 current {{ $status >= 5 ? 'active' : 'disabled' }}" aria-expanded="false">
                        <div class="pearl-icon"><i class="icon fa-send" aria-hidden="true"></i></div>
                        <span class="pearl-title">เสนองบ</span>
                    </div>
                </div>
                <br> --}}
                {{ Form::open([
                    'wire:submit.prevent' => 'submit()',
                    'autocomplete' => 'off',
                    'class' => 'form-horizontal fv-form fv-form-bootstrap4',
                ]) }}
                <div class="{{ $panel == 1 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <div class="form-control-label">
                            <label>
                                <h4><b><u>ข้อมูลใบคำขอ</u></b></h4>
                            </label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">ปีงบประมาณ <span class="text-danger">*</span></label>
                            {{ Form::select('act_year', $fiscalyear_list, $act_year, [
                                'onchange' => 'setValue_periodno("act_year",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกปีงบประมาณ--',
                                'disabled',
                            ]) }}
                            @error('act_year')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">หน่วยงาน</label>
                            <input type="text" class="form-control" value="{{ $act_dept }}" disabled>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">เลขที่ใบคำขอ </label>
                            <input type="text" class="form-control" value="{{ $act_number }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <label class="form-control-label">วันที่ใบคำขอ </label>
                            <input type="text" class="form-control" value="{{ datetoview($created_at) }}"
                                disabled>
                        </div>
                    </div>
                    {{-- <div class="row form-group">
                        <label class="form-control-label">วันที่ใบคำขอ </label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="{{ datetoview($created_at) }}"
                                disabled>
                        </div>
                    </div> --}}
                </div>

                <div class="{{ $panel == 2 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <div class="form-control-label">
                            <label>
                                <h4><b><u>ข้อมูลกิจกรรม</u></b></h4>
                            </label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">ประเภทกิจกรรม </label>
                            {{ Form::select('acttye_id', $acttye_list, $acttye_id, [
                                'onchange' => 'setValue("acttye_id",event.target.value)',
                                'class' => 'form-control select2',
                                'disabled',
                            ]) }}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">กลุ่มหลักสูตร <span class="text-danger">*</span></label>
                            {{ Form::select('act_coursegroup', $coursegroup_list, $act_coursegroup, [
                                // 'wire:change' => 'changeCoursegroup($event.target.value)',
                                'onchange' => 'setValue("act_coursegroup", event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกกลุ่มหลักสูตร--',
                                'disabled' => $formdisabled,
                            ]) }}
                        </div>
                        @error('act_coursegroup')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="row form-group">

                        <div class="col-md-3">
                            <label class="form-control-label">กลุ่มสาขาอาชีพ
                            </label>
                            {{ Form::select('act_coursesubgroup', $coursesubgroup_list, $act_coursesubgroup, [
                                // 'wire:change' => 'changeCoursesubgroup($event.target.value)',
                                'onchange' => 'setValue("act_coursesubgroup", event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกกลุ่มสาขาอาชีพ--',
                                'disabled' => $formdisabled,
                            ]) }}
                        </div>
                        @error('act_coursesubgroup')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">ประเภทหลักสูตร
                            </label>
                            {{-- {{count($course_list)}} --}}
                            {{ Form::select('act_coursetype', $coursetype_list, $act_coursetype, [
                                // 'wire:change' => 'changeCourse($event.target.value)',
                                'onchange' => 'setValue("act_coursetype", event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--ประเภทหลักสูตร--',
                                'disabled' => $formdisabled,
                            ]) }}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="col-md-2 form-control-label">หลักสูตร
                            </label>
                            {{-- {{count($course_list)}} --}}
                            {{ Form::select('act_course', $course_list, $act_course, [
                                // 'wire:change' => 'changeCourse($event.target.value)',
                                'onchange' => 'setValue("act_course", event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกหลักสูตร--',
                                'disabled' => $formdisabled,
                            ]) }}
                        </div>
                    </div>
                    <div class="row form-group">

                        <div class="col-md-6">
                            <label class="form-control-label">ชื่อกิจกรรม <span class="text-danger">*</span></label>
                            {{ Form::text('act_shortname', $act_shortname, [
                                'wire:model' => 'act_shortname',
                                'class' => 'form-control',
                                'placeholder' => 'ชื่อกิจกรรม',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_shortname')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">

                        <div class="col-md-6">
                            <label class="form-control-label">รายละเอียดกิจกรรม <span
                                    class="text-danger">*</span></label>
                            <textarea rows="6" class="form-control" wire:model="act_desc" placeholder="รายละเอียดกิจกรรม"
                                {{ $status == 1 ? '' : 'disabled' }}></textarea>
                            @error('act_desc')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label class="form-control-label">หมายเหตุ </label>
                            <textarea rows="6" class="form-control" wire:model="act_remark" placeholder="หมายเหตุ"
                                {{ $status == 1 ? '' : 'disabled' }}></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row form-group mt-4">
                        <label class="form-control-label">
                            <h4><b><u>สถานที่จัดการอบรม</u></b></h4>
                        </label>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">ประเภทสถานที่ <span class="text-danger">*</span></label>
                            {{ Form::select('act_buildtypeid', $buildingtype_list, $act_buildtypeid, [
                                'onchange' => 'setValue("act_buildtypeid",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกประเภทสถานที่--',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_buildtypeid')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">ชื่อสถานที่ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="ชื่อสถานที่"
                                wire:model="act_buildname" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_buildname')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="form-control-label">พิกัดแผนที่ละติจูด </label>
                            {{ Form::text('building_lat', $building_lat, [
                                'wire:model' => 'building_lat',
                                'class' => 'form-control',
                                'placeholder' => 'พิกัดแผนที่ละติจูด',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('building_lat')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-control-label">พิกัดแผนที่ลองติจูด </label>
                            {{ Form::text('building_long', $building_long, [
                                'wire:model' => 'building_long',
                                'class' => 'form-control',
                                'placeholder' => 'พิกัดแผนที่ลองติจูด',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('building_long')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div id="map" style="height: 400px; width: 100%" wire:ignore></div>
                        </div>
                    </div>
                </div>

                <div class="{{ $panel == 3 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <label class="form-control-label">
                            <h4><b><u>พื้นที่ดำเนินการโครงการ</u></b></h4>
                        </label>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 form-group">
                            <label class="form-control-label">จังหวัด <span class="text-danger">*</span></label>
                            {{ Form::select('province_id', $province_list, $province_id, [
                                'onchange' => 'setValue("province_id",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกจังหวัด--',
                                'disabled' => $province_disabled,
                            ]) }}
                            @error('province_id')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="form-control-label">อำเภอ <span class="text-danger">*</span></label>
                            {{ Form::select('act_district', $amphur_list, $act_district, [
                                'onchange' => 'setValue("act_district",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกอำเภอ--',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_district')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="form-control-label">ตำบล <span class="text-danger">*</span></label>
                            {{ Form::select('act_subdistrict', $tambon_list, $act_subdistrict, [
                                'onchange' => 'setValue("act_subdistrict",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกตำบล--',
                                'disabled' => $formdisabled,
                            ]) }}
                        </div>
                        @error('act_subdistrict')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                        <div class="col-md-3 form-group">
                            <label class="form-control-label">หมู่ที่ </label>
                            <input type="text" class="form-control" placeholder="หมู่ที่" wire:model="act_moo"
                                {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_moo')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="row form-group">
                        <div class="col-md-3 form-group">
                            <label class="form-control-label">ตำบล <span class="text-danger">*</span></label>
                            {{ Form::select('act_subdistrict', $tambon_list, $act_subdistrict, [
                                'onchange' => 'setValue("act_subdistrict",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกตำบล--',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_subdistrict')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="form-control-label">หมู่ที่ </label>
                            <input type="text" class="form-control" placeholder="หมู่ที่" wire:model="act_moo"
                                {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_moo')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="row form-group">
                        <div class="col-md-5 form-group">
                            <label class="form-control-label">ชื่อชุมชน </label>
                            <input type="text" class="form-control" placeholder="ชื่อชุมชน"
                                wire:model="act_commu" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_commu')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">

                        <div class="col-md-3">
                            <label class="form-control-label">ชื่อผู้นำชุมชน</label>
                            <input type="text" class="form-control" placeholder="ข้อมูลผู้นำชุมชน"
                                wire:model="act_leadname" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_leadname')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">ตำแหน่งผู้นำชุมชน </label>
                            <input type="text" class="form-control" placeholder="ตำแหน่งผู้นำชุมชน"
                                wire:model="act_position" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_position')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-5">
                            <label class="form-control-label">ข้อมูลผู้นำชุมชน</label>
                            <textarea rows="4" class="form-control" wire:model="act_leadinfo" placeholder="ข้อมูลผู้นำชุมชน"
                                {{ $status == 1 ? '' : 'disabled' }}></textarea>
                            @error('act_leadinfo')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="{{ $panel == 4 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <label class="form-control-label">
                            <h4><b><u>ค่าใช้จ่าย</u></b></h4>
                        </label>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label text-left">เดือนที่เริ่ม <span
                                class="text-danger">*</span></label>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control datepicker" data-date-language="th-th"
                                onchange="setDatePicker('stdate', event.target.value)" value="{{ $stdate }}"
                                placeholder="เดือนที่เริ่ม" {{ $status == 1 ? '' : 'disabled' }}>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="icon wb-calendar" aria-hidden="true"></i>
                                </span>
                            </div>
                            @error('stdate')
                                <label class="input-group text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label text-left">เดือนที่สิ้นสุด <span
                                class="text-danger">*</span></label>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control datepicker" data-date-language="th-th"
                                onchange="setDatePicker('endate', event.target.value)" value="{{ $endate }}"
                                placeholder="เดือนที่สิ้นสุด" {{ $status == 1 ? '' : 'disabled' }}>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="icon wb-calendar" aria-hidden="true"></i>
                                </span>
                            </div>
                            @error('endate')
                                <label class="input-group text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label text-left">จำนวนคนร่วมกิจกรรม <span
                                class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::number('act_numofpeople', null, [
                                'wire:model' => 'act_numofpeople',
                                'wire:change' => 'setnum("act_numofpeople",$event.target.value)',
                                'min' => 0,

                                'id' => 'act_numofpeople',
                                'class' => 'form-control',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_numofpeople')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label text-left">จำนวนวิทยากร <span
                                class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::number('act_numlecturer', null, [
                                'wire:model' => 'act_numlecturer',
                                'wire:change' => 'setnum("act_numlecturer",$event.target.value)',
                                'min' => 0,

                                'id' => 'act_numlecturer',
                                'class' => 'form-control',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_numlecturer')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label">จำนวนวันจัดกิจกรรม <span
                                class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::number('act_numofday', null, [
                                'wire:model' => 'act_numofday',
                                'wire:change' => 'setnum("act_numofday",$event.target.value)',
                                'min' => 0,

                                'id' => 'act_numofday',
                                'class' => 'form-control',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_numofday')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-md-2 form-control-label">จำนวนคนร่วมกิจกรรม <span
                                class="text-danger">*</span></label>
                        <div class="col-md-3">
                            {{ Form::number('act_numofpeople', null, [
                                'wire:model' => 'act_numofpeople',
                                'wire:change' => 'setnum("act_numofpeople",$event.target.value)',
                                'min' => 0,

                                'id' => 'act_numofpeople',
                                'class' => 'form-control',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_numofpeople')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div> --}}
                    {{-- <div class="form-group row">
                        <label class="col-md-2 form-control-label">จำนวนวิทยากร <span
                                class="text-danger">*</span></label>
                        <div class="col-md-3">
                            {{ Form::number('act_numlecturer', null, [
                                'wire:model' => 'act_numlecturer',
                                'wire:change' => 'setnum("act_numlecturer",$event.target.value)',
                                'min' => 0,

                                'id' => 'act_numlecturer',
                                'class' => 'form-control',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_numlecturer')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div> --}}

                    {{-- <div class="row">
                        <div class="col-2"></div>
                        <div class="col-8 table-responsive form-group">
                            <table class="table table-bordered table-hover table-striped w-full">
                                <thead>
                                    <tr>
                                        <th class="text-center">ค่าใช้จ่าย</th>
                                        <th class="text-center">อัตรา/หน่วย</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">รวมเป็นเงิน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            <label class="form-control-label">ค่าอาหาร <span
                                                    class="text-danger">*</span></label>
                                        </td>

                                        <td class="text-center">
                                            {{ Form::number('act_foodrate', null, [
                                                'wire:model' => 'act_foodrate',
                                                'wire:change' => 'calsum("act_foodrate",$event.target.value)',
                                                'min' => 0,
                                                'id' => 'act_foodrate',
                                                'class' => 'form-control',
                                                'disabled' => $formdisabled,
                                            ]) }}
                                        </td>

                                        <td class="text-center">
                                            <input name="food" type="text" class="form-control text-left"
                                                readonly=""
                                                value="{{ $act_numofday }} วัน / {{ $countsum }} คน">
                                        </td>

                                        <td class="text-center">
                                            {{ Form::text('act_amtfood', number_format($act_amtfood, 2), ['class' => 'form-control text-right', 'disabled']) }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="form-control-label">ค่าตอบแทนวิทยากร <span
                                                    class="text-danger">*</span></label>
                                        </td>

                                        <td class="text-center">
                                            {{ Form::number('course_trainer_rate', null, [
                                                'wire:model' => 'course_trainer_rate',
                                                'wire:change' => 'calsum("course_trainer_rate",$event.target.value)',
                                                'min' => 0,
                                                'id' => 'course_trainer_rate',
                                                'class' => 'form-control',
                                                'disabled' => $formdisabled,
                                            ]) }}
                                        </td>

                                        <td class="text-center">
                                            <input name="food" type="text" class="form-control text-left"
                                                readonly=""
                                                value="{{ $act_numofday }} วัน / {{ $act_numlecturer }} คน">
                                        </td>

                                        <td class="text-center">
                                            {{ Form::text('course_trainer_amt', number_format($course_trainer_amt, 2), ['class' => 'form-control text-right', 'disabled']) }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="form-control-label">ค่าวัสดุ</label>
                                        </td>

                                        <td class="text-center">
                                            {{ Form::number('act_materialrate', null, [
                                                'wire:model' => 'act_materialrate',
                                                'wire:change' => 'calsum("act_materialrate",$event.target.value)',
                                                'min' => 0,
                                                'id' => 'act_materialrate',
                                                'class' => 'form-control',
                                                'disabled' => $formdisabled,
                                            ]) }}
                                        </td>

                                        <td class="text-center">
                                            <input name="food" type="text" class="form-control text-left"
                                                readonly=""
                                                value="{{ $act_numofday }} วัน / {{ $act_numofpeople }} คน">
                                        </td>

                                        <td class="text-center">
                                            {{ Form::text('course_material_amt', number_format($course_material_amt, 2), ['class' => 'form-control text-right', 'disabled']) }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="form-control-label">ค่าใช้จ่ายอื่นๆ</label>
                                        </td>

                                        <td class="text-center">

                                        </td>

                                        <td class="text-center">

                                        </td>

                                        <td class="text-center">
                                            {{ Form::number('other_amt', null, [
                                                'wire:model' => 'other_amt',
                                                'min' => 0,
                                                'id' => 'other_amt',
                                                'class' => 'form-control text-right',
                                                'disabled' => $formdisabled,
                                            ]) }}

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                    <hr>
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label text-left">อัตราค่าอาหาร <span
                                class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::number('act_foodrate', null, [
                                'wire:model' => 'act_foodrate',
                                'wire:change' => 'calsum("act_foodrate",$event.target.value)',
                                'min' => 0,

                                'id' => 'act_foodrate',
                                'class' => 'form-control',
                                'disabled' => $formdisabled,

                            ]) }}
                            @error('act_foodrate')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label text-left">ค่าอาหาร<span
                                class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::text('act_amtfood', number_format($act_amtfood, 2), ['class' => 'form-control text-right', 'disabled']) }}
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label text-left">อัตราค่าตอบแทนวิทยากร <span
                                class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::number('course_trainer_rate', null, [
                                'wire:model' => 'course_trainer_rate',
                                'wire:change' => 'calsum("course_trainer_rate",$event.target.value)',
                                'min' => 0,

                                'id' => 'course_trainer_rate',
                                'class' => 'form-control',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('course_trainer_rate')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label text-left">ค่าตอบแทนวิทยากร <span
                                class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::text('course_trainer_amt', number_format($course_trainer_amt, 2), ['class' => 'form-control text-right', 'disabled']) }}
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label text-left">อัตราค่าวัสดุ <span
                                class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::number('act_materialrate', null, [
                                'wire:model' => 'act_materialrate',
                                'wire:change' => 'calsum("act_materialrate",$event.target.value)',
                                'min' => 0,

                                'id' => 'act_materialrate',
                                'class' => 'form-control',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_materialrate')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label text-left">ค่าวัสดุ <span
                                class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::text('course_material_amt', number_format($course_material_amt, 2), ['class' => 'form-control text-right', 'disabled']) }}
                        </div>
                    </div>
                    <hr>
                    <center>
                        <div class="form-group row pt-4 pb-1 col-12 bg-info">
                            <label class="col-md-10 form-control-label">
                                <h4><b>รวมเป็นเงิน</b></h4>
                            </label>
                            <div class="col-md-2">
                                {{ Form::text('act_amount', number_format($act_amount, 2), ['class' => 'form-control text-right', 'disabled']) }}
                            </div>
                        </div>
                    </center>

                </div>

                <div class="{{ $panel == 5 ? '' : 'd-none' }}">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label"><b><u>แนบไฟล์</u></b></label>
                            <div class="row">
                                <div class="input-group col-md-10 input-group-file" data-plugin="inputGroupFile">
                                    <input type="text" class="form-control" readonly="">
                                    <button class="btn bg-blue-grey-300 btn-file">
                                        <i class="icon wb-file" aria-hidden="true"></i>
                                        เลือกไฟล์
                                        <input type="file" wire:model="files"
                                            accept=".xlsx,.xls, .doc,.docx, .ppt,.pptx, .txt, .pdf">
                                    </button>
                                    <br>
                                    @error('files')
                                        <small class="text-danger col-md-12">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-success offset-md-1"
                                        wire:click="submit_file_array" {{ $files == null ? 'disabled' : '' }}>
                                        อัพโหลดไฟล์
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <small class="col-md-12 text-danger">รองรับไฟล์ image, doc, excel และ pdf
                                    ขนาดไฟล์ไม่เกิน 20
                                    MB/ไฟล์</small>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-8 table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ชื่อไฟล์</th>
                                        <th>ประเภทไฟล์</th>
                                        <th>ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($file_array_old as $key => $val)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-left"><a
                                                    href="{{ url('/storage' . $val['files_path'] . '/' . $val['files_gen']) }}"
                                                    title="คลิกเพื่อดาวน์โหลด" download>{{ $val['files_ori'] }}</a>
                                            </td>
                                            <td>{!! showMimeIcon($val['files_type']) !!}</td>
                                            <td><button type="button" class="btn btn-danger"
                                                    onclick="destroy_old_array({{ $key }})"><i
                                                        class="icon wb-trash"></i></button></td>
                                        </tr>
                                    @endforeach
                                    @foreach ($file_array as $key => $val)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-left">{{ $val->getClientOriginalName() }}</td>
                                            <td>{!! showMimeIcon($val->getMimeType()) !!}</td>
                                            <td><button type="button" class="btn btn-danger"
                                                    onclick="destroy_array({{ $key }})"><i
                                                        class="icon wb-trash"></i></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            {{-- <div class="wizard-buttons">
                <button class="btn btn-default" {{ $panel == 1 ? 'disabled' : '' }}
                    wire:click="back({{ $panel }})">ย้อนกลับ</button>
                <button class="btn btn-primary float-right {{ $panel == 6 ? 'd-none' : '' }}"
                    wire:click="next({{ $panel }})">ถัดไป</button>
            </div> --}}
            <br>
        </div>
    </div>
    {{-- @if ($status == 1)
        <div class='row'>
            <div class='col text-center'>
                <button type="button" class="w-full form-group btn btn-danger col-2"
                    onclick="button_function(1)">ยกเลิก</button>
                &nbsp;
                &nbsp;
                &nbsp;
                <button type="button" class="w-full form-group btn btn-success col-2"
                    onclick="submit_prototype(1)">บันทึก</button>
            </div>
        </div>
    @endif
    @if ($status == 2)
        <div class='row'>
            <div class='col text-center'>
                <button type="button" class="w-full form-group btn btn-danger col-2"
                    onclick="button_function(1)">ยกเลิก</button>
            </div>
        </div>
    @endif --}}

</div>

@push('js')
    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
        integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
        integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        document.addEventListener('livewire:load', function() {
            $('.select2').select2();
            call_datatablepop2('');
            call_datatablepop1('');
            init_leaflet_Map();

            Livewire.on('emits', () => {
                $('.select2').select2();

                leaflet_map.invalidateSize();

            });
        });

        function calsum(cal) {
            @this.calsum(cal);
        }

        function setValue_periodno(name, val) {
            @this.set(name, val);
            @this.periodno(name, val);
        }

        function init_leaflet_Geolocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Sorry, your browser does not support geolocation services.");
            }
        }

        function showPosition(position) {
            var latlng = new L.LatLng(position.coords.latitude, position.coords.longitude);
            addMarker(latlng);
            leaflet_map.setView([position.coords.latitude, position.coords.longitude], 6);
        }

        var leaflet_map, newMarker = [];

        function init_leaflet_Map() {
            if (@this.building_lat || @this.building_long) {
                leaflet_map = L.map('map').setView([@this.building_lat, @this.building_long], 6);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(leaflet_map);

                var latlng = new L.LatLng(@this.building_lat, @this.building_long);
                addMarker(latlng);
            } else {
                leaflet_map = L.map('map').setView([14.992882255673587, 100.9017413330078], 6);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(leaflet_map);
            }

            leaflet_map.on('click', addMarker);

            // Seach box
            L.Control.geocoder({
                defaultMarkGeocode: false
            }).on('markgeocode', function(e) {
                var bbox = e.geocode.bbox;
                var poly = L.polygon([
                    bbox.getSouthEast(),
                    bbox.getNorthEast(),
                    bbox.getNorthWest(),
                    bbox.getSouthWest()
                ]);
                leaflet_map.fitBounds(poly.getBounds());
            }).addTo(leaflet_map);
            //

        }

        function addMarker(e) {
            var latlng = e.latlng;
            if (e.latlng == undefined || e.latlng == null) {
                latlng = e;
            }
            // Add marker to map at click location
            let n = 0; // number of maker - 1

            if (newMarker.length >= n + 1) {
                clear_leaflet_Markers();
            }

            var LamMarker = new L.marker(latlng);
            newMarker.push(LamMarker);

            leaflet_map.addLayer(newMarker[n]); // add maker

            @this.latLng(latlng);
        }

        function clear_leaflet_Markers() {
            for (var i = 0; i < newMarker.length; i++) {
                leaflet_map.removeLayer(newMarker[i]);
                newMarker.splice(i, 1);
            }
        }

        function setValue(name, val) {
            @this.set(name, val);
        }

        $(".datepicker").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

        Livewire.on('popup', () => {
            swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.livewire.emit('redirect-to');
                    }
                });
        });

        function button_function() {
            swal({
                title: 'ยืนยันการ ยกเลิกการบันทึก ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.redirect_to();
                }
            });
        }

        function submit_prototype(number) {
            if (number == 1) {
                var title = "ยืนยันการ บันทึกข้อมูลโครงการ ?";
            } else if (number == 2) {
                var title = "ยืนยันการ ส่งผลพิจารณา ?";
            }

            swal({
                title: title,
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.submit_prototype(number);
                }
            });
        }

        function destroy_array(key) {
            swal({
                title: 'ยืนยันการ  ลบไฟล์ ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.destroy_array(key);
                }
            });
        }

        function destroy_old_array(key) {
            swal({
                title: 'ยืนยันการ  ลบไฟล์ ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.destroy_old_array(key);
                }
            });
        }

        function call_datatablepop1(search) {

            var SearchData = $('#search').val();

            var table = $('#Datatablepop1').DataTable({
                processing: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.operate.result_train_role1.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}',
                        act_number: @this.act_number,
                        act_id: @this.act_id,
                        act_div: @this.act_div,
                        role: 1,
                    },
                    headers: {
                        'Authorization': 'Bearer {{ system_key() }}'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'nationalid',
                        name: 'nationalid',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'fullname',
                        name: 'fullname',
                        className: "text-left",
                        orderable: false,
                    },
                    {
                        data: 'rolelist',
                        name: 'rolelist',
                        className: "text-left",
                        orderable: false,
                    },
                    {
                        data: 'pop_age',
                        name: 'pop_age',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'pop_gender',
                        name: 'pop_gender',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'pop_mobileno',
                        name: 'pop_mobileno',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'detail',
                        name: 'detail',
                        className: "text-center",
                        orderable: false,
                    }
                ],
                language: {
                    url: '{{ asset('assets') }}/js/datatable-thai.json',
                },
                paging: true,
                pageLength: 10,
                ordering: false,
                drawCallback: function(settings) {
                    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                    pagination.toggle(this.api().page.info().pages > 1);
                }
            });
            table.on('order.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).search(search).draw();

        }

        function call_datatablepop2(search) {

            var SearchData = $('#search').val();

            var table = $('#Datatablepop2').DataTable({
                processing: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.operate.result_train_role1.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}',
                        act_number: @this.act_number,
                        act_id: @this.act_id,
                        act_div: @this.act_div,
                        role: 2,
                    },
                    headers: {
                        'Authorization': 'Bearer {{ system_key() }}'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'nationalid',
                        name: 'nationalid',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'fullname',
                        name: 'fullname',
                        className: "text-left",
                        orderable: false,
                    },
                    {
                        data: 'rolelist',
                        name: 'rolelist',
                        className: "text-left",
                        orderable: false,
                    },
                    {
                        data: 'pop_age',
                        name: 'pop_age',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'pop_gender',
                        name: 'pop_gender',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'pop_mobileno',
                        name: 'pop_mobileno',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'detail',
                        name: 'detail',
                        className: "text-center",
                        orderable: false,
                    }
                ],
                language: {
                    url: '{{ asset('assets') }}/js/datatable-thai.json',
                },
                paging: true,
                pageLength: 10,
                ordering: false,
                drawCallback: function(settings) {
                    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                    pagination.toggle(this.api().page.info().pages > 1);
                }
            });
            table.on('order.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).search(search).draw();

        }

    </script>
@endpush
