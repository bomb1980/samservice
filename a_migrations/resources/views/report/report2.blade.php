@extends('layouts.app',['activePage' => 'master'])

@section('content')
<link href="{{ asset('css/custom2.css') }}" rel="stylesheet">

<div class="page">
    <div class="page-header">
        <h1 class="page-title">{{$title}}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item">{{$title}}</li>
        </ol>


    </div>

    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('report.report2-component', ['datas'=>$datas])

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

