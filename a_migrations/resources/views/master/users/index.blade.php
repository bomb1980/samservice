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
            @livewire('users-component')
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(function() {
        call_datatable('');
        @if(session('message'))
            // swal({
            //     title: '{{ session("message") }}',
            //     icon: 'success'
            // })
        @endif
    });

    function call_datatable(search) {
        var table = $('#Datatables').DataTable({
            processing: true,

            dom: 'rtp<"bottom"i>',
            ajax: {
                // url: '{{ route("api.users.list") }}',
                url: '{{ url("api/users/list") }}',
                type: 'GET',
                data: { token: '{{ csrf_token() }}' },
                headers: { 'Authorization': 'Bearer {{ system_key() }}' }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false},
                { data: 'name', name: 'name', className: "text-left", orderable: false },
                { data: 'email', name: 'email', className: "text-left", orderable: false },
                { data: 'edit', name: 'edit', className: "text-center", orderable: false },
                { data: 'del', name: 'del', className: "text-center", orderable: false },
                // { data: 'action', name: 'action', className: "text-center", orderable: false }

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

    window.livewire.on('userStore', () => {
        $('#exampleModal').modal('hide');

    });

function change_status(id) {
    console.log('delete:'+id);
    swal({
        title: 'Are you sure ?',
        icon: 'close',
        type: "warning",
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancle',
        confirmButtonColor: '#00BCD4',
        cancelButtonColor: '#DD6B55'
     }, function (isConfirm) {
        if(isConfirm) {
            $('#status_form' + id).submit();
        } else {
            console.log('canclce delete');
        }
    });
}
function edit(id) {
    console.log('edit:'+id);
    $('#textclick').attr('wire:click', 'edit('+id+')');
    $('#textclick').click();
}


</script>
@endpush
