@extends('layouts.app',['activePage' => 'manage'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">{{$title}}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="{{route('manage.fiscal.index2')}}"
                    class="keychainify-checked">{{$title}}</a></li>
            <li class="breadcrumb-item active">{{$sub_title}}</li>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="panel">
            <header class="panel-heading">
                <h3 class="panel-title">{!!$icon!!}
                    {{$title}}  {{$sub_title}}
                </h3>
            </header>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('manage.installment.installment-edit-component', ['budget_id' => $budget_id, 'datas' => $datas])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    window.onload = function() {
        Livewire.on('popup', () => {
            swal({
                title: "บันทึกข้อมูลเรียบร้อย",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK",
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.livewire.emit('redirect-to');
                }
            });
        });
    }
</script>
@endpush
