<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=> 'submit()', 'autocomplete'=>'off',
            'class'=>'fv-form form-horizontal fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รหัส: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('dept_code', null,
                    ['wire:model'=>'dept_code','id'=>'dept_code','class' => 'form-control'
                    ,'autocomplete'=>'off','placeholder'=>'กรุณากรอก รหัส']) !!}
                    @error('dept_code')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">หน่วยงาน: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('dept_name_th', null,
                    ['wire:model'=>'dept_name_th','id'=>'dept_name_th','class' => 'form-control'
                    ,'autocomplete'=>'off','maxlength' => 100,'placeholder'=>'ชื่อหน่วยงาน']) !!}
                    @error('dept_name_th')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ขื่อย่อ: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('dept_short_name', null,
                    ['wire:model'=>'dept_short_name','id'=>'dept_short_name','class' => 'form-control'
                    ,'autocomplete'=>'off']) !!}
                    @error('dept_short_name')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ที่อยู่: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('address', null,
                    ['wire:model'=>'address','id'=>'address','class' => 'form-control'
                    ,'autocomplete'=>'off','placeholder'=>'กรุณากรอก ที่อยู่']) !!}
                    @error('address')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ตำบล: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('district', null,
                    ['wire:model'=>'district','id'=>'district','class' => 'form-control'
                    ,'autocomplete'=>'off','placeholder'=>'กรุณากรอก ตำบล']) !!}
                    @error('district')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">อำเภอ: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('aumpur', null,
                    ['wire:model'=>'aumpur','id'=>'aumpur','class' => 'form-control'
                    ,'autocomplete'=>'off','placeholder'=>'กรุณากรอก อำเภอ']) !!}
                    @error('aumpur')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">จังหวัด: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('province', null,
                    ['wire:model'=>'province','id'=>'province','class' => 'form-control'
                    ,'autocomplete'=>'off','placeholder'=>'กรุณากรอก จังหวัด']) !!}
                    @error('province')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รหัสไปรษณีย์: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('postcode', null,
                    ['wire:model'=>'postcode','id'=>'postcode','class' => 'form-control'
                    ,'autocomplete'=>'off','maxlength' => 5,'placeholder'=>'กรุณากรอก รหัสไปรษณีย์']) !!}
                    @error('postcode')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">เบอร์โทรศัพท์: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('phone', null,
                    ['wire:model'=>'phone','id'=>'phone','class' => 'form-control'
                    ,'autocomplete'=>'off','maxlength' => 10,'placeholder'=>'กรุณากรอก เบอร์โทรศัพท์']) !!}
                    @error('phone')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">อีเมลล์: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::text('email', null,
                    ['wire:model'=>'email','id'=>'email','class' => 'form-control'
                    ,'autocomplete'=>'off','maxlength' => 100,'placeholder'=>'กรุณากรอก อีเมลล์']) !!}
                    @error('email')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภทสาขา: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {!! Form::select('branch_type_id' ,$branch_type_select, null,
                    ['wire:click'=>'changeBranchType($event.target.value)',
                    'class' => 'form-control', 'id' => 'branch_type_id',
                    'placeholder' => 'เลือกประเภทสาขา']) !!}
                    @error('branch_type_id')
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
