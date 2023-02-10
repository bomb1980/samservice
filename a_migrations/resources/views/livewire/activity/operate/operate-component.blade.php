<div>
    {{ Form::open([
    'wire:submit.prevent' => 'submit()',
    'autocomplete' => 'off',
    'class' => 'form-horizontal fv-form fv-form-bootstrap4',
    ]) }}
    <div class="form-group row">
        <label class="form-control-label col-md-1 ">ปีงบประมาณ</label>
        {{ Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, [
        'onchange' => 'setValue("fiscalyear_code", event.target.value)',
        'id' => 'fiscalyear_code',
        'class' => 'form-control col-md-2 select2',
        'placeholder' => '--เลือกปีงบประมาณ--',
        ]) }}

        <label class="form-control-label col-md-1 ">หน่วยงาน</label>
        {{ Form::select('dept_id', $dept_list, $dept_id, [
        'onchange' => 'setValue("dept_id", event.target.value)',
        'id' => 'dept_id',
        'class' => 'form-control col-md-2 select2',
        'placeholder' => '--เลือกหน่วยงาน--',
        ]) }}

        <label class="form-control-label col-md-1 ">ประเภทกิจกรรม</label>
        {{ Form::select('acttype_id', $acttype_list, $acttype_id, [
        'onchange' => 'setValue("acttype_id", event.target.value)',
        'id' => 'acttype_id',
        'class' => 'form-control col-md-2 select2',
        'placeholder' => '--เลือกประเภทกิจกรรม--',
        ]) }}
    </div>

    <hr>

    <div class="table-responsive" id="parenTable">
        <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">
                        {{-- <input type="checkbox" id="checkedAll"> --}}
                        {{-- wire:click="allrow()"  --}}
                    </th>
                    <th class="text-center" rowspan="2">ลำดับ</th>
                    <th class="text-center" rowspan="2">ปีงบประมาณ</th>
                    <th class="text-center" rowspan="2">เลขที่คำขอ</th>
                    <th class="text-center" rowspan="2">ประเภทกิจกรรม</th>
                    <th class="text-center" rowspan="2">อำเภอ</th>
                    <th class="text-center" rowspan="2">ตำบล</th>
                    <th class="text-center" rowspan="2">หมู่</th>
                    <th class="text-center" rowspan="2">ระยะเวลาดำเนินการ</th>
                    <th class="text-center" rowspan="2">จำนวนวัน</th>
                    <th class="text-center" rowspan="2">เป้าหมาย(คน)</th>
                    <th class="text-center" rowspan="2">รวมค่าใช้จ่าย</th>
                    <th class="text-center" rowspan="2">สถานะ</th>
                    <th class="text-center" colspan="3">กิจกรรม</th>
                </tr>
                <tr>
                    <th class="text-center">เริ่ม</th>
                    <th class="text-center">ติดตาม</th>
                    <th class="text-center">ปิด</th>
                </tr>
            </thead>
        </table>
    </div>
    {{ Form::close() }}

    <div class="form-group row pt-4">
        <div class="col-1">
            <input type="checkbox" id="checkedAll"> เลือกรายการทั้งหมด
        </div>
        <div class="col-2">
            <div class="btn btn-success" onclick="act_checkbox(5)">เริ่มกิจกรรม</div>
        </div>
        <div class="col-2">
            <div class="btn btn-danger" onclick="act_checkbox(6)">ปิดกิจกรรม</div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {

            $('.select2').select2();

            call_datatable('');
            Livewire.on('emits', () => {

                $('.select2').select2();
                call_datatable($("#serachbox").val());

            });
        })
    </script>
</div>

