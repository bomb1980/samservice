<div>


    <div class="row">

        <div class="col-md-3" style="display: flex; align-items: center; gap: 20px;">
            <span>ปีงบประมาณ</span>
            {{ Form::select('fiscalyear_code', $fiscalyear_select, $parent_id, ['class' => 'form-control select2']) }}
        </div>

    </div>

    {!! Form::open([
        'wire:submit.prevent' => 'submit(Object.fromEntries(new FormData($event.target)))',
        'autocomplete' => 'off',
        'class' => 'fv-form form-horizontal fv-form-bootstrap4',
    ]) !!}

    <table class="table table-bordered table-hover table-striped dataTable">
        <thead>
            <tr class="text-center">
                <th>กิจกรรม</th>
                <th>จำนวนเงิน</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th class="text-left"><strong>กิจกรรมจ้างงานเร่งด่วน</strong></th>
                <th class="text-right" class="text-right"><strong>{{ number_format($datas->req_urgentamt, 2) }}</strong>
                </th>
            </tr>
            <tr>
                <th class="text-left"><strong>กิจกรรมทักษะฝีมือแรงงาน</strong></th>
                <th class="text-right" class="text-right"><strong>{{ number_format($datas->req_skillamt, 2) }}</strong>
                </th>
            </tr>

            <tr class="text-left" style="">
                <th><strong>รวมจำนวนเงินจัดกิจกรรม</strong> </th>
                <th class="text-right"><strong>{{ number_format($datas->req_sumreqamt, 2) }}</strong></th>
            </tr>
            <tr class="text-left">
                <th><strong>จำนวนเงินที่เสนองบประมาณ</strong></th>
                <th class="text-right"><strong class="text-danger">{{ number_format($datas->req_amt, 2) }}</strong></th>
            </tr>
            <tr class="text-left">
                <th><strong>ได้รับงบประมาณ</strong> </th>
                <th class="text-right">

                    {{ Form::text('budget_amt', number_format($budget_amt, 2), ['class' => 'form-control col-md-4 float-right text-right', 'onkeyup' => 'javascript:controlnumbers( this )']) }}

                </th>
            </tr>

        </tbody>
    </table>

    <br>

    <div class="text-center">

        <button type="submit" class="btn btn-primary">{!! getIcon('save') !!} บันทึกงบประมาณ</button>
    </div>


    {!! Form::close() !!}



</div>
@push('js')
    <script>
        document.addEventListener('livewire:load', function() {

            $('.select2').change(function() {

                if ($(this).val() == '') {

                    return;
                }

                let route = '{{ route('manage.fiscal.save', ['id' => 'ddddddddddddd']) }}';

                let redirect = route.replace("ddddddddddddd", $(this).val());


                window.location = redirect;
            });


            window.livewire.on('loadJquery', () => {

                $(".month-picker").datepicker({
                    format: "mm/yyyy",
                    viewMode: "months",
                    minViewMode: "months",
                    autoclose: true
                }).on('change', function(e) {

                    let name = $(this).attr('data-name');

                    @this.set(name, $(this).val());

                });

                $(".date-picker").datepicker({
                    format: "dd/mm/yyyy",

                    autoclose: true
                }).on('change', function(e) {

                    let name = $(this).attr('data-name');

                    @this.set(name, $(this).val());

                });
            });
        });

        function setValue(name, val) {
            @this.set(name, val);
        }
        Livewire.on('popup', () => {
            swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                },
                function(isConfirm) {
                    if (isConfirm) {


                        let route = '{{ route($redirect, ['id' => 'ddddddddddddd']) }}';

                        let redirect = route.replace("ddddddddddddd", $('[name="fiscalyear_code"]').val());


                        // window.location = redirect;

                         location.reload();
                        //window.livewire.emit('redirect-to');
                    }
                });
        });

        function submit() {
            swal({
                title: 'ยืนยันการบันทึกข้อมูล ได้รับงบประมาณ ?',
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
