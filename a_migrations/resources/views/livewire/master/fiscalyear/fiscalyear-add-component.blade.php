<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open([
                'wire:submit.prevent' => 'submit()',
                'autocomplete' => 'off',
                'class' => 'form-horizontal fv-form fv-form-bootstrap4',
            ]) !!}
            <div class="form-group row">
                <label class="col-md-2 form-control-label">ปีงบประมาณ <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {!! Form::number('fiscalyear_code', null, [
                        'wire:model' => 'fiscalyear_code',
                        'id' => 'fiscalyear_code',
                        'class' => 'form-control',
                        'maxlength' => 4,
                        'placeholder' => 'ปี พ.ศ.',
                    ]) !!}
                    @error('fiscalyear_code')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">วันที่เริ่มงบฯ </label>
                <div class="col-md-3">
                    @if (!empty($fiscalyear_code))
                        <text class="form-control" id="startdate">01/10/{{ $fiscalyear_code }}</text>
                    @else
                        <text class="form-control" id="startdate"></text>
                    @endif
                </div>
                <label class="col-md-2 form-control-label">วันที่สิ้นสุดงบฯ </label>
                <div class="col-md-3">
                    @if (!empty($fiscalyear_code))
                        <text class="form-control" id="enddate">30/09/{{ $fiscalyear_code + 1 }}</text>
                    @else
                        <text class="form-control" id="enddate"></text>
                    @endif
                </div>
            </div>

            {{-- <div class="form-group row">
                <label class="col-md-2 form-control-label">วันที่เริ่มงบฯ </label>
                <div class="col-md-2">
                    <div class="input-group">
                        {!! Form::text('startdate', null, ['wire:model' => 'startdate','id' => 'startdate', 'class' => 'form-control', 'data-provide' => 'datepicker','data-date-language' => 'th-th','readonly' => 'true']) !!}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    @error('startdate')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">วันที่สิ้นสุดงบฯ </label>
                <div class="col-md-2">
                    <div class="input-group">
                        {!! Form::text('enddate', null, ['wire:model' => 'enddate','id' => 'enddate', 'class' => 'form-control', 'data-provide' => 'datepicker','data-date-language' => 'th-th','readonly' => 'true']) !!}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    @error('enddate')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div> --}}
            {{-- <div class="form-group row">
                <label class="col-md-2 form-control-label">เปิดรวบรวมคำขอ </label>
                <div class="col-md-2" wire:ignore>
                    <label class="form-control-label"> ปิด
                      <input type="checkbox" id="req_status" name="req_status" data-plugin="switchery" >
                      <span class="lever"></span> เปิด
                    </label>
                </div>
            </div> --}}
            {{-- <div class="form-group row">
                <label class="col-md-2 form-control-label">สถานะรวบรวมคำขอ </label>
                <div class="col-md-2">
                        <input type="checkbox" id="inputBasicOn" name="inputiCheckBasicCheckboxes" data-plugin="switchery" checked />
                <label class="pt-3" for="inputBasicOn">เปิด</label>
            </div> --}}
            {{-- <div class="example">
                    <div class="float-left mr-20">
                        <input type="checkbox" id="inputBasicOn" name="inputiCheckBasicCheckboxes" data-plugin="switchery" checked />
                    </div>
                <label class="pt-3" for="inputBasicOn">On</label>
                </div> --}}
            {{-- <div class="form-group row">
                <label class="col-md-2 form-control-label">วันที่</label>
                <div class="col-md-2">
                <div class="input-group date" data-provide="datepicker">
                    <input type="text" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="icon wb-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                </div>
            </div> --}}
            <div class="form-group row">
                <label class="col-md-2 form-control-label">วันที่เริ่มรวบรวมคำขอ </label>
                <div class="col-md-3">
                    <div class="input-group">
                        {!! Form::text('req_startdate', null, [
                            'wire:model' => 'req_startdate',
                            'id' => 'req_startdate',
                            'class' => 'form-control',
                            'data-provide' => 'datepicker',
                            'data-date-language' => 'th-th',
                            'readonly' => 'true',
                        ]) !!}
                        <div class="input-group-append">
                            <span wire:click='req_startdate_clear()' class="bg-light input-group-text"
                                style="cursor: pointer;">
                                <i class="text-danger icon wb-close" aria-hidden="true"></i>
                            </span>
                            <span class="bg-light input-group-text">
                                <i class="text-primary icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    @error('req_startdate')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            {{-- <div class="form-group row">
                <div class='input-group date' id='datetimepicker'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                  <span class="text-primary icon wb-calendar"></span>
                </span>
                </div>
            </div> --}}
            <div class="form-group row">
                <label class="col-md-2 form-control-label">วันที่สิ้นสุดรวบรวมคำขอ </label>
                <div class="col-md-3">
                    <div class="input-group">
                        {!! Form::text('req_enddate', null, [
                            'wire:model' => 'req_enddate',
                            'id' => 'req_enddate',
                            'class' => 'form-control',
                            'data-provide' => 'datepicker',
                            'data-date-language' => 'th-th',
                            'readonly' => 'true',
                        ]) !!}
                        <div class="input-group-append">
                            <span wire:click='req_enddate_clear()' class="bg-light input-group-text"
                                style="cursor: pointer;">
                                <i class="text-danger icon wb-close" aria-hidden="true"></i>
                            </span>
                            <span class="bg-light input-group-text">
                                <i class="text-primary icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    @error('req_enddate')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                {!! link_to(route('master.fiscalyear.index'), 'ยกเลิก', ['class' => 'btn btn-default btn-outline']) !!}
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
@push('js')
    <script>
        $(function() {
            $('#datetimepicker').datetimepicker();
        });

        // $(function() {
        // $('#datetimepicker').datepicker();
        // })
        // $('#startdate').datepicker({
        //     orientation: "bottom"
        // }).keydown(function(event) {
        //     return false;
        // });
        // $('#startdate').change(function(){
        //     @this.set('startdate', $(this).val());
        // });
        // $('#enddate').datepicker({
        //     orientation: "bottom"
        // }).keydown(function(event) {
        //     return false;
        //  });
        //  $('#enddate').change(function(){
        //     @this.set('enddate', $(this).val());
        // });
        $('#req_startdate').datepicker({
            orientation: "top"
        }).keydown(function(event) {
            return false;
        });
        $('#req_startdate').change(function() {
            @this.set('req_startdate', $(this).val());
        });

        $('#icon_req_startdate').datepicker({
            orientation: "top"
        }).keydown(function(event) {
            return false;
        });
        $('#icon_req_startdate').change(function() {
            @this.set('req_startdate', $(this).val());
        });

        $('#req_enddate').datepicker({
            orientation: "top"
        }).keydown(function(event) {
            return false;
        });
        $('#req_enddate').change(function() {
            @this.set('req_enddate', $(this).val());
        });
        $('#req_status').change(function() {
            if ($(this).is(':checked')) {
                @this.set('req_status', '1');
            } else {
                @this.set('req_status', '0');
            }
        })

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
