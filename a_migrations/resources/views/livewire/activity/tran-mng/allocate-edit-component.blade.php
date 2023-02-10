<div>
    {!! Form::open([
        'wire:submit.prevent' => 'submit()',
        'autocomplete' => 'off',
        'class' => 'form-horizontal fv-form fv-form-bootstrap4',
    ]) !!}

    <div class="form-group row">
        <label class="col-md-4 form-control-label">ปีงบประมาณ <span class="text-danger">*</span></label>
        <div class="col-md-3">
            {!! Form::select('budgetyear', $fiscalyear_list, $budgetyear, [
                'id' => 'budgetyear',
                'wire:model' => 'budgetyear',
                'onchange' => 'setSearch',
                'class' => 'form-control',
                'placeholder' => '--เลือกปีงบประมาณ--',
                'disabled',
            ]) !!}
            @error('budgetyear')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-4 form-control-label">หมายเลขคำขอ <span class="text-danger">*</span></label>
        <div class="col-md-3">
            {!! Form::select('act_id', $act_list, $act_id, [
                'id' => 'act_id',
                'class' => 'form-control',
                'placeholder' => '--เลือกหมายเลขคำขอ--',
            ]) !!}
            @error('act_id')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-4 form-control-label">หน่วยงาน</label>
        <div class="col-md-3">
            {!! Form::select('dept', $dept_list, $division_id, [
                'onchange' => 'setValue("dept_id",event.target.value)',
                'class' => 'form-control select2',
                'disabled',
            ]) !!}
            @error('dept')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-4 form-control-label">ค่ากิจกรรมอบรม <span class="text-danger">*</span></label>
        <div class="col-md-3">
            {!! Form::number('allocate_training', null, [
                'wire:model' => 'allocate_training',
                'class' => 'form-control',
                'placeholder' => 'ตัวเลข จำนวน',
            ]) !!}
            @error('allocate_training')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-4 form-control-label">ค่ากิจกรรมจ้างงาน <span class="text-danger">*</span></label>
        <div class="col-md-3">
            {!! Form::number('allocate_urgent', null, [
                'wire:model' => 'allocate_urgent',
                'class' => 'form-control',
                'placeholder' => 'ตัวเลข จำนวน',
            ]) !!}
            @error('allocate_urgent')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-4 form-control-label">ค่าบริหารโครงการ <span class="text-danger">*</span></label>
        <div class="col-md-3">
            {!! Form::number('allocate_manage', null, [
                'wire:model' => 'allocate_manage',
                'class' => 'form-control',
                'placeholder' => 'ตัวเลข จำนวน',
            ]) !!}
            @error('allocate_manage')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 form-control-label">รวม</label>
        <div class="col-md-3">
            {!! Form::number('allocate_sum', null, [
                'wire:model' => 'allocate_sum',
                'class' => 'form-control',
                'disabled',
            ]) !!}
            @error('allocate_sum')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>
    {!! Form::close() !!}

    <div class="form-group row mt-4">
        <div class="col-md-12 text-center">
            <button type="button" onclick="submit()" class="btn btn-primary">บันทึก</button>
            {!! link_to(route('activity.tran_mng.index'), 'ยกเลิก', ['class' => 'btn btn-default btn-outline']) !!}
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#act_id').select2();
            $('#act_id').on('change', function(e) {
                var data = $('#act_id').select2("val");
                @this.setAct(data);
                console.log(data);
            });
        });

        document.addEventListener('livewire:load', function() {
            window.livewire.on('select2', function(data) {
                $('#act_id').select2();
            });
        })
    </script>
</div>

@push('js')
    <script>
        $('.select2').select2();

        function setDatePicker(name, val) {
            @this.set(name, val);
            @this.setArray();
            // if(name == 'stdate' || name = "endate"){
            //     @this.setArray();
            // }
        }

        function setValue(name, val) {
            @this.set(name, val);
        }

        $(".datepicker").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

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

        function submit() {
            swal({
                title: 'ยืนยันจัดสรรโอนเงิน ?',
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
