@extends('layouts.app',['activePage' => 'master'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">บันทึกคอร์สหลักสูตร</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="#"
                    class="keychainify-checked">ข้อมูล Master สรจ.</a></li>
            <li class="breadcrumb-item active">คอร์สหลักสูตร</li>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        @livewire('master.office.master23.index-component')
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
        var table = $('#Datatables').DataTable({
            processing: true,
            dom: 'rtp<"bottom"i>',
            ajax: {
                url: '{{ route("api.master.office.master23.list") }}',
                type: 'GET',
                data: { token: '{{ csrf_token() }}',
                        courseno: $('#courseno').val(),
                        carreerno: $('#carreerno').val()
                        },
                headers: { 'Authorization': 'Bearer {{ system_key() }}' }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false},
                { data: 'coursename', name: 'coursename', className: "text-center", orderable: true },
                { data: 'carreername', name: 'carreername', className: "text-center", orderable: true },
                { data: 'schedulecode', name: 'schedulecode', className: "text-center", orderable: true },
                { data: 'schedulename', name: 'schedulename', className: "text-left", orderable: true },
                { data: 'edit', name: 'edit', className: "text-center", orderable: false },
                { data: 'del', name: 'del', className: "text-center", orderable: false }
            ],
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
{{-- <script>
    $('.delete-confirm').on('click', function (event) {
       event.preventDefault();
       const url = $(this).attr('href');
       swal({
           title: 'Are you sure?',
           text: 'This record and it`s details will be permanantly deleted!',
           icon: 'warning',
           buttons: ["Cancel", "Yes!"],
           }).then(function(value) {
           if (value) {
           window.location.href = url;
         }
       });
      });
 </script> --}}
 {{-- <script>
    Swal.fire({!!Session::pull('alert.config')!!});  // working
</script> --}}
@endpush
