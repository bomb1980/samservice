<div>
    {!! Form::open(['wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' => 'form-horizontal fv-form fv-form-bootstrap4']) !!}
    <div class="form-group row">
        <label class="form-control-label col-md-1 text-right pr-4">ปีงบประมาณ</label>
        {{ Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, ['id' => 'fiscalyear_code', 'onchange' => 'setYearValue(event.target.value, false)', 'class' => 'form-control select2 col-md-2', 'placeholder' => '--เลือกปีงบประมาณ--']) }}
        @error('fiscalyear_code')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <hr>

    <div class="form-group row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-bordered table-hover w-full dataTable" id="Datatables">
                    <thead class="bg_thead">
                        <tr class="text-center" role="row">
                            <th class="font-weight-bold text-dark col-1">คำขอ</th>
                            <th class="font-weight-bold text-dark col-1">เสนองบ</th>
                            <th class="font-weight-bold text-dark col-1">ได้รับงบ</th>
                            <th class="font-weight-bold text-dark col-1">รับโอนจากสำนักงาน</th>
                            <th class="font-weight-bold text-dark col-1">รอโอน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center" role="row">
                            <td><span id="sumreqamt">{{$sumreqamt}}</span></td>
                            <td><span id="amt">{{$amt}}</span></td>
                            <td><span id="budget">{{$budget}}</span></td>
                            <td><span id='transfer'>{{$transfer}}</span></td>
                            <td><span id='wait'>{{$wait}}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <label class="col-md-2 text-left" style="margin-left: 2.5%">
            <h4>การจัดสรรปัจจุบัน</h4>
        </label>
    </div>
    <div class="row">
        <label class="form-control-label col-md-1 text-right pr-4">งวดที่</label>
        {{ Form::select(
            'peri_code',
            $doll_peri_list, $peri_code,
                [
                    'id' => 'peri_code',
                    'onchange' => 'setPeriod(event.target.value)',
                    'class' => 'form-control select2 col-md-2',
                    'placeholder' => $doll_peri_placeholder
                ]
            )
        }}
        @error('peri_code')
            <label class="text-danger">{{ $message }}</label>
        @enderror

    </div>
    <br>
    <div class="form-group row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-bordered table-hover w-full dataTable" id="Datatables">
                    <thead class="bg_thead">
                        <tr class="text-center" role="row">
                            <th class="font-weight-bold col-1" rowspan="2">รอจัดสรร</th>
                            <th class="font-weight-bold text-dark" colspan="3">การจัดสรรส่วนกลาง</th>
                            <th class="font-weight-bold text-dark" colspan="5">การจัดสรรส่วนภูมิภาค</th>


                        </tr>
                        <tr class="text-center" role="row">
                            <th class="font-weight-bold text-dark col-1">จัดสรร</th>
                            <th class="font-weight-bold text-dark col-1">เบิกจ่าย</th>
                            <th class="font-weight-bold text-dark col-1">คงเหลือ</th>
                            <th class="font-weight-bold text-dark col-1">จัดสรร</th>
                            <th class="font-weight-bold text-dark col-1">ผูกพันเบิกจ่ายค่าบริหาร</th>
                            <th class="font-weight-bold text-dark col-1">ผูกพันเบิกจ่ายค่าดำเนินโครงการ</th>
                            <th class="font-weight-bold col-1">โอนคืน</th>
                            <th class="font-weight-bold text-dark col-1">คงเหลือ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center" role="row">
                            <td>
                                {{ $doll_BUDGETPERIOD }}
                            </td>
                            <td id="doll_BUDGET_MANAGE" style="background-color: #569fff">
                                {{ $doll_BUDGET_MANAGE }}
                            </td>
                            <td id='doll_BUDGET_SUMMANAGE'>
                                {{ $doll_BUDGET_SUMMANAGE }}
                            </td>
                            <td id='doll_sum1'>
                                {{ $doll_sum1 }}
                            </td>
                            <td id="doll_BUDGET_PROJECT" style="background-color: #569fff">
                                {{ $doll_BUDGET_PROJECT }}
                            </td>
                            <td id='doll_BUDGET_SUMMANAGEPROJECT'>
                                {{ $doll_BUDGET_SUMMANAGEPROJECT }}
                            </td>
                            <td id='doll_BUDGET_SUMPAYMENTPROJECT'>
                                {{ $doll_BUDGET_SUMPAYMENTPROJECT }}
                            </td>
                            <td>
                                {{ $doll_BUDGET_BALANCE }}
                            </td>
                            <td id='doll_sum2'>
                                {{ $doll_sum2 }}
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <label class="col-md-2 text-left" style="margin-left: 2.5%">
            <h4>การจัดสรรใหม่</h4>
        </label>
    </div>

    <div class="form-group row justify-content-center">
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-bordered table-hover w-full dataTable" id="Datatables">
                    <thead class="bg_thead">
                        <tr class="text-center" role="row">
                            <th class="font-weight-bold text-dark col-1" rowspan="2">ยอดที่สามารถจัดสรร</th>
                            <th class="font-weight-bold text-dark col-2" colspan="2">จัดสรรส่วนกลาง</th>
                            <th class="font-weight-bold text-dark col-2" colspan="2">จัดสรรส่วนภูมิภาค</th>
                            <th class="font-weight-bold text-dark col-1" rowspan="2">คงเหลือ</th>
                        </tr>
                        <tr class="text-center" role="row">
                            <th class="font-weight-bold text-dark">ยอดเดิม</th>
                            <th class="font-weight-bold text-dark">ยอดที่ต้องการปรับปรุงใหม่</th>
                            <th class="font-weight-bold text-dark">ยอดเดิม</th>
                            <th class="font-weight-bold text-dark">ยอดที่ต้องการปรับปรุงใหม่</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center" role="row">
                            <td class="align-middle">
                                {{-- {{ $doll_sum3 }} --}}
                                {{ $doll_BUDGETPERIOD }}
                            </td>
                            <td class="col-1 align-middle" style="background-color: #569fff">
                                {{ $doll_BUDGET_MANAGE }}
                            </td>
                            <td class="col-1">
                                <input oninput="remaining()" class="form-control col-md-12 text-center" id="mng_center" type="number">
                            </td>
                            <td class="col-1 align-middle" style="background-color: #569fff">
                                {{ $doll_BUDGET_PROJECT }}
                            </td>
                            <td class="col-1">
                                <input oninput="remaining()" class="form-control col-md-12 text-center" id="mng_region" type="number">
                            </td>
                            <td class="align-middle" id="remaining">
                                0
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row d-flex justify-content-center">
        <button type="button" id='perio_btn' onclick="petri_submit()" class="btn btn-primary">บันทึก</button>
    </div>

    {!! Form::close() !!}
