<div>


    <div class="panel form-group">
        <div class="panel-body container-fluid">
            <div class="row row-lg">
                <div class="col-md-12">
                    {!! Form::open([
                        'wire:submit.prevent' => 'submit()',
                        'autocomplete' => 'off',
                        'class' => 'form-horizontal fv-form fv-form-bootstrap4',
                    ]) !!}

                    <div class="row">

                        <label class="col-md-1 form-control-label">ภูมิภาค </label>
                        <div class="col-md-2">

                            {!! Form::select('region_list', $region_list, null, ['class' => 'form-control', 'wire:model'=>'region_select', 'wire:change'=>'clearArea']) !!}

                        </div>
                        <label class="col-md-1 form-control-label">จังหวัด </label>
                        <div class="col-md-2">

                            {!! Form::select('province_list', $province_list, null, ['class' => 'form-control', 'wire:model'=>'province_select']) !!}

                        </div>
                        <div class="col-md-2">

                            <button class="btn btn-primary" wire:click="exportExcel">{!! getIcon( 'excel') !!} รายงาน Excel</button>
                        </div>

                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


    <div class="row row-lg">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover w-full table-striped dataTable" id="Datatables">
                    <thead>

                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center">จำนวนกิจกรรม</th>
                            <th class="text-center">จำนวนผู้เข้าร่วมกิจกรรม</th>
                            <th class="text-center">ความพึงพอใจรวม</th>
                            <th class="text-center">จำนวนผู้ตอบแบบประเมิน</th>
                            <th class="text-center">ระดับความพึงพอใจเฉลี่ย</th>

                        </tr>

                    </thead>



                    @if (empty( $trs ) )
                    <tr>
                        <th colspan="6" class="text-center">ยังไม่มีข้อมูล</th>


                    </tr>
                    @else
                    {!!$trs!!}
                    @endif


                </table>
            </div>
        </div>
    </div>
</div>



@push('js')
<script>
    $(function() {
        // call_datatable();
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
                { data: 'sum_transfer_amt', name: 'sum_transfer_amt', className: "text-right", orderable: true },
                { data: 'centerbudget_amt', name: 'centerbudget_amt', className: "text-right", orderable: true },
                { data: 'sum_pay_amt', name: 'sum_pay_amt', className: "text-right", orderable: true },
                { data: 'refund_amt', name: 'refund_amt', className: "text-right", orderable: true },
                { data: 'regionbudget_amt', name: 'regionbudget_amt', className: "text-right", orderable: true },
                { data: 'regionperiod_amt', name: 'regionperiod_amt', className: "text-right", orderable: true },
                { data: 'regionpay_amt', name: 'regionpay_amt', className: "text-right", orderable: true },
                { data: 'regionbudget_balance', name: 'regionbudget_balance', className: "text-right", orderable: true },
                // { data: 'edit', name: 'edit', className: "text-center", orderable: false },
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
