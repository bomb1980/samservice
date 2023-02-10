<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {{ Form::open(['wire:submit.prevent'=>
            'submit()', 'autocomplete'=>'off',
            'class'=>'form-horizontal fv-form fv-form-bootstrap4']) }}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภท  <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{ Form::text('name', null,
                    ['wire:model'=>'name','id'=>'name', 'class' => 'form-control','maxlength' => 255]) }}
                    @error('name')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>



            <div class="text-center">
                <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                <button type="button" wire:click="redirectToMain()" class="btn btn-default btn-outline">ยกเลิก</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@push('js')
    <script>
        $('.select2').select2();

        function setValue(name, val){
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
                function(isConfirm){
                    if (isConfirm) {
                        window.livewire.emit('redirectToMain');
                }
            });
        });

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


