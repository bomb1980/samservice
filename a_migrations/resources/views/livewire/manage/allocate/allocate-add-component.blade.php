<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=>
            'submit()', 'autocomplete'=>'off',
            'class'=>'form-horizontal fv-form fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ปีงบประมาณ <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {!! Form::select('fiscalyear_code', ['2566','2565'], null, ['onchange' => 'setValue("fiscalyear_code",event.target.value)', 'class' => 'form-control select2', 'placeholder' => '--เลือกปีงบประมาณ--']) !!}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">งวดที่ <span class="text-danger">*</span></label>
                <div class="col-md-1">
                    {!! Form::text('formtopic', null,
                    ['wire:model'=>'formtopic','id'=>'formtopic', 'class' => 'form-control text-right']) !!}
                    @error('formtopic')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">เงินส่วนกลาง <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    <input type="text" class="form-control text-right" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">เงินส่วนภูมิภาค <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    <input type="text" class="form-control text-right" value="">
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">จัดสรรใหม่ </label>
            </div>
            <div class="form-group row">
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
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รวม <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    <input type="text" class="form-control text-right" value="">
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary"><a class="text-white" href="{{ route('manage.fiscalcenter.index') }}">บันทึกข้อมูล</a></button>
                <button class="btn btn-default btn-outline"><a href="{{ route('manage.fiscalcenter.index') }}">ยกเลิก</a></button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@push('js')
<script>
    $('#transfer_date').datepicker({
        orientation: "buttom"
    }).keydown(function(event) {
        return false;
    });
    $('#transfer_date').change(function(){
        @this.set('transfer_date', $(this).val());
    });
</script>
@endpush




