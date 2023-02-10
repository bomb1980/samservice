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
        float: right;
    }

    .btn .icon {
            width: 1em;
            text-align: center;
            margin: -1px 3px 0;
            line-height: inherit;
            float: right;
        }
</style>
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ (กิจกรรมทักษะฝีมือแรงงาน)</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{ url('request/project') }}" class="keychainify-checked">ข้อมูลคำขอรับการจัดสรรงบประมาณ</a></li>
                <li class="breadcrumb-item active">บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ (กิจกรรมทักษะฝีมือแรงงาน)</li>
            </ol>
            <div class="page-header-actions">
                <div class="btn-group btn-group-sm">
                </div>
            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="row row-lg">
                <div class="col-md-12">
                    @livewire('request.train.edit-component', ['pullreqform' => $pullreqform])
                </div>
            </div>
        </div>
    </div>
@endsection
