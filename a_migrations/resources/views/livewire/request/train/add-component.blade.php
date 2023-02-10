<div>
    <br>
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

                <button type="button" {{ $circle1 == true ? '' : 'disabled' }}
                    class="btn btn-primary w-full form-group {{ $panel == 2 ? '' : 'btn-outline' }}"
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
                <button type="button" {{ $circle2 == true ? '' : 'disabled' }}
                    class="btn btn-primary w-full form-group {{ $panel == 3 ? '' : 'btn-outline' }}"
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
                <button type="button" {{ $circle3 == true ? '' : 'disabled' }}
                    class="btn btn-primary w-full form-group {{ $panel == 4 ? '' : 'btn-outline' }}"
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
                <button type="button" {{ $circle4 == true ? '' : 'disabled' }}
                    class="btn btn-primary w-full form-group {{ $panel == 5 ? '' : 'btn-outline' }}"
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
            <div class="{{ $status == 1 ? '' : 'd-none' }}">
                <button type="button" class="w-full form-group btn btn-secondary" onclick="submit_prototype(1)"
                    >บันทึกแบบร่าง</button>
                <button type="button" class="w-full form-group btn btn-success"
                    onclick="submit_prototype(2)" {{ $show ? '' : 'disabled' }}>บันทึกส่งตรวจสอบ</button>
                <button type="button" class="w-full form-group btn btn-danger"
                    onclick="button_function()">ยกเลิก</button>
            </div>
        </div>
        <div class="form-group col-md-10 panel">
            <div class="panel-body container-fluid">
                <div class="row">
                    <div class="col-md-12 form-group text-center">
                    </div>
                </div>
                {{ Form::open([
                    'wire:submit.prevent' => 'submit()',
                    'autocomplete' => 'off',
                    'class' => 'form-horizontal fv-form fv-form-bootstrap4',
                ]) }}
                <div class="pearls row form-group">
                    <div class="pearl col-3 current {{ $status >= 1 ? 'active' : 'disabled' }}" aria-expanded="true">
                        <div class="pearl-icon"><i class="icon wb-clipboard" aria-hidden="true"></i></div>
                        <span class="pearl-title">บันทึกคำขอ</span>
                    </div>
                    <div class="pearl col-3 current {{ $status >= 2 ? 'active' : 'disabled' }}" aria-expanded="false">
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
                                <i class="icon wb-time" aria-hidden="true"></i>
                            @endif
                        </div>
                        <span class="pearl-title">
                            ผลการพิจารณาคำขอ
                        </span>
                    </div>
                    <div class="pearl col-3 current {{ $status >= 5 ? 'active' : 'disabled' }}" aria-expanded="false">
                        <div class="pearl-icon"><i class="icon fa-send" aria-hidden="true"></i></div>
                        <span class="pearl-title">เสนองบ</span>
                    </div>
                </div>
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
                            {{ Form::select('req_year', $fiscalyear_list, $req_year, [
                                'onchange' => 'setValue("req_year",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกปีงบประมาณ--',
                            ]) }}
                            @error('req_year')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">หน่วยงาน</label>
                            <input type="text" class="form-control" value="{{ $req_dept }}" disabled>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">วันที่ใบคำขอ </label>
                            <input type="text" class="form-control" value="{{ datetoview($created_at) }}"
                                disabled>
                        </div>
                    </div>
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
                            {{ Form::select('req_coursegroup', $coursegroup_list, $req_coursegroup, [
                                // 'wire:change' => 'changeCoursegroup($event.target.value)',
                                'onchange' => 'setValue("req_coursegroup", event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกกลุ่มหลักสูตร--',
                            ]) }}
                            @error('req_coursegroup')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">

                        <div class="col-md-3">
                            <label class="form-control-label">กลุ่มสาขาอาชีพ
                            </label>
                            {{ Form::select('req_coursesubgroup', $coursesubgroup_list, $req_coursesubgroup, [
                                'onchange' => 'setValue("req_coursesubgroup", event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกกลุ่มสาขาอาชีพ--',
                            ]) }}
                        </div>
                        @error('req_coursesubgroup')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">ประเภทหลักสูตร
                            </label>
                            {{ Form::select('req_coursetype', $coursetype_list, $req_coursetype, [
                                'onchange' => 'setValue("req_coursetype", event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--ประเภทหลักสูตร--',
                            ]) }}
                        </div>
                    </div>
                    <div class="row form-group">

                        <div class="col-md-3">
                            <label class="form-control-label">หลักสูตร
                            </label>
                            {{ Form::select('req_course', $course_list, $req_course, [
                                'onchange' => 'setValue("req_course", event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกหลักสูตร--',
                            ]) }}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label class="form-control-label">ชื่อกิจกรรม <span class="text-danger">*</span></label>
                            {{ Form::text('req_shortname', $req_shortname, [
                                'wire:model' => 'req_shortname',
                                'class' => 'form-control',
                                'placeholder' => 'ชื่อกิจกรรม',
                            ]) }}
                        </div>
                    </div>
                    <div class="row form-group">

                        <div class="col-md-6">
                            <label class="form-control-label">รายละเอียดกิจกรรม <span
                                    class="text-danger">*</span></label>
                            <textarea rows="6" class="form-control" wire:model="req_desc" placeholder="รายละเอียดกิจกรรม"></textarea>
                            @error('req_desc')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label class="form-control-label">หมายเหตุ </label>
                            <textarea rows="6" class="form-control" wire:model="req_remark" placeholder="หมายเหตุ"></textarea>
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
                            {{ Form::select('req_buildtypeid', $buildingtype_list, $req_buildtypeid, [
                                'onchange' => 'setValue("req_buildtypeid",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกประเภทสถานที่--',
                            ]) }}
                            @error('req_buildtypeid')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">ชื่อสถานที่ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="ชื่อสถานที่"
                                wire:model="req_buildname">
                            @error('req_buildname')
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
                            ]) }}
                            @error('building_long')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div id="map" style="height: 450px; width: 100%" wire:ignore></div>
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
                            {{ Form::select('req_district', $amphur_list, $req_district, [
                                'onchange' => 'setValue("req_district",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกอำเภอ--',
                            ]) }}
                            @error('req_district')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="form-control-label">ตำบล <span class="text-danger">*</span></label>
                            {{ Form::select('req_subdistrict', $tambon_list, $req_subdistrict, [
                                'onchange' => 'setValue("req_subdistrict",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกตำบล--',
                            ]) }}
                            @error('req_subdistrict')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="form-control-label">หมู่ที่ </label>
                            <input type="text" class="form-control" placeholder="หมู่ที่" wire:model="req_moo">
                            @error('req_moo')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-5 form-group">
                            <label class="form-control-label">ชื่อชุมชน </label>
                            <input type="text" class="form-control" placeholder="ชื่อชุมชน"
                                wire:model="req_commu">
                            @error('req_commu')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">ชื่อผู้นำชุมชน</label>
                            <input type="text" class="form-control" placeholder="ข้อมูลผู้นำชุมชน"
                                wire:model="req_leadname">
                            @error('req_leadname')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="form-control-label">ตำแหน่งผู้นำชุมชน</label>
                            <input type="text" class="form-control" placeholder="ตำแหน่งผู้นำชุมชน"
                                wire:model="req_position">
                            @error('req_position')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-5">
                            <label class="form-control-label">ข้อมูลผู้นำชุมชน</label>
                            <textarea rows="4" class="form-control" wire:model="req_leadinfo" placeholder="ข้อมูลผู้นำชุมชน"></textarea>
                            @error('req_leadinfo')
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
                                onchange="setDatePicker('stdate', event.target.value)" placeholder="เดือนที่เริ่ม">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="icon wb-calendar" aria-hidden="true"></i>
                                </span>
                            </div>
                            @error('stdate')
                                <label class="input-group text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label text-left">เดือนที่สิ้นสุด <span class="text-danger">*</span></label>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control datepicker" data-date-language="th-th"
                                onchange="setDatePicker('endate', event.target.value)" placeholder="เดือนที่สิ้นสุด">
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
                        <label class="col-md-2 form-control-label text-left">จำนวนคน <span
                                class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::number('req_numofpeople', null, [
                                'wire:model' => 'req_numofpeople',
                                'wire:change' => 'setnum("req_numofpeople",$event.target.value)',
                                'min' => 0,

                                'id' => 'req_numofpeople',
                                'class' => 'form-control',
                            ]) }}
                            @error('req_numofpeople')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label text-left">จำนวนวิทยากร <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::number('req_numlecturer', null, [
                                'wire:model' => 'req_numlecturer',
                                'wire:change' => 'setnum("req_numlecturer",$event.target.value)',
                                'min' => 0,

                                'id' => 'req_numlecturer',
                                'class' => 'form-control',
                            ]) }}
                            @error('req_numlecturer')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label text-left">จำนวนวันจัดกิจกรรม <span
                                class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::number('req_numofday', null, [
                                'wire:model' => 'req_numofday',
                                'wire:change' => 'setnum("req_numofday",$event.target.value)',
                                'min' => 0,

                                'id' => 'req_numofday',
                                'class' => 'form-control',
                            ]) }}
                            @error('req_numofday')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label text-left">อัตราค่าอาหาร <span
                                class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::number('req_foodrate', null, [
                                'wire:model' => 'req_foodrate',
                                'wire:change' => 'calsum("req_foodrate",$event.target.value)',
                                'min' => 0,

                                'id' => 'req_foodrate',
                                'class' => 'form-control',
                            ]) }}
                            @error('req_foodrate')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label text-left">ค่าอาหาร <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            {{ Form::text('req_amtfood', number_format($req_amtfood, 2), ['class' => 'form-control text-right', 'disabled']) }}
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
                            {{ Form::text('req_materialrate', null, [
                                'wire:model' => 'req_materialrate',
                                'wire:change' => 'calsum("req_materialrate",$event.target.value)',
                                'onkeyup' => 'javascript:controlnumbers( this )',

                                'id' => 'req_materialrate',
                                'class' => 'form-control',
                            ]) }}
                            @error('req_materialrate')
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
                    <div class="form-group row pt-4 pb-1 col-12 bg-info">
                        <label class="col-md-10 form-control-label text-right">
                            <h4><b>ค่าใช้จ่ายรวม</b></h4>
                        </label>
                        <div class="col-md-2">
                            {{ Form::text('req_amount', number_format($req_amount, 2), ['class' => 'form-control text-right', 'disabled']) }}
                        </div>
                    </div>
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
                        {{-- <div class="col-md-2"></div> --}}
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
            <br>
        </div>
    </div>
</div>

@push('js')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
        integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
        integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        document.addEventListener('livewire:load', function() {
            $('.select2').select2();
            init_leaflet_Map();

            Livewire.on('emits', () => {
                $('.select2').select2();

                leaflet_map.invalidateSize();

            });
        });

        function calsum(cal) {
            @this.calsum(cal);
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
            leaflet_map = L.map('map').setView([14.992882255673587, 100.9017413330078], 6);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(leaflet_map);
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

        function setDatePicker(name, val) {
            @this.set(name, val);
            @this.setArray();
        }

        function setValue(name, val) {
            @this.set(name, val);
        }

        $(".datepicker").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

        window.onload = function() {
            // test = {{ json_encode($req_number) }};
            Livewire.on('popup', ($req_number) => {
                swal({
                        title: "บันทึกแบบร่างสำเร็จ \n เลขที่ใบคำขอ " + $req_number,
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.livewire.emit('redirect-to');
                        }
                    });
            });
        }

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
            var title = "ยืนยันการ บันทึกข้อมูลโครงการ ?";
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
    </script>
@endpush
