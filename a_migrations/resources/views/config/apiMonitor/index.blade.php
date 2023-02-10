@extends('layouts.app',['activePage' => 'config'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">ตั้งค่าระบบ Api Monitor</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{ route('config.apiMonitor.index') }}"
                        class="keychainify-checked active">Api Monitor</a></li>
            </ol>
            <div class="page-header-actions">
                <div class="btn-group btn-group-sm">
                    {{ link_to(route('config.apiMonitor.create'), ' เพิ่ม Api Monitor', [
                        'class' => 'btn btn-primary btn-md float-right icon wb-plus',
                    ]) }}
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
                                            {!! Form::text('search', null, ['class' => 'form-control', 'id' => 'search', 'placeholder' => 'Search...']) !!}
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
                            {{-- @livewire('config.department-component') --}}
                            <div>
                                <table class="table table-bordered table-hover table-striped w-full dataTable"
                                    id="Datatables">
                                    <thead>
                                        <tr>
                                            <th class="col-1 text-center">ลำดับ</th>
                                            <th class="col-1 text-center">สถานะ</th>
                                            <th class="text-left">ชื่อระบบเข้าใช้งาน</th>
                                            <th class="text-left">Route API</th>
                                            <th class="text-center">ปริมาณการใช้งาน</th>
                                            <th class="text-center">ข้อมูล ณ วันที่</th>
                                            <th class="text-center">วันเวลาลงทะเบียน</th>
                                            <th class="col-1 text-center">ยกเลิก</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1.</td>
                                            <td class="text-center"><i class="icon wb-large-point text-success"
                                                    aria-hidden="true" title="Check"></i></td>
                                            <td class="text-left">SVLS</td>
                                            <td class="text-left">SVLS link Nlic</td>
                                            <td class="text-center">100</td>
                                            <td class="text-center">24/03/2565</td>
                                            <td class="text-center">01/03/2565</td>
                                            <td class="text-center"><i class="icon wb-lock text-danger"
                                                    aria-hidden="true" title="Disable"></i></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2.</td>
                                            <td class="text-center"><i class="icon wb-large-point text-warning"
                                                    aria-hidden="true" title="Check"></i></td>
                                            <td class="text-left">SVLS</td>
                                            <td class="text-left">SVLS link DPIS</td>
                                            <td class="text-center">200</td>
                                            <td class="text-center">21/03/2565</td>
                                            <td class="text-center">01/03/2565</td>
                                            <td class="text-center"><i class="icon wb-lock text-danger"
                                                    aria-hidden="true" title="Disable"></i></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3.</td>
                                            <td class="text-center"><i class="icon wb-large-point text-danger"
                                                    aria-hidden="true" title="Check"></i></td>
                                            <td class="text-left">OOAP</td>
                                            <td class="text-left">OOAP link NLIC</td>
                                            <td class="text-center">300</td>
                                            <td class="text-center">21/03/2565</td>
                                            <td class="text-center">01/03/2565</td>
                                            <td class="text-center"><i class="icon wb-lock text-danger"
                                                    aria-hidden="true" title="Disable"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
