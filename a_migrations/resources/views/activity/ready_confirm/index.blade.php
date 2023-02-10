@extends('layouts.app', ['activePage' => 'activity'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">บันทึกยืนยันความพร้อมคำขอรับการจัดสรรงบ(สรจ)</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="keychainify-checked">บริหารกิจกรรม</a></li>
                <li class="breadcrumb-item active">บันทึกยืนยันความพร้อมคำขอรับการจัดสรรงบ(สรจ)</li>
            </ol>
        </div>

        @if ($check == 1)
            <div class="row d-flex justify-content-end">
                <a href="{{ route('activity.ready_confirm.hire.create') }}"
                    class="btn btn-primary form-control icon wb-plus col-md-2">
                    เพิ่มกิจกรรมจ้างงานเร่งด่วน</a>
                <a href="{{ route('activity.ready_confirm.train.create') }}"
                    class="btn btn-primary form-control icon wb-plus ml-4 col-md-2">
                    เพิ่มกิจกรรมทักษะฝีมือแรงงาน</a>
                <a href="{{ route('activity.ready_confirm.copy') }}"
                    class="btn btn-primary form-control icon wb-plus ml-4 col-md-2" style="margin-right: 2%">
                    ดึงข้อมูลทั้งหมดจากแบบคำของบ</a>
            </div>
        @endif

        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('activity.ready-confirm.index-component')
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
