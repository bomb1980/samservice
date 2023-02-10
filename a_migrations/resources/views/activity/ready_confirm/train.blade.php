@extends('layouts.app', ['activePage' => 'activity'])

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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />

    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.css"
        integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g=="
        crossorigin="">
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">รวบรวมคำขอ (กิจกรรมทักษะฝีมือแรงงาน)</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{ url('activity/ready_confirm') }}" class="keychainify-checked">บริหารกิจกรรม</a></li>
                <li class="breadcrumb-item active">รวบรวมคำขอ (กิจกรรมทักษะฝีมือแรงงาน)</li>
            </ol>
            <div class="page-header-actions">

            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="row row-lg">
                <div class="col-md-12">
                    @livewire('activity.ready-confirm.train-add-component')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script></script>
@endpush
