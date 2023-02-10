@extends('layouts.app', ['activePage' => 'manage'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">จัดสรรงบประมาณ</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="#" class="keychainify-checked">บริหารงบประมาณ</a></li>
                <li class="breadcrumb-item active">จัดสรรงบประมาณ</li>
            </ol>
            <div class="page-header-actions">
            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('manage.local-mng.edit-component', ["fiscalyear_code" => $fiscalyear_code])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>

    </script>
@endpush
