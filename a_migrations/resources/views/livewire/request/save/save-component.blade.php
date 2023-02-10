<div>
    {!! Form::open([
        'wire:submit.prevent' => 'submit()',
        'autocomplete' => 'off',
        'class' => 'form-horizontal fv-form fv-form-bootstrap4',
    ]) !!}
    <div class="form-group row d-flex justify-content-center">
        <div class="col-md-3"></div>
        <div class="col-md-6">

            <b>ปีงบประมาณ: {{ $datas->fiscalyear_code }}</b>

            <table class="table table-bordered table-hover table-striped dataTable" id="Datatables">
                <thead>
                    <tr>
                        <th class="text-center">ประเภทกิจกรรม</th>
                        <th class="text-center">คำของบประมาณ</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td><b>กิจกรรมจ้างงานเร่งด่วน<b></td>
                        <td class="text-right">
                            <b>{{ number_format($datas->req_urgentamt, 2) }}<b>
                        </td>
                    </tr>
                    <tr>
                        <td><b>กิจกรรมฝึกทักษะฝีมือแรงงาน<b></td>
                        <td class="text-right">
                            <b>{{ number_format($datas->req_skillamt, 2) }}<b>
                        </td>
                    </tr>
                    <tr style="background-color: yellow;">
                        <td class="text-left pr-4"><b>รวมจำนวนเงินจัดกิจกรรม</b></td>
                        <td class="text-right">
                            <b>{{ number_format($datas->req_sumreqamt, 2) }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left pr-4"><b>รวมจำนวนเงินที่เสนองบประมาณ</b></td>
                        <td class="text-right">
                            {{ Form::text('req_amt', $req_amt, [
                                'wire:model' => 'req_amt',
                                'class' => 'form-control col-md-4 float-right text-right',
                                'onkeyup'=>'javascript:controlnumbers( this )'
                            ]) }}

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3"></div>


    </div>
    {!! Form::close() !!}
    <div class="form-group row d-flex justify-content-center">
        <button type="button" class="btn btn-primary" onclick="button_function()"
            style="margin-right: 10px;">บันทึกเสนองบ</button>
        <a class="btn btn-default btn-outline" href="{{ route('request.sum_list.index') }}">ยกเลิก</a>
    </div>
</div>

@push('js')
    <script>
        //
        //

        window.onload = function() {
            Livewire.on('popup', () => {
                swal({
                        title: "อัพเดทข้อมูลเรียบร้อย",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                    },
                    function(isConfirm) {
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
