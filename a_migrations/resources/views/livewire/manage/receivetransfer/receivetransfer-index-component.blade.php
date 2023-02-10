<div>
    <br>
    <div class="row form-group">
        <div class="col-md-2">
            {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, ['onchange' => 'setSearch()', 'id' => 'fiscalyear_code', 'class' => 'form-control select2', 'placeholder' => '--เลือกปีงบประมาณ--']) !!}
            @error('fiscalyear_code')
            <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped" id="Datatables">
        <thead>
            <tr>
                <th class="text-center">งวดที่</th>
                <th class="text-center">วันที่รับโอน</th>
                <th class="text-center">จำนวนเงิน</th>
                <th class="text-center">แก้ไข</th>
                {{-- <th class="text-center">ลบ</th> --}}
            </tr>
        </thead>
    </table>
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

        function setSearch(){
            $('#Datatables').DataTable().destroy();
            call_datatable();
            return false;
        }

        function call_datatable(search) {
            var table = $('#Datatables').DataTable({
                processing: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.manage.receivetransfer.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}',
                        fiscalyear_code: $("#fiscalyear_code").val()
                    },
                    headers: { 'Authorization': 'Bearer {{ system_key() }}' }
                },
                columns: [
                    { data: 'period_no', name: 'period_no', className: "text-center", orderable: false},
                    { data: 'transfer_date_show', name: 'transfer_date_show', className: "text-center", orderable: true },
                    { data: 'transfer_amt_show', name: 'transfer_amt_show', className: "text-right", orderable: true },
                    { data: 'edit', name: 'edit', className: "text-center", orderable: false },
                ],
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
