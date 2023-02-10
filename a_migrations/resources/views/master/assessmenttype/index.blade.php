@extends('layouts.app', ['activePage' => 'master'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">ข้อมูลประเภทแบบประเมิน</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="#" class="keychainify-checked">จัดการข้อมูลกลาง</a></li>
                <li class="breadcrumb-item active">ข้อมูลประเภทแบบประเมิน</li>
            </ol>
            <div class="page-header-actions">
                <div class="btn-group btn-group-sm">
                    {{ link_to(route('master.assessmenttype.create'), ' เพิ่มข้อมูล', [
                        'class' => 'btn btn-primary btn-md float-right icon wb-plus',
                    ]) }}
                </div>
            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('master.assessment-type.index-component')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
