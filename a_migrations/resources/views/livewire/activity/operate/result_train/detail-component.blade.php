<div>

    <div class="page-header">
        <h1 class="page-title">บันทึกผลการดำเนินงาน : {{ $act_number }} {{ $act_shortname }}</h1>
        <div class="row">
            <input class="btn btn-primary" onclick="alert_popup()" style="position: absolute; right: 5rem; bottom: 0rem;"
                type="button" value="ปิดกิจกรรม" {{ $formdisabled ? 'disabled' : '' }}>
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item active">บันทึกผลการดำเนินงาน</li>
        </ol>
    </div>
    <div class="page-content">
        <div class="form-horizontal">
            <div class="row">
                <div class="col-lg-12">
                    <div class="example">
                        <div class="grid-container grid-container--fit">
                            {{-- <div class="step bgfl {{ $panel == 1 ? 'current' : '' }}" wire:click="changePanel(1)">
                                <span class="step-icon icon wb-order" style="font-size: 4em;" aria-hidden="true"></span>
                                <div class="step-desc">
                                    <span class="step-title pol">ข้อมูลกิจกรรม</span>
                                </div>
                            </div> --}}
                            <div class="step bgfl {{ $panel == 2 ? 'current' : '' }}" wire:click="changePanel(2)">
                                <span class="step-icon icon wb-time" style="font-size: 5em;" aria-hidden="true"></span>
                                <div class="step-desc">
                                    <span class="step-title pol">เวลาเข้าร่วมกิจกรรม</span>
                                </div>
                            </div>
                            <div class="step bgfl {{ $panel == 3 ? 'current' : '' }}" wire:click="changePanel(3)">
                                <span class="step-icon icon wb-stats-bars" aria-hidden="true"
                                    style="font-size: 5em;"></span>
                                <div class="step-desc">
                                    <span class="step-title pol">แบบประเมิน</span>
                                </div>
                            </div>
                            <div class="step bgfl {{ $panel == 4 ? 'current' : '' }}" wire:click="changePanel(4)">
                                <span class="step-icon icon fa fa-money" aria-hidden="true"
                                    style="font-size: 5em;"></span>
                                <div class="step-desc">
                                    <span class="step-title pol">ค่าใช้จ่าย</span>
                                </div>
                            </div>
                            <div class="step bgfl {{ $panel == 5 ? 'current' : '' }}" wire:click="changePanel(5)">
                                <span class="step-icon icon wb-gallery" aria-hidden="true"
                                    style="font-size: 5em;"></span>
                                <div class="step-desc">
                                    <span class="step-title pol">รูปกิจกรรม</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-body container-fluid">
                {{-- <div class=" {{ $panel == 1 ? '' : 'd-none' }} ">
                    {{ Form::open([
                        'wire:submit.prevent' => 'submit()',
                        'autocomplete' => 'off',
                        'class' => 'form-horizontal fv-form fv-form-bootstrap4',
                    ]) }}
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">วันที่เริ่มกิจกรรม</label>
                        <div class="col-md-3 form-group">
                            <div class="input-group">
                                {{ Form::text('stdate_new', $stdate_new, [
                                    'onchange' => 'setValue_date1("stdate_new", event.target.value)',
                                    'class' => 'form-control datepicker',
                                    'id' => 'stdate_new',
                                    'autocomplete' => 'close',
                                    'disabled' => $formdisabled,
                                ]) }}
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="icon wb-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <label class="col-md-2 form-control-label">วันที่สิ้นสุดกิจกรรม</label>
                        <div class="col-md-3 form-group">
                            <div class="input-group">
                                {{ Form::text('endate_new', $endate_new, [
                                    'onchange' => 'setValue_date1("endate_new", event.target.value)',
                                    'class' => 'form-control datepicker',
                                    'id' => 'endate_new',
                                    'autocomplete' => 'close',
                                    'disabled' => $formdisabled,
                                ]) }}
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="icon wb-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            @error('endate_new')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">จำนวนวันที่ทำกิจกรรม</label>
                        <div class="col-md-3">
                            {{ Form::number('act_numofday', $act_numofpeople, [
                                'wire:model' => 'act_numofday',
                                'id' => 'act_numofday',
                                'class' => 'form-control',
                                'disabled',
                            ]) }}
                            @error('act_numofday')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">จำนวนผู้เข้าร่วมกิจกรรม</label>
                        <div class="col-md-3">
                            {{ Form::number('act_numofpeople', $act_numofpeople, [
                                'wire:model' => 'act_numofpeople',
                                'id' => 'act_numofpeople',
                                'class' => 'form-control',
                                'disabled',
                            ]) }}
                            @error('act_numofpeople')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">
                            <h5><b><u>ข้อมูลวิทยากร</u></b></h5>
                        </label>
                    </div>

                    <div class="form-group row">
                        <div class="table-responsive offset-md-1 col-md-10" id="parenTable" wire:ignore>
                            <table class="table table-bordered table-hover table-striped w-full dataTable"
                                id="DatatablesP1">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">บัตรประชาชน</th>
                                        <th class="text-center">ชื่อ-สกุล</th>
                                        <th class="text-center">ประเภทวิทยากร</th>
                                        <th class="text-center">เบอร์โทรศัพท์</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">
                            <h5><b><u>ตารางรายละเอียดวิทยากร</u></b></h5>
                        </label>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-1 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">วันที่ทำกิจกรรม</th>
                                        <th class="text-center" colspan="3">ช่วงเวลา</th>
                                        <th class="text-center">ชื่อวิทยากร</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loop_time_old as $key1 => $val1)
                                        <tr>
                                            <td>
                                                {{ datetoview($val1['startdate']) }}
                                            </td>
                                            <td>
                                                {{ datetimeTotime($val1['starttime']) }} น.
                                            </td>
                                            <td>
                                                ถึง
                                            </td>
                                            <td>
                                                {{ datetimeTotime($val1['endtime']) }} น.
                                            </td>
                                            <td>
                                                {{ $selectlecturer_list[$val1['pop_id']] }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger icon wb-trash"
                                                    wire:click="lec_del_old({{ $key1 }})"></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($formdisabled == false)
                                        <tr>
                                            <td>
                                                <center>
                                                    {{ Form::select('selectdate', $date_list, $selectdate, [
                                                        'class' => 'form-control select2 sel1',
                                                        'id' => 'selectdate',
                                                        'onchange' => 'setValue("selectdate", event.target.value)',
                                                    ]) }}
                                                </center>
                                                @error('selectdate')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </td>
                                            <td>
                                                {{ Form::text('starttime', $starttime, [
                                                    'class' => 'form-control timepicker sel2',
                                                    'id' => 'starttime',
                                                    'onchange' => 'setValue("starttime", event.target.value)',
                                                    'autocomplete' => 'close',
                                                ]) }}
                                                @error('starttime')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                                @error('timealert')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </td>
                                            <td>
                                                <label class="form-control-label text-center">
                                                    <h5>ถึง</h5>
                                                </label>
                                            </td>
                                            <td>
                                                {{ Form::text('stoptime', $stoptime, [
                                                    'class' => 'form-control timepicker sel2',
                                                    'id' => 'stoptime',
                                                    'onchange' => 'setValue("stoptime", event.target.value)',
                                                    'autocomplete' => 'close',
                                                ]) }}
                                                @error('stoptime')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                                @error('timealert')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </td>
                                            <td>
                                                <center>
                                                    {{ Form::select('namelecturer', $selectlecturer_list, $namelecturer, [
                                                        'class' => 'form-control select2 sel4',
                                                        'id' => 'namelecturer',
                                                        'onchange' => 'setValue("namelecturer", event.target.value)',
                                                    ]) }}
                                                </center>
                                                @error('namelecturer')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </td>
                                            <td>
                                                <i class="wb-plus splus" style="font-size: 1.25em; margin-top: 5%"
                                                    onclick="l_add()"></i>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($formdisabled == false)
                        <div style="text-align: center;">
                            <div class="btn btn-primary" wire:click="submit_p1()">บันทึก</div>
                            <div wire:click="redirect_to()" class="btn btn-default">ยกเลิก</div>
                        </div>
                    @endif

                    {{ Form::close() }}
                </div> --}}

                <div class=" {{ $panel == 2 ? '' : 'd-none' }} ">
                    <div class="row form-group">
                        <div class="col-md-2">
                            <div class="input-group">
                                {{ Form::text('search2', null, [
                                    'oninput' => 'setSearch2()',
                                    'class' => 'form-control',
                                    'id' => 'search2',
                                    'placeholder' => 'ค้นหา...',
                                ]) }}
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-md-3">
                            <h4>จำนวนวันที่ทำกิจกรรม : {{ $act_numofday }} วัน</h4>
                        </div>
                        <div class="col-md-3">
                            <h4>วันที่ {{ formatDateThai($activity_run_period_start) }} -
                                {{ formatDateThai($activity_run_period_end) }}
                        </div>
                        <div class="col-md-2 text-right">
                            <h4>ลงเวลาเข้าร่วมของวันที่</h4>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="col-md-1"></div>
                                {{ Form::select('stdate', $date_list_old, $stdate, [
                                    'class' => 'form-control select2 sel1',
                                    'id' => 'stdate',
                                    'onchange' => 'setshow_time("stdate", event.target.value)',
                                ]) }}
                            </div>
                            @error('stdate')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="table-responsive form-group" id="parenTable" wire:ignore>
                        <table class="table table-bordered table-hover table-striped w-full dataTable"
                            id="DatatablesP2">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">ชื่อ-สกุล</th>
                                    <th class="text-center">
                                        @if ($formdisabled == false)
                                            <input type="radio" id="checkedAllS1" name="checkname">
                                        @endif
                                        <span style="padding-left: 0.4%; padding-bottom: 0.5%">มาเข้าร่วม</span>
                                    </th>
                                    <th class="text-center">
                                        @if ($formdisabled == false)
                                            <input type="radio" id="checkedAllS1" name="checkname">
                                        @endif
                                        <span style="padding-left: 0.4%; padding-bottom: 0.5%">ไม่มาเข้าร่วม</span>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @if ($formdisabled == false)
                        <div style="text-align: center;">
                            <div class="btn btn-primary" onclick="submit_p2()">บันทึก</div>
                        </div>
                    @endif

                </div>

                <div class=" {{ $panel == 3 ? '' : 'd-none' }} ">
                    <div class="form-group row">
                        <div class="col-md-4 text-center">
                            <a target="_blank"
                                href="{{ route('assessment_qrcode', ['act_id' => $act_id, 'p_id' => 0]) }}">{{ QrCode::size(150)->generate($urltoform) }}</a>
                            <br><br>
                            <h4>ผู้นำชุมชน<h4>
                                    {{-- {{ $urltoform }} --}}
                        </div>
                        <div class="col-md-4 text-center">
                            <a target="_blank"
                                href="{{ route('assessment_qrcode', ['act_id' => $act_id, 'p_id' => 0]) }}">{{ QrCode::size(150)->generate($urltoform) }}</a>
                            <br><br>
                            <h4>ผู้เข้าร่วม<h4>
                                    {{-- {{ $urltoform }} --}}
                        </div>
                        <div class="col-md-4 text-center">
                            <a target="_blank"
                                href="{{ route('assessment_qrcode', ['act_id' => $act_id, 'p_id' => 0]) }}">{{ QrCode::size(150)->generate($urltoform) }}</a>
                            <br><br>
                            <h4>วิทยากร<h4>
                                    {{-- {{ $urltoform }} --}}
                        </div>
                    </div>

                    <label class="col-2 form-control-label">
                        <h4><b>รายชื่อผู้เข้าร่วม</b></h4>
                    </label>
                    <div class="table-responsive form-group" wire:ignore>
                        <table class="table table-bordered table-hover table-striped w-full dataTable"
                            id="DatatablesP3">
                            <thead>
                                <tr>
                                    <th class="text-center col-1">ลำดับ</th>
                                    <th class="text-center">บัตรประชาชน</th>
                                    <th class="text-center">ชื่อ-สกุล</th>
                                    <th class="text-center">สถานะการเข้าร่วม</th>
                                    <th class="text-center">ที่อยู่</th>
                                    <th class="text-center">เบอร์โทรศัพท์</th>
                                    <th class="text-center">ประเมินความพึงพอใจ</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <br>
                    <label class="col-2 form-control-label">
                        <h4><b>รายชื่อวิทยากร</b></h4>
                    </label>
                    <div class="table-responsive form-group" id="parenTable" wire:ignore>
                        <table class="table table-bordered table-hover table-striped w-full dataTable"
                            id="DatatablesP4">
                            <thead>
                                <tr>
                                    <th class="text-center col-1">ลำดับ</th>
                                    <th class="text-center">บัตรประชาชน</th>
                                    <th class="text-center">ชื่อ-สกุล</th>
                                    <th class="text-center">ประเภทวิทยากร</th>
                                    <th class="text-center">เบอร์โทรศัพท์</th>
                                    <th class="text-center">ประเมินความพึงพอใจ</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class=" {{ $panel == 4 ? '' : 'd-none' }} ">
                    {{ Form::open([
                        'wire:submit.prevent' => 'submit()',
                        'autocomplete' => 'off',
                        'class' => 'form-horizontal fv-form fv-form-bootstrap4',
                    ]) }}
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">จำนวนวันจัดกิจกรรม</label>
                        <div class="col-md-3">
                            {{ Form::number('act_numofday', null, [
                                'wire:model' => 'act_numofday',
                                'wire:change' => 'setnum("act_numofday",$event.target.value)',
                                'id' => 'act_numofday',
                                'class' => 'form-control',
                                'disabled',
                            ]) }}
                            @error('act_numofday')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        {{-- <label class="col-md-2 form-control-label">ชั่วโมงกิจกรรม/วัน</label>
                        <div class="col-md-3">
                            {{ Form::text('act_hrperday', null, [
                                'wire:model' => 'act_hrperday',
                                'wire:change' => 'setnum("act_hrperday",$event.target.value)',
                                'oninput' => 'num_format("act_hrperday", event.target.value)',
                                'id' => 'act_hrperday',
                                'maxlength' => 10,
                                'class' => 'form-control',
                                'disabled',
                            ]) }}
                            @error('act_hrperday')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div> --}}
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">จำนวนคนร่วมกิจกรรม</label>
                        <div class="col-md-3">
                            {{ Form::number('act_numofpeople', null, [
                                'wire:model' => 'act_numofpeople',
                                'wire:change' => 'setnum("act_numofpeople",$event.target.value)',
                                'id' => 'act_numofpeople',
                                'class' => 'form-control',
                                'disabled',
                            ]) }}
                            @error('act_numofpeople')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">จำนวนวิทยากร</label>
                        <div class="col-md-3">
                            {{ Form::number('act_numlecturer', null, [
                                'wire:model' => 'act_numlecturer',
                                'wire:change' => 'setnum("act_numlecturer",$event.target.value)',
                                'id' => 'act_numlecturer',
                                'class' => 'form-control',
                                'disabled',
                            ]) }}
                            @error('act_numlecturer')
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
                                                value="{{ $act_numofday }} วัน / {{ $act_numofpeople }} คน">
                                        </td>

                                        <td class="text-center">
                                            {{ Form::text('act_amtfood', number_format($act_amtfood, 2), [
                                                // 'wire:model' => 'act_amtfood',
                                                // 'wire:change' => 'calsum("act_amtfood",$event.target.value)',
                                                // 'id' => 'act_amtfood',
                                                'class' => 'form-control',
                                                'disabled',
                                                // 'disabled' => $distext,
                                            ]) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label class="form-control-label">ค่าตอบแทนวิทยากร</label>
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
                                            {{ Form::text('course_trainer_amt', number_format($course_trainer_amt, 2), [
                                                // 'wire:model' => 'course_trainer_amt',
                                                // 'wire:change' => 'calsum("course_trainer_amt",$event.target.value)',
                                                // 'id' => 'course_trainer_amt',
                                                'class' => 'form-control',
                                                'disabled',
                                                // 'disabled' => $distext,
                                            ]) }}

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
                                            {{ Form::text('course_material_amt', number_format($course_material_amt, 2), [
                                                // 'wire:model' => 'course_material_amt',
                                                // 'wire:change' => 'calsum("course_material_amt",$event.target.value)',
                                                // 'onkeypress' => 'return validateNumber(event)',
                                                // 'id' => 'course_material_amt',
                                                'class' => 'form-control',
                                                'disabled',
                                                // 'disabled' => $distext,
                                            ]) }}

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

                                        <td class="text-center">
                                            {{ Form::text('other_amt', null, [
                                                'wire:change' => 'calsum("other_amt",$event.target.value)',
                                                'wire:model' => 'other_amt',
                                                'id' => 'other_amt',
                                                'class' => 'form-control',
                                                'disabled' => $formdisabled,
                                            ]) }}

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
                                {{ Form::text('act_amount', number_format($act_amount, 2), [
                                    // 'wire:model' => 'act_amount',
                                    // 'id' => 'act_amount',
                                    'class' => 'form-control',
                                    'disabled',
                                ]) }}
                            </div>
                        </div>
                    </center>
                    {{ Form::close() }}

                    @if ($formdisabled == false)
                        <div class="form-group row">
                            <div class="col-12 text-center">
                                <button wire:click="SubmitOrClose_payment(1)"
                                    class="btn btn-primary">บันทึกข้อมูล</button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class=" {{ $panel == 5 ? '' : 'd-none' }} ">
                    <div class="col-lg-12">
                        <div class="panel-body">
                            <div class="form-group row">
                                <div class="col-2 form-control-label">
                                    <h4><b>ก่อนดำเนินกิจกรรม :</b></h4>
                                </div>
                            </div>
                            <div class="form-group row">
                                @if (!$OoapTblActimagePre)
                                    @foreach ($images_no as $key => $val)
                                        <div class="col-md-2" wire:ignore>
                                            {{ Form::file('files_image', [
                                                'data-height' => '250',
                                                'wire:model' => 'files_image_pre.' . $key,
                                                'class' => 'files_image',
                                                'disabled' => $formdisabled,
                                            ]) }}
                                            @error('files_image')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    @endforeach
                                @else
                                    @foreach ($OoapTblActimagePre as $key => $val)
                                        <div class="col-md-2 text-center" wire:ignore>
                                            {{ Form::file('files_image', [
                                                'data-height' => '250',
                                                'wire:model' => 'files_image_pre.' . $key,
                                                'class' => 'files_image',
                                                'data-default-file' => $url . $images_pre_path[$key] . '/' . $images_pre_name[$key],
                                                'disabled' => $formdisabled,
                                            ]) }}
                                            @error('files_image')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                            {{-- <img style="height: 200px;"
                                                src="{{ 'http://116.204.180.86:8060/storage' }}{{ $images_pre_path[$key] }}/{{ $images_pre_name[$key] }}">
                                            <br>
                                            <button type="button" class="btn btn-danger"
                                                onclick="del({{ $image_id[$key] }})">
                                                <i class="wb-trash"></i>
                                            </button> --}}
                                        </div>
                                        &nbsp;&nbsp;
                                    @endforeach
                                    @for ($i = 0; $i < $images_no_pre; $i++)
                                        <div class="col-md-2" wire:ignore>
                                            {{ Form::file('files_image', [
                                                'data-height' => '250',
                                                'wire:model' => 'files_image_pre.' . $i,
                                                'class' => 'files_image',
                                                'disabled' => $formdisabled,
                                            ]) }}
                                            @error('files_image')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    @endfor
                                @endif
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-2 form-control-label">
                                    <h4><b>ระหว่างดำเนินกิจกรรม :</b></h4>
                                </div>
                            </div>
                            <div class="form-group row">
                                @if (!$OoapTblActimageCon)
                                    @foreach ($images_no as $key => $val)
                                        <div class="col-md-2" wire:ignore>
                                            {{ Form::file('files_image', [
                                                'data-height' => '250',
                                                'wire:model' => 'files_image_con.' . $key,
                                                'class' => 'files_image',
                                                'data-default-file' => '',
                                                'disabled' => $formdisabled,
                                            ]) }}
                                            @error('files_image')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    @endforeach
                                @else
                                    @foreach ($OoapTblActimageCon as $key => $val)
                                        <div class="col-md-2" wire:ignore>
                                            {{ Form::file('files_image', [
                                                'data-height' => '250',
                                                'wire:model' => 'files_image_con.' . $key,
                                                'class' => 'files_image',
                                                'data-default-file' => $url . $images_con_path[$key] . '/' . $images_con_name[$key],
                                                'disabled' => $formdisabled,
                                            ]) }}
                                            @error('files_image')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    @endforeach
                                    @for ($i = 0; $i < $images_no_con; $i++)
                                        <div class="col-md-2" wire:ignore>
                                            {{ Form::file('files_image', [
                                                'data-height' => '250',
                                                'wire:model' => 'files_image_con.' . $i,
                                                'class' => 'files_image',
                                                'disabled' => $formdisabled,
                                            ]) }}
                                            @error('files_image')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    @endfor
                                @endif
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-2 form-control-label">
                                    <h4><b>หลังดำเนินกิจกรรม :</b></h4>
                                </div>
                            </div>
                            <div class="form-group row">
                                @if (!$OoapTblActimagePro)
                                    @foreach ($images_no as $key => $val)
                                        <div class="col-md-2" wire:ignore>
                                            {{ Form::file('files_image', [
                                                'data-height' => '250',
                                                'wire:model' => 'files_image_pro.' . $key,
                                                'class' => 'files_image',
                                                'disabled' => $formdisabled,
                                            ]) }}
                                            @error('files_image')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    @endforeach
                                @else
                                    @foreach ($OoapTblActimagePro as $key => $val)
                                        <div class="col-md-2" wire:ignore>
                                            {{ Form::file('files_image', [
                                                'data-height' => '250',
                                                'wire:model' => 'files_image_pro.' . $key,
                                                'class' => 'files_image',
                                                'data-default-file' => $url . $images_pro_path[$key] . '/' . $images_pro_name[$key],
                                                'disabled' => $formdisabled,
                                            ]) }}
                                            @error('files_image')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    @endforeach
                                    @for ($i = 0; $i < $images_no_pro; $i++)
                                        <div class="col-md-2" wire:ignore>
                                            {{ Form::file('files_image', [
                                                'data-height' => '250',
                                                'wire:model' => 'files_image_pro.' . $i,
                                                'class' => 'files_image',
                                                'disabled' => $formdisabled,
                                            ]) }}
                                            @error('files_image')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    @endfor
                                @endif
                            </div>
                            @if ($formdisabled == false)
                                <div class="form-group row">
                                    <div class="col-12 text-center">
                                        <button wire:click="submit_images"
                                            class="btn btn-primary">บันทึกข้อมูล</button>
                                        <button wire:click="redirect_to"
                                            class="btn btn-default btn-outline">ยกเลิก</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <br>
            @if ($formdisabled)
                <div class='row'>
                    <div class='col text-center'>
                        <button type="button" class="w-full form-group btn btn-danger col-2"
                            wire:click="callback()">ยกเลิก</button>
                    </div>
                </div>
            @endif
        </div>
        <script>
            document.addEventListener('livewire:load', function() {
                $('.select2').select2();
                call_datatable('');
                call_datatable2('', 0);
                call_datatable3('');
                call_datatable4('');
                $(".datepicker").datepicker({
                    language: 'th-th',
                    format: 'dd/mm/yyyy',
                    autoclose: true,
                    orientation: "bottom"
                });
                $(".timepicker").timepicker({
                    'scrollDefault': 'now',
                    'timeFormat': 'G:i',
                })

                window.livewire.on('emits', () => {
                    $('.select2').select2();
                })
                window.livewire.on('emits2', (num) => {
                    $('#DatatablesP2').DataTable().destroy();
                    call_datatable2('', num);
                })

                Livewire.on('popup', (num) => {
                    if (num == 1) {
                        swal({
                                title: "บันทึกเสร็จสิ้น",
                                type: "success",
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "ตกลง",
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    window.livewire.emit('redirect-to');
                                }
                            });
                    } else {
                        swal({
                            title: "การปิดกิจกรรมเสร็จสิ้น",
                            type: "success",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "ตกลง",
                        });
                    }

                });
            })
        </script>
    </div>
</div>
@push('js')
    <link rel="stylesheet" href="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.css">
    <script src="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
    <script>
        function del(num) {
            swal({
                title: 'ต้องการลบรูปภาพนี้ใช่หรือไม่',
                icon: 'close',
                type: "success",
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#00BCD4',
                cancelButtonText: 'ยกเลิก',
                cancelButtonColor: '#00BCD4',
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.del(num);
                    window.livewire.emit('redirect-to');
                } else {
                    console.log('reject');
                }
            });
        }

        function alert_popup() {
            swal({
                title: 'ยืนยันการปิดกิจกรรมใช่หรือไม่',
                icon: 'close',
                type: "success",
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#00BCD4',
                cancelButtonText: 'ยกเลิก',
                cancelButtonColor: '#00BCD4',
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.SubmitOrClose_payment(2);
                } else {
                    console.log('reject');
                }
            });
        }

        function setshow_time(name, val) {
            @this.set(name, val);
            @this.setdbtime(val);
        }

        function validateNumber(thestr) {
            const pattern = /^[0-9]$/;
            return pattern.test(thestr.key)
        }

        function setValue_date1(name, val) {
            @this.set(name, val);
            @this.setValue_date1(name, val);
        }

        function setValue(name, val) {
            @this.set(name, val);
        }

        function l_add(key) {
            @this.l_add(key);
        }

        // function setValuedate(name, val) {
        //     @this.set(name, val);
        //     @this.setArray(name, val);
        // }

        function theFunction() {
            swal({
                    title: "ท่านไม่มีสิทธิ์แก้ไขรายการนี้",
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.livewire.emit('redirect-to');
                    }
                });
        }

        function setSearch2() {
            $('#DatatablesP2').DataTable().destroy();
            call_datatable2($("#search2", 0).val());
            return false;
        }

        function call_datatable(search) {

            var SearchData = $('#search').val();

            var table = $('#DatatablesP1').DataTable({
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
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'pop_mobileno',
                        name: 'pop_mobileno',
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

        var table2;

        function call_datatable2(search, num) {
            if (@this.date_list_old[num] == undefined || @this.date_list_old[num] == null) {
                datetime = @this.date_list_old[0];
            } else {
                datetime = @this.date_list_old[num];
            }
            var SearchData = $('#search2').val();

            table2 = $('#DatatablesP2').DataTable({
                processing: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.operate.result_train.poptime.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}',
                        act_number: @this.act_number,
                        act_id: @this.act_id,
                        act_div: @this.act_div,
                        check: @this.num_disabled,
                        date: datetime,
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
                        data: 'fullname',
                        name: 'fullname',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'checkbox_s1',
                        name: 'checkbox_s1',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'checkbox_s0',
                        name: 'checkbox_s0',
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
            table2.on('order.dt', function() {
                table2.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).search(search).draw();
            $('#checkedAllS1').on('click', function() {
                var rows = table2.rows({
                    'search': 'applied'
                }).nodes();
                $('.checkSingle1', rows).prop('checked', this.checked);
            });
            $('#checkedAllS0').on('click', function() {
                var rows = table2.rows({
                    'search': 'applied'
                }).nodes();
                $('.checkSingle0', rows).prop('checked', this.checked);
            });
            $('#checkedAllS2').on('click', function() {
                var rows = table2.rows({
                    'search': 'applied'
                }).nodes();
                $('.checkSingle2', rows).prop('checked', this.checked);
            });
        }

        function submit_p2() {
            let a = [];
            var rows = table2.rows({
                'search': 'applied'
            }).nodes();
            $('.checkSingle1', rows).each(function() {
                if ($(this).prop("checked") == true) {
                    a[this.value] = this.id;
                }
            });
            $('.checkSingle0', rows).each(function() {
                if ($(this).prop("checked") == true) {
                    a[this.value] = this.id;
                }
            });
            $('#DatatablesP2').DataTable().destroy();
            @this.select_values_list = a;
            @this.save();

        }

        function call_datatable3(search) {

            table3 = $('#DatatablesP3').DataTable({
                processing: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.operate.result_train.form_train.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}',
                        act_number: @this.act_number,
                        act_id: @this.act_id,
                        act_div: @this.act_div,
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
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'role',
                        name: 'role',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'address',
                        name: 'address',
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
        }

        function call_datatable4(search) {

            // var SearchData = $('#search').val();

            var table = $('#DatatablesP4').DataTable({
                processing: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.operate.result_train_role1_form.list') }}',
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

    <script type="text/javascript">
        document.addEventListener('livewire:load', function() {
            $('.files_image').dropify();
        });

        function test() {
            var value = $('#brow_list').val();
            if (value) {
                window.livewire.emit('redirect-to-support', {
                    data: $('#brow [value="' + value + '"]').data('value')
                });
            } else {
                window.livewire.emit('redirect-to-support', {
                    data: 'false'
                });
            }
        }

        function checkname() {
            var value = $('#brow_list').val();
            if (value) {
                window.livewire.emit('redirect-to-name_search', {
                    data: $('#brow [value="' + value + '"]').data('value')
                });
            } else {
                window.livewire.emit('redirect-to-name_search', {
                    data: 'false'
                });
            }
        }
    </script>
@endpush
