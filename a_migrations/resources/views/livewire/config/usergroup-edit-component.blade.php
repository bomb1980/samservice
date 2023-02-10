<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=> 'submit()', 'autocomplete'=>'off',
            'class'=>'fv-form form-horizontal fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อกลุ่ม: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('user_group_name', null,
                    ['wire:model'=>'user_group_name','id'=>'user_group_name','class' => 'form-control'
                    ,'autocomplete'=>'off','placeholder'=>'กรุณากรอก ชื่อกลุ่ม']) !!}
                    @error('user_group_name')
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