@push('js')
<script>
    $('.select2').select2();

        $(document).ready(function() {

            @if (session()->get('pending_room'))
                swal('', 'บันทึกข้อมูลเรียบร้อยแล้ว', 'success');
                $("[name='selecter']").attr('data-click-state', 0)
                $("[name='selecter']").css('border', "1px solid grey")
                $("[name='selecter']").removeClass();
                $("[glob_name='selecter_text']").css('color', 'black');
                //
                $('#select_2').attr('data-click-state', 1)
                $('#select_2').css('border', "")
                $('#select_2').toggleClass('card card-inverse bg-warning')
                $("[name=" + 'selecter_2_text' + "]").css('color', 'white');
            @endif

            @if (session()->get('message_edit'))
                swal('', 'แก้ไขข้อมูลเรียบร้อยแล้ว', 'success');
            @endif

            @if (session()->get('message_delete'))
                swal('', 'ลบข้อมูล เรียบร้อยแล้ว', 'success');
            @endif

            @if (session('act_start'))
                swal({
                    title: "บันทึกเริ่มกิจกรรมเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                });
            @endif

            @if (session('act_end'))
                swal({
                    title: "บันทึกปิดกิจกรรมเรียบร้อย",
                    text: "{{ session()->get('act_end') }}",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                });
            @endif

        });


        function change_start($act_id) {
            swal({
                title: 'ยืนยันเริ่มกิจกรรม ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.actStart($act_id);
                }
            });
        }


        function change_end($act_id) {
            swal({
                title: 'ยืนยันปิดกิจกรรม ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.actEnd($act_id);
                }
            });
        }

        function setSearch() {
            $('#Datatables').DataTable().destroy();
            call_datatable($("#serachbox").val());
            return false;
        }

        var table;

        function call_datatable(search) {
            table = $('#Datatables').DataTable({
                processing: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.acitivity.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}',
                        fiscalyear_code: @this.fiscalyear_code,
                        dept_id: @this.dept_id,
                        acttype_id: @this.acttype_id,
                        selectall: @this.selectall,
                    },
                    headers: {
                        'Authorization': 'Bearer {{ system_key() }}'
                    }
                },
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 1,
                }, ],
                order: [
                    [1, 'asc']
                ],
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'act_year',
                        name: 'act_year',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'act_number',
                        name: 'act_number',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'amphur_name',
                        name: 'amphur_name',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'tambon_name',
                        name: 'tambon_name',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'act_moo',
                        name: 'act_moo',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'act_start_To_end_format',
                        name: 'act_start_To_end_format',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'act_numofday',
                        name: 'act_numofday',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'act_numofpeople',
                        name: 'act_numofpeople',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'act_amount_format',
                        name: 'act_amount_format',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'status_confirm',
                        name: 'status_confirm',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'act_start',
                        name: 'act_start',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'details',
                        name: 'details',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'act_end',
                        name: 'act_end',
                        className: "text-center",
                        orderable: false
                    },
                ],
                language: {
                    url: '{{ asset('assets') }}/js/datatable-thai.json',
                },
                paging: true,
                pageLength: 10,
                ordering: false,
                drawCallback: function(settings) {
                    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                    pagination.toggle(this.api().page.info().pages > 1);
                }
            });
            table.on('order.dt search.dt', function() {
                let i = 1;

                table.cells(null, 1, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });
            }).search(search)
            table.draw();

            $('#checkedAll').on('click', function() {
                var rows = table.rows({
                    'search': 'applied'
                }).nodes();

                $('.checkSingle', rows).prop('checked', this.checked);
            });
        }

        function test($val)
        {
            console.log('adad');
        }

        function setValue(name, val) {
            $('#Datatables').DataTable().destroy();
            @this.set(name, val);
        }

        function allrow($val) {
            $('#Datatables').DataTable().destroy();
            var selectall = $val;
            @this.selectall = selectall;
            console.log(selectall);

        }

// act_checkbox_start
// act_checkbox_close

        function act_checkbox(status) {

            let resultCheckbox = [];
            var rows = table.rows({
                'search': 'applied'
            }).nodes();

            $('.checkSingle', rows).each(function() {
                if ($(this).prop("checked") == true) {
                    resultCheckbox.push(this.value);;
                }
            });

            if (resultCheckbox.length == 0) {
                swal({
                    title: 'โปรดเลือดอย่างน้อย 1 รายการ',
                    icon: 'close',
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                });
            } else {
                var text;
                if(status == 5){
                    text = 'ยืนยันการเปิดโครงการใช่หรือไม่'
                }else{
                    text = 'ยืนยันการปิดโครงการใช่หรือไม่'
                }
                swal({
                    title: text,
                    icon: 'close',
                    html: true,
                    type: "success",
                    showCancelButton: true,
                    confirmButtonText: 'ตกลง',
                    confirmButtonColor: '#00BCD4',
                    cancelButtonText: 'ยกเลิก',
                    cancelButtonColor: '#00BCD4',
                }, function(isConfirm) {
                    if (isConfirm) {
                        // status
                        @this.getCheckList(status,resultCheckbox);
                    }
                });
            }
        }
</script>
@endpush
