@extends('layouts.app', ['activePage' => 'manage'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">{{ $title }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            <div class="page-header-actions">

            </div>
        </div>

        @livewire('report.report7-component')



    </div>
@endsection
