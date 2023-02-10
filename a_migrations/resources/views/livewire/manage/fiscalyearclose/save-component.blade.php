<div class="my-setting">
    {!! Form::open(['wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' => 'form-horizontal fv-form fv-form-bootstrap4']) !!}

    <div class="form-group row items-center">
        <label class="form-control-label col-md-3 text-right pr-4">ปีงบประมาณ <span class="text-danger">*</span></label>



        {{$parent_datas->fiscalyear_code}}


        @if (config('app.th_link'))
        <b class="gogo">fiscalyear_code</b>
        @endif



    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">คำขอ</label>
        {{ number_format(  $parent_datas->req_sumreqamt, 2)}}



        @if (config('app.th_link'))
        <b class="gogo">req_sumreqamt</b>
        @endif
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">เสนองบ</label>
        {{ number_format(  $parent_datas->req_amt, 2)}}

        @if (config('app.th_link'))
        <b class="gogo">req_amt</b>
        @endif
    </div>
    <hr>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ได้รับงบ</label>
        {{ number_format($parent_datas->total_transfer_amt, 2)}}

        @if (config('app.th_link'))
        <b class="gogo">total_transfer_amt</b>
        @endif

    </div>
    <hr>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ค่าบริหารส่วนกลาง</label>



        {{ number_format($parent_datas->sub_manage_payment_amt1, 2)}}


        @if (config('app.th_link'))
        <b class="gogo">sub_manage_payment_amt1</b>
        @endif

    </div> <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ค่าบริหารส่วนภูมิภาค</label>



        {{ number_format($parent_datas->sub_manage_payment_amt2, 2)}}


        @if (config('app.th_link'))
        <b class="gogo">sub_manage_payment_amt2</b>
        @endif

    </div>




    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">รวมค่าบริหาร</label>



        {{ number_format($parent_datas->total_manage_payment_amt, 2)}}


        @if (config('app.th_link'))
        <b class="gogo">total_manage_payment_amt</b>
        @endif

    </div>


    <hr>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">กิจกรรมจ้างงานเร่งด่วน</label>
        {{ number_format($parent_datas->urgentpayment_amt, 2)}}

        @if (config('app.th_link'))
        <b class="gogo">urgentpayment_amt</b>
        @endif


    </div>

    {{-- <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">จำนวนเงินที่เบิกจ่ายให้ส่วนภูมิภาค</label>
        {{ number_format($parent_datas->urgentpayment_amt + $parent_datas->trainingpayment_amt, 2)}}

        @if (config('app.th_link'))
        <b class="gogo">urgentpayment_amt + trainingpayment_amt</b>
        @endif

    </div> --}}

    <hr>



    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">กิจกรรมทักษะฝีมือแรงงาน</label>
        {{ number_format($parent_datas->trainingpayment_amt, 2)}}


        @if (config('app.th_link'))
        <b class="gogo">trainingpayment_amt</b>
        @endif
    </div>



    <hr>




    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">รวมค่าใช้จ่าย</label>

        {{ number_format($parent_datas->total_manage_payment_amt + $parent_datas->urgentpayment_amt + $parent_datas->trainingpayment_amt, 2)}}


        @if (config('app.th_link'))
        <b class="gogo">total_manage_payment_amt + urgentpayment_amt + trainingpayment_amt</b>
        @endif
    </div>

    <hr>

    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">คืนเงินแผ่นดิน</label>

        {!! Form::number('refund_amt', $refund_amt, ['wire:model' => 'refund_amt', 'class' => 'form-control col-md-3' ]) !!}


        @if (config('app.th_link'))
        <b class="gogo"> budget_amt - ( centerbudget_amt +  urgentpayment_amt +  trainingpayment_amt)  </b>
        @endif
        @error('refund_amt')
            <label class="text-danger mt-2 ml-4">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">บันทึก</button>
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

        $(".datepicker").datepicker({
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
                function(isConfirm) {
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
