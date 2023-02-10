<div>
    <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
        <thead>
            <tr>
                <th class="col-1 text-center">ลำดับ</th>
                <th class="text-left">ชื่อประเภทแบบประเมิน</th>
                <th class="col-1">แก้ไข</th>
                <th class="col-1">ลบ</th>
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

        function call_datatable(search) {
            var table = $('#Datatables').DataTable({
                processing: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.master.assessmenttype') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}'
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
                        data: 'assessment_types_name',
                        name: 'assessment_types_name',
                        className: "text-left",
                        orderable: true
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'del',
                        name: 'del',
                        className: "text-center",
                        orderable: false
                    }
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
            table.on('order.dt', function() {}).search(search).draw();
        }

        function change_status(id) {
            $('#status_form' + id).submit();
        }

        function change_delete(id) {
            swal({
                title: 'ยืนยันการ ลบ ข้อมูล ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    $('#delete_form' + id).submit();
                } else {
                    console.log('reject delete');
                }
            });
        }
    </script>
@endpush
