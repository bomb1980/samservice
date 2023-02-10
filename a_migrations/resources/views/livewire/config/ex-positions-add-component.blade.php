<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=> 'submit()', 'autocomplete'=>'off',
            'class'=>'fv-form form-horizontal fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ตำแหน่งบริหารงาน: <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('executive_positons_name_th', null,
                    ['wire:model'=>'executive_positons_name_th','id'=>'executive_positons_name_th','class' => 'form-control'
                    ,'autocomplete'=>'off','maxlength' => 100,'placeholder'=>'ไม่เกิน 100 ตัวอักษร']) !!}
                    @error('executive_positons_name_th')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รายละเอียด: </label>
                <div class="col-md-7">
                    {!! Form::text('executive_positions_description', null,
                    ['wire:model'=>'executive_positions_description','id'=>'executive_positions_description','class' => 'form-control'
                    ,'autocomplete'=>'off']) !!}
                    @error('executive_positions_description')
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
