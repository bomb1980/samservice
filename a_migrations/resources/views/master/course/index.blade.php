@extends('layouts.app',['activePage' => 'master'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">ข้อมูลหลักสูตรอบรม</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item">{{$main_title}}</li>
        </ol>
        <div class="page-header-actions">
            <div class="btn-group btn-group-sm">
                {{ link_to(route('master.course.create'),' เพิ่มข้อมูล',['class'=>'btn
                btn-primary btn-md
                float-right icon wb-plus'])
                }}
            </div>
        </div>
    </div>

    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('master.course.course-component')
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
                url: '{{ route("api.master.course.list") }}',
                type: 'GET',
                data: { token: '{{ csrf_token() }}' },
                headers: { 'Authorization': 'Bearer {{ system_key() }}' }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false},
                { data: 'code', name: 'code', className: "text-left", orderable: true },
                { data: 'acttype_name', name: 'acttype_name', className: "text-left", orderable: true },
                { data: 'name', name: 'name', className: "text-left", orderable: true },
                { data: 'shortname', name: 'shortname', className: "text-left", orderable: true },
                // { data: 'ownertype_name', name: 'ownertype_name', className: "text-left", orderable: true },
                // { data: 'acttype_name', name: 'acttype_name', className: "text-left", orderable: true },
                { data: 'coursegroup_name', name: 'coursegroup_name', className: "text-left", orderable: true },
                { data: 'coursesubgroup_name', name: 'coursesubgroup_name', className: "text-left", orderable: true },
                { data: 'coursetype_name', name: 'coursetype_name', className: "text-left", orderable: true },
                { data: 'hour_descp', name: 'hour_descp', className: "text-center", orderable: true },
                { data: 'day_descp', name: 'day_descp', className: "text-center", orderable: true },
                { data: 'people_descp', name: 'people_descp', className: "text-center", orderable: true },
                { data: 'edit', name: 'edit', className: "text-center", orderable: false },
                { data: 'del', name: 'del', className: "text-center", orderable: false }
            ],
            language: {
            url: '{{ asset("assets") }}/js/datatable-thai.json',
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
        }, function (isConfirm) {
            if(isConfirm) {
                $('#delete_form' + id).submit();
            } else {
                console.log('reject delete');
            }
        });
    }
</script>
@endpush
