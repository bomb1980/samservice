<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {{ Form::open(['wire:submit.prevent'=> 'submit()', 'autocomplete'=>'off', 'class'=>'form-horizontal fv-form fv-form-bootstrap4']) }}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รหัสกลุ่มสาขาอาชีพ  <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::text('code', $code, ['wire:model'=>'code','id'=>'code', 'class' => 'form-control','maxlength' => 2]) }}
                    @error('code')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อกลุ่มสาขาอาชีพ  <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::text('name', $name,
                    ['wire:model'=>'name','id'=>'name', 'class' => 'form-control','maxlength' => 1000]) }}
                    @error('name')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อย่อ  <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::text('shortname', $shortname,
                    ['wire:model'=>'shortname','id'=>'shortname', 'class' => 'form-control','maxlength' => 200]) }}
                    @error('shortname')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภทกิจกรรม  {{ $acttype_id }}<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('acttype_id', $acttype_list, $acttype_id, ['class' => 'form-control select2', 'wire:change' => 'changeActtype($event.target.value)','placeholder' => 'กรุณาเลือกประเภทกิจกรรม']) !!}
                    @error('acttype_id')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">กลุ่มหลักสูตร  <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('coursegroup_id', $coursegroup_list, $coursegroup_id, ['class' => 'form-control select2', 'wire:change' => 'changeCoursegroup($event.target.value)','placeholder' => 'กรุณาเลือกกลุ่มหลักสูตร']) !!}
                    @error('coursegroup_id')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                {!! link_to(route('master.coursegroup.index'), 'ยกเลิก', ['class' => 'btn btn-default btn-outline']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('js')
    <script>

        $('.select2').select2();

        function submit_click() {
            swal({
                title: 'ยืนยันการ บันทึก ข้อมูล ?',
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
