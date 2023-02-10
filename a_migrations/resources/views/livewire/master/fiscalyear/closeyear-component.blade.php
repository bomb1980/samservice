<div>
    {{-- <div class="row row-lg">
        <div class="col-md-12">
            <div class="form-group row">
                <label class="form-control-label col-md-1 text-right">ปีงบประมาณ </label>
                <div class="col-md-2">
                    {!! Form::select('budgetyear', $budgetyearSelect, null ,['class' => 'form-control', 'id' =>
                    'budgetyear','placeholder' => 'แสดงทั้งหมด','onchange' => 'callAjax(this.value)']) !!}
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row row-lg">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover w-full table-striped dataTable" id="Datatables">
                    <thead>
                        <tr>
                            <th class="text-center" rowspan="2">ลำดับ</th>
                            <th class="text-center" rowspan="2">ปีงบประมาณ</th>
                            <th class="text-center" rowspan="2">งบประมาณที่ได้รับ</th>
                            <th class="text-center" rowspan="2">ค่าใช้จ่ายส่วนกลางเงินบริหาร</th>

                            <th class="text-center bg-gray" colspan="3">ค่าใช้จ่าย</th>


                            <th class="text-center" rowspan="2">คงเหลือ</th>
                            <th class="text-center" rowspan="2">เงินคืนแผ่นดิน</th>
                            <th class="text-center" rowspan="2">ปิดปีงบประมาณ</th>
                        </tr>
                        <tr>
                            <th class="text-center bg-gray">ทักษะผีมือแรงงาน</th>
                            <th class="text-center bg-gray">จ้างงานเร่งด่วน</th>
                            <th class="text-center bg-gray">เงินบริหาร</th>
                        </tr>


                        @if (config('app.th_link') )

                        <tr>
                            <th class="text-center bg-gray">no</th>
                            <th class="text-center bg-gray">fiscalyear_code</th>
                            <th class="text-center bg-gray">total_transfer_amt</th>
                            <th class="text-center bg-gray">sub_manage_payment_amt1</th>
                            <th class="text-center bg-gray">trainingpayment_amt</th>
                            <th class="text-center bg-gray">urgentpayment_amt</th>
                            <th class="text-center bg-gray">sub_manage_payment_amt2</th>
                            <th class="text-center bg-gray">stil_amt</th>
                            <th class="text-center bg-gray">refund_amt</th>
                            <th class="text-center bg-gray">buttons</th>


                        </tr>


                        @endif


                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>



@push('js')
<script>
    $(function() {
        call_datatable();
    });


    function call_datatable() {
        var table = $('#Datatables').DataTable({
            processing: true,
            dom: 'rtp<"bottom"i>',
            ajax: {
                url: '{{ route("api.master.fiscalyear.list") }}',
                type: 'GET',
                data: { token: '{{ csrf_token() }}',
                fiscalyear_code: $('#fiscalyear_code').val()
                        },
                headers: { 'Authorization': 'Bearer {{ system_key() }}' }
            },
            columns: [


                { data: 'no', name: 'no', className: "text-center", orderable: true },
                { data: 'fiscalyear_code', name: 'fiscalyear_code', className: "text-center", orderable: true },
                { data: 'total_transfer_amt', name: 'total_transfer_amt', className: "text-right", orderable: true },
                { data: 'sub_manage_payment_amt1', name: 'sub_manage_payment_amt1', className: "text-right", orderable: true },

                { data: 'trainingpayment_amt', name: 'trainingpayment_amt', className: "text-right", orderable: true },
                { data: 'urgentpayment_amt', name: 'urgentpayment_amt', className: "text-right", orderable: true },
                { data: 'sub_manage_payment_amt2', name: 'sub_manage_payment_amt2', className: "text-right", orderable: true },
                { data: 'stil_amt', name: 'stil_amt', className: "text-right", orderable: true },
                { data: 'refund_amt', name: 'refund_amt', className: "text-right", orderable: true },
                { data: 'buttons', name: 'buttons', className: "text-center", orderable: true },


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
@endpush
