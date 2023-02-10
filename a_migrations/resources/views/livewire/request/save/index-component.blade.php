<div>
    {!! Form::open(['wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' => 'form-horizontal fv-form fv-form-bootstrap4']) !!}
    <div class="form-group row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="row mb-4">
                <div class="col-md-2">
                    {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, ['wire:change' => 'changeYears($event.target.value)', 'class' => 'form-control select2', 'placeholder' => '--เลือกปีงบประมาณ--']) !!}
                </div>
            </div>
            <table class="table table-bordered table-hover table-striped dataTable" id="Datatables">
                <thead>
                    <tr>
                        <th class="text-center">ประเภทกิจกรรม</th>
                        <th class="text-center">คำของบประมาณ</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($reqform)>0)
                        <tr>
                            <td><b>กิจกรรมจ้างงานเร่งด่วน<b></td>
                            <td class="text-right">
                                <b>{{ number_format($sum_total_labour ?? 0, 2) }}<b>
                            </td>
                        </tr>
                        <tr>
                            <td><b>กิจกรรมฝึกทักษะฝีมือแรงงาน<b></td>
                            <td class="text-right">
                                <b>{{ number_format($sum_total_skill ?? 0, 2) }}<b>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left pr-4"><b>รวมจำนวนเงินจัดกิจกรรม</b></td>
                            <td class="text-right">
                                <b>{{ number_format($total_sum2 ?? 0, 2) }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left pr-4"><b>รวมจำนวนเงินที่เสนองบประมาณ</b></td>
                            <td class="text-right">
                                    {!! Form::number('req_amt', $req_amt, ['wire:model' => 'req_amt', 'id' => 'req_amt', 'class' => 'form-control col-md-4 float-right text-right']) !!}

                            </td>
                        </tr>

                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="form-group row d-flex justify-content-center">
        <button type="button" class="btn btn-primary" onclick="button_function()">บันทึกเสนองบ</button>
    </div>
</div>

@push('js')
<script>
    window.onload = function() {
        Livewire.on('popup', () => {
            swal({
                title: "อัพเดทข้อมูลเรียบร้อย",
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
    }

    function button_function() {
        swal({
            title: 'ยืนยันการ บันทึกเสนองบ ?',
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
</script>
@endpush
