<div>

    <div class="row row-lg">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover w-full table-striped dataTable" id="Datatables">
                    <thead>

                        <tr>
                            <th class="text-center" rowspan="2">ลำดับ</th>
                            <th class="text-center" rowspan="2">ปีงบประมาณ</th>
                            <th class="text-center bg-pink-100" colspan="2">งบประมาณที่ขอแยกตามประเภท</th>
                            <th class="text-center bg-purple-100" rowspan="2">รวมจำนวนเงินจัดกิจกรรม</th>
                            <th class="text-center bg-purple-100" rowspan="2">จำนวนเงินที่เสนองบประมาณ</th>
                            <th class="text-center bg-purple-100" rowspan="2">สิ้นสุดเมือ</th>
                            <th class="text-center bg-purple-100" rowspan="2">สถานะ</th>
                            <th class="text-center bg-purple-100" rowspan="2"></th>
                        </tr>
                        <tr>

                            <th class="text-center bg-pink-100">กิจกรรมจ้างงานเร่งด่วน</th>
                            <th class="text-center bg-pink-100">กิจกรรมทักษะฝีมือแรงงาน</th>

                        </tr>

                        @if (config('app.th_link'))
                        <tr>

                            <th class="text-center bg-pink-100">ลำดับ</th>
                            <th class="text-center bg-pink-100">fiscalyear_code</th>
                            <th class="text-center bg-pink-100">req_urgentamt</th>
                            <th class="text-center bg-pink-100">req_skillamt</th>
                            <th class="text-center bg-pink-100">req_sumreqamt</th>
                            <th class="text-center bg-pink-100">req_amt</th>
                            <th class="text-center bg-pink-100">req_amt</th>
                            <th class="text-center bg-pink-100">status</th>
                            <th class="text-center bg-pink-100"></th>

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
                url: '{{ route("api.master.fiscalyear.rec") }}',
                type: 'GET',
                data: { token: '{{ csrf_token() }}',
                fiscalyear_code: $('#fiscalyear_code').val()
                        },
                headers: { 'Authorization': 'Bearer {{ system_key() }}' }
            },
            columns: [
                { data: 'no', name: 'no', className: " text-center", orderable: true },
                { data: 'fiscalyear_code', name: 'fiscalyear_code', className: " text-center", orderable: true },
                { data: 'req_urgentamt', name: 'req_urgentamt', className: "text-right", orderable: true },
                { data: 'req_skillamt', name: 'req_skillamt', className: "text-right", orderable: true },
                { data: 'req_sumreqamt', name: 'req_sumreqamt', className: "text-right", orderable: true },
                { data: 'req_amt', name: 'req_amt', className: "text-right", orderable: true },
                { data: 'req_enddate', name: 'req_enddate', className: "text-center", orderable: true },
                { data: 'status', name: 'status', className: "text-center", orderable: true },
                { data: 'edit', name: 'edit', className: "text-center", orderable: false },
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
