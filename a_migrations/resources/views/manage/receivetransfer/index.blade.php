@extends('layouts.app', ['activePage' => 'manage'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">ข้อมูลรับโอนเงินจากสำนักงบประมาณ</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
          {!!$bredcum!!}
        </ol>
        <ol>
            <div class="page-header-actions">
                <div class="btn-group btn-group-sm">
                    {{ link_to(route('manage.receivetransfer.create'),' เพิ่มข้อมูลรับโอนจากสำนักงบประมาณ',['class'=>'btn btn-primary float-right icon wb-plus']) }}
                </div>
            </div>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="panel">
            <header class="panel-heading">
                <h3 class="panel-title">{!!$icon!!}
                    {{$title}}
                </h3>
            </header>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('manage.receivetransfer.receivetransfer-index-component', ['columns'=>$columns, 'delete_budget_id'=>$delete_budget_id])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
