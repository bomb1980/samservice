@extends('layouts.app',['activePage' => 'master'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">บันทึกหน่วยวัดพื้นที่</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="#"
                    class="keychainify-checked">ข้อมูล Master สรจ.</a></li>
            <li class="breadcrumb-item active">หน่วยวัดพื้นที่</li>
        </ol>
        <div class="page-header-actions">
            <div class="btn-group btn-group-sm">
                {{ link_to(route('master.office.master11.create'),' เพิ่มหน่วยวัดพื้นที่',['class'=>'btn
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
                        @livewire('master.office.master11.index-component')
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
                url: '{{ route("api.master.office.master11.list") }}',
                type: 'GET',
                data: { token: '{{ csrf_token() }}' },
                headers: { 'Authorization': 'Bearer {{ system_key() }}' }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false},
                { data: 'unitname', name: 'unitname', className: "text-left", orderable: true },
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

    function change_budgetyears() {
        $('#Datatables').DataTable().destroy();
        call_datatable($('#search option:selected').text());
        return false;
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
