<div>
    {!! Form::open([
        'wire:submit.prevent' => 'submit()',
        'autocomplete' => 'off',
        'class' => 'form-horizontal fv-form fv-form-bootstrap4',
    ]) !!}
    <div class="form-group row">
        {{-- <label class="form-control-label col-md-1 ">งบส่วนภูมิภาค</label>
        {!! Form::number('local_budget', null, [
            'id' => 'local_budget',
            'wire:model' => 'local_budget',
            'class' => 'form-control col-md-2',
            'placeholder' => 'งบส่วนภูมิภาค',
            'disabled',
        ]) !!} --}}
        @error('local_budget')
            <label class="text-danger">{{ $message }}</label>
        @enderror

        <label class="form-control-label col-md-1 ">ปีงบประมาณ</label>
        {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, [
            'class' => 'form-control select2 col-md-2',
            'onchange' => 'changeFiscalyear(event.target.value)',
            'placeholder' => '--เลือกปีงบประมาณ--',
        ]) !!}
        @error('fiscalyear_code')
            <label class="text-danger">{{ $message }}</label>
        @enderror

        <label class="col-md-1 form-control-label">คำค้น </label>
        <div class="col-md-2">
            {{ Form::search('txt_search', null, [
                'id' => 'txt_search',
                'class' => 'form-control',
                'onchange' => 'changeSearcg(event.target.value)',
                'onkeyup' => 'changeSearcg(event.target.value)',
                'autocomplete' => 'off',
                'placeholder' => 'ค้นหา...',
            ]) }}
        </div>
        <div class="col-md-1">
            <a class="btn btn-primary btn-md white" onclick="search_table()">ค้นหา</a>
        </div>
    </div>
    {{-- <hr>

    <div class="form-group row">
        <label class="form-control-label col-md-1 ">งบส่วนภูมิภาค</label>
        {!! Form::number('local_budget', null, [
            'id' => 'local_budget',
            'wire:model' => 'local_budget',
            'class' => 'form-control col-md-2',
            'placeholder' => 'งบส่วนภูมิภาค',
            'disabled',
        ]) !!}
        @error('local_budget')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-1 ">ยอดโครงการ</label>
        {!! Form::number('project_cost', null, [
            'id' => 'project_cost',
            'wire:model' => 'project_cost',
            'class' => 'form-control col-md-2',
            'placeholder' => 'ยอดโครงการ',
        ]) !!}
        @error('local_budget')
            <label class="text-danger">{{ $message }}</label>
        @enderror

        <label class="form-control-label col-md-1 ">ยอดจัดสรร</label>
        {!! Form::number('total_allocate', null, [
            'id' => 'total_allocate',
            'wire:model' => 'total_allocate',
            'class' => 'form-control col-md-2',
            'placeholder' => 'ยอดจัดสรร',
        ]) !!}
        @error('local_budget')
            <label class="text-danger">{{ $message }}</label>
        @enderror

        <label class="form-control-label col-md-1 ">ยอดโอน</label>
        {!! Form::number('transfer_amt', null, [
            'id' => 'transfer_amt',
            'wire:model' => 'transfer_amt',
            'class' => 'form-control col-md-2',
            'placeholder' => 'ยอดโอน',
        ]) !!}
        @error('local_budget')
            <label class="text-danger">{{ $message }}</label>
        @enderror

        <label class="form-control-label col-md-1 ">รอโอน</label>
        {!! Form::number('transfer_amt_wait', null, [
            'id' => 'transfer_amt_wait',
            'wire:model' => 'transfer_amt_wait',
            'class' => 'form-control col-md-2',
            'placeholder' => 'รอโอน',
        ]) !!}
        @error('local_budget')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div> --}}
    {!! Form::close() !!}

    <div class="table-responsive" wire:ignore>
        <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">ลำดับ</th>
                    <th class="text-center" rowspan="2">หน่วยงาน</th>
                    <th class="text-center" colspan="2">จ้างงานเร่งด่วน</th>
                    <th class="text-center" colspan="2">ฝึกทักษะฝีมือแรงงาน</th>
                    <th class="text-center" colspan="2">รวมโครงการ</th>
                    <th class="text-center border" rowspan="2">ค่ากิจกรรมจ้างงาน</th>
                    <th class="text-center" rowspan="2">ค่ากิจกรรมอบรม</th>
                    <th class="text-center" rowspan="2">บริหารกิจกรรม</th>
                    <th class="text-center border" rowspan="2">รวม</th>
                    <th class="text-center" rowspan="2">แก้ไข</th>
                </tr>
                <tr>
                    <th class="text-center">โครงการ</th>
                    <th class="text-center">ค่าใช้จ่าย</th>
                    <th class="text-center">โครงการ</th>
                    <th class="text-center">ค่าใช้จ่าย</th>
                    <th class="text-center">โครงการ</th>
                    <th class="text-center">ค่าใช้จ่าย</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@push('js')
    <script>
        $('.select2').select2();

        $(function() {

            @if (session('success'))

                swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                });
            @endif

            call_datatable('');
        });


        function changeFiscalyear(val) {
            @this.set('fiscalyear_code', val);
        }

        function changeSearcg(val) {
            @this.set('txt_search', val);
        }

        // function searchYear() {
        //     var fiscalyear_code = $('#fiscalyear_code').val();
        //     @this.setYear(fiscalyear_code);
        //     $('#Datatables').DataTable().destroy();
        //     call_datatable();
        // }

        // function searchPeriod() {
        //     var periodno = $('#periodno').val();
        //     @this.periodno = periodno;
        //     $('#Datatables').DataTable().destroy();
        //     call_datatable();
        // }

        function search_table() {
            $('#Datatables').DataTable().destroy();
            call_datatable();
            return false;
        }

        function call_datatable(search) {

            var fiscalyear_code = $('#fiscalyear_code').val();
            var periodno = $('#periodno').val();

            var table = $('#Datatables').DataTable({
                processing: true,
                destroy: true,
                responsive: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.activity.tran_mng.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}',
                        fiscalyear_code: @this.fiscalyear_code,
                        txt_search: @this.txt_search,
                    },
                    headers: {
                        'Authorization': 'Bearer {{ system_key() }}'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'division_name',
                        name: 'division_name',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'count_urgent',
                        name: 'count_urgent',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'sum_urgent',
                        name: 'sum_urgent',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'count_training',
                        name: 'count_training',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'sum_training',
                        name: 'sum_training',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'count_act',
                        name: 'count_act',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'sum_act',
                        name: 'sum_act',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'allocate_urgent',
                        name: 'allocate_urgent',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'allocate_training',
                        name: 'allocate_training',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'allocate_manage',
                        name: 'allocate_manage',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'sum_allocate',
                        name: 'sum_allocate',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        className: "text-center",
                        orderable: false
                    },
                ],
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
                    table.column(0, {
                        search: 'applied',
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                })
                .search(search).draw();
        }

        Livewire.on('emits', () => {
            $('.select2').select2();
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

        function todo() {
            swal({
                title: 'ยืนยันการ ส่งต่อปรับแผน ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.todo();
                }
            });
        }
    </script>
@endpush
