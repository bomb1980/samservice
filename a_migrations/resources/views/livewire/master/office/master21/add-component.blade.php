<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=>
            'submit()', 'autocomplete'=>'off',
            'class'=>'form-horizontal fv-form fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อกลุ่มหลักสูตร <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::text('coursename', null,
                    ['wire:model'=>'coursename','id'=>'coursename', 'class' => 'form-control','maxlength' => 300,'placeholder'=>'ไม่เกิน 300 ตัวอักษร']) !!}
                    @error('coursename')
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



