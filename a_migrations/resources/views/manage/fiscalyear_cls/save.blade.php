@extends('layouts.app', ['activePage' => 'manage'])

@section('content')
    <style>
        .my-setting .row {

            align-items: center;
        }

        .gogo {
            color: red;
            display: inline-block;
            font-size: 154%;
            margin-left: 20px;
        }
    </style>
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">{{ $title }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{ $index_link }}" class="keychainify-checked">{{ $title }}</a>
                </li>
                <li class="breadcrumb-item active">{{ $sub_title }}</li>
            </ol>
            <div class="page-header-actions">

            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">

                            @livewire('manage.fiscalyear-close.save-component', ['parent_datas' => $parent_datas])
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
