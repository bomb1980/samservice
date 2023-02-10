<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {{ Form::open([
                'wire:submit.prevent' => 'submit()',
                'autocomplete' => 'off',
                'class' => 'form-horizontal fv-form fv-form-bootstrap4',
            ]) }}

            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภทกิจกรรม: <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('acttype_id', $activity_types_list, $acttype_id, [
                        'class' => 'form-control',
                        'wire:change' => 'changeActivityType($event.target.value)',
                        'placeholder' => 'กรุณาเลือกประเภทกิจกรรม',
                    ]) !!}
                    @error('acttype_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภทแบบประเมิน: <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('assessment_types_id', $assessment_types_list, $assessment_types_id, [
                        'class' => 'form-control',
                        'wire:change' => 'changeAssessmentType($event.target.value)',
                        'placeholder' => 'กรุณาเลือกประเภทแบบประเมิน',
                    ]) !!}
                    @error('assessment_types_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            {{-- <div class="form-group row">
                <div class="col-md-3"></div>
                <label class="col-md-1" style="font-size: 1rem; padding: 0.429rem 0;">เลขที่ชุดแบบประเมิน <span
                        class="text-danger">*</span></label>
                <div class="col-md-3">
                    {{ Form::text('ASSESS_TEMPLATENO', null, [
                        'wire:model' => 'ASSESS_TEMPLATENO',
                        'id' => 'ASSESS_TEMPLATENO',
                        'class' => 'form-control',
                        'readonly' => 'true',
                    ]) }}
                    @error('ASSESS_TEMPLATENO')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div> --}}

            {{-- <div class="form-group row">
                <div class="col-md-3"></div>
                <label class="col-md-1" style="font-size: 1rem; padding: 0.429rem 0;">สร้างวันที่ <span
                        class="text-danger">*</span></label>
                <div class="col-md-3">
                    {{ Form::text('CREATE_AT', null, [
                        'wire:model' => 'CREATE_AT',
                        'id' => 'CREATE_AT',
                        'class' => 'form-control',
                        'readonly' => 'true',
                    ]) }}
                    @error('CREATE_AT')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div> --}}
            <div class="form-group row">
                <label class="col-md-6 offset-md-3 form-control-label text-left"><b>ชุดคำถามแบบให้คะแนน (1 น้อยสุด - 5 มากสุด)</b></label>
            </div>

            {{-- <div class="form-group row" style="margin-top: 2%">
                <div class="col-md-3"></div>
                <label class="col-md-6" style="font-size: 1rem; padding: 0.429rem 0;">ชุดคำถามแบบให้คะแนน (1 น้อยสุด - 5
                    มากสุด)</label>
            </div> --}}

            <div class="form-group row">
                <label class="col-md-3 form-control-label">กลุ่มคำถาม <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::select('Auto_ASSESS_HDR', $Auto_ASSESS_HDR_select2, $Auto_ASSESS_HDR, [
                        'onchange' => 'setValue("Auto_ASSESS_HDR",event.target.value)',
                        'class' => 'form-control select2',
                        'placeholder' => $ph,
                        'id' => 'selec',
                    ]) }}
                    @error('Auto_ASSESS_HDR')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            {{-- <div class="form-group row">
                <div class="col-md-3"></div>
                <label class="col-md-1" style="font-size: 1rem; padding: 0.429rem 0;">กลุ่มคำถาม <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{ Form::select('Auto_ASSESS_HDR', $Auto_ASSESS_HDR_select2, $Auto_ASSESS_HDR, [
                        'onchange' => 'setValue("Auto_ASSESS_HDR",event.target.value)',
                        'class' => 'form-control select2',
                        'placeholder' => $ph,
                        'id' => 'selec',
                    ]) }}
                    @error('Auto_ASSESS_HDR')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div> --}}

            <div class="form-group row">
                <label class="col-md-3 form-control-label">คำถาม <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::textarea('ASSESS_DESCRIPTION_R', null, [
                        'wire:model' => 'ASSESS_DESCRIPTION_R',
                        'id' => 'ASSESS_DESCRIPTION_R',
                        'class' => 'form-control',
                        'rows' => 3,
                    ]) }}
                    @error('ASSESS_DESCRIPTION_R')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary"
                        wire:click="add_r">เพิ่ม</button>
                </div>
            </div>

            {{-- <div class="form-group row">
                <div class="col-md-3"></div>
                <label class="col-md-1" style="font-size: 1rem; padding: 0.429rem 0;">คำถาม <span
                        class="text-danger">*</span></label>
                <div class="col-md-3">
                    {{ Form::textarea('ASSESS_DESCRIPTION_R', null, [
                        'wire:model' => 'ASSESS_DESCRIPTION_R',
                        'id' => 'ASSESS_DESCRIPTION_R',
                        'class' => 'form-control',
                        'rows' => 3,
                    ]) }}
                    @error('ASSESS_DESCRIPTION_R')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <label class="col-md-1" style="font-size: 1rem;"><button type="button" class="btn btn-primary"
                        wire:click="add_r">เพิ่ม</button></label>
            </div> --}}

            <div class="form-group row">
                <div class="col-md-6 offset-md-3">
                    <table class="table table-bordered table-hover table-striped w-full dataTable"
                        id="Datatables">
                        <tr style="background-color:#abe4ff">
                            <th class="text-center" style="width:10%">ลำดับ</th>
                            <th class="text-center" style="width:25%">กลุ่มคำถาม</th>
                            <th class="text-left" style="width:45%">คำถาม</th>
                            <th class="text-center" style="width:20%">ลบ</th>
                        </tr>

                        @foreach ($ASSESS_DESCRIPTION_R_LIST as $key => $value)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $Auto_ASSESS_HDR_list[$key] }}</td>
                                <td class="text-left">{{ $value }}</td>
                                <td class="text-center"><i wire:click="del_r({{ $key }})" class="wb-trash"
                                        style="color: #ff6961; cursor: pointer;"></i></td>
                            </tr>
                        @endforeach
                    </table>
                    @error('ASSESS_DESCRIPTION_R_LIST')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            {{-- Datatable --}}
            {{-- <div class="col-md-6 offset-md-3">
                <div class="table-responsive" style="margin-left: -1.75%">
                    <table class="table table-bordered mb-md-auto" id="Datatables" style="width:100%">
                        <tr style="background-color:#abe4ff">
                            <th class="text-center" style="width:10%">ลำดับ</th>
                            <th class="text-center" style="width:25%">กลุ่มคำถาม</th>
                            <th class="text-left" style="width:45%">คำถาม</th>
                            <th class="text-center" style="width:20%">ลบ</th>
                        </tr>

                        @foreach ($ASSESS_DESCRIPTION_R_LIST as $key => $value)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $Auto_ASSESS_HDR_list[$key] }}</td>
                                <td class="text-left">{{ $value }}</td>
                                <td class="text-center"><i wire:click="del_r({{ $key }})" class="wb-trash"
                                        style="color: #ff6961; cursor: pointer;"></i></td>
                            </tr>
                        @endforeach

                    </table>
                </div>
                @error('ASSESS_DESCRIPTION_R_LIST')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div> --}}

            <div class="form-group row">
                <label class="col-md-6 offset-md-3 form-control-label text-left"><b>ชุดคำถามแบบอธิบาย</b></label>
            </div>

            {{-- <div class="form-group row" style="margin-top: 3%">
                <div class="col-md-3"></div>
                <label class="col-md-6" style="font-size: 1rem; padding: 0.429rem 0;">ชุดคำถามแบบอธิบาย</label>
            </div> --}}

            <div class="form-group row">
                <label class="col-md-3 form-control-label">คำถาม <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::textarea('ASSESS_DESCRIPTION_O', null, [
                        'wire:model' => 'ASSESS_DESCRIPTION_O',
                        'id' => 'ASSESS_DESCRIPTION_O',
                        'class' => 'form-control',
                        'rows' => 3,
                    ]) }}
                    @error('ASSESS_DESCRIPTION_O')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-3">
                    <button wire:click="add_o" type="button"
                        class="btn btn-primary">เพิ่ม</button>
                </div>
            </div>

            {{-- <div class="form-group row">
                <div class="col-md-3"></div>
                <label class="col-md-1" style="font-size: 1rem; padding: 0.429rem 0;">คำถาม <span
                        class="text-danger">*</span></label>
                <div class="col-md-3">
                    {{ Form::textarea('ASSESS_DESCRIPTION_O', null, [
                        'wire:model' => 'ASSESS_DESCRIPTION_O',
                        'id' => 'ASSESS_DESCRIPTION_O',
                        'class' => 'form-control',
                        'rows' => 3,
                    ]) }}
                    @error('ASSESS_DESCRIPTION_O')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <label class="col-md-1" style="font-size: 1rem;"><button wire:click="add_o" type="button"
                        class="btn btn-primary">เพิ่ม</button></label>
            </div> --}}

            <div class="form-group row">
                <div class="col-md-6 offset-md-3">
                    <table class="table table-bordered table-hover table-striped w-full dataTable"
                        id="Datatables">
                        <tr style="background-color:#abe4ff">
                            <th class="text-center" style="width:10%">ลำดับ</th>
                            <th class="text-left" style="width:70%">คำถาม</th>
                            <th class="text-center" style="width:20%">ลบ</th>
                        </tr>
                        @foreach ($ASSESS_DESCRIPTION_O_LIST as $key => $value)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-left">{{ $value }}</td>
                                <td class="text-center"><i wire:click="del_o({{ $key }})" class="wb-trash"
                                        style="color: #ff6961; cursor: pointer;"></i></td>
                            </tr>
                        @endforeach
                    </table>
                    @error('ASSESS_DESCRIPTION_O_LIST')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            {{-- Datatable --}}
            {{-- <div class="col-md-6 offset-md-3">
                <div class="table-responsive" style="margin-left: -1.75%">
                    <table class="table table-bordered mb-md-auto" id="Datatables" style="width:100%">
                        <tr style="background-color:#abe4ff">
                            <th class="text-center" style="width:10%">ลำดับ</th>
                            <th class="text-left" style="width:70%">คำถาม</th>
                            <th class="text-center" style="width:20%">ลบ</th>
                        </tr>
                        @foreach ($ASSESS_DESCRIPTION_O_LIST as $key => $value)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-left">{{ $value }}</td>
                                <td class="text-center"><i wire:click="del_o({{ $key }})" class="wb-trash"
                                        style="color: #ff6961; cursor: pointer;"></i></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                @error('ASSESS_DESCRIPTION_O_LIST')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div> --}}

            <div class="text-center" style="margin-top: 1.5%">
                <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                <button type="button" wire:click="cancel" class="btn btn-default btn-outline">ยกเลิก</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@push('js')
    <script>
        $('.select2').select2();

        var newRec = true;
        $('#selec').on("select2:closing", function(e) {
            console.log("newRec = " + newRec)
            if (newRec == true) {
                var str = $('#selec').data("select2").$dropdown.find('.select2-search__field').val();
                if (str == '' || str == null || str == undefined) {} else {
                    @this.Auto_ASSESS_HDR = str;
                    @this.ph = str;
                }
            } else {
                newRec = true
            }
        });

        function setValue(name, val) {
            @this.set(name, val);
            // @this.ph = null;
            newRec = false;
        }
        //

        Livewire.on('emits', () => {
            $('.select2').select2();
        });

        Livewire.on('popup', () => {
            swal({
                    title: "แก้ไขข้อมูลเรียบร้อย",
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
