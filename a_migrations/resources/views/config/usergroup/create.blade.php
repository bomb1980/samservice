@extends('layouts.app',['activePage' => 'config'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">ตั้งค่าระบบ กลุ่มสิทธิ์ผู้ใช้งาน</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="{{ route('config.usergroup.index') }}"
                    class="keychainify-checked active">กลุ่มสิทธิ์ผู้ใช้งาน</a></li>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="panel">
            <header class="panel-heading">
                <h3 class="panel-title"><i class="icon wb-plus-circle" aria-hidden="true"></i>
                    เพิ่มกลุ่มสิทธิ์ผู้ใช้งาน
                </h3>
            </header>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('config.usergroup-add-component')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
</script>
@endpush
