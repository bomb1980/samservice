<div class="form-horizontal fv-form fv-form-bootstrap4">
    <div class="panel">
        <div class="panel-body container-fluid">
            <div class="row form-group">
                <div class="col-md-2 form-control-label">
                    <label>
                        <h4><b><u>ข้อมูลใบคำขอ</u></b></h4>
                    </label>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-2 form-control-label">ปีงบประมาณ </label>
                <div class="col-md-3">
                    {{ Form::select('req_year', $fiscalyear_list, $req_year, [
                        'onchange' => 'setValue("req_year",event.target.value)',
                        'class' => 'form-control select2',
                        'placeholder' => '--เลือกปีงบประมาณ--',
                        'disabled' => true,
                    ]) }}
                    @error('req_year')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-2 form-control-label">หน่วยงาน </label>
                <div class="col-md-3">
                    <input type="text" class="form-control" value="{{ $req_dept }}" disabled>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-2 form-control-label">เลขที่ใบคำขอ </label>
                <div class="col-md-3">
                    <input type="text" class="form-control" value="{{ $req_number }}" disabled>
                </div>

                <label class="col-md-2 form-control-label">วันที่ใบคำขอ </label>
                <div class="col-md-3">
                    <input type="text" class="form-control" value="{{ datetoview($created_at) }}" disabled>
                </div>
            </div>
            <hr>
            @if ($req_acttype == 1)
                <div class="row form-group">
                    <div class="col-md-2 form-control-label">
                        <label>
                            <h4><b><u>ข้อมูลกิจกรรม</u></b></h4>
                        </label>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ประเภทกิจกรรม </label>
                    <div class="col-md-3">
                        {{ Form::select('req_acttype', $acttye_list, $req_acttype, [
                            'onchange' => 'setValue("req_acttype",event.target.value)',
                            'class' => 'form-control select2',
                            'disabled',
                        ]) }}
                    </div>

                    <label class="col-md-2 form-control-label">ชื่อกิจกรรม</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="ชื่อกิจกรรม" wire:model="req_shortname"
                            disabled>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">รายละเอียดกิจกรรม </label>
                    <div class="col-md-6">
                        <textarea rows="6" class="form-control" wire:model="req_desc" placeholder="รายละเอียดกิจกรรม" disabled></textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">หมายเหตุ </label>
                    <div class="col-md-6">
                        <textarea rows="2" class="form-control" wire:model="req_remark" placeholder="หมายเหตุ" disabled></textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ประเภทกิจกรรม </label>
                    <div class="col-md-3">
                        {{ Form::select('req_troubletype', $troubletype_list, $req_troubletype, [
                            'onchange' => 'setvalue("req_troubletype",event.target.value)',
                            'class' => 'form-control select2',
                            'disabled',
                        ]) }}
                    </div>

                    <label class="col-md-2 form-control-label">จำนวนประชาชนในพื้นที่<br>ที่ได้รับประโยชน์ </label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" wire:model="req_peopleno" disabled>
                    </div>

                </div>

                <div class="row form-group mt-4">
                    <label class="col-md-2 form-control-label">
                        <h4><b><u>สถานที่ดำเนินการ</u></b></h4>
                    </label>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ประเภทสถานที่ </label>
                    <div class="col-md-3">
                        {{ Form::select('req_buildtypeid', $buildingtype_list, $req_buildtypeid, [
                            'onchange' => 'setvalue("req_buildtypeid",event.target.value)',
                            'class' => 'form-control select2',
                            'disabled',
                        ]) }}
                    </div>

                    <label class="col-md-2 form-control-label">ชื่อสถานที่</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" wire:model="req_buildname" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">พิกัดแผนที่ละติจูด</label>
                    <div class="col-md-3">
                        {{ Form::text('building_lat', $building_lat, [
                            'wire:model' => 'building_lat',
                            'class' => 'form-control',
                            'placeholder' => 'พิกัดแผนที่ละติจูด',
                            'disabled' => true,
                        ]) }}
                        @error('building_lat')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <label class="col-md-2 form-control-label">พิกัดแผนที่ลองติจูด</label>
                    <div class="col-md-3">
                        {{ Form::text('building_long', $building_long, [
                            'wire:model' => 'building_long',
                            'class' => 'form-control',
                            'placeholder' => 'พิกัดแผนที่ลองติจูด',
                            'disabled' => true,
                        ]) }}
                        @error('building_long')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-8 offset-md-2">
                        <iframe width="100%" height="450"
                            src="https://maps.google.com/maps?q={{ $building_lat ?? 13.757093 }}, {{ $building_long ?? 100.555918 }}&hl=es;z=14&amp;output=embed"></iframe>
                    </div>
                </div>

                <br>
                <div class="row form-group mt-4">
                    <label class="col-md-2 form-control-label">
                        <h4><b><u>สถานที่ดำเนินการ</u></b></h4>
                    </label>
                </div>

                <div class="row form-group mt-4">
                    <label class="col-md-2 form-control-label">รูปแบบการวัดพื้นที่ </label>
                    <div class="col-md-3">
                        {{ Form::select('req_measure', $patternarea_list, $req_measure, [
                            'onchange' => 'setValue("req_measure",event.target.value)',
                            'class' => 'form-control select2',
                            'disabled',
                        ]) }}
                    </div>
                </div>

                <div class="row form-group {{ $req_measure > 1 ? '' : 'd-none' }}">
                    <label class="col-md-2 form-control-label">หน่วยระยะทาง </label>
                    <div class="col-md-3">
                        {{ Form::select('req_metric', $unit_list, $req_metric, [
                            'onchange' => 'setValue("req_metric",event.target.value)',
                            'class' => 'form-control select2',
                            'disabled',
                        ]) }}
                    </div>
                </div>

                <div class="row form-group {{ ($req_measure > 1 && $req_metric != null) ? '' : 'd-none' }}">
                    <label class="col-md-2 form-control-label">กว้าง </label>
                    <div class="col-md-3">
                        <input type="number" min="0" class="form-control" wire:model="req_width" disabled>
                    </div>
                    <label class="col-md-2 form-control-label">ยาว </label>
                    <div class="col-md-3">
                        <input type="number" min="0" class="form-control" wire:model="req_length" disabled>
                    </div>
                </div>

                <div class="row form-group {{ $req_measure == 2 && $req_metric == 1 ? '' : 'd-none' }}">
                    <label class="col-md-2 form-control-label">ลึก </label>
                    <div class="col-md-3">
                        <input type="number" min="0" class="form-control" wire:model="req_height" disabled>
                    </div>
                    <label class="col-md-2 form-control-label">ปริมาตร </label>
                    <div class="col-md-3">
                        {{ Form::number('req_unit', null, [
                            'wire:model' => 'req_unit',
                            'id' => 'req_unit',
                            'class' => 'form-control',
                            'disabled',
                        ]) }}
                    </div>
                </div>
                <div class="row form-group {{ ($req_measure == 2 && $req_metric == 2) ? '' : 'd-none' }}">
                    <label class="col-md-2 form-control-label">ลึก <span class="text-danger">*</span></label>
                    <div class="col-md-3">
                        <input type="number" min="0" class="form-control" wire:model="req_height" disabled>
                    </div>
                    <label class="col-md-2 form-control-label">ปริมาตร </label>
                    <div class="col-md-3">
                        {{ Form::number('req_unit', null, [
                            'wire:model' => 'req_unit',
                            'id' => 'req_unit',
                            'class' => 'form-control',
                            'disabled',
                        ]) }}
                    </div>
                </div>
                <div class="row form-group {{ ($req_measure == 3 && $req_metric == 1) ? '' : 'd-none' }}">
                    <label class="col-md-2 form-control-label">พื้นที่ (ตารางเมตร) </label>
                    <div class="col-md-3">
                        {{ Form::number('req_unit', null, [
                            'wire:model' => 'req_unit',
                            'id' => 'req_unit',
                            'class' => 'form-control',
                            'disabled',
                        ]) }}
                    </div>
                </div>
                <div class="row form-group {{ ($req_measure == 3 && $req_metric == 2) ? '' : 'd-none' }}">
                    <label class="col-md-2 form-control-label">พื้นที่ (ตารางกิโลเมตร) </label>
                    <div class="col-md-3">
                        {{ Form::number('req_unit', null, [
                            'wire:model' => 'req_unit',
                            'id' => 'req_unit',
                            'class' => 'form-control',
                            'disabled',
                        ]) }}
                    </div>
                </div>
                <hr>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">
                        <h4><b><u>พื้นที่ดำเนินการ</u></b></h4>
                    </label>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">จังหวัด</label>
                    <div class="col-md-3 form-group">
                        {{ Form::select('province_id', $province_list, $province_id, [
                            'onchange' => 'setValue("province_id",event.target.value)',
                            'class' => 'form-control select2',
                            'placeholder' => '--เลือกจังหวัด--',
                            'disabled' => true,
                        ]) }}
                        @error('province_id')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <label class="col-md-2 form-control-label">อำเภอ</label>
                    <div class="col-md-3 form-group">
                        {{ Form::select('req_district', $amphur_list, $req_district, [
                            'onchange' => 'setValue("req_district",event.target.value)',
                            'class' => 'form-control select2',
                            'placeholder' => '--เลือกอำเภอ--',
                            'disabled' => true,
                        ]) }}
                        @error('req_district')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ตำบล</label>
                    <div class="col-md-3 form-group">
                        {{ Form::select('req_subdistrict', $tambon_list, $req_subdistrict, [
                            'onchange' => 'setValue("req_subdistrict",event.target.value)',
                            'class' => 'form-control select2',
                            'placeholder' => '--เลือกตำบล--',
                            'disabled' => true,
                        ]) }}
                        @error('req_subdistrict')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <label class="col-md-2 form-control-label">หมู่ที่</label>
                    <div class="col-md-3 form-group">
                        <input type="text" class="form-control" placeholder="หมู่ที่" wire:model="req_moo"
                            disabled>
                        @error('req_moo')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ชื่อชุมชน</label>
                    <div class="col-md-3 form-group">
                        <input type="text" class="form-control" placeholder="ชื่อชุมชน" wire:model="req_commu"
                            disabled>
                        @error('req_commu')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ชื่อผู้นำชุมชน</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="ข้อมูลผู้นำชุมชน"
                            wire:model="req_leadname" disabled>
                        @error('req_leadname')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <label class="col-md-2 form-control-label">ตำแหน่งผู้นำชุมชน</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="ตำแหน่งผู้นำชุมชน"
                            wire:model="req_position" disabled>
                        @error('req_position')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ข้อมูลผู้นำชุมชน</label>
                    <div class="col-md-6">
                        <textarea rows="4" class="form-control" wire:model="req_leadinfo" placeholder="ข้อมูลผู้นำชุมชน" disabled></textarea>
                    </div>
                </div>

                <hr>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">
                        <h4><b><u>ค่าใช้จ่าย</u></b></h4>
                    </label>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">เดือนที่เริ่ม</label>
                    <div class="input-group col-md-3">
                        <input type="text" class="form-control datepicker" data-date-language="th-th"
                            onchange="setDatePicker('stdate', event.target.value)" value="{{ $stdate }}"
                            placeholder="เดือนที่เริ่ม" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <label class="col-md-2 form-control-label">เดือนที่สิ้นสุด</label>
                    <div class="input-group col-md-3">
                        <input type="text" class="form-control datepicker" data-date-language="th-th"
                            onchange="setDatePicker('endate', event.target.value)" value="{{ $endate }}"
                            placeholder="เดือนที่สิ้นสุด" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">จำนวนวันดำเนินการ</label>
                    <div class="col-md-3">
                        {{ Form::number('req_numofday', null, [
                            'wire:model' => 'req_numofday',
                            'id' => 'req_numofday',
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) }}
                        @error('req_numofday')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">จำนวนคน</label>
                    <div class="col-md-3">
                        {{ Form::number('req_numofpeople', null, [
                            'wire:model' => 'req_numofpeople',
                            'id' => 'req_numofpeople',
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) }}
                        @error('req_numofpeople')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <label class="col-md-2 form-control-label">อัตราค่าตอบแทน <br> ต่อวันต่อคน</label>
                    <div class="col-md-3">
                        {{ Form::number('course_trainer_rate', null, [
                            'wire:model' => 'course_trainer_rate',
                            'id' => 'course_trainer_rate',
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) }}
                        @error('course_trainer_rate')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <center>
                    <div class="form-group row pt-4 pb-1 col-8 bg-blue-500">
                        <label class="col-md-8 form-control-label text-left">
                            <h4><b>รวมเป็นเงิน</b></h4>
                        </label>
                        <div class="col-md-4">
                            {{ Form::text('req_amount', number_format($req_amount, 2), ['class' => 'form-control text-right', 'disabled']) }}
                            {{-- {{ Form::number('req_amount', null, [
                                'wire:model' => 'req_amount',
                                'id' => 'req_amount',
                                'class' => 'form-control text-right',
                                'disabled',
                            ]) }} --}}
                        </div>
                    </div>
                </center>
            @else
                <div class="row form-group">
                    <div class="col-md-2 form-control-label">
                        <label>
                            <h4><b><u>ข้อมูลกิจกรรม</u></b></h4>
                        </label>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ประเภทกิจกรรม </label>
                    <div class="col-md-3">
                        {{ Form::select('req_acttype', $acttye_list, $req_acttype, [
                            'onchange' => 'setValue("req_acttype",event.target.value)',
                            'class' => 'form-control select2',
                            'disabled',
                        ]) }}
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">กลุ่มหลักสูตร </label>
                    <div class="col-md-3">
                        {{ Form::select('req_coursegroup', $coursegroup_list, $req_coursegroup, [
                            // 'wire:change' => 'changeCoursegroup($event.target.value)',
                            'onchange' => 'setValue("req_coursegroup", event.target.value)',
                            'class' => 'form-control select2',
                            'placeholder' => '--เลือกกลุ่มหลักสูตร--',
                            'disabled' => true,
                        ]) }}
                    </div>
                    @error('req_coursegroup')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">กลุ่มสาขาอาชีพ </label>
                    <div class="col-md-3">
                        {{-- {{count($coursesubgroup_list)}} --}}
                        {{-- @if (count($coursesubgroup_list) > 0) --}}
                        {{ Form::select('req_coursesubgroup', $coursesubgroup_list, $req_coursesubgroup, [
                            // 'wire:change' => 'changeCoursesubgroup($event.target.value)',
                            'onchange' => 'setValue("req_coursesubgroup", event.target.value)',
                            'class' => 'form-control select2',
                            'placeholder' => '--เลือกกลุ่มสาขาอาชีพ--',
                            'disabled' => true,
                        ]) }}
                        {{-- @else
                {{ Form::select('req_coursesubgroup', ['--ไม่มีกลุ่มสาขาอาชีพ--'], null, ['class' => 'form-control', 'disabled']) }}
                   @endif --}}
                    </div>
                    @error('req_coursesubgroup')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ประเภทหลักสูตร</label>
                    <div class="col-md-3">
                        {{ Form::select('req_coursetype', $coursetype_list, $req_coursetype, [
                            'onchange' => 'setValue("req_coursetype", event.target.value)',
                            'class' => 'form-control select2',
                            'placeholder' => '--ประเภทหลักสูตร--',
                            'disabled' => true,
                        ]) }}
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">หลักสูตร </label>
                    <div class="col-md-3">
                        {{-- {{count($course_list)}} --}}
                        {{ Form::select('req_course', $course_list, $req_course, [
                            // 'wire:change' => 'changeCourse($event.target.value)',
                            'onchange' => 'setValue("req_course", event.target.value)',
                            'class' => 'form-control select2',
                            'placeholder' => '--เลือกหลักสูตร--',
                            'disabled' => true,
                        ]) }}
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ชื่อกิจกรรม </label>
                    <div class="col-md-6">
                        <textarea rows="4" class="form-control" wire:model="req_shortname" placeholder="ชื่อกิจกรรม" disabled></textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">รายละเอียดกิจกรรม </label>
                    <div class="col-md-6">
                        <textarea rows="6" class="form-control" wire:model="req_desc" placeholder="รายละเอียดกิจกรรม" disabled></textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">หมายเหตุ </label>
                    <div class="col-md-6">
                        <textarea rows="6" class="form-control" wire:model="req_remark" placeholder="หมายเหตุ" disabled></textarea>
                    </div>
                </div>
                <div class="row form-group mt-4">
                    <label class="col-md-2 form-control-label">
                        <h4><b><u>สถานที่จัดการอบรม</u></b></h4>
                    </label>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ประเภทสถานที่ </label>
                    <div class="col-md-3">
                        {{ Form::select('req_buildtypeid', $buildingtype_list, $req_buildtypeid, [
                            'onchange' => 'setValue("req_buildtypeid",event.target.value)',
                            'class' => 'form-control select2',
                            'placeholder' => '--เลือกประเภทสถานที่--',
                            'disabled' => true,
                        ]) }}
                        @error('req_buildtypeid')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ชื่อสถานที่</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="ชื่อสถานที่"
                            wire:model="req_buildname" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">พิกัดแผนที่ละติจูด</label>
                    <div class="col-md-3">
                        {{ Form::text('building_lat', $building_lat, [
                            'wire:model' => 'building_lat',
                            'class' => 'form-control',
                            'placeholder' => 'พิกัดแผนที่ละติจูด',
                            'disabled' => true,
                        ]) }}
                        @error('building_lat')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <label class="col-md-2 form-control-label">พิกัดแผนที่ลองติจูด</label>
                    <div class="col-md-3">
                        {{ Form::text('building_long', $building_long, [
                            'wire:model' => 'building_long',
                            'class' => 'form-control',
                            'placeholder' => 'พิกัดแผนที่ลองติจูด',
                            'disabled' => true,
                        ]) }}
                        @error('building_long')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-8 offset-md-2">
                        <iframe width="100%" height="450"
                            src="https://maps.google.com/maps?q={{ $building_lat ?? 13.757093 }}, {{ $building_long ?? 100.555918 }}&hl=es;z=14&amp;output=embed"></iframe>
                    </div>
                </div>
                <hr>

                <div class="row form-group">
                    <label class="col-md-2 form-control-label">
                        <h4><b><u>พื้นที่ดำเนินการโครงการ</u></b></h4>
                    </label>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">จังหวัด</label>
                    <div class="col-md-3 form-group">
                        {{ Form::select('province_id', $province_list, $province_id, [
                            'onchange' => 'setValue("province_id",event.target.value)',
                            'class' => 'form-control select2',
                            'placeholder' => '--เลือกจังหวัด--',
                            'disabled' => true,
                        ]) }}
                        @error('province_id')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <label class="col-md-2 form-control-label">อำเภอ</label>
                    <div class="col-md-3 form-group">
                        {{ Form::select('req_district', $amphur_list, $req_district, [
                            'onchange' => 'setValue("req_district",event.target.value)',
                            'class' => 'form-control select2',
                            'placeholder' => '--เลือกอำเภอ--',
                            'disabled' => true,
                        ]) }}
                        @error('req_district')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ตำบล</label>
                    <div class="col-md-3 form-group">
                        {{ Form::select('req_subdistrict', $tambon_list, $req_subdistrict, [
                            'onchange' => 'setValue("req_subdistrict",event.target.value)',
                            'class' => 'form-control select2',
                            'placeholder' => '--เลือกตำบล--',
                            'disabled' => true,
                        ]) }}
                        @error('req_subdistrict')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <label class="col-md-2 form-control-label">หมู่ที่</label>
                    <div class="col-md-3 form-group">
                        <input type="text" class="form-control" placeholder="หมู่ที่" wire:model="req_moo"
                            disabled>
                        @error('req_moo')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ชื่อชุมชน</label>
                    <div class="col-md-3 form-group">
                        <input type="text" class="form-control" placeholder="ชื่อชุมชน" wire:model="req_commu"
                            disabled>
                        @error('req_commu')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ชื่อผู้นำชุมชน</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="ข้อมูลผู้นำชุมชน"
                            wire:model="req_leadname" disabled>
                        @error('req_leadname')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <label class="col-md-2 form-control-label">ตำแหน่งผู้นำชุมชน</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="ตำแหน่งผู้นำชุมชน"
                            wire:model="req_position" disabled>
                        @error('req_position')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">ข้อมูลผู้นำชุมชน</label>
                    <div class="col-md-6">
                        <textarea rows="4" class="form-control" wire:model="req_leadinfo" placeholder="ข้อมูลผู้นำชุมชน" disabled></textarea>
                    </div>
                </div>
                <hr>

                <div class="row form-group">
                    <label class="col-md-2 form-control-label">
                        <h4><b><u>ค่าใช้จ่าย</u></b></h4>
                    </label>
                </div>
                <div class="row form-group">
                    <label class="col-md-2 form-control-label">เดือนที่เริ่ม</label>
                    <div class="input-group col-md-3">
                        <input type="text" class="form-control datepicker" data-date-language="th-th"
                            onchange="setDatePicker('stdate', event.target.value)" value="{{ $stdate }}"
                            placeholder="เดือนที่เริ่ม" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <label class="col-md-2 form-control-label">เดือนที่สิ้นสุด</label>
                    <div class="input-group col-md-3">
                        <input type="text" class="form-control datepicker" data-date-language="th-th"
                            onchange="setDatePicker('endate', event.target.value)" value="{{ $endate }}"
                            placeholder="เดือนที่สิ้นสุด" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">จำนวนวันจัดกิจกรรม</label>
                    <div class="col-md-3">
                        {{ Form::number('req_numofday', null, [
                            'wire:model' => 'req_numofday',
                            'id' => 'req_numofday',
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) }}
                        @error('req_numofday')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <label class="col-md-2 form-control-label">ชั่วโมงกิจกรรม/วัน</label>
                    <div class="col-md-3">
                        {{ Form::number('req_hrperday', null, [
                            'wire:model' => 'req_hrperday',
                            'id' => 'req_hrperday',
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) }}
                        @error('req_hrperday')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">จำนวนคนร่วมกิจกรรม</label>
                    <div class="col-md-3">
                        {{ Form::number('req_numofpeople', null, [
                            'wire:model' => 'req_numofpeople',
                            'id' => 'req_numofpeople',
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) }}
                        @error('req_numofpeople')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">จำนวนวิทยากร</label>
                    <div class="col-md-3">
                        {{ Form::number('req_numlecturer', null, [
                            'wire:model' => 'req_numlecturer',
                            'id' => 'req_numlecturer',
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) }}
                        @error('req_numlecturer')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>

                <div class="row">
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
                                        <label class="form-control-label">ค่าอาหาร</label>
                                    </td>

                                    <td class="text-right">
                                        <label class="form-control-label">{{ number_format($req_foodrate, 2) }}</label>
                                    </td>

                                    <td class="text-center">
                                        <label class="form-control-label">{{ $req_numofday }} วัน /
                                            {{ $req_numofpeople }}
                                            คน</label>
                                    </td>

                                    <td class="text-right">
                                        <label class="form-control-label">{{ number_format($req_amtfood, 2) }}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <label class="form-control-label">ค่าตอบแทนวิทยากร</label>
                                    </td>

                                    <td class="text-right">
                                        <label class="form-control-label">{{ number_format($course_trainer_rate, 2) }}</label>
                                    </td>

                                    <td class="text-center">
                                        <label class="form-control-label">{{ $req_numofday }} วัน /
                                            {{ $req_numlecturer }}
                                            คน</label>
                                    </td>

                                    <td class="text-right">
                                        <label class="form-control-label">{{ number_format($course_trainer_amt, 2) }}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <label class="form-control-label">ค่าวัสดุ</label>
                                    </td>

                                    <td class="text-right">
                                        <label class="form-control-label">{{ number_format($req_materialrate, 2) }}</label>
                                    </td>

                                    <td class="text-center">
                                        <label class="form-control-label">{{ $req_numofday }} วัน /
                                            {{ $req_numofpeople }}
                                            คน</label>
                                    </td>

                                    <td class="text-right">
                                        <label class="form-control-label">{{ number_format($course_material_amt, 2) }}</label>
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td class="text-center">
                                        <label class="form-control-label">ค่าใช้จ่ายอื่นๆ</label>
                                    </td>

                                    <td class="text-center">

                                    </td>

                                    <td class="text-center">

                                    </td>

                                    <td class="text-right">
                                        <label class="form-control-label">{{ number_format($other_amt, 2) }}</label>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <center>
                    <div class="form-group row pt-4 pb-1 col-8 bg-blue-500">
                        <label class="col-md-8 form-control-label text-left">
                            <h4><b>รวมเป็นเงิน</b></h4>
                        </label>
                        <div class="col-md-4">
                            {{ Form::text('req_amount', number_format($req_amount, 2), ['class' => 'form-control text-right', 'disabled']) }}
                        </div>
                    </div>
                </center>
            @endif

            <hr>
            <div class="row form-group">
                <label class="col-md-2 form-control-label">
                    <h4><b><u>ไฟล์แนบ</u></b></h4>
                </label>
            </div>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8 table-responsive form-group">
                    <table class="table table-bordered table-hover table-striped w-full text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อไฟล์</th>
                                <th>ประเภทไฟล์</th>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="col-md-12 form-group text-center">
        @if ($disbutton)
            <button type="button" class="form-group btn btn-success"
                wire:click="submitapprove(3)">คุณสมบัติผ่าน</button>
            <button type="button" class="form-group btn btn-warning"
                wire:click="submitapprove(5)">ส่งคำขอกลับ</button>
            <button type="button" class="form-group btn btn-danger"
                wire:click="submitapprove(4)">คุณสมบัติไม่ผ่าน</button>

            <div class="row form-group">
                <label class="col-md-3 form-control-label"></label>
                <div class="col-md-6">
                    <textarea rows="4" class="form-control" wire:model="req_approvenote" placeholder="โปรดระบุเหตุผล"></textarea>
                    @error('req_approvenote')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
        @else
            @if ($status == 3)
            <label>
                <h3 style="color: #08B315"><b>คุณสมบัติผ่าน</b></h3>
            </label>
            @elseif ($status == 4)
            <label>
                <h3 style="color: red"><b>คุณสมบัติไม่ผ่าน</b></h3>
            </label>
                <div class="row form-group">
                    <label class="col-md-3 form-control-label"></label>
                    <div class="col-md-6">
                        <textarea rows="4" class="form-control" wire:model="req_approvenote" placeholder="โปรดระบุเหตุผล" disabled></textarea>
                        @error('req_approvenote')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
            @elseif ($status == 5)
            <label>
                <h3 style="color: #E8AE14"><b>ส่งคำขอกลับ</b></h3>
            </label>
                <div class="row form-group">
                    <label class="col-md-3 form-control-label"></label>
                    <div class="col-md-6">
                        <textarea rows="4" class="form-control" wire:model="req_approvenote" placeholder="โปรดระบุเหตุผล" disabled></textarea>
                        @error('req_approvenote')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>

@push('js')
    <script>
        Livewire.on('popup', () => {
            swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
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
    </script>
@endpush

