@extends('layouts.app', ['activePage' => 'result'])

@section('content')
    <div class="page" style="background-color: #FFFFFF">
        <div class="page-header">
            <h1 class="page-title">บันทึกแบบประเมิน</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="#" class="keychainify-checked">กิจกรรม</a></li>
                <li class="breadcrumb-item active">บันทึกแบบประเมิน</li>
            </ol>
            <div class="page-header-actions">

            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('activity.assessment.assessment-add-component')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
