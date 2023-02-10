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
                            <th class="text-center" rowspan="2">ปีงบประมาณ</th>
                            <th class="text-right" rowspan="2">คำขอ</th>
                            <th class="text-right" rowspan="2">เสนองบ</th>
                            <th class="text-right" rowspan="2">งบ</th>
                            <th class="text-right" rowspan="2">รับโอน</th>
                            <th class="text-center bg-pink-100" colspan="3">ส่วนกลาง</th>
                            <th class="text-center bg-purple-100" colspan="3">สรจ</th>
                            <th class="col-1" rowspan="2">แก้ไข</th>
                            <th class="col-1" rowspan="2">ลบ</th>
                        </tr>
                        <tr>
                            <th class="text-right bg-pink-100">จัดสรร</th>
                            <th class="text-right bg-pink-100">เบิกจ่าย</th>
                            <th class="text-right bg-pink-100">เงินคงเหลือ</th>
                            <th class="text-right bg-purple-100">จัดสรร</th>
                            {{-- <th class="text-right bg-purple-100">รับโอน</th> --}}
                            <th class="text-right bg-purple-100">เบิกจ่าย</th>
                            <th class="text-right bg-purple-100">เงินคงเหลือ</th>
                        </tr>


                    </thead>
                </table>
            </div>
        </div>
    </div>


</div>



@push('js')
<script>
    $(function() {
            @if (session('success'))

                swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                });
            @endif

            @if (session('success_del'))

                swal({
                    title: "ลบข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                });
            @endif
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
                { data: 'fiscalyear_code', name: 'fiscalyear_code', className: "text-center", orderable: true },
                { data: 'sum_total_amt', name: 'sum_total_amt', className: "text-right", orderable: true },
                { data: 'req_amt', name: 'req_amt', className: "text-right", orderable: true },
                { data: 'budget_amt', name: 'budget_amt', className: "text-right", orderable: true },
                { data: 'total_transfer_amt', name: 'total_transfer_amt', className: "text-right", orderable: true },
                { data: 'centerbudget_amt', name: 'centerbudget_amt', className: "text-right", orderable: true },
                { data: 'sub_manage_payment_amt1', name: 'sub_manage_payment_amt1', className: "text-right", orderable: true },
                { data: 'refund_amt', name: 'refund_amt', className: "text-right", orderable: true },
                { data: 'regionbudget_amt', name: 'regionbudget_amt', className: "text-right", orderable: true },
                // { data: 'regionperiod_amt', name: 'regionperiod_amt', className: "text-right", orderable: true },
                { data: 'sub_manage_payment_amt2', name: 'sub_manage_payment_amt2', className: "text-right", orderable: true },
                { data: 'regionbudget_balance', name: 'regionbudget_balance', className: "text-right", orderable: true },
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
@endpush
