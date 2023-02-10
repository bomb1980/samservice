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
            <table class="table table-bordered table-hover w-full table-striped dataTable" id="manual_Datatables">
                <thead class="bg-blue-500">
                    <tr class="text-center" >
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
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <th>{{$budget_manage}}</th>
                        <th>{{$budget_summanage}}</th>
                        <th>{{$budget_summanage}}</th>
                        <th>{{$budget_project}}</th>
                        <th>{{$budget_summanageproject}}</th>
                        <th>{{$budget_sumpaymentproject}}</th>
                        <th>{{$budget_project_balance}}</th>
                    </tr>
                </tbody>
            </table>
            <b class="pt-10"><u>รายละเอียดค่าใช้จ่าย</u></b>
            <div class="form-group row">
                <div class="col-md-3">
                    {{ Form::text('search', null, ['oninput' => 'setSearch()', 'class' => 'form-control', 'id' => 'search', 'placeholder' => 'คำค้น (Keyword)']) }}
                </div>
                    <label class="form-control-label col-md-1 text-right pr-4">ประเภท</label>
                    {{ Form::select('acttype_id', $acttype_list, $acttype_id, ['id' => 'acttype_id', 'onchange' => 'setSearch()','class' => 'form-control select2 col-md-2', 'placeholder' => '--เลือกประเภท--']) }}
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
            // call_datatable();
            call_datatable_detail();
        });
        Livewire.on('emp', () => {
            $('.select2').select2();
        });
        function setValue(name, val) {
            if( $.fn.DataTable.isDataTable("#Datatables_Detail") ){
                // $('#Datatables').DataTable().destroy();
                $('#Datatables_Detail').DataTable().destroy();
            }
            @this.setVal(name, val);
        }
        $(function() {
            $('.select2').select2();
        });

        var table;
        function setSearch(){
            if( $.fn.DataTable.isDataTable("#Datatables_Detail") ){
                table.search( $("#search").val() ).draw();
                table.column(2).search( $("#acttype_id").val() ).draw();
            }
        }

        function call_datatable_detail(search) {
            table = $('#Datatables_Detail').DataTable({
                processing: true,
                bInfo: false,
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
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false},
                    { data: 'division_name', name: 'division_name', className: "text-center", orderable: false },
                    { data: 'name', name: 'name', className: "text-center", orderable: false },
                    { data: 'act_shortname', name: 'act_shortname', className: "text-center", orderable: false },
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
            // table.on('order.dt', function() {
            // // table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
            // //     cell.innerHTML = i + 1;
            // // });
            // }).search(search).draw();
        }
    </script>
@endpush


