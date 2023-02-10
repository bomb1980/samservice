<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=>
            'submit()', 'autocomplete'=>'off',
            'class'=>'form-horizontal fv-form fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">คำนำหน้าชื่อ  <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::text('cmleader_prefix', null,
                    ['wire:model'=>'cmleader_prefix','id'=>'cmleader_prefix', 'class' => 'form-control','maxlength' => 20,]) !!}
                    @error('cmleader_prefix')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อ <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::text('cmleader_name', null,
                    ['wire:model'=>'cmleader_name','id'=>'name', 'class' => 'form-control','maxlength' => 100]) !!}
                    @error('cmleader_name')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">นามสกุล </label>
                <div class="col-md-6">
                    {!! Form::text('cmleader_surname', null,
                    ['wire:model'=>'cmleader_surname','id'=>'cmleader_surname', 'class' => 'form-control','maxlength' => 100]) !!}
                    @error('cmleader_surname')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">หมู่ </label>
                <div class="col-md-6">
                    {!! Form::text('moo', null,
                    ['wire:model'=>'moo','id'=>'moo', 'class' => 'form-control','maxlength' => 100]) !!}
                    @error('moo')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">จังหวัด <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('province_id', $province_select, $province_id,
                    ['wire:change' => 'changeProvince($event.target.value)', 'class' => 'form-control', 'id' => 'province_id','placeholder' => 'กรุณาเลือกจังหวัด']) !!}
                    @error('province_id')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">อำเภอ <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('amphur_id', $amphur_select, $amphur_id,
                    ['wire:change' => 'changeAmphur($event.target.value)', 'class' => 'form-control', 'id' => 'amphur_id','placeholder' => 'กรุณาเลือกอำเภอ']) !!}
                    @error('amphur_id')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ตำบล <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('tambon_id', $tambon_select, $tambon_id,
                    ['wire:change' => 'changeTambon($event.target.value)', 'class' => 'form-control', 'id' => 'amphur_id','placeholder' => 'กรุณาเลือกตำบล']) !!}
                    @error('tambon_id')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">วันเกิด </label>
                <div class="col-md-3">
                    <div class="input-group">
                        {!! Form::text('cmleader_birthdate', $cmleader_birthdate, ['wire:model' => 'cmleader_birthdate','id' => 'cmleader_birthdate', 'class' => 'form-control', 'data-provide' => 'datepicker','data-date-language' => 'th-th','readonly' => 'true']) !!}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    @error('startdate')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">เบอร์โทรศัพท์ </label>
                <div class="col-md-6">
                    {!! Form::text('cmleader_tel', null,
                    ['wire:model'=>'cmleader_tel','id'=>'cmleader_tel', 'class' => 'form-control','maxlength' => 100]) !!}
                    @error('cmleader_tel')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">เบอร์แฟกซ์ </label>
                <div class="col-md-6">
                    {!! Form::text('cmleader_fax', null,
                    ['wire:model'=>'cmleader_fax','id'=>'cmleader_fax', 'class' => 'form-control','maxlength' => 100]) !!}
                    @error('cmleader_fax')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">เบอร์มือถือ </label>
                <div class="col-md-6">
                    {!! Form::text('cmleader_mobile', null,
                    ['wire:model'=>'cmleader_mobile','id'=>'cmleader_mobile', 'class' => 'form-control','maxlength' => 100]) !!}
                    @error('cmleader_mobile')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">อีเมล์ </label>
                <div class="col-md-6">
                    {!! Form::text('cmleader_email', null,
                    ['wire:model'=>'cmleader_email','id'=>'cmleader_email', 'class' => 'form-control','maxlength' => 320]) !!}
                    @error('cmleader_email')
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
@push('js')
    <script>
        $('#cmleader_birthdate').datepicker({
        orientation: "bottom"
        }).keydown(function(event) {
        return false;
        });
        $('#cmleader_birthdate').change(function(){
        @this.set('cmleader_birthdate', $(this).val());
        });
    </script>
@endpush





