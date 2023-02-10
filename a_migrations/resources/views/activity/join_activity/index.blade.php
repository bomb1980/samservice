@extends('layouts.app',['activePage' => 'activity'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">บันทึกเวลาเข้าร่วมกิจกรรม</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="#" class="keychainify-checked">กิจกรรม</a></li>
            <li class="breadcrumb-item active">บันทึกเวลาเข้าร่วมกิจกรรม</li>
        </ol>
    </div>

    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('activity.join-activity.join-activity-component')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    // $(function() {
    //     call_datatable();
    // });

    // function callAjax(val){
    //     $.get('callAjax/'+ val ,function(data){
    //         let array = Object.entries(data);
    //         console.log(array);
    //         $('#carreerno').empty();
    //         array.forEach((currentValue, index, arr) => {
    //             $('#carreerno').append($('<option>', {
    //                 value: currentValue[0],
    //                 text : currentValue[1]
    //             }));
    //         });
    //     });
    //     change_data();
    // }
    // function create_data(){
    //     if($('#courseno').val()&&$('#carreerno').val()){
    //         window.livewire.emit('redirect-to',{ courseno:$('#courseno').val(),carreerno:$('#carreerno').val()});
    //     }
    //     else{
    //         alert("กรุณาระบุ กลุ่มหลักสูตรและสาขาอาชีพ ให้ครบถ้วน");
    //     }
    // }
    // function call_datatable() {
    //     var table = $('#Datatables').DataTable({
    //         processing: true,
    //         dom: 'rtp<"bottom"i>',
    //         ajax: {
    //             url: '{{ route("api.master.fiscalyear.list") }}',
    //             type: 'GET',
    //             data: { token: '{{ csrf_token() }}',
    //             fiscalyear_code: $('#fiscalyear_code').val()
    //                     },
    //             headers: { 'Authorization': 'Bearer {{ system_key() }}' }
    //         },
    //         columns: [
    //             // { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false},
    //             { data: 'fiscalyear_code', name: 'fiscalyear_code', className: "text-center", orderable: true },
    //             // { data: 'startdate_view', name: 'startdate_view', className: "text-center", orderable: true },
    //             // { data: 'enddate_view', name: 'enddate_view', className: "text-center", orderable: true },
    //             { data: 'sum_total_amt', name: 'sum_total_amt', className: "text-right", orderable: true },
    //             { data: 'req_amt', name: 'req_amt', className: "text-right", orderable: true },
    //             { data: 'budget_amt', name: 'budget_amt', className: "text-right", orderable: true },
    //             { data: 'sum_transfer_amt', name: 'sum_transfer_amt', className: "text-right", orderable: true },
    //             { data: 'centerbudget_amt', name: 'centerbudget_amt', className: "text-right", orderable: true },
    //             { data: 'sum_pay_amt', name: 'sum_pay_amt', className: "text-right", orderable: true },
    //             { data: 'centerbudget_balance', name: 'centerbudget_balance', className: "text-right", orderable: true },

    //             // { data: 'refund_amt', name: 'refund_amt', className: "text-right", orderable: true },

    //             // { data: 'ostbudget_amt', name: 'ostbudget_amt', className: "text-right", orderable: true },
    //             // { data: 'centerbudget_amt', name: 'centerbudget_amt', className: "text-right", orderable: true },
    //             // { data: 'centerbudget_withdraw', name: 'centerbudget_withdraw', className: "text-right", orderable: true },

    //             { data: 'regionbudget_amt', name: 'regionbudget_amt', className: "text-right", orderable: true },
    //             { data: 'regionperiod_amt', name: 'regionperiod_amt', className: "text-right", orderable: true },
    //             { data: 'regionpay_amt', name: 'regionpay_amt', className: "text-right", orderable: true },
    //             { data: 'regionbudget_balance', name: 'regionbudget_balance', className: "text-right", orderable: true },
    //             { data: 'edit', name: 'edit', className: "text-center", orderable: false },
    //             { data: 'del', name: 'del', className: "text-center", orderable: false }
    //         ],
    //         language: {
    //         url: '{{ asset("assets") }}/js/datatable-thai.json',
    //         },
    //         paging: true,
    //         pageLength:10,
    //         ordering:false,
    //         drawCallback: function(settings) {
    //             var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    //             pagination.toggle(this.api().page.info().pages > 1);
    //         }
    //     });

    // }
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
