<div>
    <div class="row">


        <div class="col-md-3" style="display: flex; align-items: center; gap: 20px;">

            <span>ปีงบประมาณ</span>
            {{ Form::select('fiscalyear_code', $fiscalyear_select, $parent_datas->fiscalyear_code, [
                'class' => 'form-control
                                                                        select2',
                'placeholder' => '--เลือกปีงบประมาณ--',
            ]) }}

        </div>

        <div class="col-md-3" style="display: flex; align-items: center; gap: 20px;">
            <span style=" display: inline-block; text-align: right; ">เลขที่คำขอ</span>
            {{ Form::select('my_time', $plane_period_list, $my_time, [
                'class' => 'form-control select2',
                'placeholder' => '--เลือกเลขที่คำขอ--',
                // 'wire:model' => 'my_time',

                // 'wire:change'=>'change_sub_status(\'ready\')'
            ]) }}



        </div>
        <div class="col-md-3" style="display: flex; align-items: center; gap: 20px;">


            @if (session()->get('my_time'))
                <label class="text-danger">{{ session()->get('my_time') }}</label>
            @endif

        </div>

    </div>



    <div class="form-group row">
        <div class="table-responsive">
            <table class="table table-bordered border table-hover table-striped w-full dataTable">
                <thead>
                    <tr class="text-center" role="row">
                        <th class="font-weight-bold text-dark">เงินค่าบริหาร</th>
                        <th class="font-weight-bold text-dark">เบิกจ่าย</th>
                        <th class="font-weight-bold text-dark">คงเหลือ</th>
                    </tr>
                </thead>
                <tbody>

                    @if ($payment_group == 1)
                        <tr class="text-center" role="row">
                            <td>{{ number_format($parent_datas->centerbudget_amt, 2) }}</td>
                            <td>{{ number_format($parent_datas->sub_manage_payment_amt1, 2) }}</td>
                            <td>{{ number_format($parent_datas->centerbudget_amt - $parent_datas->sub_manage_payment_amt1, 2) }}
                            </td>
                        </tr>
                    @else
                        <tr class="text-center" role="row">
                            <td>{{ number_format($parent_datas->regionbudget_amt, 2) }}</td>
                            <td>{{ number_format($parent_datas->sub_manage_payment_amt2, 2) }}</td>
                            <td>{{ number_format($parent_datas->regionbudget_amt - $parent_datas->sub_manage_payment_amt2, 2) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>






    @if (!empty($show_sub_form))
        {{-- <h1 style="text-transform: uppercase;">
        FORM STATUS IS {{ $sub_status }}
    </h1> --}}
        <b>รายละเอียดค่าใช้จ่าย</b>
        @php
            $i = 0;
        @endphp
        <table class="table table-bordered table-hover table-striped dataTable">
            <thead>

                <tr>
                    <th class="text-center">ลำดับ</th>

                    <th class="text-center">วันที่</th>
                    <th class="text-center">รายการ</th>
                    {{-- <th class="text-center">ชื่อผู้เบิกจ่าย</th> --}}
                    <th class="text-right">จำนวนเงิน</th>


                    {{-- <th class="text-center">ประเภท</th> --}}
                    <th class="text-center"> </th>

                </tr>

            </thead>

            @foreach ($sub_datas as $kd => $vd)
                @php

                    if ($payment_group != $vd['payment_group']);
                    // continue;
                @endphp
                @if ($sub_status == 'edit' && $edit_index == $kd)
                    <tr>
                        <td class="text-center">{{ ++$i }}</td>

                        <td class="text-center">
                            <input data-name="set_sub_data.pay_date" type="text" class="form-control date-picker"
                                data-date-language="th-th" wire:model="set_sub_data.pay_date"
                                placeholder="วันที่">

                                <div class="text-left">

                                    @error('set_sub_data.pay_date')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror

                                </div>

                        </td>
                        <td class="text-left">
                            <input data-name="set_sub_data.pay_desp" type="text" class="form-control"
                                data-date-language="th-th" wire:model="set_sub_data.pay_desp"
                                placeholder="รายละเอียดค่าใช้จ่าย">
                            @error('set_sub_data.pay_desp')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </td>


                        <td class="text-right">


                            {{ Form::text('set_sub_data[pay_amt]', $vd['pay_amt'], [
                                'wire:model' => 'set_sub_data.pay_amt',
                                'class' => 'form-control',
                                'onkeyup' => 'javascript:controlnumbers( this )',
                            ]) }}

                            @error('set_sub_data.pay_amt')
                                <br>
                                <label class="text-danger">{{ $message }}</label>
                            @enderror

                            @if (session()->get('getSubDataTotal'))
                                <br>

                                <label class="text-danger">{{ session()->get('getSubDataTotal') }}</label>
                            @endif


                        </td>

                        <td class="text-center">
                            <button type="button" wire:click="save_sub_form()"
                                class="btn btn-primary">{!! getIcon('save') !!}
                                บันทึก</button>
                            <button type="button" wire:click="change_sub_status('ready')"
                                class="btn btn-primary">{!! getIcon('cancel') !!} ยกเลิก</button>
                        </td>

                    </tr>
                @else
                    <tr>
                        <td class="text-center">{{ ++$i }}</td>


                        <td class="text-center">{{ $vd['pay_date'] }}</td>
                        <td class="text-left">{{ $vd['pay_desp'] }}</td>
                        <td class="text-right">{{ number_format($vd['pay_amt'], 2) }}</td>
                        <td class="text-center">
                            @if ($sub_status == 'ready')
                                <button type="button" wire:click="edit_row( {{ $kd }} )"
                                    class="btn btn-primary">{!! getIcon('edit') !!}
                                    แก้ไข</button>
                                <button type="button" wire:click="delete_sub_row( {{ $kd }} )"
                                    class="btn btn-primary">{!! getIcon('delete') !!} ลบ</button>
                            @elseif ($sub_status == 'prepare_delete' && $edit_index == $kd)
                                <button type="button" wire:click="delete_sub_row( {{ $kd }} )"
                                    class="btn btn-primary">{!! getIcon('delete') !!} ยืนยันลบ</button>
                                <button type="button" wire:click="change_sub_status('ready')"
                                    class="btn btn-primary">{!! getIcon('cancel') !!} ยกเลิก</button>
                            @endif

                        </td>

                    </tr>
                @endif
            @endforeach

            @if ($sub_status == 'add')
                <tr>
                    <td class="text-center">{{ ++$i }}</td>

                    <td class="text-center">

                        <input data-name="set_sub_data.pay_date" type="text" class="form-control date-picker"
                            data-date-language="th-th" wire:model="set_sub_data.pay_date" placeholder="วันที่รับเงิน">

                            <div class="text-left">

                                @error('set_sub_data.pay_date')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror

                            </div>
                    </td>
                    <td class="text-left">


                        <input data-name="set_sub_data.pay_desp" type="text" class="form-control"
                            data-date-language="th-th" wire:model="set_sub_data.pay_desp"
                            placeholder="รายละเอียดค่าใช้จ่าย">


                        @error('set_sub_data.pay_desp')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror

                    </td>

                    <td class="text-right">
                        {{ Form::text('set_sub_data[pay_amt]', null, [
                            'wire:model' => 'set_sub_data.pay_amt',
                            'class' => 'form-control',
                            'onkeyup' => 'javascript:controlnumbers( this )',
                        ]) }}



    @error('set_sub_data.pay_amt')
        <label class="text-danger">{{ $message }}</label>
    @enderror

    @if (session()->get('getSubDataTotal'))
        <br>

        <label class="text-danger">{{ session()->get('getSubDataTotal') }}</label>
    @endif




                    </td>

                    <td class="text-center">
                        <button type="button" wire:click="save_sub_form()"
                            class="btn btn-primary">{!! getIcon('save') !!}
                            บันทึก</button>
                        <button type="button" wire:click="change_sub_status('ready')"
                            class="btn btn-primary">{!! getIcon('cancel') !!} ยกเลิก</button>
                    </td>

                </tr>
            @elseif ($sub_status == 'ready')
                <tr>

                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td class="text-center"><button type="button" wire:click="change_sub_status('add')"
                            class="btn btn-primary">{!! getIcon('add') !!} เพิ่ม</button></td>
                </tr>
            @endif

        </table>
    @endif

    {{-- <div wire:ignore class="gogo">sdafsdfsdfsddadsdfdfsdsds</div> --}}

</div>
@push('js')
    <script>
        function setBombSelect() {
            $(".select2").select2()
                .on('change', function(e) {

                    let name = $(this).attr('name');

                    if (name == 'fiscalyear_code') {

                        if ($(this).val() == '') {

                            let route = '{{ route($redirect_index) }}';

                            window.location = route;

                            return false;

                        }

                        let route = '{{ route($redirect_route, ['id' => 'ddddddddddddd']) }}';

                        let redirect = route.replace("ddddddddddddd", $(this).val());

                        window.location = redirect;
                    } else if (name == 'my_time') {

                        // if ($(this).val() == '') {

                        //     return false;
                        // }

                        @this.set(name, $(this).val());

                        // @this.change_sub_status('ready');


                    }

                });
        }
        document.addEventListener('livewire:load', function() {

            // alert('sdfasdfsd');

            setBombSelect();


            window.livewire.on('loadJquery', () => {
                setBombSelect();

                // alert('dfdasdds');


                $(".month-picker").datepicker({
                    format: "mm/yyyy",
                    viewMode: "months",
                    minViewMode: "months",
                    autoclose: true
                }).on('change', function(e) {

                    let name = $(this).attr('data-name');

                    @this.set(name, $(this).val());

                });

                $(".date-picker").datepicker({
                    format: "dd/mm/yyyy",

                    autoclose: true
                }).on('change', function(e) {

                    let name = $(this).attr('data-name');

                    @this.set(name, $(this).val());

                    // $('.gogo').html( $(this).val() );
                });
            });
        });

        function setValue(name, val) {
            @this.set(name, val);
        }
        Livewire.on('popup', () => {
            swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                },
                function(isConfirm) {
                    if (isConfirm) {
                        location.reload();
                        //window.livewire.emit('redirect-to');
                    }
                });
        });

        function submit() {
            swal({
                title: 'ยืนยันการบันทึกข้อมูล ได้รับงบประมาณ ?',
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
