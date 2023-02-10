@extends('layouts.app', ['activePage' => 'master'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">{{ $title }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item">{{ $title }}</li>
            </ol>

            <div class="page-header-actions">
                <div class="btn-group btn-group-sm">
                    <a href="{{route('master.acttype.create')}}" class="btn
                    btn-primary btn-md
                    float-right icon wb-plus">เพิ่มประเภทกิจกรรม</a>
                </div>
            </div>

        </div>

        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">

                    <div class="row form-group">

                        <div class="col-md-2">
                            <div class="input-group">
                                <input oninput="set_search()" class="form-control" id="search" placeholder="ค้นหา..."
                                    name="search" type="text">
                            </div>
                        </div>


                    </div>
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('history-component', ['columns' => $columns, 'api' => $api])
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection
