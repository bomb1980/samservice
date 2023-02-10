<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open([
            'wire:submit.prevent' => 'submit()',
            'autocomplete' => 'off',
            'class' => 'form-horizontal fv-form fv-form-bootstrap4',
            ]) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">หัวข้อแบบประเมิน: <span
                        class="text-danger">*</span></label>
                <div class="col-md-3">
                    {{ Form::text('assessment_topics_name', $assessment_topics_name, [
                    'wire:model' => 'assessment_topics_name',
                    'id' => 'assessment_topics_name',
                    'class' => 'form-control',
                    'autocomplete' => 'off',
                    'maxlength' => 100,
                    'placeholder' => 'หัวข้อประเมิน',
                    ]) }}
                    @error('assessment_topics_name')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภทกิจกรรม: <span
                        class="text-danger">*</span></label>
                <div class="col-md-3">
                    {!! Form::select('activity_types_id', $activity_types_list, $activity_types_id, [
                    'id' => 'activity_types_id',
                    'class' => 'form-control',
                    'placeholder' => '--เลือกประเภทกิจกรรม--'
                    ]) !!}
                    @error('activity_types_id')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภทแบบประเมิน: <span
                        class="text-danger">*</span></label>
                <div class="col-md-3">
                    {!! Form::select('assessment_types_id', $assessment_types_list, $assessment_types_id, [
                    'id' => 'assessment_types_id',
                    'class' => 'form-control',
                    'placeholder' => '--เลือกประเภทแบบประเมิน--'
                    ]) !!}
                    @error('assessment_types_id')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 form-control-label">รายละเอียดแบบประเมิน: </label>
                <div class="col-md-7">
                    {{ Form::textarea('descriptions', $descriptions, [
                    'wire:model' => 'descriptions',
                    'id' => 'descriptions',
                    'class' => 'form-control',
                    'autocomplete' => 'off',
                    'placeholder' => 'รายละเอียดแบบประเมิน',
                    ]) }}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12 text-center">
                    {{-- <button wire:click="submit" class="btn btn-primary">บันทึกข้อมูล</button> --}}
                    <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                    {!! link_to(route('master.assessment_topic.index'), 'ยกเลิก', ['class' => 'btn btn-default
                    btn-outline']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

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

        $(document).ready(function() {
            $('#activity_types_id').select2();
            $('#activity_types_id').on('change', function(e) {
                var data = $('#activity_types_id').select2("val");
                @this.activity_types_id = data;
                console.log(data);
            });

            $('#assessment_types_id').select2();
            $('#assessment_types_id').on('change', function(e) {
                var data = $('#assessment_types_id').select2("val");
                @this.assessment_types_id = data;
                console.log(data);
            });
        });


        document.addEventListener('livewire:load', function() {
            window.livewire.on('select2', function(data) {
                $('#activity_types_id').select2();
                $('#assessment_types_id').select2();
            });

            window.livewire.on('add_item', function() {
                closeModal();
            });

            window.livewire.on('save_success', function() {
                swal({
                        title: '',
                        text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                        type: 'success',
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'OK',
                    },
                    function() {
                        @this.redirectTo();
                    });
            });
        });
    </script>
</div>
