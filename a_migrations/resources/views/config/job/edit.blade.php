@extends('layouts.app',['activePage' => 'config'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">ตั้งค่าเวลาดึงข้อมูล </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="{{ route('config.job.index') }}"
                    class="keychainify-checked active">เวลาดึงข้อมูล</a></li>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="panel">
            <header class="panel-heading">
                <h3 class="panel-title"><i class="icon wb-edit" aria-hidden="true"></i>
                    แก้ไขตั้งค่าเวลาดึงข้อมูล
                </h3>
            </header>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('config.job-edit-component',[
                        'dataJob'=>$datajob,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
