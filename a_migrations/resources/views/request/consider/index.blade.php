@extends('layouts.app',['activePage' => 'request'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">บันทึกผลการพิจารณาคำขอรับการจัดสรรงบประมาณ</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="#"
                    class="keychainify-checked">ข้อมูลคำขอรับการจัดสรรงบประมาณ</a></li>
            <li class="breadcrumb-item active">บันทึกผลการพิจารณาคำขอรับการจัดสรรงบประมาณ</li>
        </ol>
    </div>

    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('request.consider.index-component')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


