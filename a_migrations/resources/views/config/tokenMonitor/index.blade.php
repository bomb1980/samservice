@extends('layouts.app',['activePage' => 'config'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">ตั้งค่าระบบ บริหารจัดการ Access Token ระบบ</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{ route('config.tokenMonitor.index') }}"
                        class="keychainify-checked active">บริหารจัดการ Access Token ระบบ</a></li>
            </ol>
        </div>

        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="form-group row">
                        <div class="col-md-2 text-right">
                            <label class="form-control-label font-weight-bold">System Name</label>
                        </div>
                        <div class="col-md-4 text-left">
                            {!! Form::text('system', null, ['class' => 'form-control', 'id' => 'system']) !!}
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-success offset-md-1"> generate</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-right">
                            <label class="form-control-label font-weight-bold">Public Token</label>
                        </div>
                        <div class="col-md-8">
                            {!! Form::textarea('token', null, ['class' => 'form-control', 'id' => 'token', 'rows' => '6']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-right">
                            <label class="form-control-label font-weight-bold">Monitor</label>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger"> ไม่สามารถเชื่อมต่อได้</button>
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
                            url: '{{ route('api.config.usergroup.list') }}',
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
                                data: 'user_group_name',
                                name: 'user_group_name',
                                className: "text-left",
                                orderable: true
                            },
                            {
                                data: 'status',
                                name: 'status',
                                className: "text-center",
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
                        ordering:false,
                        drawCallback: function(settings) {
                            var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                            pagination.toggle(this.api().page.info().pages > 1);

                            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                            elems.forEach(function(html) {
                                var switchery = new Switchery(html, {
                                    size: 'small'
                                });
                            });

                            $('.js-switch').change(function() {
                                let is_active = $(this).prop('checked') === true ? 1 : 0;
                                let id = $(this).data('id');
                                if (id) {
                                    $('#status_form' + id).submit();
                                }
                            });
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

                function search_table() {
                    $('#Datatables').DataTable().destroy();
                    call_datatable($('#search').val());
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
