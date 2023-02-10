@extends('layouts.app',['activePage' => 'master'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">กำหนดสิทธิ์การเข้าใช้งานระบบ</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="{{ route('permission.index') }}"
                    class="keychainify-checked">การตั้งค่า</a></li>
            <li class="breadcrumb-item active">กำหนดสิทธิ์การเข้าใช้งานระบบ</li>
        </ol>
        <div class="page-header-actions">
            <div class="">
                {{ link_to(route('grouppermission.index'),' จัดการข้อมูลกลุ่มผู้ใช้',['class'=>'btn btn-primary btn-md
                icon wb-settings'])
                }}
                {{ link_to(route('permission.create'),' เพิ่มสิทธิ์การเข้าใช้งาน',['class'=>'btn btn-primary btn-md
                icon wb-plus'])
                }}
            </div>
        </div>
    </div>

    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('permission.permission-component', ['columns'=>$columns]);
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