</div>

@push('js')
    <script>
        $('.select2').select2();
        $(document).ready(function() {
            Livewire.on('peri', () => {
                $('.select2').select2();

                let mng_center = @this.doll_BUDGET_MANAGE;
                $('#mng_center').val(parseFloat(mng_center.replace(/,/g, '')));
                let mng_region = @this.doll_BUDGET_PROJECT;
                $('#mng_region').val(parseFloat(mng_region.replace(/,/g, '')));

                remaining();
            });
            Livewire.on('year', () => {
                $('.select2').select2();
                remaining();
            });
            Livewire.on('popup', () => {
                $('.select2').select2();
                // call_datatable('');
                swal({
                        title: "บันทึกข้อมูลเรียบร้อย",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                        }
                });
            });

            @if (session()->get('pending_room'))
                swal('', 'บันทึกข้อมูลเรียบร้อยแล้ว', 'success');
            @endif
            @if (session()->get('message_edit'))
                swal('', 'แก้ไขข้อมูลเรียบร้อยแล้ว', 'success');
            @endif
            @if (session()->get('message_delete'))
                swal('', 'ลบข้อมูล เรียบร้อยแล้ว', 'success');
            @endif

        });

        function setYearValue(val, prevent_peri_null) {
            @this.setYearValue(val, prevent_peri_null);
        }

        function petri_submit() {
            var new_total =  parseFloat($("#mng_center").val()) + parseFloat($("#mng_region").val());
            // if($('#peri_code').val() == 1){
            //     if( parseFloat(@this.doll_BUDGETPERIOD.replace(/,/g, '')) < parseFloat(new_total) ){
            //         swal('', 'ยอดรวมการจัดสรรใหม่ เกินยอดที่สามารถจัดสรรได้', 'warning');
            //         return false;
            //     }
            // }else{
            //     if( parseFloat(@this.doll_sum3.replace(/,/g, '')) < parseFloat(new_total) ){
            //         swal('', 'ยอดรวมการจัดสรรใหม่ เกินยอดที่สามารถจัดสรรได้', 'warning');
            //         return false;
            //     }
            // }
            let total = parseFloat(@this.doll_BUDGET_BALANCE.replace(/,/g, '')) + parseFloat(@this.doll_BUDGETPERIOD.replace(/,/g, ''));
            if( total < parseFloat(new_total) ){
                swal('', 'ยอดรวมการจัดสรรใหม่ เกินยอดที่สามารถจัดสรรได้', 'warning');
                return false;
            }

            if( parseFloat(@this.doll_BUDGET_SUMMANAGE) > parseFloat($("#mng_center").val()) ){
                swal('', 'ยอดการจัดสรรส่วนกลางใหม่ น้อยกว่างบเบิกจ่าย', 'warning');
                return false;
            }

            var sumproject = ( parseFloat(@this.doll_BUDGET_SUMMANAGEPROJECT) + parseFloat(@this.doll_BUDGET_SUMPAYMENTPROJECT) ) + parseFloat(@this.doll_BUDGET_BALANCE) ;
            if( parseFloat(sumproject) > parseFloat($("#mng_region").val()) ){
                swal('', 'ยอดการจัดสรรส่วนภูมิภาคใหม่ น้อยกว่างบเบิกจ่าย\n(ผูกพันเบิกจ่ายค่าบริหาร + ผูกพันเบิกจ่ายค่าดำเนินโครงการ + โอนคืน)', 'warning');
                return false;
            }
            @this.setUpdatePertri($('#mng_center').val(), $('#mng_region').val(), $('#fiscalyear_code').val(), $('#peri_code').val());
        }

        function setPeriod(val) {
            @this.setPeriValue($('#peri_code').val());
        }

        function remaining(){
            var summanage = parseFloat(@this.doll_BUDGET_SUMMANAGE);
            var new_summanage = $("#mng_center").val() - summanage;

            var sumproject = ( parseFloat(@this.doll_BUDGET_SUMMANAGEPROJECT) + parseFloat(@this.doll_BUDGET_SUMPAYMENTPROJECT) ) + parseFloat(@this.doll_BUDGET_BALANCE) ;
            var new_sumproject = $("#mng_region").val() - sumproject;

            var sum = new_summanage + new_sumproject;
            let total = parseFloat(sum).toLocaleString('en-US', {minimumFractionDigits: 2});

            $('#remaining').text(total);
        }
    </script>
@endpush
