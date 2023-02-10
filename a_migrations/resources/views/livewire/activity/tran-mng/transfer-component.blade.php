<div>
    {!! Form::open(['wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' => 'form-horizontal fv-form fv-form-bootstrap4']) !!}
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ปีงบประมาณ</label>
        {!! Form::select('fiscalyear_code', $fiscalyear_list, null, ['id' => 'fiscalyear_code', 'onchange' => 'setSearch', 'class' => 'form-control col-md-2', 'placeholder' => '--เลือกปีงบประมาณ--']) !!}
        @error('fiscalyear_code')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">หน่วยงาน</label>
        {!! Form::select('dept', $dept_list, null, ['onchange' => 'setValue("dept_id",event.target.value)', 'class' => 'form-control col-md-2 select2']) !!}
        @error('dept')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ยอดยืนยัน</label>
        {!! Form::number('project_cost', null, ['onchange' => 'setValue("dept_id",event.target.value)', 'class' => 'form-control col-md-2', 'placeholder' => 'ยอดยืนยันโครงการ']) !!}
        @error('project_cost')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <hr>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">จัดสรร</label>
        {!! Form::number('project_cost', null, ['onchange' => 'setValue("dept_id",event.target.value)', 'class' => 'form-control col-md-2', 'placeholder' => 'ค่ากิจกรรม']) !!}
        @error('project_cost')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <hr>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">โอนแล้ว</label>
        {!! Form::number('project_cost', null, ['onchange' => 'setValue("dept_id",event.target.value)', 'class' => 'form-control col-md-2', 'placeholder' => 'ค่าบริหารโครงการ']) !!}
        @error('project_cost')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">รอโอน</label>
        {!! Form::number('project_cost', null, ['onchange' => 'setValue("dept_id",event.target.value)', 'class' => 'form-control col-md-2', 'placeholder' => 'ค่าบริหารโครงการ']) !!}
        @error('project_cost')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <hr>
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
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">จำนวน</label>
        {!! Form::number('project_cost', null, ['onchange' => 'setValue("dept_id",event.target.value)', 'class' => 'form-control col-md-2']) !!}
        @error('project_cost')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row d-flex justify-content-center mt-4">
        <button type="submit" class="btn btn-primary">บันทึก</button>
    </div>
    {!! Form::close() !!}
</div>
    {!! Form::close() !!}
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

        $(".datepicker").datepicker( {
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

        Livewire.on('emits', () => {
            $('.select2').select2();
            $(".ads_Checkbox").change(function() {
                var searchIDs = $(".ads_Checkbox").map(function(_, el) {
                    if ($(this).is(':checked')) {
                        return 'on';
                    } else {
                        return 'off';
                    }
                }).get();
                // console.log(searchIDs);
            });

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
                        window.livewire.emit('redirect-to');
                }
            });
        });

        function button_function() {
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
                    @this.redirect_to();
                }
            });
        }
    </script>
@endpush
