<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=>
            'submit()', 'autocomplete'=>'off',
            'class'=>'form-horizontal fv-form fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ปีงบประมาณ <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{ Form::select('fiscalyear_code', $fiscalyear_select, $fiscalyear_code, ['onchange' => 'setVal("fiscalyear_code",event.target.value)', 'class' => 'form-control select2', 'placeholder' => '--เลือกปีงบประมาณ--']) }}
                    @error('fiscalyear_code')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">งวดที่ <span class="text-danger">*</span></label>
                <div class="col-md-1">
                    {!! Form::number('period_no', null, ['wire:model'=>'period_no','id'=>'period_no', 'class' => 'form-control text-right']) !!}
                    @error('period_no')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ช่วงเวลา <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{-- {!! Form::select('start_month', ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'], null, ['onchange' => 'setValue("start_month",event.target.value)', 'class' => 'form-control select2', 'placeholder' => '--เลือกเดือน--']) !!} --}}
                    <div class="input-group">
                        <input type="text" class="form-control datepicker"
                            data-date-language="th-th" onchange="setDatePicker('startdate', event.target.value)"
                            placeholder="เดือนที่เริ่ม">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    @error('startdate')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <label class="col-md-1 form-control-label text-center">- </label>
                <div class="col-md-2">
                    {{-- {!! Form::select('end_month', ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'], null, ['onchange' => 'setValue("end_month",event.target.value)', 'class' => 'form-control select2', 'placeholder' => '--เลือกเดือน--']) !!} --}}
                    <div class="input-group">
                        <input type="text" class="form-control datepicker"
                            data-date-language="th-th" onchange="setDatePicker('enddate', event.target.value)"
                            placeholder="เดือนที่สิ้นสุด">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    @error('enddate')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">สัดส่วน <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    <input type="number" wire:model="period_rate" class="form-control text-right" placeholder="เหลือสัดส่วน {{ number_format($left_per ,2) }} %" disabled>
                    {{-- {!! Form::text('period_rate', null, ['wire:model'=>'period_rate','id'=>'period_rate', 'class' => 'form-control text-right', 'disabled' => 'true']) !!} --}}
                    @error('period_rate')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <label class="col-md-1 form-control-label text-left">% </label>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">จำนวนเงิน <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    <input type="number" wire:model="period_amt" min="1" max="{{ $left_amt }}" class="form-control text-right" placeholder="เหลือจำนวนเงิน {{ number_format($left_amt ,2) }} บาท">
                    {{-- {!! Form::number('period_amt', null, ['wire:model'=>'period_amt','id'=>'period_amt', 'class' => 'form-control text-right']) !!} --}}
                    @error('period_amt')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            {!! Form::close() !!}
            <div class="text-center">
                {{-- <button class="btn btn-primary"><a class="text-white" href="{{ route('manage.installment.index') }}">บันทึกข้อมูล</a></button> --}}
                <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                <button class="btn btn-default btn-outline"><a href="{{ route('manage.installment.index') }}">ยกเลิก</a></button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $('.select2').select2();

        function setDatePicker(name, val) {
            @this.set(name, val);
            // @this.setArray();
        }
        function setVal(name, val) {
            @this.set(name, val);
        }

        $(".datepicker").datepicker( {
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

        Livewire.on('popup', () => {
            swal({
                title: "บันทึกข้อมูลเรียบร้อย",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK",
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.livewire.emit('redirect-to');
                }
            });
        });

        function submit_click() {
        swal({
            title: 'ยืนยันการ เพิ่มข้อมูลงวดเงิน ?',
            icon: 'close',
            type: "warning",
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#00BCD4',
            cancelButtonColor: '#DD6B55'
        }, function(isConfirm) {
            if (isConfirm) {
                @this.submit();
            }
        });
        }
    </script>
@endpush



