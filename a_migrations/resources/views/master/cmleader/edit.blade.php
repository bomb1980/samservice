@extends('layouts.app',['activePage' => 'master'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">บันทึกข้อมูลหลักกิจกรรม</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="#"
                    class="keychainify-checked">จัดการข้อมูลกลาง</a></li>
            <li class="breadcrumb-item active">ข้อมูลผู้นำชุมชน</li>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="panel">
            <header class="panel-heading">
                <h3 class="panel-title"><i class="icon wb-plus-circle" aria-hidden="true"></i>
                    แก้ไขข้อมูลผู้นำชุมชน
                </h3>
            </header>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('master.cmleader.cmleader-edit-component',['dataCmleader'=>$dataCmleader,])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    window.onload = function() {
        Livewire.on('popup', () => {
            swal({
                title: "อัพเดทข้อมูลเรียบร้อย",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK",
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.livewire.emit('redirect-to');
                }
            });
        });
    }
</script>
@endpush
