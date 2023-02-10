<div>


    <div class="row">

        <div class="col-md-3" style="display: flex; align-items: center; gap: 20px;">
            <span>ปีงบประมาณ</span>
            {{ Form::select('fiscalyear_code', $fiscalyear_select, $parent_id, ['class' => 'form-control select2']) }}
        </div>

    </div>

    <br>
    {{-- {!! Form::open([
        'wire:submit.prevent' => 'submit(Object.fromEntries(new FormData($event.target)))',
        'autocomplete' => 'off',
        'class' => 'fv-form form-horizontal fv-form-bootstrap4',
    ]) !!}

    <table class="table table-bordered table-hover table-striped dataTable">
        <thead>
            <tr class="text-center">
                <th>กิจกรรม</th>
                <th>จำนวนเงิน</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th class="text-left"><strong>กิจกรรมจ้างงานเร่งด่วน</strong></th>
                <th class="text-right" class="text-right"><strong>{{ number_format($datas->req_urgentamt, 2) }}</strong>
                </th>
            </tr>
            <tr>
                <th class="text-left"><strong>กิจกรรมทักษะฝีมือแรงงาน</strong></th>
                <th class="text-right" class="text-right"><strong>{{ number_format($datas->req_skillamt, 2) }}</strong>
                </th>
            </tr>

            <tr class="text-left" style="">
                <th><strong>รวมจำนวนเงินจัดกิจกรรม</strong> </th>
                <th class="text-right"><strong>{{ number_format($datas->req_sumreqamt, 2) }}</strong></th>
            </tr>
            <tr class="text-left">
                <th><strong>จำนวนเงินที่เสนองบประมาณ</strong></th>
                <th class="text-right"><strong class="text-danger">{{ number_format($datas->req_amt, 2) }}</strong></th>
            </tr>
            <tr class="text-left">
                <th><strong>ได้รับงบประมาณ</strong> </th>
                <th class="text-right">

                    <div class="text-right col-md-4 float-right">


                        {{ Form::text('budget_amt', number_format($budget_amt, 2), ['class' => 'form-control  text-right', 'onkeyup' => 'javascript:controlnumbers( this )']) }}


                        @if (session()->get('budget_amt'))
                            <span class="text-danger">{{ session()->get('budget_amt') }}</span>
                        @endif
                    </div>

                </th>
            </tr>

        </tbody>
    </table>

    <br>

    <div class="text-center">

        <button type="submit" class="btn btn-primary">{!! getIcon('save') !!} บันทึกงบประมาณ</button>
    </div>


    {!! Form::close() !!} --}}


    <form class="form-horizontal">
        <div class="form-group row">
            <label class="col-md-1 form-control-label">งบที่ได้รับ: </label>
            <div class="col-md-2">
                <input id="budget_amt" class="form-control
                                text-right" disabled="true"
                    name="budget_amt" type="text" value="{{ number_format($budget_amt, 2) }}">
            </div>
            <label class="col-md-2 form-control-label">ยอดรอบงวดเงิน: </label>
            <div class="col-md-2">
                <input id="sum_period_amt" class="form-control text-right" disabled="true" name="sum_period_amt"
                    type="text" value="{{ number_format($getSubDataTotals_['total_budgetperiod'], 2) }}">
            </div>
        </div>
    </form>



    @if (!empty($show_sub_form))

        <b>การแบ่งงวดเงิน และการรรับโอนจากสำนักงบประมาณ</b>
        @php
            $i = 0;
        @endphp

        <table class="table table-bordered table-hover table-striped dataTable">
            <thead>
                <tr>
                    <th class="text-center">งวดที่</th>
                    <th class="text-center">เดือนเริ่มต้น</th>
                    <th class="text-center">เดือนสิ้นสุด</th>
                    <th class="text-right">จำนวนเงิน</th>
                    <th class="text-center">ยอดรับโอน</th>
                    <th class="text-center"> </th>
                </tr>
            </thead>

            @foreach ($sub_datas as $kd => $vd)
                @if ($sub_status == 'edit' && $edit_index == $kd)
                    <tr>
                        <td class="text-center">{{ ++$i }}</td>
                        <td class="text-center">

                            <input data-name="set_sub_data.startperioddate" type="text"
                                class="form-control month-picker" data-date-language="th-th"
                                wire:model="set_sub_data.startperioddate" placeholder="เดือนที่เริ่ม">

                            @error('set_sub_data.startperioddate')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror

                            @if (session()->get('startperioddate'))
                                <label class="text-danger">{{ session()->get('startperioddate') }}</label>
                            @endif

                        </td>
                        <td class="text-center">

                            <input data-name="set_sub_data.endperioddate" type="text"
                                class="form-control month-picker" data-date-language="th-th"
                                wire:model="set_sub_data.endperioddate" placeholder="เดือนที่สิ้นสุด">


                            @error('set_sub_data.endperioddate')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror

                            @if (session()->get('endperioddate'))
                                <label class="text-danger">{{ session()->get('endperioddate') }}</label>
                            @endif

                        </td>


                        <td class="text-right">
                            {{ Form::text('set_sub_data[budgetperiod]', $vd['budgetperiod'], [
                                'wire:model' => 'set_sub_data.budgetperiod',
                                'onkeyup' => 'javascript:controlnumbers( this )',
                            ]) }}

                            @if (session()->get('getSubDataTotal'))
                                <br>
                                <label class="text-danger">{{ session()->get('getSubDataTotal') }}</label>
                            @endif

                            @if (session()->get('budgetperiod'))
                                <br>
                                <label class="text-danger">{{ session()->get('budgetperiod') }}</label>
                            @endif

                        </td>
                        <td class="text-right"> {{ number_format($vd['total_transfer_amt'], 2) }}



                        </td>


                        <td class="text-center">
                            <button type="button" wire:click="save_sub_form( {{ $kd }} )"
                                class="btn btn-primary">{!! getIcon('save') !!} บันทึก</button>
                            <button type="button" wire:click="change_sub_status('ready')"
                                class="btn btn-primary">{!! getIcon('cancel') !!} ยกเลิก</button>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="text-center">{{ ++$i }}</td>


                        <td class="text-center">{{ $vd['startperioddate'] }}</td>
                        <td class="text-center"> {{ $vd['endperioddate'] }}</td>

                        <td class="text-right"> {{ number_format($vd['budgetperiod'], 2) }}</td>
                        <td class="text-right"> {{ number_format($vd['total_transfer_amt'], 2) }} </td>

                        <td class="text-center">


                            @if ($sub_status == 'ready')
                                {{-- <button type="button" wire:click="edit_row( {{ $kd }} )"
                                    class="btn btn-primary">{!! getIcon('edit') !!} แก้ไข</button> --}}





                                <a href="{{ route('manage.installment.edit', ['year_id' => $parent_id, 'budget_id' => $vd['budget_id']]) }}"
                                    class="btn btn-primary">{!! getIcon('edit') !!} แก้ไข</a>
                                <button type="button" wire:click="delete_sub_row( {{ $kd }} )"
                                    class="btn btn-primary">{!! getIcon('delete') !!} ลบ</button>

                                @if (session()->get('try_delete') && $edit_index == $kd)
                                    <br>
                                    <label class="text-danger">{{ session()->get('try_delete') }}</label>
                                @endif
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

                        <input data-name="set_sub_data.startperioddate" type="text" class="form-control month-picker"
                            data-date-language="th-th" wire:model="set_sub_data.startperioddate"
                            placeholder="เดือนที่เริ่ม">

                        @error('set_sub_data.startperioddate')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror

                        @if (session()->get('startperioddate'))
                            <label class="text-danger">{{ session()->get('startperioddate') }}</label>
                        @endif


                    </td>
                    <td class="text-center">

                        <input data-name="set_sub_data.endperioddate" type="text" class="form-control month-picker"
                            data-date-language="th-th" wire:model="set_sub_data.endperioddate"
                            placeholder="เดือนที่สิ้นสุด">

                        @error('set_sub_data.endperioddate')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror

                        @if (session()->get('endperioddate'))
                            <label class="text-danger">{{ session()->get('endperioddate') }}</label>
                        @endif

                    </td>
                    <td class="text-right">

                        {{ Form::text('set_sub_data[budgetperiod]', $set_sub_data['budgetperiod'], [
                            'wire:model' => 'set_sub_data.budgetperiod',
                            'onkeyup' => 'javascript:controlnumbers( this )',
                        ]) }}

                        @if (session()->get('getSubDataTotal'))
                            <br>
                            <label class="text-danger">{{ session()->get('getSubDataTotal') }}</label>
                        @endif

                    </td>

                    <td class="text-center">


                    </td>

                    <td>
                        <button type="button" wire:click="save_sub_form()"
                            class="btn btn-primary">{!! getIcon('save') !!} บันทึก</button>
                        <button type="button" wire:click="change_sub_status('ready')"
                            class="btn btn-primary">{!! getIcon('cancel') !!} ยกเลิก</button>
                    </td>
                </tr>
            @elseif ($sub_status == 'ready')
                {{-- <tr>
                    <td></td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td class="text-center"><button type="button" wire:click="change_sub_status('add')"
                            class="btn btn-primary">{!! getIcon('add') !!} เพิ่ม</button></td>
                </tr> --}}

            @endif

        </table>
    @endif



    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="submit_modal(Object.fromEntries(new FormData($event.target)))">
                        <input name="test_modal" type="text"
                                class="form-control"
                                 placeholder="เดือนที่เริ่ม">

                        <button>Submit</button>
                    </form>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

 --}}


</div>
@push('js')
    <script>
        document.addEventListener('livewire:load', function() {

            $('.select2').change(function() {

                if ($(this).val() == '') {

                    return;
                }

                let route = '{{ route('manage.fiscal.save2', ['id' => 'ddddddddddddd']) }}';

                let redirect = route.replace("ddddddddddddd", $(this).val());


                window.location = redirect;
            });


            window.livewire.on('loadJquery', () => {

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
