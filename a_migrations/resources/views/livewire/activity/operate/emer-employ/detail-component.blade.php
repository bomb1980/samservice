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
                                <span class="step-icon icon wb-user" style="font-size: 5em;" aria-hidden="true"></span>
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
                                <span class="step-icon icon fa-money" aria-hidden="true" style="font-size: 5em;"></span>
                                <div class="step-desc">
                                    <span class="step-title pol">ค่าใช้จ่าย</span>
                                </div>
                            </div>
                            <div class="step bgfl {{ $panel == 5 ? 'current' : '' }}" wire:click="changePanel(5)">
                                <span class="step-icon icon fa-camera" aria-hidden="true"
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
                <div class="row row-lg">
                    <div class="col-md-12">

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
                                    </h4>
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

                            <div class="form-group">
                                <div class="table-responsive" id="parenTable" wire:ignore>
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
                                                    <span
                                                        style="padding-left: 0.4%; padding-bottom: 0.5%">มาเข้าร่วม</span>
                                                </th>
                                                <th class="text-center">
                                                    @if ($formdisabled == false)
                                                        <input type="radio" id="checkedAllS1" name="checkname">
                                                    @endif
                                                    <span
                                                        style="padding-left: 0.4%; padding-bottom: 0.5%">ไม่มาเข้าร่วม</span>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            @if ($formdisabled == false)
                                <div style="text-align: center;">
                                    <div class="btn btn-primary" onclick="submit_p2()">บันทึก</div>
                                </div>
                            @endif
                        </div>

                        <div class=" {{ $panel == 3 ? '' : 'd-none' }} ">
                            <div class="form-group row">
                                <div class="col-md-6 text-center">
                                    <a target="_blank"
                                        href="{{ route('assessment_qrcode', ['act_id' => $act_id, 'p_id' => 0]) }}">{{ QrCode::size(150)->generate($urltoform) }}</a>
                                    <br><br>
                                    <h4>ผู้เข้าร่วม<h4>
                                            {{-- {{ $urltoform }} --}}
                                </div>
                                <div class="col-md-6 text-center">
                                    <a target="_blank"
                                        href="{{ route('assessment_qrcode', ['act_id' => $act_id, 'p_id' => 0]) }}">{{ QrCode::size(150)->generate($urltoform) }}</a>
                                    <br><br>
                                    <h4>ผู้นำชุมชน<h4>
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
                                            <th class="text-center">ลำดับ</th>
                                            <th class="text-center">บัตรประชาชน</th>
                                            <th class="text-center">ชื่อ-สกุล</th>
                                            <th class="text-center">ที่อยู่</th>
                                            <th class="text-center">เบอร์โทรศัพท์</th>
                                            <th class="text-center">ประเมินความพึงพอใจ</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>

                        <div class=" {{ $panel == 4 ? '' : 'd-none' }} ">
                            <div class="form-group row">
                                <div class="col-6 row">
                                    <label class="col-md-3 form-control-label text-right">จำนวนวันดำเนินการ</label>
                                    <div class="col-md-7">
                                        {{ Form::text('act_numofday', null, [
                                            'wire:model' => 'act_numofday',
                                            'id' => 'numofday',
                                            'class' => 'form-control',
                                            'disabled',
                                        ]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6 row">
                                    <label class="col-md-3 form-control-label text-right">จำนวนคน</label>
                                    <div class="col-md-7">
                                        {{ Form::text('act_numofpeople', null, [
                                            'wire:model' => 'act_numofpeople',
                                            'id' => 'act_numofpeople',
                                            'class' => 'form-control',
                                            'disabled',
                                        ]) }}
                                    </div>
                                </div>
                                <label class="col-md-2 form-control-label">อัตราค่าตอบแทนต่อคนต่อวัน <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-3">
                                    {{ Form::text('act_rate', number_format($act_rate, 2), ['class' => 'form-control', 'disabled']) }}

                                    {{-- {{ Form::text('act_rate', number_format($act_rate, 2), [
                                        'wire:model' => 'act_rate',
                                        'id' => 'act_rate',
                                        'class' => 'form-control',
                                        'disabled',
                                    ]) }} --}}
                                    @error('act_rate')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>

                            <center>
                                <div class="form-group row pt-4 pb-1 col-10 bg-blue-500">
                                    <label class="col-md-10 form-control-label text-left">
                                        <h4><b>รวมเป็นเงิน</b></h4>
                                    </label>
                                    <div class="col-md-2">
                                        {{ Form::text('act_amount', number_format($act_amount, 2), [
                                            // 'wire:model' => 'act_amount',
                                            'id' => 'act_amount',
                                            'class' => 'form-control',
                                            'disabled',
                                        ]) }}
                                    </div>
                                </div>
                            </center>

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
                                                <div class="col-md-2" wire:ignore>
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
                                                </div>
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
                // $('#DatatablesP1').DataTable().destroy();
                // $('#DatatablesP2').DataTable().destroy();
                // call_datatable2('');
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
                        ใช่ หรือไม่
                    });
                }

            });
        })
    </script>
</div>

@push('js')
    <link rel="stylesheet" href="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.css">
    <script src="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
    <script>
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

        function setDatePicker(name, val) {
            @this.set(name, val);
            @this.setArray();
        }

        function setValue_date1(name, val) {
            @this.set(name, val);
            @this.setValue_date1(name, val);
        }

        function setValue(name, val) {
            @this.set(name, val);
        }

        function setValuedate(name, val) {
            @this.set(name, val);
            @this.setArray(name, val);
        }

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

        function setSearch() {
            $('#DatatablesP1').DataTable().destroy();
            call_datatable($("#search").val());
            return false;
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
                    url: '{{ route('api.operate.result_train.list') }}',
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
                        className: "text-left",
                        orderable: false,
                    },
                    // {
                    //     data: 'rolelist',
                    //     name: 'rolelist',
                    //     className: "text-left",
                    //     orderable: false,
                    // },
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
