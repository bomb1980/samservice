<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=>
            'submit()', 'autocomplete'=>'off',
            'class'=>'form-horizontal fv-form fv-form-bootstrap4']) !!}

            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อกลุ่มหลักสูตร  <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('courseno', $courseno_select, $courseno,
                    ['wire:change' => 'changeCourseNo($event.target.value)', 'class' => 'form-control', 'id' => 'courseno','placeholder' => 'กรุณาเลือกชื่อหลักสูตร']) !!}
                    @error('courseno')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อกลุ่มสาขาอาชีพ <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::text('carreername', null,
                    ['wire:model'=>'carreername','id'=>'carreername', 'class' => 'form-control','maxlength' => 200,'placeholder'=>'ไม่เกิน 200 ตัวอักษร']) !!}
                    @error('coursename')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">1 หลักและเหตุผล  </label>
                <div class="col-md-6">
                    {!! Form::textarea('groupcarreer1', null,
                    ['wire:model'=>'groupcarreer1','id'=>'groupcarreer1', 'class' => 'form-control','maxlength' => 1000,'placeholder'=>'ไม่เกิน 1000 ตัวอักษร']) !!}
                    @error('groupcarreer1')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">2 วัตถุประสงค์โครงการ  </label>
                <div class="col-md-6">
                    {!! Form::textarea('groupcarreer2', null,
                    ['wire:model'=>'groupcarreer2','id'=>'groupcarreer2', 'class' => 'form-control','maxlength' => 1000,'placeholder'=>'ไม่เกิน 1000 ตัวอักษร']) !!}
                    @error('groupcarreer2')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">3 เนื้อหาหลักสูตร  </label>
                <div class="col-md-6">
                    {!! Form::textarea('groupcarreer3', null,
                    ['wire:model'=>'groupcarreer3','id'=>'groupcarreer3', 'class' => 'form-control','maxlength' => 1000,'placeholder'=>'ไม่เกิน 1000 ตัวอักษร']) !!}
                    @error('groupcarreer3')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">4 คุณสมบัติผู้เรียน  </label>
                <div class="col-md-6">
                    {!! Form::textarea('groupcarreer4', null,
                    ['wire:model'=>'groupcarreer4','id'=>'groupcarreer4', 'class' => 'form-control','maxlength' => 1000,'placeholder'=>'ไม่เกิน 1000 ตัวอักษร']) !!}
                    @error('groupcarreer4')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">5 รูปแบบหรือวิธีอบรม  </label>
                <div class="col-md-6">
                    {!! Form::textarea('groupcarreer5', null,
                    ['wire:model'=>'groupcarreer5','id'=>'groupcarreer5', 'class' => 'form-control','maxlength' => 1000,'placeholder'=>'ไม่เกิน 1000 ตัวอักษร']) !!}
                    @error('groupcarreer5')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">6 วิธีรูปแบบประเมินผล  </label>
                <div class="col-md-6">
                    {!! Form::textarea('groupcarreer6', null,
                    ['wire:model'=>'groupcarreer6','id'=>'groupcarreer6', 'class' => 'form-control','maxlength' => 1000,'placeholder'=>'ไม่เกิน 1000 ตัวอักษร']) !!}
                    @error('groupcarreer6')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">7 จำนวนวันที่ใช้อบรม  </label>
                <div class="col-md-6">
                    {!! Form::textarea('groupcarreer7', null,
                    ['wire:model'=>'groupcarreer7','id'=>'groupcarreer7', 'class' => 'form-control','maxlength' => 1000,'placeholder'=>'ไม่เกิน 1000 ตัวอักษร']) !!}
                    @error('groupcarreer7')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">8 อุปกรณ์สถานที่จัดอบรม  </label>
                <div class="col-md-6">
                    {!! Form::textarea('groupcarreer8', null,
                    ['wire:model'=>'groupcarreer8','id'=>'groupcarreer8', 'class' => 'form-control','maxlength' => 1000,'placeholder'=>'ไม่เกิน 1000 ตัวอักษร']) !!}
                    @error('groupcarreer8')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">9 คุณวุฒิ คุณสมบัติวิทยากร  </label>
                <div class="col-md-6">
                    {!! Form::textarea('groupcarreer9', null,
                    ['wire:model'=>'groupcarreer9','id'=>'groupcarreer9', 'class' => 'form-control','maxlength' => 1000,'placeholder'=>'ไม่เกิน 1000 ตัวอักษร']) !!}
                    @error('groupcarreer9')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">10 ผลที่คาดว่าจะได้รับ  </label>
                <div class="col-md-6">
                    {!! Form::textarea('groupcarreer10', null,
                    ['wire:model'=>'groupcarreer10','id'=>'groupcarreer10', 'class' => 'form-control','maxlength' => 1000,'placeholder'=>'ไม่เกิน 1000 ตัวอักษร']) !!}
                    @error('groupcarreer10')
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
