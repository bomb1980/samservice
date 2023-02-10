@extends('layouts.app',['activePage' => 'master'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">ข้อมูลกลุ่มสาขาอาชีพ</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="#"
                    class="keychainify-checked">จัดการข้อมูลกลาง</a></li>
            <li class="breadcrumb-item active">ข้อมูลกลุ่มสาขาอาชีพ</li>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="panel">
            <header class="panel-heading">
                <h3 class="panel-title"><i class="icon wb-plus-circle" aria-hidden="true"></i>
                    เพิ่มข้อมูลกลุ่มสาขาอาชีพ
                </h3>
            </header>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('master.coursesubgroup.coursesubgroup-add-component')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
