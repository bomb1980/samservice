@extends('layouts.app', ['activePage' => 'manage'])

@section('content')
    <style>
        .form-control:disabled,
        .form-control[readonly] {
            background-color: #c3dbe7;
            opacity: 1;
        }
    </style>
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">{{ $main_title }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{ route('manage.fiscal.index') }}"
                        class="keychainify-checked">บริหารงบประมาณ</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            <div class="page-header-actions">


                @if (!empty($show_add_budget_button))
                    <div class="btn-group btn-group-sm">

                        <a href="{{route('manage.installment.create',['year_id'=>$datas->id])}}" class="btn btn-primary btn-md" ><i
                                class="icon wb-plus"></i> เพิ่มข้อมูลงวดเงิน</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('manage.fiscal.fiscal-component', ['datas' => $datas, 'view' => $view])
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
            // call_datatable('');
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
