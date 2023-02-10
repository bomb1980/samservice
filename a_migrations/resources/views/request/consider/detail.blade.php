@extends('layouts.app', ['activePage' => 'request'])

@section('content')
    <div class="page">
        <div class="page-header">
            @if ($acttype_id == 1)
            <h1 class="page-title">ขั้นตอนพิจารณาแบบคำขอทำโครงการ (งานเร่งด่วน)</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="#" class="keychainify-checked">บันทึกคำของบประมาณ</a></li>
                <li class="breadcrumb-item active">บันทึกแบบคำขอทำโครงการ (งานเร่งด่วน)</li>
            </ol>
            @else
            <h1 class="page-title">ขั้นตอนพิจารณาแบบคำขอทำโครงการ (กิจกรรมทักษะฝีมือแรงงาน)</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="#" class="keychainify-checked">บันทึกคำของบประมาณ</a></li>
                <li class="breadcrumb-item active">บันทึกแบบคำขอทำโครงการ (กิจกรรมทักษะฝีมือแรงงาน)</li>
            </ol>
            @endif
        </div>

        <div class="page-content container-fluid">
            <div class="row row-lg">
                <div class="col-md-12">
                    @livewire('request.consider.detail-component', ['pullreqform' => $pullreqform])
                </div>
            </div>
        </div>
    </div>
@endsection
