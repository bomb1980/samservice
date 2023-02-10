@extends('layouts.app',['activePage' => 'manage'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">{{$main_title}}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="{{route('manage.fiscal.index')}}" class="keychainify-checked">บริหารงบประมาณ</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
        </ol>


    </div>
    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('manage.cen-depo.save-component',['parent_datas'=>$parent_datas, 'payment_group'=>$payment_group])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

