@extends('layouts.app',['activePage' => 'config'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">ตั้งค่าระบบ ข้อมูลผู้ใช้งานระบบ</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="{{ route('config.users.index') }}"
                    class="keychainify-checked active">ข้อมูลผู้ใช้งานระบบ</a></li>
        </ol>
        <div class="page-header-actions">
            <div class="btn-group btn-group-sm">
                {{ link_to(route('config.users.create'),' เพิ่มข้อมูลผู้ใช้งานระบบใหม่',['class'=>'btn btn-primary
                btn-md
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
                        <div class="form-group datatable-list">
                            <div class="input-group">
                                <div class="form-group datatable-list">
                                    <div class="input-group">
                                        {!! Form::text('search', NULL, ['class' => 'form-control', 'id' => 'search',
                                        'placeholder' => 'Search...']) !!}
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-primary float-right"
                                                onclick="search_table()">
                                                <i class="icon wb-search" aria-hidden="true"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('config.users-component')
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
        call_datatable('');
    });

    function call_datatable(search) {
        var table = $('#Datatables').DataTable({
            processing: true,
            dom: 'rtp<"bottom"i>',
            ajax: {
                url: '{{ route("api.config.users.list") }}',
                type: 'GET',
                data: { token: '{{ csrf_token() }}' },
                headers: { 'Authorization': 'Bearer {{ system_key() }}' }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false},
                { data: 'empname', name: 'empname', className: "text-center", orderable: true },
                { data: 'em_citizen_id', name: 'em_citizen_id', className: "text-center", orderable: true },
                { data: 'posit_name_th', name: 'posit_name_th', className: "text-center", orderable: true },
                { data: 'positlevel_name_th', name: 'positlevel_name_th', className: "text-center", orderable: true },
                { data: 'dept_name_th', name: 'dept_name_th', className: "text-center", orderable: true },
                { data: 'user_group_name', name: 'user_group_name', className: "text-center", orderable: true },
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
            table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).search(search).draw();
    }

    function search_table() {
        $('#Datatables').DataTable().destroy();
        call_datatable($('#search').val());
        return false;
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
