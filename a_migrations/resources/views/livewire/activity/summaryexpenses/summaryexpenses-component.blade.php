<div>
    <div class="form-group row">
        <div style="flex: 0 0 5%;"></div>
        <label class="col-md-1 form-control-label">ปีงบประมาณ </label>
        {!! Form::select('budgetyear', $budgetyear_list, $budgetyear, ['onchange' => 'setValue("budgetyear",event.target.value)', 'class' => 'form-control select2 col-md-2', 'placeholder' => '--เลือกปีงบประมาณ--']) !!}

        <label class="form-control-label col-md-1 text-right pr-4">งวดที่</label>
       {{ Form::select('periodno', $periodno_list, $periodno, ['onchange' => 'setValue("periodno",event.target.value)', 'class' => 'form-control  select2 col-md-2', 'id' => 'periodno',  'placeholder' => '--เลือกงวด--' ]) }}
    </div>
    <div class="form-group row">
        <div class="table-responsive">
            <table class="table table-bordered table-hover w-full table-striped dataTable" id="Datatables">
                <thead class="bg-blue-500">
                    {{-- <tr class="text-center" >
                        <th colspan="3">การจัดส่วนกลาง</th>
                        <th colspan="4">การจัดส่วนภูมิภาค</th>
                    </tr>
                    <tr class="text-center">
                        <th>งบประมาณ</th>
                        <th>เบิกจ่าย</th>
                        <th>คงเหลือ</th>
                        <th>งบประมาณ</th>
                        <th>ค่าใช้จ่ายการบริหาร</th>
                        <th>ค่าใช้จ่ายโครงการ</th>
                        <th>คงเหลือ</th>
                    </tr> --}}
                    <th>ลำดับ</th>
                        <th>หน่วยงาน</th>
                        <th>ประเภท</th>
                        <th>รายละเอียดค่าใช้จ่าย</th>
                        <th>วันที่เบิกจ่าย</th>
                        <th>จำนวนเงิน</th>
                    </tr>
                </thead>
            </table>
            <b class="pt-10"><u>รายละเอียดค่าใช้จ่าย</u></b>
            <div class="form-group row">
                <div class="col-md-3">
                    {{ Form::text('search', null, ['class' => 'form-control', 'id' => 'search', 'placeholder' => 'คำค้น (Keyword)']) }}
                </div>
                    <label class="form-control-label col-md-1 text-right pr-4">ประเภท</label>
                    {{ Form::select('acttype_id', $acttype_list, $acttype_id, ['wire:model' => 'acttype_id', 'class' => 'form-control select2 col-md-2', 'placeholder' => '--เลือกประเภท--']) }}
            </div>
            <table class="table table-bordered table-hover w-full table-striped dataTable" id="Datatables_Detail">
                <thead class="bg-blue-500">
                    <tr class="text-center">
                        <th>ลำดับ</th>
                        <th>หน่วยงาน</th>
                        <th>ประเภท</th>
                        <th>รายละเอียดค่าใช้จ่าย</th>
                        <th>วันที่เบิกจ่าย</th>
                        <th>จำนวนเงิน</th>
                    </tr>
                </thead>
                {{-- <tfoot class="bg-blue-500 text-white">
                    <tr>
                        <td></th>
                        <td></th>
                        <td></th>
                        <th class="text-right">รวมเป็นเงิน</th>
                        <th class="text-center">8,000</th>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
</div>

@push('js')
    <script>
        Livewire.on('emits', () => {
            $('.select2').select2();
            call_datatable();
        });
        Livewire.on('emp', () => {
            $('.select2').select2();
        });
        function setValue(name, val) {
            if( $.fn.DataTable.isDataTable("#Datatables") ){
                // $('#Datatables').DataTable().destroy();
                $('#Datatables').DataTable().destroy();
            }
            @this.setVal(name, val);
        }
        // $(function() {
        //     call_datatable_detail();
        // });

        function call_datatable(search) {
            var table = $('#Datatables').DataTable({
                processing: true,
                "bInfo": false,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route("api.activity.summaryexpensesyeardetail.list") }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}' ,
                        budgetyear: @this.budgetyear,
                        periodno: @this.periodno
                    },
                    headers: { 'Authorization': 'Bearer {{ system_key() }}' }
                },
                columns: [
                    // { data: 'budget_manage', name: 'budget_manage', className: "text-center", orderable: false },
                    // { data: 'budget_summanage', name: 'budget_summanage', className: "text-center", orderable: false },
                    // { data: 'budget_manage_balance', name: 'budget_manage_balance', className: "text-center", orderable: false },
                    // { data: 'budget_project', name: 'budget_project', className: "text-center", orderable: false },
                    // { data: 'budget_summanageproject', name: 'budget_summanageproject', className: "text-center", orderable: false },
                    // { data: 'budget_sumpaymentproject', name: 'budget_sumpaymentproject', className: "text-center", orderable: false },
                    // { data: 'budget_project_balance', name: 'budget_project_balance', className: "text-center", orderable: false }
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false},
                    { data: 'division_name', name: 'division_name', className: "text-center", orderable: false },
                    { data: 'name', name: 'name', className: "text-center", orderable: false },
                    { data: 'req_shortname', name: 'req_shortname', className: "text-center", orderable: false },
                    { data: 'pay_date', name: 'pay_date', className: "text-center", orderable: false },
                    { data: 'pay_amt', name: 'pay_amt', className: "text-center", orderable: false }
                ],
                language: {
                url: '{{ asset("assets") }}/js/datatable-thai.json',
                },
                paging: false,
                pageLength:10,
                ordering:false,
                drawCallback: function(settings) {
                    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                 pagination.toggle(this.api().page.info().pages > 1);
                }
            });
            table.on('order.dt', function() {
            // table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
            //     cell.innerHTML = i + 1;
            // });
            }).search(search).draw();
        }

        function call_datatable_detail(search) {
            var table = $('#Datatables_Detail').DataTable({
                processing: true,
                "bInfo": false,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route("api.activity.summaryexpensesyear.list") }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}' ,
                        budgetyear: @this.budgetyear
                    },
                    headers: { 'Authorization': 'Bearer {{ system_key() }}' }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false},
                    { data: 'division_name', name: 'division_name', className: "text-center", orderable: false },
                    { data: 'name', name: 'name', className: "text-center", orderable: false },
                    { data: 'req_shortname', name: 'req_shortname', className: "text-center", orderable: false },
                    { data: 'pay_date', name: 'pay_date', className: "text-center", orderable: false },
                    { data: 'pay_amt', name: 'pay_amt', className: "text-center", orderable: false }
                ],
                language: {
                url: '{{ asset("assets") }}/js/datatable-thai.json',
                },
                paging: false,
                pageLength:10,
                ordering:false,
                drawCallback: function(settings) {
                    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                 pagination.toggle(this.api().page.info().pages > 1);
                }
            });
            table.on('order.dt', function() {
            // table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
            //     cell.innerHTML = i + 1;
            // });
            }).search(search).draw();
        }
    </script>
@endpush

