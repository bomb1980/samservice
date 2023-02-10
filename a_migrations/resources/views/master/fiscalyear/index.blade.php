@extends('layouts.app',['activePage' => 'master'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">ข้อมูลปีงบประมาณ</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item">ข้อมูลปีงบประมาณ</li>
        </ol>
        <div class="page-header-actions">
            <div class="btn-group btn-group-sm">
                {{ link_to(route('master.fiscalyear.create'),' เพิ่มข้อมูล',['class'=>'btn
                btn-primary btn-md
                float-right icon wb-plus'])
                }}
            </div>
        </div>
    </div>

    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('master.fiscalyear.fiscalyear-component')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

