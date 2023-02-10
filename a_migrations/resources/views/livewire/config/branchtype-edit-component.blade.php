<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=> 'submit()', 'autocomplete'=>'off',
            'class'=>'fv-form form-horizontal fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อประเภทหน่วยงาน: <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('branch_name', $branch_name,
                    ['wire:model'=>'branch_name','id'=>'branch_name','class' => 'form-control'
                    ,'autocomplete'=>'off','placeholder'=>'กรุณากรอก ชื่อประเภทหน่วยงาน']) !!}
                    @error('branch_name')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อประเภทหน่วยงาน (ย่อย): </label>
                <div class="col-md-7">
                    {!! Form::text('branch_short_name', $branch_short_name,
                    ['wire:model'=>'branch_short_name','id'=>'branch_short_name','class' => 'form-control'
                    ,'autocomplete'=>'off','maxlength' => 100,'placeholder'=>'ไม่เกิน 100 ตัวอักษร']) !!}
                    @error('branch_short_name')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รายละเอียดประเภทหน่วยงาน: </label>
                <div class="col-md-7">
                    {!! Form::text('branch_description', $branch_description,
                    ['wire:model'=>'branch_description','id'=>'branch_description','class' => 'form-control'
                    ,'autocomplete'=>'off']) !!}
                    @error('branch_description')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                <button type="reset" wire:click='thisReset()' class="btn btn-default btn-outline">ยกเลิก</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
