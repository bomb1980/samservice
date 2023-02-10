@extends('layouts.app',['activePage' => 'setting'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">กำหนดสิทธิ์ผู้ใช้งานระบบ</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="">จัดการข้อมูลกลาง</a></li>
                <li class="breadcrumb-item active">กำหนดสิทธิ์ผู้ใช้งานระบบ</li>
            </ol>
        </div>
        <div class="page-content container-fluid">
            <div class="panel">
                <header class="panel-heading">
                    <h3 class="panel-title"><i class="icon wb-user-circle" aria-hidden="true"></i>
                        เพิ่มสิทธิ์ผู้ใช้งานระบบ
                    </h3>
                </header>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('setting.permission-edit-component',['dataPermission' => $dataPermission])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
