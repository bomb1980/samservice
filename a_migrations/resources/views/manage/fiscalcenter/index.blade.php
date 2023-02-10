@extends('layouts.app',['activePage' => 'manage'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">บริหารงบประมาณส่วนกลาง</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="#"
                    class="keychainify-checked">บริหารงบประมาณ</a></li>
            <li class="breadcrumb-item active">บริหารงบประมาณส่วนกลาง</li>
        </ol>
        <ol>
            <div class="page-header-actions">
                <div class="btn-group btn-group-sm">
                    {{ link_to(route('manage.receivetransfer.create'),' เพิ่มข้อมูลรับโอนจากสำนักงบประมาณ',['class'=>'btn btn-primary float-right icon wb-plus']) }}
                </div>
                <div class="btn-group btn-group-sm">
                    {{ link_to(route('manage.allocate.create'),' เพิ่มข้อมูลจัดสรรเงิน',['class'=>'btn btn-primary btn-md float-right icon wb-plus'])}}
                </div>
            </div>
        </ol>
    </div>

    </div>

    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('manage.fiscalcenter.fiscalcenter-component')
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
        call_datatable('');
    });

    function change_status(id) {
        $('#status_form' + id).submit();
    }

    function change_delete(id) {

        swal({
            title: 'ยืนยันการ ลบ ข้อมูล ?',
            icon: 'close',
            type: "warning",
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#00BCD4',
            cancelButtonColor: '#DD6B55'
        }, function (isConfirm) {
            if(isConfirm) {
                $('#delete_form' + id).submit();
            } else {
                console.log('reject delete');
            }
        });
    }
</script>
@endpush
