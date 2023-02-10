<div>

    <div class="page-header">
        <h1 class="page-title">ข้อมูลงวดเงิน</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="#" class="keychainify-checked">บริหารงบประมาณ</a></li>
            <li class="breadcrumb-item active">ข้อมูลงวดเงิน</li>
        </ol>
        <ol>
            <div class="page-header-actions">
                <div class="btn-group btn-group-sm">
                    {{-- {{ link_to(route('manage.installment.create'), ' เพิ่มข้อมูลงวดเงิน', ['class' => 'btn btn-primary btn-md float-right icon wb-plus']) }} --}}
                    <button type="button" class="btn btn-primary btn-md" wire:click="gotoUrl" {{ $sum_period_amt >= $budget_amt ? 'disabled' : '' }}><i class="icon wb-plus"></i> เพิ่มข้อมูลงวดเงิน</button>
                </div>
            </div>
        </ol>
    </div>

    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">

                        <div class="row mb-4">
                            <div class="col-md-2">
                                {{ Form::select('fiscalyear_code', $fiscalyear_select, $fiscalyear_search, [
                                    'onchange' => 'setVal("fiscalyear_search",event.target.value)',
                                    'class' => 'form-control select2',
                                    'placeholder' => '--เลือกปีงบประมาณ--',
                                ]) }}
                            </div>
                        </div>
                        <form class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-1 form-control-label">งบที่ได้รับ: </label>
                                <div class="col-md-2">
                                    {{ Form::text('budget_amt', number_format($budget_amt, 2), [
                                        'id' => 'budget_amt',
                                        'class' => 'form-control
                                                    text-right',
                                        'disabled' => 'true',
                                    ]) }}
                                </div>
                                <label class="col-md-2 form-control-label">ยอดรอบงวดเงิน: </label>
                                <div class="col-md-2">
                                    {{ Form::text('sum_period_amt', number_format($sum_period_amt, 2), [
                                        'id' => 'sum_period_amt',
                                        'class' => 'form-control text-right',
                                        'disabled' => 'true',
                                    ]) }}
                                </div>
                            </div>
                        </form>
                        <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
                            <thead>
                                <tr>
                                    <th class="col-1 text-center">งวด</th>
                                    <th class="text-center">ช่วงเวลา</th>
                                    <th class="col-1 text-center">สัดส่วน</th>
                                    <th class="text-center">จำนวนงบประมาณ</th>
                                    <th class="col-1 text-center">แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data_list)
                                    @foreach ($data_list as $item)
                                        <tr>
                                            <td class="text-center">{{ $item['period_no'] }}</td>
                                            <td class="text-center">
                                                {{ monthThaiName($item['startdate']) . ' - ' . monthThaiName($item['enddate']) }}
                                            </td>
                                            <td class="text-right">{{ number_format($item['period_rate'], 2) . '%' }}
                                            </td>
                                            <td class="text-right">{{ number_format($item['period_amt'], 2) }}</td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <div class="icondemo vertical-align-middle p-2">
                                                        <a href="{{ url('/manage/installment/'.$item["id"].'/edit') }}" aria-label="แก้ไข">
                                                            <i class="icon wb-pencil" aria-hidden="true"
                                                                title="แก้ไข"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(function() {
            @if (session('success'))

                swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                });
            @endif

            @if (session('success_del'))

                swal({
                    title: "ลบข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                });
            @endif
            call_datatable('');
        });

        function setVal(name, val){
            $('#Datatables').DataTable().destroy();
            @this.set(name, val);
        }

        document.addEventListener('livewire:load', function () {
            Livewire.on('emits', () => {
                call_datatable('');
                return false;
            });
        });

        function call_datatable(search) {
            var table = $('#Datatables').DataTable({
                retrieve: true,
                processing: true,
                dom: 'rtp<"bottom"i>',
                // ajax: {
                //     url: '{{ route('api.manage.receivetransfer.list') }}',
                //     type: 'GET',
                //     data: {
                //         token: '{{ csrf_token() }}',
                //         fiscalyear_id: $("#fiscalyear_id").val()
                //     },
                //     headers: { 'Authorization': 'Bearer {{ system_key() }}' }
                // },
                // columns: [
                //     { data: 'period_no', name: 'period_no', className: "text-center", orderable: false},
                //     { data: 'transfer_date_show', name: 'transfer_date_show', className: "text-center", orderable: true },
                //     { data: 'transfer_amt_show', name: 'transfer_amt_show', className: "text-right", orderable: true },
                //     { data: 'edit', name: 'edit', className: "text-center", orderable: false },
                // ],
                language: {
                url: '{{ asset('assets') }}/js/datatable-thai.json',
                },
                paging: true,
                pageLength:10,
                ordering:false,
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
        }

    </script>
@endpush
