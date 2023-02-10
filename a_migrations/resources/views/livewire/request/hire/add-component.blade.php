<div>
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
            <div>
                <button type="button" class="w-full form-group btn btn-secondary"
                    onclick="submit_prototype(1)">บันทึกแบบร่าง</button>
                <button type="button"  {{ $button_enables == true ? '' : 'disabled' }} class="w-full form-group btn btn-success"
                    onclick="submit_prototype(2)">บันทึกส่งตรวจสอบ</button>
                <button type="button" class="w-full form-group btn btn-danger"
                    onclick="button_function()">ยกเลิก</button>
            </div>
            <div class="{{ $status != 1 ? '' : 'd-none' }}">
                <button type="button" class="w-full form-group btn btn-default" disabled>
                    @if ($status == 2)
                        รอพิจารณา
                    @elseif ($status == 3)
                        ผ่าน
                    @elseif ($status == 4)
                        ไม่ผ่าน
                    @elseif ($status == 5)
                        เสนองบ
                    @elseif ($status == 9)
                        ยกเลิก
                    @endif
                </button>
            </div>
        </div>
        <div class="form-group col-md-10 panel">
            <div class="panel-body container-fluid">
                <div class="pearls row form-group">
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

                <div class="{{ $panel == 1 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label><b><u>ข้อมูลใบคำขอ</u></b></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="">ปีงบประมาณ</label>
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
                            <label for="">หน่วยงาน</label>
                            <input type="text" class="form-control" value="{{$req_dept}}" disabled>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="">เลขที่ใบคำขอ</label>
                            <input type="text" class="form-control" wire:model="req_number" disabled>
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
                            <input type="text" class="form-control" wire:model="req_shortname" placeholder="ชื่อกิจกรรม"></textarea>
                            @error('req_shortname')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="">รายละเอียดกิจกรรม</label>
                            <textarea rows="4" class="form-control" wire:model="req_desc" placeholder="รายละเอียดกิจกรรม"></textarea>
                            @error('req_desc')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="">หมายเหตุ</label>
                            <textarea rows="4" class="form-control" wire:model="req_remark" placeholder="หมายเหตุ"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="">ประเภทความเดือดร้อน</label>
                            {{ Form::select('req_troubletype', $troubletype_list, $req_troubletype, [
                                'onchange' => 'setValue("req_troubletype",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกประเภทความเดือดร้อน--',
                            ]) }}
                            @error('req_troubletype')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-12">จำนวนประชาชนในพื้นที่ ที่ได้รับประโยชน์</label>
                        <div class="col-md-2 form-group">
                            <input type="number" min="1" oninput = "validity.valid||(value='')" class="form-control" placeholder="ตัวเลขจำนวน" wire:model="req_peopleno">
                            @error('req_peopleno')
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
                        <div class="col-md-4">
                            <label for="">ชื่อสถานที่</label>
                            <input type="text" class="form-control" placeholder="ชื่อสถานที่" wire:model="req_buildname">
                            @error('req_buildname')
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
                            {{ Form::select('req_measure', $patternarea_list, $req_measure, [
                                'onchange' => 'setValue("req_measure",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกรูปแบบการวัดพื้นที่--',
                            ]) }}
                            @error('req_measure')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group {{ $req_measure != 2 ? 'd-none' : '' }}">
                        <div class="col-md-2">
                            <label for="">หน่วยระยะทาง</label>
                            {{ Form::select('req_metric', $unit_list, $req_metric, [
                                'onchange' => 'setValue("req_metric",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกหน่วยระยะทาง--',
                            ]) }}
                            @error('req_metric')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="">กว้าง</label>
                            <input type="number" min="1" oninput = "validity.valid||(value='')" class="form-control" placeholder="กว้าง"
                            wire:model="req_width">
                             @error('req_width')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="">ยาว</label>
                            <input type="number" min="1" oninput = "validity.valid||(value='')" class="form-control" placeholder="ยาว"
                            wire:model="req_length">
                            @error('req_length')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="">ลึก</label>
                            <input type="number" min="1" oninput = "validity.valid||(value='')" class="form-control" placeholder="ลึก"  wire:model="req_height">
                            @error('req_height')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="">ปริมาตร </label>
                                {{ Form::number('req_unit', null, [
                                    'wire:model' => 'req_unit',
                                    'id' => 'req_unit',
                                    'class' => 'form-control',
                                    'disabled',
                                ]) }}
                        </div>
                    </div>
                    <div class="row form-group {{ $req_measure != 3 ? 'd-none' : '' }}">
                        <div class="col-md-2">
                            <label for="">หน่วยระยะทาง</label>
                            {{ Form::select('req_metric', $unit_list, $req_metric, [
                                'onchange' => 'setValue("req_metric",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกหน่วยระยะทาง--',
                            ]) }}
                            @error('req_metric')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="">กว้าง</label>
                            <input type="number" min="1" oninput = "validity.valid||(value='')" class="form-control" placeholder="กว้าง"
                            wire:model="req_width">
                             @error('req_width')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="">ยาว</label>
                            <input type="number" min="1" oninput = "validity.valid||(value='')" class="form-control" placeholder="ยาว"
                            wire:model="req_length">
                            @error('req_length')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="">ตารางเมตร/ตารางกิโลเมตร</label>
                                {{ Form::number('req_unit', null, [
                                    'wire:model' => 'req_unit',
                                    'id' => 'req_unit',
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
                            <label for="">ตำบล</label>
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
                            <label for="">หมู่ที่</label>
                            <input type="text" class="form-control" placeholder="หมู่" wire:model="req_moo">
                            @error('req_moo')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-5 form-group">
                            <label for="">ชื่อชุมชน</label>
                            <input type="text" class="form-control" placeholder="ชื่อชุมชน"
                                wire:model="req_commu">
                            @error('req_commu')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="">ชื่อผู้นำชุมชน</label>
                            <input type="text" class="form-control" placeholder="ข้อมูลผู้นำชุมชน"
                                wire:model="req_leadname">
                            @error('req_leadname')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="">ตำแหน่งผู้นำชุมชน</label>
                            <input type="text" class="form-control" placeholder="ตำแหน่งผู้นำชุมชน"
                                wire:model="req_position">
                            @error('req_position')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-5">
                            <label for="">ข้อมูลผู้นำชุมชน</label>
                            <textarea rows="4" class="form-control" wire:model="req_leadinfo" placeholder="ข้อมูลผู้นำชุมชน"></textarea>
                            @error('req_leadinfo')
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
                        </div>
                        <div class="col-md-3">
                            <label for="">เดือนที่สิ้นสุด</label>
                            <div class="input-group">
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
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 form-group">
                            <label for="">จำนวนวันดำเนินการ</label>
                            {{ Form::number('req_numofday', null, [
                                'wire:model' => 'req_numofday',
                                'wire:change' => 'setnum("req_numofday",$event.target.value)',
                                'min' => 1,

                                'id' => 'req_numofday',
                                'class' => 'form-control text-right',
                            ]) }}
                            @error('req_numofday')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="">จำนวน (คน)</label>
                            {{ Form::number('req_numofpeople', null, [
                                'wire:model' => 'req_numofpeople',
                                'wire:change' => 'setnum("req_numofpeople",$event.target.value)',
                                'min' => 1,

                                'id' => 'req_numofpeople',
                                'class' => 'form-control text-right',
                            ]) }}
                            @error('req_numofpeople')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 form-group">
                            <label for="">อัตราค่าตอบแทน ต่อคนต่อวัน</label>
                            {{ Form::number('req_rate', null, [
                                'wire:model' => 'req_rate',
                                'wire:change' => 'setnum("req_rate",$event.target.value)',
                                'min' => 1,

                                'id' => 'req_rate',
                                'class' => 'form-control text-right',
                            ]) }}
                            @error('req_rate')
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
            //

            // L.marker([51.5, -0.09]).addTo(leaflet_map)
            //     .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
            //     .openPopup();
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

        window.onload = function() {
            Livewire.on('popup', ($req_number) => {
                swal({
                    title: "บันทึกข้อมูลเรียบร้อย \n เลขที่ใบคำขอ " + $req_number,
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
            if (number == 1) {
                var title = "ยืนยันการ บันทึกแบบร่าง ?";
            }else{
                var title = "ยืนยันการ บันทึกส่งพิจารณา ?";
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
    </script>
@endpush

