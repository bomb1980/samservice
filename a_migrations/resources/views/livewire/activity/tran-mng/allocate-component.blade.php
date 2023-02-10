<div>
    {!! Form::open([
        'wire:submit.prevent' => 'submit()',
        'autocomplete' => 'off',
        'class' => 'form-horizontal fv-form fv-form-bootstrap4',
    ]) !!}
    <div class="form-group row">
        <label class="form-control-label col-md-4 text-right pr-4">ปีงบประมาณ <span
            class="text-danger">*</span></label>
        {!! Form::select('budgetyear', $fiscalyear_list, $budgetyear, [
            'id' => 'budgetyear',
            'wire:model' => 'budgetyear',
            'class' => 'form-control col-md-3',
            'placeholder' => '--เลือกปีงบประมาณ--',
            // 'disabled',
        ]) !!}
        @error('budgetyear')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-4 text-right pr-4">งวดที่ <span
            class="text-danger">*</span></label>
        {!! Form::select('periodno', $period_list, $periodno, [
            'id' => 'periodno',
            'wire:model' => 'periodno',
            'class' => 'form-control col-md-3',
            'placeholder' => '--เลือกงวด--',
            // 'disabled',
        ]) !!}
        @error('periodno')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-4 text-right pr-4">หน่วยงาน</label>
        {!! Form::select('dept', $dept_list, $division_id, [
            'onchange' => 'setValue("dept_id",event.target.value)',
            'class' => 'form-control col-md-3 select2',
            'disabled',
        ]) !!}
        @error('dept')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-4 text-right pr-4">ค่ากิจกรรมอบรม <span
                class="text-danger">*</span></label>
        {{ Form::number('allocate_training', null, [
            'wire:model' => 'allocate_training',
            'class' => 'form-control col-md-2 text-right',
            'placeholder' => 'ตัวเลข จำนวน',
        ]) }}
        @error('allocate_training')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-4 text-right pr-4">ค่ากิจกรรมจ้างงาน <span
                class="text-danger">*</span></label>
        {!! Form::number('allocate_urgent', null, [
            'wire:model' => 'allocate_urgent',
            'class' => 'form-control col-md-2 text-right',
            'placeholder' => 'ตัวเลข จำนวน',
        ]) !!}
        @error('allocate_urgent')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-4 text-right pr-4">ค่าบริหารโครงการ <span
                class="text-danger">*</span></label>
        {!! Form::number('allocate_manage', null, [
            'wire:model' => 'allocate_manage',
            'class' => 'form-control col-md-2 text-right',
            'placeholder' => 'ตัวเลข จำนวน',
        ]) !!}
        @error('allocate_manage')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    {{-- <hr>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">วันที่โอน</label>
        <div class="input-group col-md-2">
            <input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th"
                onchange="setDatePicker('stdate', event.target.value)" placeholder="วันที่โอน">
            <div class="input-group-append">
                <span class="input-group-text">
                    <i class="icon wb-calendar" aria-hidden="true"></i>
                </span>
            </div>
        </div>
    </div> --}}
    <div class="form-group row">
        <label class="form-control-label col-md-4 text-right pr-4">รวม</label>
        {!! Form::number('allocate_sum', null, [
            'wire:model' => 'allocate_sum',
            'class' => 'form-control col-md-2 text-right',
            'placeholder' => 'ตัวเลข จำนวน',
            'disabled',
        ]) !!}
        @error('allocate_sum')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    {!! Form::close() !!}
    <br>
    <div class="form-group row d-flex justify-content-center mt-4">
        <button type="button" class="btn btn-primary" onclick="submit()">บันทึก</button>
    </div>
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
                title: 'ยืนยันการ ยกเลิกโครงการ ?',
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
