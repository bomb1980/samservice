@extends('layouts.app',['activePage' => 'permission'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">ข้อมูลสิทธิ์การใช้งาน</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{ route('permission.index') }}"
                    class="keychainify-checked">การตั้งค่า</a></li>
                <li class="breadcrumb-item active">กำหนดสิทธิ์การเข้าใช้งานระบบ</li>
            </ol>
        </div>
        <div class="page-content container-fluid">
            <div class="panel">
                <header class="panel-heading">
                    <h3 class="panel-title"><i class="icon wb-user-circle" aria-hidden="true"></i>
                        เพิ่มสิทธิ์การใช้งาน
                    </h3>
                </header>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('permission.permission-add-component')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script type="text/javascript">
    window.onload = function() {
        Livewire.on('popup', () => {
            swal({
                title: "บันทึกข้อมูลเรียบร้อย",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK",
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.livewire.emit('redirect-to');
                }
            });
        }),
        Livewire.on('check_userper', () => {
            // swal("มีข้อมูลเเล้ว กรุณาตรวจสอบ!!", "", "success")
            swal({
                title: "มีข้อมูลเเล้ว กรุณาตรวจสอบ",
                text: "ต้องการแก้ไขสิทธิ์ ?",
                type: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK",
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.livewire.emit('redirect-to-edit');
                    }
                }
            );
        });
    }
</script>
@endpush
