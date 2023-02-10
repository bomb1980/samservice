<div>
    <div class="col-lg-12">
        <div class="panel-body">
            <form onsubmit="return false" class="form-horizontal fv-form fv-form-bootstrap4">
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ปีงบประมาณ <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, ['onchange' => 'setValue("fiscalyear_code",event.target.value)', 'class' => 'form-control select2', 'placeholder' => '--เลือกปีงบประมาณ--']) !!}
                    @error('fiscalyear_code')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">งวดที่ <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {!! Form::select('fybdperiod_id', $fybdperiod_list, $fybdperiod_id, ['onchange' => 'setValue("fybdperiod_id",event.target.value)', 'class' => 'form-control select2', 'placeholder' => '--เลือกงวด--']) !!}
                    {{-- {!! form::text('fybdperiod_id', null,
                    ['wire:model'=>'fybdperiod_id','id'=>'fybdperiod_id', 'class' => 'form-control text-right']) !!} --}}
                    @error('fybdperiod_id')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">วันที่รับโอน <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" class="form-control" data-date-language="th-th"  data-plugin="datepicker" onchange="setValue('transfer_date', event.target.value)" placeholder="วว/ดด/ปปปป">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    @error('transfer_date')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">จำนวนเงิน <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {!! Form::number('transfer_amt', $transfer_amt, ['wire:model' => 'transfer_amt', 'class' => 'form-control text-right', 'placeholder' => 'ตัวเลข จำนวน']) !!}
                    @error('transfer_amt')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รายละเอียด</label>
                <div class="col-md-3">
                    {!! Form::textarea('transfer_desp', $transfer_desp, ['wire:model' => 'transfer_desp', 'rows' => 4, 'class' => 'form-control', 'placeholder' => 'รายละเอียด']) !!}
                </div>
            </div>
            {{-- <div class="form-group row">
                <label class="col-md-3 form-control-label">จัดสรรส่วนกลาง <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    <input type="text" class="form-control text-right" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">จัดสรรส่วนภูมิภาค <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    <input type="text" class="form-control text-right" value="">
                </div>
            </div> --}}
            </form>
            <div class="text-center">
                <button type="button" onclick="submit()" class="btn btn-primary">บันทึกข้อมูล</button>
                <button class="btn btn-default btn-outline"><a href="{{ route('manage.receivetransfer.index') }}">ยกเลิก</a></button>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    function setValue(name, val){
        @this.set(name, val);
    }

    function submit() {
        swal({
            title: 'ยืนยันการ เพิ่มข้อมูลรับโอนเงินจากสำนักงบประมาณ ?',
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




