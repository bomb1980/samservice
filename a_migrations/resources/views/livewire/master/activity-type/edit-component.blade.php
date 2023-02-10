<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open([
            'wire:submit.prevent' => 'submit()',
            'autocomplete' => 'off',
            'class' => 'form-horizontal fv-form fv-form-bootstrap4',
            ]) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อประเภทกิจกรรม: <span
                        class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::text('name', $name, [
                    'wire:model' => 'name',
                    'id' => 'name',
                    'class' => 'form-control',
                    'autocomplete' => 'off',
                    'maxlength' => 100,
                    'placeholder' => 'ชื่อประเภทกิจกรรม',
                    ]) }}
                    @error('name')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12 text-center">
                    <button onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                    {!! link_to(route('master.activitytype.index'), 'ยกเลิก', ['class' => 'btn btn-default
                    btn-outline']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@push('js')
    <script>
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
