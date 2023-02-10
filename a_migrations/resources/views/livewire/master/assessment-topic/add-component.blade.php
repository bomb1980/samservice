<div>
    <div class="col-lg-12">
        <div class="panel-body">

            <div class="form-group row">
                <label class="col-md-2 form-control-label">ข้อมูลหัวข้อประเมิน: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {{ Form::text('assessment_topics_name', null, [
                        'wire:model' => 'assessment_topics_name',
                        'id' => 'assessment_topics_name',
                        'class' => 'form-control',
                        'autocomplete' => 'off',
                        'maxlength' => 100,
                        'placeholder' => 'ข้อมูลหัวข้อประเมิน',
                    ]) }}
                    @error('assessment_topics_name')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12 text-center">
                    <button wire:click="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                    {!! link_to(route('master.assessment_topic.index'), 'ยกเลิก', ['class' => 'btn btn-default btn-outline']) !!}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
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
