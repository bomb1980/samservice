<div>
    {!! Form::open(['wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' => 'form-horizontal fv-form fv-form-bootstrap4']) !!}

    <div class="form-group row">
        <label class="form-control-label col-md-1 text-right pr-4">ปีงบประมาณ</label>
        {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, ['id' => 'fiscalyear_code', 'onchange' => 'setSearch', 'class' => 'form-control col-md-2', 'disabled']) !!}
        @error('fiscalyear_code')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>

    <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
        <thead>
            <tr>
                <th class="text-center col-1">
                    {!! Form::checkbox('select_all', '1', $select_all, ['wire:click' => 'check_list()', 'class' => 'mt-4 mr-4']) !!}
                    เลือกทั้งหมด
                </th>
                <th class="text-center">เลขที่คำขอ</th>
                <th class="text-center">หน่วยงาน</th>
                <th class="text-center">ประเภทกิจกรรม</th>
                <th class="text-center">อำเภอ</th>
                <th class="text-center">ตำบล</th>
                <th class="text-center">หมู่</th>
                <th class="text-center">จำนวนวัน</th>
                <th class="text-center">จำนวนคน</th>
                <th class="text-center">รวม</th>
                {{-- <th class="text-center">สถานะใบคำขอ</th>
                <th class="text-center">แก้ไข</th>
                <th class="text-center">ลบ</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($actlist as $key => $val)
                <tr>
                    <td class="text-center">
                        {!! Form::checkbox('select.' . $key, $val['reqform_id'], null, ['wire:model' => 'select.' . $key]) !!}
                    </td>
                    <td>{{ $val['reqform_no'] }}</td>
                    <td>{{ $val['dept_id'] }}</td>
                    <td>{{ $val['name'] }}</td>
                    <td>{{ $val['amphur_name'] }}</td>
                    <td>{{ $val['tambon_name'] }}</td>
                    <td class="text-center">{{ $val['moo'] }}</td>
                    <td class="text-center">{{ $val['day_qty'] }}</td>
                    <td class="text-center">{{ $val['people_qty'] }}</td>
                    <td class="text-center">{{ $val['total_amt'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="form-group row d-flex justify-content-center mt-4">
        <button type="submit" class="btn btn-primary">เลือกรายการ</button>
    </div>

    {!! Form::close() !!}
</div>

@push('js')
    <script>
        $('.select2').select2();

        function setDatePicker(name, val) {
            @this.set(name, val);
            @this.setArray();
            // if(name == 'stdate' || name = "endate"){
            //     @this.setArray();
            // }
        }

        function setValue(name, val) {
            @this.set(name, val);
        }

        $(".datepicker").datepicker( {
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

        Livewire.on('emits', () => {
            $('.select2').select2();
            $(".ads_Checkbox").change(function() {
                var searchIDs = $(".ads_Checkbox").map(function(_, el) {
                    if ($(this).is(':checked')) {
                        return 'on';
                    } else {
                        return 'off';
                    }
                }).get();
                // console.log(searchIDs);
            });

        });

        Livewire.on('popup', () => {
            swal({
                title: "บันทึกข้อมูลเรียบร้อย",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK",
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.livewire.emit('redirect-to');
                }
            });
        });

        function button_function() {
            swal({
                title: 'ยืนยันการ ยกเลิกโครงการ ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.redirect_to();
                }
            });
        }
    </script>
@endpush
