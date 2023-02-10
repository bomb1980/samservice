@extends('layouts.app', ['activePage' => 'activity'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">บันทึกข้อมูลปรับแผน/โครงการ</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="#" class="keychainify-checked">บริหารกิจกรรม</a></li>
                <li class="breadcrumb-item active">บันทึกข้อมูลปรับแผน/โครงการ</li>
            </ol>
            <div class="page-header-actions">

            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('activity.plan-adjust.index-component')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            @if (session('success'))

                swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                });
            @endif

            @if (session('success_del'))

                swal({
                    title: "ลบข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                });
            @endif
            // call_datatable('');
        });

        function setSearch() {
            // let fiscalyear_code = $("#fiscalyear_code").val();
            // let dept_id = $("#dept_id").val();
            // let acttype_id = $("#acttype_id").val();
            // let serachbox = $("#serachbox").val();
            // alert(serachbox);
            // $('#Datatables').DataTable().destroy();
            call_datatable($("#serachbox").val());
            return false;
        }

        // function call_datatable(search) {
        //     // alert($("#fiscalyear_code").val());
        //     var table = $('#Datatables').DataTable({
        //         processing: true,
        //         dom: 'rtp<"bottom"i>',
        //         ajax: {
        //             url: '{{ route('api.activity.ready_confirm.list') }}',
        //             type: 'GET',
        //             data: {
        //                 token: '{{ csrf_token() }}',
        //                 fiscalyear_code: $("#fiscalyear_code").val(),
        //                 dept_id: $("#dept_id").val(),
        //                 acttype_id: $("#acttype_id").val(),
        //                 status: $("#status").val(),
        //                 plan: 1
        //             },
        //             headers: {
        //                 'Authorization': 'Bearer {{ system_key() }}'
        //             }
        //         },
        //         columns: [{
        //                 data: 'DT_RowIndex',
        //                 name: 'DT_RowIndex',
        //                 className: "text-center",
        //                 orderable: false
        //             },
        //             {
        //                 data: 'act_number',
        //                 name: 'act_number',
        //                 className: "text-center",
        //                 orderable: true
        //             },
        //             {
        //                 data: 'division_name',
        //                 name: 'division_name',
        //                 className: "text-center",
        //                 orderable: true
        //             },
        //             {
        //                 data: 'name',
        //                 name: 'name',
        //                 className: "text-center",
        //                 orderable: true
        //             },
        //             {
        //                 data: 'amphur_name',
        //                 name: 'amphur_name',
        //                 className: "text-center",
        //                 orderable: true
        //             },
        //             {
        //                 data: 'tambon_name',
        //                 name: 'tambon_name',
        //                 className: "text-center",
        //                 orderable: true
        //             },
        //             {
        //                 data: 'act_moo',
        //                 name: 'act_moo',
        //                 className: "text-center",
        //                 orderable: true
        //             },
        //             {
        //                 data: 'act_numofday',
        //                 name: 'act_numofday',
        //                 className: "text-right",
        //                 orderable: true
        //             },
        //             {
        //                 data: 'act_numofpeople',
        //                 name: 'act_numofpeople',
        //                 className: "text-right",
        //                 orderable: true
        //             },
        //             {
        //                 data: 'act_amount',
        //                 name: 'act_amount',
        //                 className: "text-right",
        //                 orderable: true
        //             },
        //             {
        //                 data: 'status_confirm2',
        //                 name: 'status_confirm2',
        //                 className: "text-center",
        //                 orderable: false
        //             },
        //             {
        //                 data: 'edit_plan',
        //                 name: 'edit_plan',
        //                 className: "text-center",
        //                 orderable: false
        //             },
        //             {
        //                 data: 'del2',
        //                 name: 'del2',
        //                 className: "text-center",
        //                 orderable: false
        //             },
        //         ],
        //         language: {
        //             url: '{{ asset('assets') }}/js/datatable-thai.json',
        //         },
        //         paging: true,
        //         pageLength: 10,
        //         ordering: false,
        //         drawCallback: function(settings) {
        //             var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
        //             pagination.toggle(this.api().page.info().pages > 1);
        //         }
        //     });
        //     table.on('order.dt', function() {
        //         // table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
        //         //     cell.innerHTML = i + 1;
        //         // });
        //     }).search(search).draw();
        //     // table.columns(2).search($("#fiscalyear_code").val()).draw();
        //     // table.columns(8).search($("#leave_status").val()).draw();
        // }

        function change_status(id) {
            $('#status_form' + id).submit();
        }

        // function change_delete(id) {

        //     swal({
        //         title: 'ยืนยันการ ลบ ข้อมูล ?',
        //         icon: 'close',
        //         type: "warning",
        //         showCancelButton: true,
        //         confirmButtonText: 'ยืนยัน',
        //         cancelButtonText: 'ยกเลิก',
        //         confirmButtonColor: '#00BCD4',
        //         cancelButtonColor: '#DD6B55'
        //     }, function(isConfirm) {
        //         if (isConfirm) {
        //             $('#delete_form' + id).submit();
        //         } else {
        //             console.log('reject delete');
        //         }
        //     });
        // }
    </script>
@endpush
