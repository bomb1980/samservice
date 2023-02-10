<div>
    {!! Form::open([
        'wire:submit.prevent' => 'submit()',
        'autocomplete' => 'off',
        'class' => 'form-horizontal fv-form fv-form-bootstrap4',
    ]) !!}
    <div class="col-lg-12">
        <div class="panel-body">
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภทแบบประเมิน <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{ Form::text('assessment_types_name', null,
                    ['wire:model'=>'assessment_types_name','id'=>'assessment_types_name', 'class' => 'form-control','maxlength' => 200]) }}
                    @error('assessment_types_name')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="form-group row mt-4">
                <div class="col-md-12 text-center">
                    <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                    {!! link_to(route('master.assessmenttype.index'), 'ยกเลิก', ['class' => 'btn btn-default btn-outline']) !!}
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}
</div>

@push('js')
    <script>
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
