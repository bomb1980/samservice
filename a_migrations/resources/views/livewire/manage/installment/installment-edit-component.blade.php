<div>
    @php
        $i = 0;
    @endphp

    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open([
                'wire:submit.prevent' => 'submit()',
                'autocomplete' => 'off',
                'class' => 'form-horizontal fv-form fv-form-bootstrap4',
            ]) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ปีงบประมาณ <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{ Form::select('fiscalyear_code', $fiscalyear_select, $datas->fiscalyear_code, ['onchange' => 'setVal("fiscalyear_code",event.target.value)', 'class' => 'form-control select2', 'placeholder' => '--เลือกปีงบประมาณ--', 'disabled']) }}
                    @error('fiscalyear_code')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">งวดที่ <span class="text-danger">*</span></label>
                <div class="col-md-1">
                    {!! Form::number('period_no', null, [
                        'wire:model' => 'set_sub_data.periodno',
                        'id' => 'period_no',
                        'class' => 'form-control text-right',
                        'disabled',
                    ]) !!}
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
                        <input type="text" class="form-control datepicker" data-date-language="th-th"
                            onchange="setDatePicker('set_sub_data.startperioddate', event.target.value)"
                            wire:model="set_sub_data.startperioddate" placeholder="เดือนที่เริ่ม">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>




                    @error('set_sub_data.startperioddate')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror

                    @if (session()->get('startperioddate'))
                        <label class="text-danger">{{ session()->get('startperioddate') }}</label>
                    @endif

                </div>
                <label class="col-md-1 form-control-label text-center">- </label>


                <div class="col-md-2">

                    <div class="input-group">
                        <input type="text" class="form-control datepicker" data-date-language="th-th"
                            onchange="setDatePicker('set_sub_data.endperioddate', event.target.value)"
                            wire:model="set_sub_data.endperioddate" placeholder="เดือนที่สิ้นสุด">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>


                    @error('set_sub_data.endperioddate')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror

                    @if (session()->get('endperioddate'))
                        <label class="text-danger">{{ session()->get('endperioddate') }}</label>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 form-control-label">สัดส่วน <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    <input type="number" wire:model="period_rate" class="form-control text-right" placeholder="เหลือสัดส่วน 100.00 %" disabled="">

                                    </div>
                <label class="col-md-1 form-control-label text-left">% </label>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">จำนวนเงิน <span class="text-danger">*</span></label>
                <div class="col-md-2">

                    {{ Form::text('set_sub_data[budgetperiod]', $set_sub_data['budgetperiod'], [
                        'wire:model' => 'set_sub_data.budgetperiod',
                        'onkeyup' => 'javascript:controlnumbers( this )',
                        'class'=>'form-control text-right',
                        'placeholder' => 'เหลือจำนวนเงิน',
                    ]) }}

                    @error('set_sub_data.budgetperiod')
                    <br>
                        <label class="text-danger">{{ $message }}</label>
                    @enderror


                    @if (session()->get('getSubDataTotal'))
                        <br>
                        <label class="text-danger">{{ session()->get('getSubDataTotal') }}</label>
                    @endif

                    @if (session()->get('budgetperiod'))
                        <br>
                        <label class="text-danger">{{ session()->get('budgetperiod') }}</label>
                    @endif
                </div>
            </div>

            {!! Form::close() !!}
            <div class="text-center">
                <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                <button type="button" wire:click='redirect_to()' class="btn btn-default btn-outline">ยกเลิก</button>
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


        $(".datepicker").datepicker({
            format: "mm/yyyy",
            viewMode: "months",
            minViewMode: "months"
        });



        // Livewire.on('dddddfdfdfdf', () => {
        //     $(".datepicker").datepicker({
        //         format: "mm/yyyy",
        //         viewMode: "months",
        //         minViewMode: "months"
        //     });
        // });

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
