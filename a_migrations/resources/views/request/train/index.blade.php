@extends('layouts.app',['activePage' => 'request'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">บันทึกแบบคำขอทำโครงการ (กิจกรรมทักษะฝีมือแรงงาน)</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="#"
                    class="keychainify-checked">บันทึกคำขอ</a></li>
            <li class="breadcrumb-item"><a href="#"
                    class="keychainify-checked">โครงการปีงบประมาณ</a></li>
            <li class="breadcrumb-item active">บันทึกแบบคำขอทำโครงการ (กิจกรรมทักษะฝีมือแรงงาน)</li>
        </ol>
        <div class="page-header-actions">
            <div class="btn-group btn-group-sm">
                {{ link_to(route('request.train.create'),'บันทึกแบบคำขอทำโครงการ',['class'=>'btn
                btn-primary btn-md
                float-right icon wb-plus'])
                }}
            </div>
        </div>
    </div>

    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('request.train.index-component')
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
        call_datatable();
    });

    function callAjax(val){
        $.get('callAjax/'+ val ,function(data){
            let array = Object.entries(data);
            console.log(array);
            $('#carreerno').empty();
            array.forEach((currentValue, index, arr) => {
                $('#carreerno').append($('<option>', {
                    value: currentValue[0],
                    text : currentValue[1]
                }));
            });
        });
        change_data();
    }
    function create_data(){
        if($('#courseno').val()&&$('#carreerno').val()){
            window.livewire.emit('redirect-to',{ courseno:$('#courseno').val(),carreerno:$('#carreerno').val()});
        }
        else{
            alert("กรุณาระบุ กลุ่มหลักสูตรและสาขาอาชีพ ให้ครบถ้วน");
        }
    }
    function call_datatable() {
        var table = $('#dataTable').DataTable({
            processing: true,
            dom: 'rtp<"bottom"i>',
            language: {
            url: '{{ asset("assets") }}/js/datatable-thai.json',
            },
            paging: true,
            pageLength:10,
            ordering:false,
            drawCallback: function(settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);
            }
        });

    }
    function change_data() {
        $('#Datatables').DataTable().destroy();
        call_datatable();
        return false;
    }
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
