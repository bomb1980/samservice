<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {{ Form::open(['wire:submit.prevent'=>
            'submit()', 'autocomplete'=>'off',
            'class'=>'form-horizontal fv-form fv-form-bootstrap4']) }}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อประเภทความเดือดร้อน  <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::text('name', $name,
                    ['wire:model'=>'name','id'=>'name', 'class' => 'form-control','maxlength' => 1000]) }}
                    @error('name')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อย่อ  </label>
                <div class="col-md-6">
                    {{ Form::text('shotname', $shotname,
                    ['wire:model'=>'shotname','id'=>'shortname', 'class' => 'form-control','maxlength' => 200]) }}
                    @error('shortname')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                {!! link_to(route('master.troubletype.index'), 'ยกเลิก', ['class' => 'btn btn-default btn-outline']) !!}
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
