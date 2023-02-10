@extends('layouts.app',['activePage' => 'permission'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">จัดการข้อมูลกลุ่มผู้ใช้</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('grouppermission.index') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item blue-500">จัดการข้อมูลกลาง</li>
                <li class="breadcrumb-item active">จัดการข้อมูลกลุ่มผู้ใช้</li>
            </ol>
        </div>

        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('permission.grouppermission-add-component')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
