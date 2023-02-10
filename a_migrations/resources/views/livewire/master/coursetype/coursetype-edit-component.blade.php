<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {{ Form::open([
                'wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' => 'form-horizontal fv-form fv-form-bootstrap4',
            ]) }}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รหัสประเภทหลักสูตร <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::text('code', $code, [
                        'wire:model' => 'code',
                        'id' => 'code',
                        'class' => 'form-control',
                        'maxlength' => 3,
                    ]) }}
                    @error('code')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อประเภทหลักสูตร <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::text('name', $name, [
                        'wire:model' => 'name',
                        'id' => 'name',
                        'class' => 'form-control',
                        'maxlength' => 1000,
                    ]) }}
                    @error('name')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อย่อ </label>
                <div class="col-md-6">
                    {{ Form::text('shortname', $shortname, [
                        'wire:model' => 'shortname',
                        'id' => 'shortname',
                        'class' => 'form-control',
                        'maxlength' => 200,
                    ]) }}
                    @error('shortname')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">กลุ่มหลักสูตร <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('coursegroup_id', $coursegroup_list, $coursegroup_id, ['class' => 'form-control select21', 'wire:change' => 'changeCoursegroup($event.target.value)','placeholder' => 'กรุณาเลือกกลุ่มหลักสูตร']) !!}
                    @error('coursegroup_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">กลุ่มสาขาอาชีพ <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('coursesubgroup_id', $coursesubgroup_list, $coursesubgroup_id, ['class' => 'form-control select22', 'wire:change' => 'changeCourseSubgroup($event.target.value)','placeholder' => 'กรุณาเลือกกลุ่มย่อยหลักสูตร']) !!}
                    @error('coursesubgroup_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                {!! link_to(route('master.coursetype.index'), 'ยกเลิก', ['class' => 'btn btn-default btn-outline']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('js')
    <script>

        // $('.select21').select2();
        // $('.select22').select2();

        function submit_click() {
            swal({
                title: 'ยืนยันการ แก้ไข ข้อมูล ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.submit();
                }
            });
        }
    </script>
@endpush
