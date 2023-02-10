@extends('layouts.app', ['activePage' => 'activity'])

@section('content')
    <style>
        .btn-group>.btn:first-child {
            margin-left: 26rem;
        }
    </style>
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">บันทึกผู้เข้าร่วมโครงการ</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item active">บันทึกผู้เข้าร่วมโครงการ</li>
            </ol>
        </div>

        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('activity.participant.participant-component')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
