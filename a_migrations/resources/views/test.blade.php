@extends('layouts.app', ['activePage' => 'master'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">หัวข้อประเมิน กิจกรรมพัฒนาทักษะฝีมือแรงงาน</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="#" class="keychainify-checked"> เทส API พื้นที่</a></li>
                <li class="breadcrumb-item active"> เทสฟอร์ม API พื้นที่</li>
            </ol>
        </div>
        <div class="page-content container-fluid">
            <div class="panel">
                <header class="panel-heading">
                    <h3 class="panel-title"><i class="icon wb-plus-circle" aria-hidden="true"></i>
                        เทส API พื้นที่
                    </h3>
                </header>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('test', ['data' => $data])
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
                        title: "แก้ไขข้อมูลเรียบร้อย",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.livewire.emit('redirect-to');
                        }
                    });
            });
        }
    </script>
@endpush
