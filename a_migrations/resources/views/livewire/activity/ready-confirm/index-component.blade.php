<div>
    <div class="form-group row">
        <label class="form-control-label col-md-1 text-right pr-4">ปีงบประมาณ</label>
        {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, [
            'class' => 'form-control col-md-2 select2',
            'onchange' => 'changeFiscalyear(event.target.value)',
            'placeholder' => '--เลือกปีงบประมาณ--',
        ]) !!}
        {{-- <input type="search" id="txt_search" class="form-control col-md-2 ml-4" wire:model="txt_search"
            placeholder="คำค้น keyword" /> --}}
    </div>
    <div class="form-group row" wire:ignore>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
                <thead>
                    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th class="text-center">เลขที่คำขอ</th>
                        <th class="text-center">ประเภทกิจกรรม</th>
                        <th class="text-center">อำเภอ</th>
                        <th class="text-center">ตำบล</th>
                        <th class="text-center">หมู่</th>
                        <th class="text-center">ระยะเวลาดำเนินการ</th>
                        <th class="text-center">จำนวนวัน</th>
                        <th class="text-center">เป้าหมาย(คน)</th>
                        <th class="text-center">รวมค่าใช้จ่าย</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-center">ยืนยัน</th>
                        <th class="text-center">แก้ไข</th>
                        <th class="text-center">ลบ</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @if ($btn_submit)
        <div class="form-group row">
            <div class="col">
                <div style="text-align: center;" id="select_submit">
                    <button type="button" onclick="submit_click()" class="btn btn-primary">ยืนยันความพร้อม</button>
                </div>
            </div>
        </div>
    @endif
    <script>
        document.addEventListener('livewire:load', function() {
            $('.select2').select2();
            call_datatable();
            Livewire.on('emits', () => {
            $('.select2').select2();
            $('#Datatables').DataTable().destroy();
                call_datatable();
            });
        });
    </script>
</div>

@push('js')
    <script>
        $(function() {
            @if (session('successapprove'))
                swal({
                    title: "บันทึกยืนยันความพร้อมเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                });
            @endif

            @if (session('success'))
                swal({
                    title: "คัดลอกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                });
            @endif


            @if (session('success_del'))

                swal({
                    title: "ลบข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                });
            @endif

        });

        function changeFiscalyear(val) {
            @this.set('fiscalyear_code', val);
        }

        function change_approve($act_id) {
            swal({
                title: 'ยืนยันความพร้อมกิจกรรม ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.approve($act_id);
                }
            });
        }

        function submit_click() {
            swal({
                title: 'ยืนยันความพร้อมกิจกรรม ทั้งหมด ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.submit();
                }
            });
        }

        function call_datatable(data) {

            var table = $('#Datatables').DataTable({
                processing: true,
                // serverSide: true,
                // destroy: true,
                // responsive: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.activity.ready_confirm.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}',
                        fiscalyear_code: @this.fiscalyear_code,
                        txt_search: @this.txt_search,
                        // dept_id: @this.division_id,
                    },
                    headers: {
                        'Authorization': 'Bearer {{ system_key() }}'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'act_number',
                        name: 'act_number',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'name',
                        name: 'act_acttype',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'amphur_name',
                        name: 'amphur_name',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'tambon_name',
                        name: 'tambon_name',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'act_moo',
                        name: 'act_moo',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'period',
                        name: 'period',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'act_numofday',
                        name: 'act_numofday',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'act_numofpeople',
                        name: 'act_numofpeople',
                        className: "text-center",
                        orderable: true
                    },
                    {
                        data: 'act_amount',
                        name: 'act_amount',
                        className: "text-right",
                        orderable: true
                    },
                    {
                        data: 'status_confirm3',
                        name: 'status_confirm3',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'approve',
                        name: 'approve',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'del',
                        name: 'del',
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

            table.on('order.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });

            }).draw();

            if (table.context.length == 0) {
                @this.set('act_year', data['act_year']);
            }
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
