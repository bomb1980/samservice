@extends('layouts.app',['activePage' => 'master'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">บันทึกเวลาเข้าร่วมกิจกรรม</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="#" class="keychainify-checked">กิจกรรม</a></li>
            <li class="breadcrumb-item active">บันทึกเวลาเข้าร่วมกิจกรรม</li>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="panel">
            <header class="panel-heading">
                <h3 class="panel-title"><i class="icon wb-plus-circle" aria-hidden="true"></i>
                    บันทึกเวลาเข้าร่วมกิจกรรม
                </h3>
            </header>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('activity.join-activity.join-activity-add-component')
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
        });
    }
</script>
@endpush
