<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=>
            'submit()', 'autocomplete'=>'off',
            'class'=>'form-horizontal fv-form fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">กลุ่มหลักสูตร </span></label>
                <div class="col-md-6">
                    {!! Form::text('coursename', null,
                    ['wire:model'=>'coursename','id'=>'coursename', 'class' => 'form-control','disabled' => 'true']) !!}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">กลุ่มสาขาอาชีพ </span></label>
                <div class="col-md-6">
                    {!! Form::text('carreername', null,
                    ['wire:model'=>'carreername','id'=>'carreername', 'class' => 'form-control','disabled' => 'true']) !!}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รหัส <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {!! Form::text('schedulecode', null,
                    ['wire:model'=>'schedulecode','id'=>'schedulecode', 'class' => 'form-control','disabled' => 'true']) !!}
                    @error('schedulecode')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อคอร์สหลักสูตร <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::text('schedulename', null,
                    ['wire:model'=>'schedulename','id'=>'schedulename', 'class' => 'form-control','disabled' => 'true']) !!}
                    @error('schedulename')
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

