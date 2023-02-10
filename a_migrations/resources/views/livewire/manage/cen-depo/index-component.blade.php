<div>
    {{-- {!! Form::open(['wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' => 'form-horizontal fv-form fv-form-bootstrap4']) !!} --}}

    <div class="form-group row">
        {{-- <label class="form-control-label col-md-3 text-right pr-4">ปีงบประมาณ</label> --}}
        {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, ['onchange' => 'setValue("fiscalyear_code",event.target.value)', 'class' => 'form-control select2 col-md-2', 'placeholder' => '--เลือกปีงบประมาณ--']) !!}
        @error('fiscalyear_code')
            <label class="text-danger">{{ $message }}</label>
        @enderror
<label class="form-control-label col-md-2 text-right pr-4">งวดที่</label>
        {!! Form::select('time_list_code', $time_list, $time_list_code, ['wire:model' => 'time_list_code', 'class' => 'form-control select2 col-md-3', 'placeholder' => '--เลือกงวด--']) !!}
<label class="form-control-label col-md-2 text-right pr-4">หน่วยงาน</label>
        {!! Form::select('dept_code', $dept_list, $dept_code, ['wire:model' => 'dept_code', 'class' => 'form-control select2 col-md-3', 'placeholder' => '--เลือกหน่วยงาน--']) !!}

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
                    <tr class="text-center" role="row">
                        <td>{{ number_format($disburse ?? 0 ,2)}}</td>
                        <td>{{ number_format($service_pay ?? 0 ,2)}}</td>
                        <td>{{ number_format($disburse-$service_pay ?? 0 ,2)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row d-flex justify-content-end">
        {{-- <a href="{{ $disburse-$service_pay > 0 ? route('manage.cen_depo.create') : 'javascript:void(0)' }}" class="btn btn-primary icon wb-plus btn-md col-md-1" {{ $disburse-$service_pay > 0 ? '' : 'disabled' }}>
            เพิ่ม</a> --}}
        <button type="button" class="btn btn-primary icon wb-plus btn-md col-md-1" onclick="location.href='{{ route('manage.cen_depo.create') }}'" {{ $disburse-$service_pay > 0 ? '' : 'disabled' }}> เพิ่ม</button>
    </div>

    <div class="form-group row">
        <div class="table-responsive">
            <table class="table table-bordered table-hover border table-striped w-full dataTable" id="Datatables">
                <thead>
                    <tr class="text-center" role="row">
                        <th class="font-weight-bold text-dark">ลำดับ</th>
                        <th class="font-weight-bold text-dark">วันที่</th>
                        <th class="font-weight-bold text-dark">รายการ</th>
                        <th class="font-weight-bold text-dark">จำนวนเงิน</th>
                        <th class="font-weight-bold text-dark">แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($data as $key => $val)
                        <tr>
                            <td class="text-center">{{ $i++ }}</td>
                            <td class="text-center">{{ datetoview($val->pay_date) }}</td>
                            <td class="text-left">{{ $val->pay_name }}</td>
                            <td class="text-right">{{ number_format($val->pay_amt ?? 0 ,2) }}</td>
                            <td class="text-center"><a href="#"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- {!! Form::close() !!} --}}
</div>

@push('js')
    <script>
        $(function() {
            $('.select2').select2();
            call_datatable('');
        });

        document.addEventListener('livewire:load', function () {
            Livewire.on('emits', () => {
                call_datatable('');
                return false;
            });
        });

        function setValue(name, val) {
            $('#Datatables').DataTable().destroy();
            @this.set(name, val);
        }

        function call_datatable(search) {
            var table = $('#Datatables').DataTable({
                retrieve: true,
                processing: true,
                dom: 'rtp<"bottom"i>',
                language: {
                    url: '{{ asset('assets') }}/js/datatable-thai.json',
                },
                paging: true,
                pageLength: 10,
                ordering: false,
                drawCallback: function(settings) {
                    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                    pagination.toggle(this.api().page.info().pages > 1);
                }
            });
            table.on('order.dt', function() {
                // table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
                //     cell.innerHTML = i + 1;
                // });
            }).search(search).draw();
            // table.columns(2).search($("#fiscalyear_code").val()).draw();
            // table.columns(8).search($("#leave_status").val()).draw();
        }
    </script>
@endpush
