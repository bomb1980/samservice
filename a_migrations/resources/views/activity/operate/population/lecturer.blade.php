@extends('layouts.app', ['activePage' => 'operate'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">เพิ่มวิทยากร</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item active">บริหารกิจกรรม</li>
            </ol>
            <div class="page-header-actions">

            </div>
        </div>
        <div class="page-content container-fluid">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('activity.operate.population.lecturer-add-component', ['act_id' => $act_id])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(function() {
        @if(session('success'))

            swal({
                title: "บันทึกข้อมูลเรียบร้อย",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ตกลง",
            });

        @endif
    });
</script>

@endpush
