<div>
    {!! Form::open(['wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' => 'form-horizontal fv-form fv-form-bootstrap4']) !!}

    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ปีงบประมาณ</label>
        <div class="col-md-2">
            {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, ['onchange' => 'setValue("fiscalyear_code",event.target.value)', 'class' => 'form-control select2', 'placeholder' => '--เลือกปีงบประมาณ--']) !!}
            @error('fiscalyear_code')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">วันที่เบิก</label>
        <div class="input-group col-md-2">
            <input type="text" class="form-control datepicker" data-date-language="th-th" wire:model="pay_date"
                onchange="setValue('pay_date', event.target.value)" placeholder="วันที่เบิก">
            <div class="input-group-append">
                <span class="input-group-text">
                    <i class="icon wb-calendar" aria-hidden="true"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">รายการ</label>
        <div class="col-md-3">
            {!! Form::text('pay_name', $pay_name, ['wire:model' => 'pay_name', 'class' => 'form-control', 'placeholder' => 'รายการ']) !!}
            @error('pay_name')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">รายละเอียด</label>
        <div class="col-md-4">
            {!! Form::textarea('pay_desp', $pay_desp, ['wire:model' => 'pay_desp', 'class' => 'form-control', 'placeholder' => 'รายละเอียด']) !!}
            @error('list')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">จำนวนเงิน</label>
        <div class="col-md-2">
            {!! Form::number('pay_amt', $pay_amt, ['wire:model' => 'pay_amt', 'class' => 'form-control text-right', 'placeholder' => 'จำนวนเงิน']) !!}
            @error('pay_amt')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div class="form-group row d-flex justify-content-center">
        <button type="button" onclick="submit_button()" class="btn btn-primary">บันทึก</button>
    </div>
    {!! Form::close() !!}
</div>

@push('js')
    <script>

        $( function() {
            $('.select2').select2();
            $( ".datepicker" ).datepicker({
                orientation: 'auto bottom'
            });
        } );
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

        Livewire.on('emits', () => {
            $('.select2').select2();
            $(".ads_Checkbox").change(function() {
                var searchIDs = $(".ads_Checkbox").map(function(_, el) {
                    if ($(this).is(':checked')) {
                        return 'on';
                    } else {
                        return 'off';
                    }
                }).get();
                // console.log(searchIDs);
            });

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

        function submit_button() {
            swal({
                title: 'ยืนยันการ เบิกค่าใช้จ่ายส่วนกลาง ?',
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
