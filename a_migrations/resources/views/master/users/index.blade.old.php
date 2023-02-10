@extends('layouts.app',['activePage' => 'master'])

@section('content')
<div class="page">
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}" class="keychainify-checked">Master</a>
            </li>
            <li class="breadcrumb-item active">Users</li>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-actions"></div>
                <h3 class="panel-title">Basic</h3>
            </header>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-6">
                        <div class="form-group datatable-list">
                            {!! Form::open(['onsubmit' => 'return search_table()']) !!}
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
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{-- @livewire('users-component') --}}
                        {{-- @include('livewire.users-create') --}}
                        {{ link_to(route('users.create'), 'CREATE',['class'=>'btn btn-primary float-right']) }}

                    </div>
                </div>
                <div class="row row-lg">
                    <div class="col-md-12">
                        <table class="table table-hover dataTable table-striped w-full" id="Datatables">
                            <thead>
                                <tr>
                                    <th>index</th>
                                    <th>name</th>
                                    <th>email</th>
                                    <th>edit</th>
                                </tr>
                            </thead>
                        </table>
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
        @if(session('message'))
            Swal.fire({
                title: '{{ session("message") }}',
                icon: 'success'
            })
        @endif
    });

    function call_datatable(search) {
        var table = $('#Datatables').DataTable({
            processing: true,
            dom: 'rtp<"bottom"i>',
            ajax: {
                url: '{{ route("api.users.list") }}',
                type: 'GET',
                data: { token: '{{ csrf_token() }}' },
                headers: { 'Authorization': 'Bearer {{ system_key() }}' }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false},
                { data: 'name', name: 'name', className: "text-left", orderable: false },
                { data: 'email', name: 'email', className: "text-left", orderable: false },
                { data: 'edit', name: 'edit', className: "text-center", orderable: false }
            ],
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

    // window.livewire.on('userStore', () => {
    //     $('#exampleModal').modal('hide');
    // });


    function change_status(id) {
        Swal.fire({
            title: '<strong>ยืนยันการเปลี่ยนสถานะ</strong>',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#00BCD4',
            cancelButtonColor: '#DD6B55'
        }).then(function(isConfirm) {
            if(isConfirm.value) {
                $('#status_form' + id).submit();
            }
        });
    }

    function change_role(id) {
        Swal.fire({
            title: '<strong>ยืนยันการเปลี่ยนสิทธิ์</strong>',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#00BCD4',
            cancelButtonColor: '#DD6B55'
        }).then(function(isConfirm) {
            if(isConfirm.value) {
                $('#role_form' + id).submit();
            }
        });
    }
</script>
@endpush
