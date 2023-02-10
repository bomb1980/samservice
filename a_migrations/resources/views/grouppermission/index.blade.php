@extends('layouts.app',['activePage' => 'setting'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">จัดการข้อมูลกลุ่มผู้ใช้</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('setting.grouppermission.index') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item blue-500">จัดการข้อมูลกลาง</li>
                <li class="breadcrumb-item active">จัดการข้อมูลกลุ่มผู้ใช้</li>
            </ol>
        </div>
        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label">กลุ่มผู้ใช้งาน: <span class="text-danger">*</span></label>
                                <div class="col-md-5">
                                    {!! Form::select('role_name',App\Models\OoapMasRole::where('in_active', false)->orderBy('role_name', 'asc')->pluck('role_name', 'role_id'),null,['class' => 'form-control', 'id' => 'search', 'onchange' => 'change_budgetyears(this.value)'],) !!}
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <input type="checkbox" id="selectall" name="selectall">
                        <label for="selectall">เลือกทั้งหมด</label>
                    </div>
                    <div class="row row-lg">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">ฟังก์ชั่นหลัก</th>
                                        <th class="text-center">ฟังก์ชั่นย่อย</th>
                                        <th class="text-center">ดูข้อมูล</th>
                                        <th class="text-center">เพิ่มข้อมูล</th>
                                        <th class="text-center">แก้ไขข้อมูล</th>
                                        <th class="text-center">ลบข้อมูล</th>
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
                    url: '{{ route('api.setting.grouppermission.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}'
                    },
                    headers: {
                        'Authorization': 'Bearer {{ system_key() }}'
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'menu_name',
                        name: 'menu_name',
                        className: "text-left",
                        orderable: true
                    },
                    {
                        data: 'submenu_name',
                        name: 'submenu_name',
                        className: "text-left",
                        orderable: true
                    },
                    {
                        data: 'view_data',
                        name: 'view_data',
                        className: 'select-checkbox',
                        orderable: false
                    },
                    {
                        data: 'insert_data',
                        name: 'insert_data',
                        className: "select-checkbox",
                        orderable: false
                    },
                    {
                        data: 'update_data',
                        name: 'update_data',
                        className: "select-checkbox",
                        orderable: false
                    },
                    {
                        data: 'delete_data',
                        name: 'delete_data',
                        className: "select-checkbox",
                        orderable: false
                    }
                ],
                language: {
                    url: '{{ asset('assets') }}/js/datatable-thai.json',
                },
                paging: true,
                pageLength: 10,
                // ordering:false,
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
