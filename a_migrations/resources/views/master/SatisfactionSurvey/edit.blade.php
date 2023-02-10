@extends('layouts.app',['activePage' => 'master'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">แก้ไขบริหารแบบประเมินความพึงพอใจ</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('master.form.index') }}" class="keychainify-checked">บริหารแบบประเมินความพึงพอใจ</a></li>
            <li class="breadcrumb-item active">แก้ไขแบบประเมินความพึงพอใจ</li>
        </ol>
    </div>

    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('master.satisfaction-survey.satisfaction-survey-edit', compact('assessment_topics_id'))
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
