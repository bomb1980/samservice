@extends('layouts.app', ['activePage' => 'request'])

@section('content')
    <style>
        .pearl.disabled::before,
        .pearl.disabled::after {
            background-color: rgb(0, 0, 0, 8%);
        }

        .dot-checkmark i:before {
            font-family: sans-serif;
            content: "✔";
            color: white;
            display: inline-block;
            width: 2em;
            background: #11c26d;
            border-radius: 50%;
        }
    </style>
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">บันทึกแบบคำขอทำโครงการ (กิจกรรมจ้างงานเร่งด่วน)</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{ url('request/project') }}" class="keychainify-checked">ข้อมูลคำขอรับการจัดสรรงบประมาณ</a></li>
                <li class="breadcrumb-item active">บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ (กิจกรรมจ้างงานเร่งด่วน)</li>
            </ol>
            <div class="page-header-actions">
                <div class="btn-group btn-group-sm">

                </div>
            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="row row-lg">
                <div class="col-md-12">
                    @livewire('request.hire.add-component')
                </div>
            </div>
        </div>
    </div>
@endsection
