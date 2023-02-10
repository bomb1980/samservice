<div>
    <div class="row">
        <div class="form-group col-md-12 panel">
            <div class="panel-body container-fluid">
                <br>
                <div class='row'>
                    <div class="col text-center">
                        <div>
                            <button type="button"
                                class="btn btn-primary col-2 form-group {{ $panel == 1 ? '' : 'btn-outline' }}"
                                wire:click="changPanel(1)">ข้อมูลใบคำขอ &nbsp;
                                @if ($circle1 == true)
                                    <span class="dot-checkmark text-center">
                                        <i></i>
                                    </span>
                                @elseif ($alert1 == true)
                                    <span class="text-center">
                                        <i class="icon wb-alert" aria-hidden="true" style="color:red" ></i>
                                    </span>
                                @endif
                            </button>
                            <button type="button"
                                class="btn btn-primary col-2 form-group {{ $panel == 2 ? '' : 'btn-outline' }}"
                                wire:click="changPanel(2)">ข้อมูลกิจกรรม
                                @if ($circle2 == true)
                                    <span class="dot-checkmark text-center">
                                        <i></i>
                                    </span>
                                @elseif ($alert2 == true)
                                    <span class="text-center">
                                        <i class="icon wb-alert" aria-hidden="true" style="color:red" ></i>
                                    </span>
                                @endif
                            </button>
                            <button type="button"
                                class="btn btn-primary col-2 form-group {{ $panel == 3 ? '' : 'btn-outline' }}"
                                wire:click="changPanel(3)">พื้นที่ดำเนินการ
                                @if ($circle3 == true)
                                    <span class="dot-checkmark text-center">
                                        <i></i>
                                    </span>
                                @endif
                            </button>
                            <button type="button"
                                class="btn btn-primary col-2 form-group {{ $panel == 4 ? '' : 'btn-outline' }}"
                                wire:click="changPanel(4)">ค่าใช้จ่าย
                                @if ($circle4 == true)
                                    <span class="dot-checkmark text-center">
                                        <i></i>
                                    </span>
                                @elseif ($alert4 == true)
                                    <span class="text-center">
                                        <i class="icon wb-alert" aria-hidden="true" style="color:red" ></i>
                                    </span>
                                @endif
                            </button>
                            <button type="button"
                                class="btn btn-primary col-2 form-group {{ $panel == 5 ? '' : 'btn-outline' }}"
                                wire:click="changPanel(5)">แนบไฟล์
                                @if ($circle5 == true)
                                    <span class="dot-checkmark text-center">
                                        <i></i>
                                    </span>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                {{ Form::open([
                    'wire:submit.prevent' => 'submit()',
                    'autocomplete' => 'off',
                    'class' => 'form-horizontal fv-form fv-form-bootstrap4',
                ]) }}
                <div class="{{ $panel == 1 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <div class="col-md-2 form-control-label">
                            <label>
                                <h4><b><u>ข้อมูลใบคำขอ</u></b></h4>
                            </label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">ปีงบประมาณ <span class="text-danger">*</span></label>
                        <div class="col-md-3">
                            {{ Form::select('act_year', $fiscalyear_list, $act_year, [
                                'onchange' => 'setValue("act_year",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกปีงบประมาณ--',
                            ]) }}
                            @error('act_year')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">งวดที่</label>
                        <div class="col-md-3 form-group">
                            <input type="number" class="form-control text-right" wire:model="act_periodno">
                        </div>
                        @error('act_periodno')
                            <label class="col-md-12 text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">หน่วยงาน <span class="text-danger">*</span></label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="{{$act_dept}}" disabled>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">วันที่ใบคำขอ </label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="{{ datetoview($created_at) }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="{{ $panel == 2 ? '' : 'd-none' }}">
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
                            {{ Form::select('acttye_id', $acttye_list, $acttye_id, [
                                'onchange' => 'setValue("acttye_id",event.target.value)',
                                'class' => 'form-control select2',
                                'disabled',
                            ]) }}
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">ชื่อกิจกรรม </label>
                        <div class="col-md-6">
                            <textarea rows="4" class="form-control" wire:model="act_shortname" placeholder="ชื่อกิจกรรม"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">รายละเอียดกิจกรรม </label>
                        <div class="col-md-6">
                            <textarea rows="6" class="form-control" wire:model="act_desc" placeholder="รายละเอียดกิจกรรม"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">หมายเหตุ </label>
                        <div class="col-md-6">
                            <textarea rows="6" class="form-control" wire:model="act_remark" placeholder="หมายเหตุ"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">ประเภทความเดือดร้อน </label>
                        <div class="col-md-3">
                            {{ Form::select('act_troubletype', $troubletype_list, $act_troubletype, [
                                'onchange' => 'setValue("act_troubletype",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกประเภทความเดือดร้อน--',
                            ]) }}
                            @error('act_troubletype')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">จำนวนประชาชนในพื้นที่ ที่ได้รับประโยชน์</label>
                        <div class="col-md-3 form-group">
                            <input type="number" class="form-control text-right" placeholder="ตัวเลขจำนวน"
                                wire:model="act_peopleno">
                        </div>
                        @error('act_peopleno')
                            <label class="col-md-12 text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="row form-group mt-4">
                        <label class="col-md-2 form-control-label">
                            <h4><b><u>สถานที่ดำเนินการ</u></b></h4>
                        </label>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">ประเภทสถานที่ </label>
                        <div class="col-md-3">
                            {{ Form::select('act_buildtypeid', $buildingtype_list, $act_buildtypeid, [
                                'onchange' => 'setValue("act_buildtypeid",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกประเภทสถานที่--',
                            ]) }}
                            @error('act_buildtypeid')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">ชื่อสถานที่</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="ชื่อสถานที่"
                                wire:model="act_buildname">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">พิกัดแผนที่ละติจูด</label>
                        <div class="col-md-3">
                            {{ Form::text('building_lat', $building_lat, [
                                'wire:model' => 'building_lat',
                                'class' => 'form-control',
                                'placeholder' => 'พิกัดแผนที่ละติจูด',
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
                            ]) }}
                            @error('building_long')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                            <div id="map" style="height: 450px; width: 100%" wire:ignore></div>
                        </div>
                    </div>
                    <div class="row form-group mt-4">
                        <label class="col-md-2 form-control-label">
                            <h4><b><u>สถานที่ดำเนินการ</u></b></h4>
                        </label>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">รูปแบบการวัดพื้นที่ </label>
                        <div class="col-md-3">
                            {{ Form::select('act_measure', $patternarea_list, $act_measure, [
                                'onchange' => 'setValue("act_measure",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกรูปแบบการวัดพื้นที่--',
                            ]) }}
                            @error('act_measure')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group {{ $act_measure > 1 ? '' : 'd-none' }}">
                        <label class="col-md-2 form-control-label">หน่วยระยะทาง </label>
                        <div class="col-md-3">
                            {{ Form::select('act_metric', $unit_list, $act_metric, [
                                'onchange' => 'setValue("act_metric",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกหน่วยระยะทาง--',
                            ]) }}
                             @error('act_metric')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group {{ $act_measure > 1 ? '' : 'd-none' }}">
                        <label class="col-md-2 form-control-label">กว้าง </label>
                        <div class="col-md-3">
                            <input type="number" class="form-control text-right" placeholder="กว้าง"
                            wire:model="act_width">
                             @error('act_width')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label">ยาว </label>
                        <div class="col-md-3">
                            <input type="number" class="form-control text-right" placeholder="ยาว"
                            wire:model="act_length">
                             @error('act_length')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group {{ $act_measure == 2 ? '' : 'd-none' }}">
                        <label class="col-md-2 form-control-label">สูง </label>
                        <div class="col-md-3">
                            <input type="number" class="form-control text-right" placeholder="สูง"
                                    wire:model="act_height">
                             @error('act_height')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label">ปริมาตร </label>
                        <div class="col-md-3">
                            {{ Form::number('act_unit', null, [
                                    'wire:model' => 'act_unit',
                                    'id' => 'act_unit',
                                    'class' => 'form-control text-right',
                                    'disabled',
                                ]) }}
                        </div>
                    </div>
                    <div class="row form-group {{ $act_measure == 3 ? '' : 'd-none' }}">
                        <label class="col-md-2 form-control-label">ปริมาณพื้นที่ (ตารางเมตร/ตารางกิโลเมตร) </label>
                        <div class="col-md-3">
                            {{ Form::number('act_unit', null, [
                                    'wire:model' => 'act_unit',
                                    'id' => 'act_unit',
                                    'class' => 'form-control text-right',
                                    'disabled',
                                ]) }}
                        </div>
                    </div>
                </div>

                <div class="{{ $panel == 3 ? '' : 'd-none' }}">
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
                            ]) }}
                            @error('province_id')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label">อำเภอ</label>
                        <div class="col-md-3 form-group">
                            {{ Form::select('act_district', $amphur_list, $act_district, [
                                'onchange' => 'setValue("act_district",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกอำเภอ--',
                            ]) }}
                            @error('act_district')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">ตำบล</label>
                        <div class="col-md-3 form-group">
                            {{ Form::select('act_subdistrict', $tambon_list, $act_subdistrict, [
                                'onchange' => 'setValue("act_subdistrict",event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => '--เลือกตำบล--',
                            ]) }}
                            @error('act_subdistrict')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label">หมู่ที่</label>
                        <div class="col-md-3 form-group">
                            <input type="text" class="form-control" placeholder="หมู่ที่" wire:model="act_moo">
                            @error('act_moo')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">ชื่อชุมชน</label>
                        <div class="col-md-3 form-group">
                            <input type="text" class="form-control" placeholder="ชื่อชุมชน"
                                wire:model="act_commu">
                            @error('act_commu')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">ชื่อผู้นำชุมชน</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="ข้อมูลผู้นำชุมชน"
                                wire:model="act_leadname">
                            @error('act_leadname')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label">ตำแหน่งผู้นำชุมชน</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="ตำแหน่งผู้นำชุมชน"
                                wire:model="act_position">
                            @error('act_position')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">ข้อมูลผู้นำชุมชน</label>
                        <div class="col-md-7">
                            <textarea rows="4" class="form-control" wire:model="act_leadinfo" placeholder="ข้อมูลผู้นำชุมชน"></textarea>
                        </div>
                    </div>
                </div>

                <div class="{{ $panel == 4 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">
                            <h4><b><u>ค่าใช้จ่าย</u></b></h4>
                        </label>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">เดือนที่เริ่ม</label>
                        <div class="input-group col-md-3">
                            <input type="text" class="form-control datepicker" data-date-language="th-th"
                                onchange="setDatePicker('stdate', event.target.value)" placeholder="เดือนที่เริ่ม">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="icon wb-calendar" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <label class="col-md-2 form-control-label">เดือนที่สิ้นสุด</label>
                        <div class="input-group col-md-3">
                            <input type="text" class="form-control datepicker" data-date-language="th-th"
                                onchange="setDatePicker('endate', event.target.value)" placeholder="เดือนที่สิ้นสุด">
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
                            {{ Form::number('act_numofday', null, [
                                'wire:model' => 'act_numofday',
                                'wire:change' => 'setnum("act_numofday",$event.target.value)',
                                'id' => 'act_numofday',
                                'class' => 'form-control',
                            ]) }}
                            @error('act_numofday')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">จำนวนคน</label>
                        <div class="col-md-3">
                            {{ Form::number('act_numofpeople', null, [
                                'wire:model' => 'act_numofpeople',
                                'wire:change' => 'setnum("act_numofpeople",$event.target.value)',
                                'id' => 'act_numofpeople',
                                'class' => 'form-control',
                            ]) }}
                            @error('act_numofpeople')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label">อัตราค่าตอบแทนต่อคนต่อวัน</label>
                        <div class="col-md-3">
                            {{ Form::number('act_rate', null, [
                                'wire:model' => 'act_rate',
                                'wire:change' => 'setnum("act_rate",$event.target.value)',
                                'id' => 'act_rate',
                                'class' => 'form-control',
                            ]) }}
                            @error('act_rate')
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
                                {{ Form::number('act_amount', null, [
                                    'wire:model' => 'act_amount',
                                    'id' => 'act_amount',
                                    'class' => 'form-control text-right',
                                    'disabled',
                                ]) }}
                            </div>
                        </div>
                    </center>
                </div>

                <div class="{{ $panel == 5 ? '' : 'd-none' }}">
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label"><b><u>แนบไฟล์</u></b></label>
                        <div class="input-group col-md-5 input-group-file" data-plugin="inputGroupFile">
                            {{-- <input type="text" class="form-control" readonly=""> --}}
                            <input type="text" class="form-control" readonly=""
                                value="{{ $files ? $files->getClientOriginalName() : null }}">
                            <!-- <div class="input-group-append"> -->
                            <button class="btn bg-blue-grey-300 btn-file">
                                <i class="icon wb-file" aria-hidden="true"></i>
                                เลือกไฟล์
                                <input type="file" wire:model="files"
                                    accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                            </button>
                            <!-- </div> -->
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
                        <div class="col-md-12">
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
            <div class="wizard-buttons">
                <button class="btn btn-default" {{ $panel == 1 ? 'disabled' : '' }}
                    wire:click="back({{ $panel }})">ย้อนกลับ</button>
                <button class="btn btn-primary float-right {{ $panel == 5 ? 'd-none' : '' }}"
                    wire:click="next({{ $panel }})">ถัดไป</button>
            </div>
            <br>
        </div>
    </div>no
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
</div>

