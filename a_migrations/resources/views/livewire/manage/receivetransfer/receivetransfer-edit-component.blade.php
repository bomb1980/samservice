<div>
    <div class="col-lg-12">
        <br>
        <br>
        <br>
        <br>
        <div class="panel-body">
            {{-- <form onsubmit="return false" class="form-horizontal fv-form fv-form-bootstrap4"> --}}

            {!! Form::open([
                'wire:submit.prevent' => 'submit(Object.fromEntries(new FormData($event.target)))',
                'autocomplete' => 'off',
                'class' => 'fv-form form-horizontal fv-form-bootstrap4',
                // 'method' => 'GET'
            ]) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ปีงบประมาณ <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {!! Form::select('fiscalyear_code', $year_list, $fiscalyear_code, [
                        'wire:change' => 'clearArea("fiscalyear_code")',
                        'class' => 'form-control select2',
                        'wire:model' => 'fiscalyear_code',
                        'placeholder' => '--เลือกปีงบประมาณ--',
                    ]) !!}
                    @error('fiscalyear_code')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">งวดที่ <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {!! Form::select('fybdperiod_id', $periodno_list, $fybdperiod_id, [
                        'wire:change' => 'clearArea("fybdperiod_id")',
                        'class' => 'form-control select2',
                        'placeholder' => '--เลือกงวด--',
                        'wire:model' => 'fybdperiod_id',
                    ]) !!}

                    @error('fybdperiod_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>



            @if ($budget)

                <div class="form-group row">
                    <label class="col-md-3 form-control-label">ครั้งที่ <span class="text-danger">*</span></label>
                    <div class="col-md-3">
                        {!! Form::select('fybdtransfer_id', $transfer_list, $fybdtransfer_id, [
                            'wire:change' => 'clearArea("fybdtransfer_id")',
                            'class' => 'form-control select2',
                            'placeholder' => '--เลือกครั้ง--',
                            'wire:model' => 'fybdtransfer_id',
                        ]) !!}

                        @error('fybdtransfer_id')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>


                @if (!empty($OoapTblFybdtransfer))
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">วันที่รับโอน <span
                                class="text-danger">*</span></label>
                        <div class="col-md-3">
                            <div class="input-group">
                                {{-- <input type="text" class="form-control datepicker" data-date-language="th-th" data-name="transfer_date" placeholder="วว/ดด/ปปปป"> --}}

                                <input value="{{$transfer_date}}" type="text" class="form-control datepicker" data-date-language="th-th" data-name="transfer_date" placeholder="วว/ดด/ปปปป">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="icon wb-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            @error('transfer_date')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">จำนวนเงิน <span class="text-danger">*</span></label>
                        <div class="col-md-3">
                            {!! Form::text('transfer_amt', $transfer_amt, [
                                'wire:model' => 'transfer_amt',
                                'class' => 'form-control text-right',
                                'placeholder' => 'ตัวเลข จำนวน',
                                'onkeyup' => 'javascript:controlnumbers( this )',
                            ]) !!}
                            @error('transfer_amt')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror

                            @if (session()->get('total_transfer_amt'))
                                <label class="text-danger">{{ session()->get('total_transfer_amt') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">รายละเอียด</label>
                        <div class="col-md-3">
                            {!! Form::textarea('transfer_desp', $transfer_desp, [
                                // 'wire:model' => 'transfer_desp',
                                'rows' => 4,
                                'class' => 'form-control',
                                'placeholder' => 'รายละเอียด',
                            ]) !!}
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                        <button class="btn btn-default btn-outline"><a
                                href="{{ route('manage.receivetransfer.index') }}">ยกเลิก</a></button>
                    </div>
                @endif
            @else
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">วันที่รับโอน <span class="text-danger">*</span></label>
                    <div class="col-md-3">
                        <div class="input-group">



                            <input value="{{$transfer_date}}" type="text" class="form-control datepicker" data-date-language="th-th" data-name="transfer_date" placeholder="วว/ดด/ปปปป">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="icon wb-calendar" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        @error('transfer_date')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">จำนวนเงิน <span class="text-danger">*</span></label>
                    <div class="col-md-3">
                        {!! Form::text('transfer_amt', $transfer_amt, [
                            'wire:model' => 'transfer_amt',
                            'class' => 'form-control text-right',
                            'placeholder' => 'ตัวเลข จำนวน',
                            'onkeyup' => 'javascript:controlnumbers( this )',
                        ]) !!}
                        @error('transfer_amt')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror

                        @if (session()->get('total_transfer_amt'))
                            <label class="text-danger">{{ session()->get('total_transfer_amt') }}</label>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">รายละเอียด</label>
                    <div class="col-md-3">
                        {!! Form::textarea('transfer_desp', $transfer_desp, [
                            // 'wire:model' => 'transfer_desp',
                            'rows' => 4,
                            'class' => 'form-control',
                            'placeholder' => 'รายละเอียด',
                        ]) !!}
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                    <button class="btn btn-default btn-outline"><a
                            href="{{ route('manage.receivetransfer.index') }}">ยกเลิก</a></button>
                </div>


            @endif
            </form>
        </div>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener('livewire:load', function() {

            $(".datepicker").datepicker({
                language: 'th-th',
                format: 'dd/mm/yyyy',
                // endDate: '+20y',
                autoclose: true
            }).on('change', function(e) {

                let name = $(this).attr('data-name');

                // @this.set_sub_data.startperioddate  = $(this).val();

                @this.set(name, $(this).val());
            });
        });


        Livewire.on('dfdfdfdfdfdfdfdf', () => {
            // $('.select2').select2();

            $(".datepicker").datepicker({
                language: 'th-th',
                format: 'dd/mm/yyyy',
                // endDate: '+20y',
                autoclose: true
            }).on('change', function(e) {

                let name = $(this).attr('data-name');

                // @this.set_sub_data.startperioddate  = $(this).val();

                @this.set(name, $(this).val());
            });
        });

        function setValue(name, val) {
            @this.set(name, val);
        }

        function submit() {
            swal({
                title: 'ยืนยันการ แก้ไขข้อมูลรับโอนเงินจากสำนักงบประมาณ ?',
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
