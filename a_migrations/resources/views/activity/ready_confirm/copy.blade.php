@extends('layouts.app',['activePage' => 'activity'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">บันทึกยืนยันความพร้อมคำขอรับการจัดสรรงบ(สรจ)</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="{{ url('activity/ready_confirm') }}" class="keychainify-checked">บริหารกิจกรรม</a></li>
            <li class="breadcrumb-item active">บันทึกยืนยันความพร้อมคำขอรับการจัดสรรงบ(สรจ)</li>
        </ol>
        <div class="page-header-actions">

        </div>
    </div>

    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('activity.ready-confirm.copy-req-component')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function change_status(id) {
        $('#status_form' + id).submit();
    }

    function closeModal() {
        $('#exampleModal').modal('hide');
    }
</script>
@endpush
