@extends('layouts.app', ['activePage' => 'activity'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">บันทึกผู้เข้าร่วมโครงการ</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="#" class="keychainify-checked">กิจกรรม</a></li>
                <li class="breadcrumb-item active">บันทึกผู้เข้าร่วมโครงการ</li>
            </ol>
            <div class="page-header-actions">

            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('activity.participant.participant-add-component', [
                                'reqform_id' => $reqform_id,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
