<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open([
                'wire:submit.prevent' => 'submit()',
                'autocomplete' => 'off',
                'class' => 'form-horizontal fv-form fv-form-bootstrap4',
            ]) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อหัวข้อประเมิน <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::text('estimate_name', null, [
                        'wire:model' => 'estimate_name',
                        'id' => 'estimate_name',
                        'class' => 'form-control',
                        'maxlength' => 20,
                    ]) !!}
                    @error('estimate_name')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อย่อ ข้อประเมิน <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::text('estimate_short', null, [
                        'wire:model' => 'estimate_short',
                        'id' => 'estimate_short',
                        'class' => 'form-control',
                        'maxlength' => 200,
                    ]) !!}
                    @error('estimate_short')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">กิจกรรม <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('acttype_id', $acttype_list, 1, [
                        'wire:model' => 'acttype_id',
                        'class' => 'form-control select2',
                        'id' => 'acttype_id',
                        'placeholder' => 'กรุณาเลือกกิจกรรม',
                    ]) !!}
                    @error('acttype_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภทแบบประเมิน <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('estimate_type_id', $estimate_type_list, 1, [
                        'wire:model' => 'estimate_type_id',
                        'class' => 'form-control select2',
                        'id' => 'estimate_type_id',
                        'placeholder' => 'กรุณาเลือกประเภทแบบประเมิน',
                    ]) !!}
                    @error('coursesubgroup_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                <button type="button" wire:click='thisReset()' class="btn btn-default btn-outline">ยกเลิก</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@push('js')
    <script>
        $('.select2').select2();

        function setValue(name, val) {
            @this.set(name, val);
        }

        Livewire.on('emits', () => {
            $('.select2').select2();
        });

        Livewire.on('popup', () => {
            swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.livewire.emit('redirect-to');
                    }
                });
        });

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
