<div>
    {{ Form::open([
        'wire:submit.prevent' => 'submit()',
        'autocomplete' => 'off',
        'class' => 'form-horizontal fv-form fv-form-bootstrap4',
    ]) }}
    <div class="form-group row">
        <label class="col-md-2 form-control-label">ประเภทกิจกรรม</label>
        <div class="col-md-3">
            {{ Form::select('acttype_id', $acttype_list, $acttype_id, [
                // 'wire:model' => 'acttype_id',
                'onchange' => 'setValue("acttype_id",event.target.value)',
                'id' => 'acttype_id',
                'class' => 'form-control select2',
                'placeholder' => '--เลือกประเภทกิจกรรม--',
                'disabled',
            ]) }}
            @error('fiscalyear_code')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-2 form-control-label">เลขที่ใบคำขอ </label>
        <div class="col-md-3">
            <input type="text" class="form-control" value="{{ $act_number }}" disabled>
        </div>
    </div>

    <div class="form-group row">
        <div class="table-responsive" wire:ignore>
            <table class="table table-bordered border table-hover table-striped w-full dataTable text-center"
                id="Datatables">
                <thead>
                    <tr class="text-center">
                        <th class="text-center col-1"><input type="checkbox" name="checkedAll" id="checkedAll" /></th>
                        <th class="col-1">ลำดับ</th>
                        <th class="col-2">ชื่อ-นามสกุล</th>
                        <th class="col-2">ประเภท</th>
                        <th class="col-2">จังหวัด</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div style="text-align: center;">
        <div class="btn btn-primary" onclick="submit_checkbox()">บันทึก</div>
        <div class="btn btn-default" onclick="callBack()">ยกเลิก</div>
    </div>

    {{ Form::close() }}
    <script>
        document.addEventListener('livewire:load', function() {
            $('.select2').select2();
            call_datatable('');
            window.livewire.on('emits', () => {
                $('.select2').select2();
            })
        })
        window.onload = function() {
            Livewire.on('popup', () => {
                swal({
                        title: "บันทึกเสร็จสิ้น",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "ตกลง",
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.livewire.emit('redirect-to');
                            // window.close();
                        }
                    });
            });
        }
    </script>
</div>
@push('js')
    <script>
        // $(function() {
        //     call_datatable('');
        // });

        var table;

        function call_datatable(search) {

            table = $('#Datatables').DataTable({
                processing: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.master.lecturer_pop.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}',
                        act_number: @this.act_number,
                    },
                    headers: {
                        'Authorization': 'Bearer {{ system_key() }}'
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        className: "text-center",
                        orderable: false
                    }, {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'yourname',
                        name: 'yourname',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'lecturer_types_name',
                        name: 'lecturer_types_name',
                        className: "text-center",
                        orderable: false,
                    },
                    {
                        data: 'province_name',
                        name: 'province_name',
                        className: "text-center",
                        orderable: false,
                    }
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
            }).search(search).draw();

            $('#checkedAll').on('click', function() {
                var rows = table.rows({
                    'search': 'applied'
                }).nodes();
                $('.checkSingle1', rows).prop('checked', this.checked);
            });
        }

        function submit_checkbox() {
            let a = [];
            var rows = table.rows({
                'search': 'applied'
            }).nodes();
            $('.checkSingle1', rows).each(function() {
                if ($(this).prop("checked") == true) {
                    a[this.value] = this.id;
                }
            });
            $('#Datatables').DataTable().destroy();
            @this.select_values_list = a;
            @this.submit();
        }

        function callBack() {
            swal({
                title: 'ต้องการยกเลิกใช่หรือไม่',
                icon: 'close',
                html: true,
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#00BCD4',
                cancelButtonText: 'ยกเลิก',
                cancelButtonColor: '#00BCD4',
            }, function(isConfirm) {
                if (isConfirm) {
                    window.close();
                } else {
                    console.log('reject');
                }
            });
        }
    </script>
@endpush
