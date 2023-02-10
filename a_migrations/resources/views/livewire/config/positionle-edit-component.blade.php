<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=> 'submit()', 'autocomplete'=>'off',
            'class'=>'fv-form form-horizontal fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ระดับตำแหน่ง : <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('positlevel_name_th', null,
                    ['wire:model'=>'positlevel_name_th','id'=>'positlevel_name_th','class' => 'form-control'
                    ,'autocomplete'=>'off','maxlength' => 100,'placeholder'=>'กรุณากรอกระดับตำแหน่ง']) !!}
                    @error('positlevel_name_th')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รายละเอียด: </label>
                <div class="col-md-7">
                    {!! Form::text('positlevel_description', null,
                    ['wire:model'=>'positlevel_description','id'=>'positlevel_description','class' => 'form-control'
                    ,'autocomplete'=>'off']) !!}
                    @error('positlevel_description')
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
