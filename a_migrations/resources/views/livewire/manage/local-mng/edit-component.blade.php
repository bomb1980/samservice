<div>
    {!! Form::open([
    'wire:submit.prevent' => 'submit()',
    'autocomplete' => 'off',
    'class' => 'form-horizontal fv-form fv-form-bootstrap4',
    ]) !!}
    <div class="form-group row">
        <label class="form-control-label col-md-1 pr-4">ปีงบประมาณ</label>
        {{ Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, [
        'id' => 'fiscalyear_code',
        // 'onchange' => 'setYearValue(event.target.value)',
        'class' => 'form-control select2 col-md-2',
        'placeholder' => '--เลือกปีงบประมาณ--',
        ]) }}
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
                        @if ($fiscalyear_code)
                        <tr class="text-center" role="row">
                            <td>{{ number_format($getFiscalyear->req_sumreqamt) }}</td>
                            <td>{{ number_format($getFiscalyear->req_amt) }}</td>
                            <td>{{ number_format($getFiscalyear->budget_amt) }}</td>
                            <td>{{ number_format($getFiscalyear->transfer_amt) }}</td>
                            <td>{{ number_format($getFiscalyear->budget_amt - $getFiscalyear->transfer_amt) }}</td>
                        </tr>
                        @endif
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
                        @if ($fiscalyear_code)
                        <tr class="text-center" role="row">
                            <td>
                                {{ number_format($budget_period) }}
                            </td>
                            <td style="background-color: #569fff">
                                {{ number_format($budget_manage) }}
                            </td>
                            <td>
                                {{ number_format($getFiscalyear->sub_manage_payment_amt1) }}
                            </td>
                            <td>
                                {{ number_format($balance) }}
                            </td>
                            <td style="background-color: #569fff">
                                {{ number_format($budget_project) }}
                            </td>
                            <td>
                                {{ number_format($budget_summanageproject) }}
                            </td>
                            <td>
                                {{ number_format($budget_sumpaymentproject) }}
                            </td>
                            <td>
                                {{ number_format($getFiscalyear->refund_amt) }}
                            </td>
                            <td>
                                {{ number_format($balance_region) }}
                            </td>
                        </tr>
                        @endif
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
                        @if ($fiscalyear_code)
                        <tr class="text-center" role="row">
                            <td class="align-middle">
                                {{ number_format($able_2_mng) }}
                            </td>
                            <td class="col-1 align-middle" style="background-color: #569fff">
                                {{ number_format($budget_manage) }}
                            </td>
                            <td class="col-1">
                                {{ Form::number('centerbudget_amt', $centerbudget_amt, [
                                'wire:model' => 'centerbudget_amt',
                                'class' => 'form-control',
                                'autocomplete' => 'off',
                                'placeholder' => '',
                                ]) }}
                                @error('centerbudget_amt')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </td>
                            <td class="col-1 align-middle" style="background-color: #569fff">
                                {{ number_format($budget_project) }}
                            </td>
                            <td class="col-1">
                                {{ Form::number('regionbudget_amt', $regionbudget_amt, [
                                'wire:model' => 'regionbudget_amt',
                                'class' => 'form-control',
                                'autocomplete' => 'off',
                                'placeholder' => '',
                                ]) }}
                                @error('regionbudget_amt')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </td>
                            <td class="align-middle" id="remaining">
                                {{ number_format($ostbudget_amt) }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row d-flex justify-content-center">
        <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
        {!! link_to(route('manage.local_mng.edit',['fiscalyear_code' => $fiscalyear_code]), 'ยกเลิก', ['class' => 'btn btn-default btn-outline ml-4']) !!}
    </div>
    {!! Form::close() !!}

    <script>
        $(document).ready(function() {
            $('#fiscalyear_code').select2();
            $('#fiscalyear_code').on('change', function(e) {
                var data = $('#fiscalyear_code').select2("val");
                @this.fiscalyear_code = data;
                console.log(data);
            });
        });

        document.addEventListener('livewire:load', function() {
            window.livewire.on('select2', function(data) {
                $('#fiscalyear_code').select2();
            });
        })
    </script>
</div>

@push('js')
<script>
        $(function() {
            @if(session('success'))
                swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                });

            @endif
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
