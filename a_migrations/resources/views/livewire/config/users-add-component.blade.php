<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=> 'submit()', 'autocomplete'=>'off',
            'class'=>'fv-form form-horizontal fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อ: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('em_name_th', null,
                    ['wire:model'=>'em_name_th','id'=>'em_name_th','class' => 'form-control'
                    ,'autocomplete'=>'off','placeholder'=>'กรุณากรอก ชื่อ']) !!}
                    @error('em_name_th')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">นามสกุล: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('em_surname_th', null,
                    ['wire:model'=>'em_surname_th','id'=>'em_surname_th','class' => 'form-control'
                    ,'autocomplete'=>'off','placeholder'=>'กรุณากรอก นามสกุล']) !!}
                    @error('em_surname_th')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รหัสผู้ใช้: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('em_citizen_id', null,
                    ['wire:model'=>'em_citizen_id','id'=>'em_citizen_id','class' => 'form-control'
                    ,'autocomplete'=>'off','maxlength' => 13,'placeholder'=>'กรุณากรอก รหัสผู้ใช้']) !!}
                    @error('em_citizen_id')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ตำแหน่ง: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::select('position_id' ,$position_select, null,
                    ['wire:click'=>'changeposition($event.target.value)',
                    'class' => 'form-control', 'id' => 'position_id',
                    'placeholder' => 'เลือกประเภทสาขา']) !!}
                    @error('position_id')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ระดับ: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::select('positionle_id' ,$positionle_select, null,
                    ['wire:click'=>'changepositionle($event.target.value)',
                    'class' => 'form-control', 'id' => 'positionle_id',
                    'placeholder' => 'เลือกระดับ']) !!}
                    @error('positionle_id')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">หน่วยงาน: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::select('department_id' ,$department_select, null,
                    ['wire:click'=>'changedepartment($event.target.value)',
                    'class' => 'form-control', 'id' => 'department_id',
                    'placeholder' => 'เลือกหน่วยงาน']) !!}
                    @error('department_id')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">กลุ่มผู้ใช้งาน: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::select('user_group_id' ,$usergroup_select, null,
                    ['wire:click'=>'changeusergroup($event.target.value)',
                    'class' => 'form-control', 'id' => 'user_group_id',
                    'placeholder' => 'เลือกกลุ่มผู้ใช้งาน']) !!}
                    @error('user_group_id')
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
