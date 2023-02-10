<div>ddaaddfdadsdfsdd
    {!! Form::open(['wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' => 'form-horizontal fv-form fv-form-bootstrap4']) !!}

    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ปีงบประมาณ <span class="text-danger">*</span></label>
        {{-- {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, ['onchange' => 'setValue("fiscalyear_code",event.target.value)', 'class' => 'form-control select2 col-md-2', 'placeholder' => '--เลือกปีงบประมาณ--']) !!} --}}
        {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, ['wire:change' => 'changeYears($event.target.value)', 'class' => 'form-control col-md-2', 'placeholder' => '--เลือกปีงบประมาณ--']) !!}
        @error('fiscalyear_code')
            <label class="text-danger mt-2 ml-4">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">คำขอ</label>
        {!! Form::number('total_sum', $total_sum, ['wire:model' => 'total_sum', 'class' => 'form-control col-md-3', 'disabled']) !!}
        @error('total_sum')
            <label class="text-danger mt-2 ml-4">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">เสนองบ</label>
        {!! Form::number('req_amt', $req_amt, ['wire:model' => 'req_amt', 'class' => 'form-control col-md-3', 'disabled']) !!}
        @error('req_amt')
            <label class="text-danger mt-2 ml-4">{{ $message }}</label>
        @enderror
    </div>
    <hr>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ได้รับงบ</label>
        {!! Form::number('budget_amt', $budget_amt, ['wire:model' => 'budget_amt', 'class' => 'form-control col-md-3', 'disabled']) !!}
        @error('budget_amt')
            <label class="text-danger mt-2 ml-4">{{ $message }}</label>
        @enderror
    </div>
    <hr>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ค่าบริหารส่วนกลาง</label>
        {!! Form::number('centerbudget_amt', $centerbudget_amt, ['wire:model' => 'centerbudget_amt', 'class' => 'form-control col-md-3', 'disabled']) !!}
        @error('centerbudget_amt')
            <label class="text-danger mt-2 ml-4">{{ $message }}</label>
        @enderror
    </div>
    {{-- <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ค่าบริหารส่วนภูมิภาค</label>
        {!! Form::number('regionbudget_amt', $regionbudget_amt, ['wire:model' => 'regionbudget_amt', 'class' => 'form-control col-md-3', 'disabled']) !!}
        @error('regionbudget_amt')
            <label class="text-danger mt-2 ml-4">{{ $message }}</label>
        @enderror
    </div> --}}
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">กิจกรรมจ้างงานเร่งด่วน</label>
        {!! Form::number('total_sum_labour', $total_sum_labour, ['class' => 'form-control col-md-3', 'disabled']) !!}
        @error('total_sum_labour')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">กิจกรรมทักษะฝีมือแรงงาน</label>
        {!! Form::number('total_sum_train', $total_sum_train, ['class' => 'form-control col-md-3', 'disabled']) !!}
        @error('total_sum_train')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">รวมค่าใช้จ่าย</label>
        {!! Form::number('total_budget_off', $total_budget_off, ['wire:model' => 'total_budget_off', 'class' => 'form-control col-md-3', 'disabled']) !!}
        @error('total_budget_off')
            <label class="text-danger mt-2 ml-4">{{ $message }}</label>
        @enderror
    </div>
    <hr>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">คืนเงินแผ่นดิน</label>
        {!! Form::number('refund_amt', $refund_amt, ['wire:model' => 'refund_amt', 'class' => 'form-control col-md-3', 'disabled']) !!}
        @error('refund_amt')
            <label class="text-danger mt-2 ml-4">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">บันทึก</button>
    </div>

    {!! Form::close() !!}
</div>

@push('js')
    <script>
        $('.select2').select2();

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
                function(isConfirm) {
                    if (isConfirm) {
                        window.livewire.emit('redirect-to');
                    }
                });
        });

        function button_function() {
            swal({
                title: 'ยืนยันการ ยกเลิกโครงการ ?',
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
    </script>
@endpush
