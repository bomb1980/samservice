<div>
    <br>
    <div class="row">
        <div class="col-md-2 form-group">
            <div>
                <button type="button" class="btn btn-primary w-full form-group {{ $panel == 1 ? '' : 'btn-outline' }}"
                    wire:click="changPanel(1)">ข้อมูลใบคำขอ
                    @if ($circle1 == true)
                            <span style="float:right" class="dot-checkmark text-center">
                                <i></i>
                            </span>
                    @elseif ($alert1 == true)
                            <span class="text-center">
                                <i class="icon wb-alert" aria-hidden="true" style="color:red;float:right"></i>
                            </span>
                    @endif
                </button>
                <button type="button" {{ $circle1 == true ? '' : 'disabled' }} class="btn btn-primary w-full form-group {{ $panel == 2 ? '' : 'btn-outline' }}"
                    wire:click="changPanel(2)">ข้อมูลกิจกรรม
                    @if ($circle2 == true)
                        <span style="float:right" class="dot-checkmark text-center">
                            <i></i>
                        </span>
                    @elseif ($alert2 == true)
                        <span class="text-center">
                            <i class="icon wb-alert" aria-hidden="true" style="color:red;float:right"></i>
                        </span>
                    @endif
                </button>
                <button type="button" {{ $circle2 == true ? '' : 'disabled' }} class="btn btn-primary w-full form-group {{ $panel == 3 ? '' : 'btn-outline' }}"
                    wire:click="changPanel(3)">พื้นที่ดำเนินการ
                    @if ($circle3 == true)
                        <span style="float:right" class="dot-checkmark text-center">
                            <i></i>
                        </span>
                    @elseif ($alert3 == true)
                        <span class="text-center">
                            <i class="icon wb-alert" aria-hidden="true" style="color:red;float:right"></i>
                        </span>
                    @endif
                </button>
                <button type="button" {{ $circle3 == true ? '' : 'disabled' }} class="btn btn-primary w-full form-group {{ $panel == 4 ? '' : 'btn-outline' }}"
                    wire:click="changPanel(4)">ค่าใช้จ่าย
                    @if ($circle4 == true)
                        <span style="float:right" class="dot-checkmark text-center">
                            <i></i>
                        </span>
                    @elseif ($alert4 == true)
                        <span class="text-center">
                            <i class="icon wb-alert" aria-hidden="true" style="color:red;float:right"></i>
                        </span>
                    @endif
                </button>
                <button type="button" {{ $circle4 == true ? '' : 'disabled' }} class="btn btn-primary w-full form-group {{ $panel == 5 ? '' : 'btn-outline' }}"
                    wire:click="changPanel(5)">แนบไฟล์
                    @if ($circle5 == true)
                    <span style="float:right" class="dot-checkmark text-center">
                        <i></i>
                    </span>
                @endif
                </button>
            </div>
            <br>
            <hr>
            <br>
            <div class="{{ $status == 1 ? '' : 'd-none' }}">
                <button type="button" class="w-full form-group btn btn-success"
                    onclick="submit_prototype(1)">บันทึกแบบร่างยืนยันความพร้อม</button>
                <button type="button" class="w-full form-group btn btn-danger"
                    onclick="button_function()">ยกเลิก</button>
            </div>
            <div class="{{ $status != 1 ? '' : 'd-none' }}">
                <button type="button" class="w-full form-group btn btn-default" disabled>
                    @if ($status == 2)
                        ยืนยันความพร้อม
                    @elseif ($status == 3)
                        @if ($act_plan_adjust_status >= 1)
                            ปรับแผน
                        @else
                            จัดสรรโอนเงิน
                        @endif
                    @else
                        ดำเนินกิจกรรม
                    @endif
                </button>
            </div>
        </div>
        <div class="form-group col-md-10 panel">
            <div class="panel-body container-fluid">
                <div class="pearls row form-group">
                    <div class="pearl col-3 current {{ $status >= 1 ? 'active' : 'disabled' }}" aria-expanded="true">
                        <div class="pearl-icon"><i class="icon wb-clipboard" aria-hidden="true"></i></div>
                        <span class="pearl-title">บันทึกแบบร่างยืนยันความพร้อม</span>
                        @if ($dateshow1)
                            <small class="text-danger col-md-12">({{ $dateshow1 }})</small>
                        @endif
                    </div>
                    <div class="pearl col-2 current {{ $status >= 2 ? 'active' : 'disabled' }}" aria-expanded="false">
                        <div class="pearl-icon"><i class="icon wb-check" aria-hidden="true"></i></div>
                        <span class="pearl-title">ยืนยันความพร้อม</span>
                        @if ($dateshow2)
                            <small class="text-danger col-md-12">({{ $dateshow2 }})</small>
                        @endif
                    </div>
                    <div class="pearl col-3 current {{ $status >= 3 ? 'active' : 'disabled' }}" aria-expanded="false">
                        <div class="pearl-icon"><i class="icon wb-payment" aria-hidden="true"></i></div>
                        <span class="pearl-title">จัดสรรโอนเงิน</span>
                        @if ($dateshow3)
                            <small class="text-danger col-md-12">({{ $dateshow3 }})</small><br>
                            <small class="text-danger col-md-12">(จำนวนการปรับแผน {{ $countnumstatus }} ครั้ง)</small>
                        @endif
                    </div>
                    <div class="pearl col-2 current {{ $status > 3 ? 'active' : 'disabled' }}" aria-expanded="false">
                        <div class="pearl-icon"><i class="icon wb-calendar" aria-hidden="true"></i></div>
                        <span class="pearl-title">ดำเนินกิจกรรม</span>
                    </div>
                </div>
                <br>
                {{ Form::open([
                    'wire:submit.prevent' => 'submit()',
                    'autocomplete' => 'off',
                    'class' => 'form-horizontal fv-form fv-form-bootstrap4',
                ]) }}
                <div class="{{ $panel == 1 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label><b><u>ข้อมูลใบคำขอ</u></b></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="">ปีงบประมาณ</label>
                            {{ Form::select('act_year', $fiscalyear_list, $act_year, [
                                'onchange' => 'setValue("act_year",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกปีงบประมาณ--',
                                'disabled' => true,
                            ]) }}
                            @error('act_year')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="">หน่วยงาน</label>
                            <input type="text" class="form-control" value="{{$act_dept}}" disabled>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="">เลขที่ใบคำขอ</label>
                            <input type="text" class="form-control" value="{{ $act_number }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <label for="">วันที่ใบคำขอ</label>
                            <input type="text" class="form-control" value="{{ datetoview($created_at) }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="{{ $panel == 2 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label><b><u>ข้อมูลกิจกรรม</u></b></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="">ประเภทกิจกรรม</label>
                            {{ Form::select('acttye_id', $acttye_list, $acttye_id, [
                                'onchange' => 'setValue("acttye_id",event.target.value)',
                                'class' => 'form-control select2',
                                'disabled',
                            ]) }}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="">ชื่อกิจกรรม</label>
                            <input type="text" class="form-control" wire:model="act_shortname" placeholder="ชื่อกิจกรรม" {{ $status == 1 ? '' : 'disabled' }}></textarea>
                            @error('act_shortname')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="">รายละเอียดกิจกรรม</label>
                            <textarea rows="4" class="form-control" wire:model="act_desc" placeholder="รายละเอียดกิจกรรม" {{ $status == 1 ? '' : 'disabled' }}>></textarea>
                            @error('act_desc')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="">หมายเหตุ</label>
                            <textarea rows="4" class="form-control" wire:model="act_remark" placeholder="หมายเหตุ" {{ $status == 1 ? '' : 'disabled' }}>></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="">ประเภทความเดือดร้อน</label>
                            {{ Form::select('act_troubletype', $troubletype_list, $act_troubletype, [
                                'onchange' => 'setValue("act_troubletype",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกประเภทความเดือดร้อน--',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_troubletype')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-12">จำนวนประชาชนในพื้นที่ ที่ได้รับประโยชน์</label>
                        <div class="col-md-2 form-group">
                            <input type="number" min="1" oninput = "validity.valid||(value='')" class="form-control" placeholder="ตัวเลขจำนวน" wire:model="act_peopleno" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_peopleno')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label><b><u>สถานที่ดำเนินการ</u></b></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="">ประเภทสถานที่</label>
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
                        <div class="col-md-4">
                            <label for="">ชื่อสถานที่</label>
                            <input type="text" class="form-control" placeholder="ชื่อสถานที่" wire:model="act_buildname" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_buildname')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 form-group">
                            <label for="">พิกัดแผนที่ ละติจูด</label>
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
                        <div class="col-md-3 form-group">
                            <label for="">พิกัดแผนที่ ลองติจูด</label>
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
                    <div id="map" style="height: 400px; width: 100%" wire:ignore></div>
                    <hr>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label><b><u>ขนาดพื้นที่ดำเนินการ</u></b></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="">รูปแบบการวัดพื้นที่</label>
                            {{ Form::select('act_measure', $patternarea_list, $act_measure, [
                                'onchange' => 'setValue("act_measure",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกรูปแบบการวัดพื้นที่--',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_measure')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group {{ $act_measure != 2 ? 'd-none' : '' }}">
                        <div class="col-md-2">
                            <label for="">หน่วยระยะทาง</label>
                            {{ Form::select('act_metric', $unit_list, $act_metric, [
                                'onchange' => 'setValue("act_metric",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกหน่วยระยะทาง--',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_metric')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="">กว้าง</label>
                            <input type="number" min="1" oninput = "validity.valid||(value='')" class="form-control" placeholder="กว้าง"
                            wire:model="act_width" {{ $status == 1 ? '' : 'disabled' }}>
                             @error('act_width')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="">ยาว</label>
                            <input type="number" min="1" oninput = "validity.valid||(value='')" class="form-control" placeholder="ยาว"
                            wire:model="act_length" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_length')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="">ลึก</label>
                            <input type="number" min="1" oninput = "validity.valid||(value='')" class="form-control" placeholder="ลึก"
                            wire:model="act_height" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_height')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="">ปริมาตร </label>
                                {{ Form::number('act_unit', null, [
                                    'wire:model' => 'act_unit',
                                    'id' => 'act_unit',
                                    'class' => 'form-control',
                                    'disabled',
                                ]) }}
                        </div>
                    </div>
                    <div class="row form-group {{ $act_measure != 3 ? 'd-none' : '' }}">
                        <div class="col-md-2">
                            <label for="">หน่วยระยะทาง</label>
                            {{ Form::select('act_metric', $unit_list, $act_metric, [
                                'onchange' => 'setValue("act_metric",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกหน่วยระยะทาง--',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_metric')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="">กว้าง</label>
                            <input type="number" min="1" oninput = "validity.valid||(value='')" class="form-control" placeholder="กว้าง"
                            wire:model="act_width" {{ $status == 1 ? '' : 'disabled' }}>
                             @error('act_width')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="">ยาว</label>
                            <input type="number" min="1" oninput = "validity.valid||(value='')" class="form-control" placeholder="ยาว"
                            wire:model="act_length" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_length')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="">ตารางเมตร/ตารางกิโลเมตร</label>
                                {{ Form::number('act_unit', null, [
                                    'wire:model' => 'act_unit',
                                    'id' => 'act_unit',
                                    'class' => 'form-control',
                                    'disabled',
                                ]) }}
                        </div>
                    </div>
                </div>

                <div class="{{ $panel == 3 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label><b><u>พื้นที่ดำเนินการโครงการ</u></b></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 form-group">
                            <label for="">จังหวัด</label>
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
                            <label for="">อำเภอ</label>
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
                            <label for="">ตำบล</label>
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
                            <label for="">หมู่ที่</label>
                            <input type="text" class="form-control" placeholder="หมู่" wire:model="act_moo" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_moo')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-5 form-group">
                            <label for="">ชื่อชุมชน</label>
                            <input type="text" class="form-control" placeholder="ชื่อชุมชน"
                                wire:model="act_commu" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_commu')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="">ชื่อผู้นำชุมชน</label>
                            <input type="text" class="form-control" placeholder="ข้อมูลผู้นำชุมชน"
                                wire:model="act_leadname" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_leadname')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="">ตำแหน่งผู้นำชุมชน</label>
                            <input type="text" class="form-control" placeholder="ตำแหน่งผู้นำชุมชน"
                                wire:model="act_position" {{ $status == 1 ? '' : 'disabled' }}>
                            @error('act_position')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-5">
                            <label for="">ข้อมูลผู้นำชุมชน</label>
                            <textarea rows="4" class="form-control" wire:model="act_leadinfo" placeholder="ข้อมูลผู้นำชุมชน" {{ $status == 1 ? '' : 'disabled' }}></textarea>
                            @error('act_leadinfo')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="{{ $panel == 4 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label><b><u>ค่าใช้จ่าย</u></b></label>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="">เดือนที่เริ่ม</label>
                            <div class="input-group">
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
                        </div>
                        <div class="col-md-3">
                            <label for="">เดือนที่สิ้นสุด</label>
                            <div class="input-group">
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
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 form-group">
                            <label for="">จำนวนวันดำเนินการ</label>
                            {{ Form::number('act_numofday', null, [
                                'wire:model' => 'act_numofday',
                                'wire:change' => 'setnum("act_numofday",$event.target.value)',
                                'min' => 1,

                                'id' => 'act_numofday',
                                'class' => 'form-control text-right',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_numofday')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="">จำนวน (คน)</label>
                            {{ Form::number('act_numofpeople', null, [
                                'wire:model' => 'act_numofpeople',
                                'wire:change' => 'setnum("act_numofpeople",$event.target.value)',
                                'min' => 1,

                                'id' => 'act_numofpeople',
                                'class' => 'form-control text-right',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_numofpeople')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 form-group">
                            <label for="">อัตราค่าตอบแทน ต่อคนต่อวัน</label>
                            {{ Form::number('act_rate', null, [
                                'wire:model' => 'act_rate',
                                'wire:change' => 'setnum("act_rate",$event.target.value)',
                                'min' => 1,

                                'id' => 'act_rate',
                                'class' => 'form-control text-right',
                                'disabled' => $formdisabled,
                            ]) }}
                            @error('act_rate')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row pt-4 pb-1 bg-info rounded">
                        <div class="col-md-9">
                        </div>
                        <label class="col-md-1 form-control-label text-right">
                            <label><b>ค่าใช้จ่ายรวม</b></label>
                        </label>
                        <div class="col-md-2">
                            {{ Form::text('act_amount', number_format($act_amount, 2), ['class' => 'form-control text-right', 'disabled']) }}
                        </div>
                    </div>
                </div>

                <div class="{{ $panel == 5 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label><b><u>แนบไฟล์</u></b></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="input-group col-md-5 input-group-file" data-plugin="inputGroupFile">
                            <input type="text" class="form-control" readonly="">
                            <!-- <div class="input-group-append"> -->
                            <button class="btn bg-blue-grey-300 btn-file"
                                {{ $status == 1 ? '' : 'disabled' }}>
                                <i class="icon wb-file" aria-hidden="true"></i>
                                เลือกไฟล์
                                <input type="file" wire:model="files"
                                    accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf"
                                    {{ $status == 1 ? '' : 'disabled' }}>
                            </button>
                            <br>
                            @error('files')
                                <small class="text-danger col-md-12">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-success offset-md-1" wire:click="submit_file_array"
                                {{ $files == null ? 'disabled' : '' }}>
                                <i class="icon wb-upload" aria-hidden="true"></i> อัพโหลดไฟล์
                            </button>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-9">
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
                                                    title="คลิกเพื่อดาวน์โหลด" download>{{ $val['files_ori'] }}</a></td>
                                            <td>{!! showMimeIcon($val['files_type']) !!}</td>
                                            <td>
                                                @if ($formdisabled != true)
                                                <button type="button" class="btn btn-danger" onclick="destroy_old_array({{ $key }})"><i class="icon wb-trash"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach ($file_array as $key => $val)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-left">{{ $val->getClientOriginalName() }}</td>
                                            <td>{!! showMimeIcon($val->getMimeType()) !!}</td>
                                            <td><button type="button" class="btn btn-danger" onclick="destroy_array({{ $key }})"><i class="icon wb-trash"></i></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
</div>

@push('js')
    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>

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
            if(@this.building_lat || @this.building_long){
                leaflet_map = L.map('map').setView([@this.building_lat, @this.building_long], 6);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(leaflet_map);

                var latlng = new L.LatLng(@this.building_lat, @this.building_long);
                addMarker(latlng);
            }else{
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

        function addMarker(e){
            var latlng = e.latlng;
            if(e.latlng == undefined || e.latlng == null){
                latlng = e;
            }
            // Add marker to map at click location
            let n = 0;// number of maker - 1

            if(newMarker.length >= n+1){
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
            // if(name == 'stdate' || name = "endate"){
            //     @this.setArray();
            // }
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
                var title = "ยืนยันการ บันทึกแบบร่าง ?";
            }else{
                var title = "ยืนยันการ บันทึกยืนยันความพร้อม ?";
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
    </script>
@endpush

