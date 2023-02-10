@extends('layouts.app',['activePage' => 'activity'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">สรุปรวมค่าใช้จ่ายประจำปี</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="#"
                    class="keychainify-checked">บริหารกิจกรรม</a></li>
            <li class="breadcrumb-item active">สรุปรวมค่าใช้จ่ายประจำปี</li>
        </ol>
        <div class="page-header-actions">

        </div>
    </div>

    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('activity.summaryexpenses.summaryexpensesyear-component')
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