@push('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

    <script>
        document.addEventListener('livewire:load', function() {
            $('.select2').select2();
            initMap();
            Livewire.on('emits', () => {
                $('.select2').select2();
            });
        });

        var markers = [];

        function calsum(cal) {
            @this.calsum(cal);
        }

        function initGeolocation() {
            if (navigator.geolocation) {
                // Call getCurrentPosition with success and failure callbacks
                navigator.geolocation.getCurrentPosition(success, fail);
            } else {
                alert("Sorry, your browser does not support geolocation services.");
            }
        }

        function success(position) {
            // @this.set('app_address_latitude', position.coords.latitude);
            // @this.set('app_address_longitude', position.coords.longitude);

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            const arr = {
                "lat": position.coords.latitude,
                "lng": position.coords.longitude
            };
            placeMarkerAndPanTo(arr, map);
            map.addListener("click", (e) => {
                placeMarkerAndPanTo(e.latLng, map);
                // alert(e.latLng);
            });
        }

        function fail() {
            alert("Sorry, your browser does not support geolocation services.");
        }

        function initMap() {
            if ('{{ $building_lat }}' || '{{ $building_long }}') {
                var lat = '{{ $building_lat }}';
                var lng = '{{ $building_long }}';
                var zoomView = 15;
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: zoomView,
                    center: new google.maps.LatLng(lat, lng),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                new google.maps.Marker({
                    position: new google.maps.LatLng(lat, lng),
                    map: map,
                    // title: 'ถนน ลาดปลาเค้า'
                });
                map.addListener("click", (e) => {
                    placeMarkerAndPanTo(e.latLng, map);
                    // alert(e.latLng);
                });
            } else {
                var lat = '13.8';
                var lng = '100.5';
                var zoomView = 5;
                const markers = map = new google.maps.Map(document.getElementById("map"), {
                    zoom: zoomView,
                    center: new google.maps.LatLng(lat, lng),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                map.addListener("click", (e) => {
                    placeMarkerAndPanTo(e.latLng, map);
                    // alert(e.latLng);
                });
            }
        }

        function placeMarkerAndPanTo(latLng, map) {
            deleteMarkers();
            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: 'latLng ' + latLng
            });
            markers.push(marker);
            @this.latLng(latLng);
            // map.panTo(latLng);
        }

        function clearMarkers() {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
        }

        function deleteMarkers() {
            clearMarkers();
            markers = [];
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
            // test = {{ json_encode($act_number) }};
            Livewire.on('popup', ($act_number) => {
                swal({
                        title: "บันทึกแบบร่างสำเร็จ \n เลขที่ใบคำขอ " + $act_number,
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
            if (number == 1) {
                var title = "ยืนยันการ บันทึกข้อมูลโครงการ ?";
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
