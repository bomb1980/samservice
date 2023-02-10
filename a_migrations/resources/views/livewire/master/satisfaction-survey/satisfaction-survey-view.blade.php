<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {{ Form::open(['wire:submit.prevent'=>
            'submit()', 'autocomplete'=>'off',
            'class'=>'form-horizontal fv-form fv-form-bootstrap4']) }}

            <div class="form-group row">
                <div class="col-md-3"></div>
                <label class="col-md-1" style="font-size: 1rem; padding: 0.429rem 0;">เลขที่ชุดแบบประเมิน  <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {{ Form::text('ASSESS_TEMPLATENO', null,
                    ['wire:model'=>'ASSESS_TEMPLATENO','id'=>'ASSESS_TEMPLATENO', 'class' => 'form-control', 'readonly'=>'true']) }}
                    @error('ASSESS_TEMPLATENO')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                {{-- <label class="col-md-1" style="font-size: 1rem;"><button wire:click="auto_ASSESS_TEMPLATENO" type="button" class="btn btn-primary">อัตโนมัต</button></label> --}}
            </div>

            <div class="form-group row">
                <div class="col-md-3"></div>
                <label class="col-md-1" style="font-size: 1rem; padding: 0.429rem 0;">สร้างวันที่  <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {{ Form::text('UPDATE_AT', null,
                    ['wire:model'=>'UPDATE_AT','id'=>'UPDATE_AT', 'class' => 'form-control', 'readonly'=>'true']) }}
                    @error('UPDATE_AT')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                {{-- <label class="col-md-1" style="font-size: 1rem;"><button wire:click="auto_UPDATE_AT"  type="button" class="btn btn-primary">อัตโนมัต</button></label> --}}
            </div>

            <div class="form-group row" style="margin-top: 2%">
                <div class="col-md-3"></div>
                <label class="col-md-9" style="font-size: 1rem; padding: 0.429rem 0;">ชุดคำถามแบบให้คะแนน (1 น้อยสุด - 5 มากสุด)</label>
            </div>

            <div class="form-group row">
                <div class="col-md-3"></div>
                <label class="col-md-1" style="font-size: 1rem; padding: 0.429rem 0;">กลุ่มคำถาม  <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{ Form::text('Auto_ASSESS_HDR', null,
                    ['wire:model'=>'Auto_ASSESS_HDR','id'=>'Auto_ASSESS_HDR', 'class' => 'form-control', 'readonly'=>'true']) }}
                    @error('Auto_ASSESS_HDR')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-3"></div>
                <label class="col-md-1" style="font-size: 1rem; padding: 0.429rem 0;">คำถาม  <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {{ Form::textarea('ASSESS_DESCRIPTION_R', null,
                    ['wire:model'=>'ASSESS_DESCRIPTION_R','id'=>'ASSESS_DESCRIPTION_R', 'class' => 'form-control','rows' => 3, 'readonly'=>'true']) }}
                    @error('ASSESS_DESCRIPTION_R')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <label class="col-md-1" style="font-size: 1rem;"><button type="button" class="btn btn-primary" wire:click="add_r" disabled>เพิ่ม</button></label>
            </div>

            {{-- Datatable --}}
            <div class="col-md-6 offset-md-3" >
                <div class="table-responsive" style="margin-left: -1.75%">
                    <table class="table table-bordered mb-md-auto" id="Datatables" style="width:100%">
                        <tr style="background-color:#abe4ff">
                            <th class="text-center" style="width:10%">ลำดับ</th>
                            <th class="text-center" style="width:25%">กลุ่มคำถาม</th>
                            <th class="text-left" style="width:45%">คำถาม</th>
                            <th class="text-center" style="width:20%">ลบ</th>
                        </tr>
                        {{-- where the for begin --}}
                        @foreach ($ASSESS_DESCRIPTION_R_LIST as $key=>$value )
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td class="text-center">{{$Auto_ASSESS_HDR_list[$key]}}</td>
                                <td class="text-left">{{$value}}</td>
                                <td class="text-center">-</td>
                            </tr>
                        @endforeach
                        {{-- --- --}}
                    </table>
                </div>
                @error('ASSESS_DESCRIPTION_R_LIST')
                <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            {{-- -- --}}


            <div class="form-group row" style="margin-top: 3%">
                <div class="col-md-3"></div>
                <label class="col-md-9" style="font-size: 1rem; padding: 0.429rem 0;">ชุดคำถามแบบอธิบาย</label>
            </div>

            <div class="form-group row">
                <div class="col-md-3"></div>
                <label class="col-md-1" style="font-size: 1rem; padding: 0.429rem 0;">คำถาม  <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {{ Form::textarea('ASSESS_DESCRIPTION_O', null,
                    ['wire:model'=>'ASSESS_DESCRIPTION_O','id'=>'ASSESS_DESCRIPTION_O', 'class' => 'form-control','rows' => 3, 'readonly'=>'true']) }}
                    @error('ASSESS_DESCRIPTION_O')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <label class="col-md-1" style="font-size: 1rem;"><button wire:click="add_o" type="button" class="btn btn-primary" disabled>เพิ่ม</button></label>
            </div>

            {{-- Datatable --}}
            <div class="col-md-6 offset-md-3" >
                <div class="table-responsive" style="margin-left: -1.75%">
                    <table class="table table-bordered mb-md-auto" id="Datatables" style="width:100%">
                        <tr style="background-color:#abe4ff">
                            <th class="text-center" style="width:10%">ลำดับ</th>
                            <th class="text-left" style="width:70%">คำถาม</th>
                            <th class="text-center" style="width:20%">ลบ</th>
                        </tr>
                        {{-- where the for begin --}}
                        @foreach ($ASSESS_DESCRIPTION_O_LIST as $key=>$value )
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td class="text-left">{{$value}}</td>
                                <td class="text-center">-</td>
                            </tr>
                        @endforeach
                        {{-- --- --}}
                    </table>
                </div>
                @error('ASSESS_DESCRIPTION_O_LIST')
                <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            {{-- -- --}}

            <div class="text-center" style="margin-top: 1.5%">
                <button type="button" wire:click="cancel" class="btn btn-default btn-outline">ย้อนกลับ</button>
            </div>
            {{ Form::close() }}
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
                title: "แก้ไขข้อมูลเรียบร้อย",
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
