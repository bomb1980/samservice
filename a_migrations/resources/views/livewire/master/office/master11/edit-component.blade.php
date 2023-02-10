<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=>
            'submit()', 'autocomplete'=>'off',
            'class'=>'form-horizontal fv-form fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">หน่วย <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::text('unitname', null,
                    ['wire:model'=>'unitname','id'=>'unitname', 'class' => 'form-control','maxlength' => 255,'placeholder'=>'ไม่เกิน 255 ตัวอักษร']) !!}
                    @error('unitname')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                <button type="button" wire:click='thisReset()' class="btn btn-default btn-outline">ยกเลิก</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>



