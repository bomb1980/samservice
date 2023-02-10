@extends('layouts.app', ['activePage' => 'master'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">บริหารจัดการ แบบประเมินความพึงพอใจ</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="#" class="keychainify-checked">จัดการข้อมูลกลาง</a></li>
                <li class="breadcrumb-item active">บริหารจัดการ แบบประเมินความพึงพอใจ</li>
            </ol>
            <div class="page-header-actions">
                <div class="btn-group btn-group-sm">
                    {{ link_to(route('master.estimate.create'), ' เพิ่มข้อมูล', [
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
                            @livewire('master.estimate.estimate-component')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
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
                    // $('#delete_form' + id).submit();
                    swal('', 'ลบข้อมูลเรียบร้อยแล้ว', 'success');
                } else {
                    // console.log('reject delete');
                }
            });
        }
    </script>
@endpush
